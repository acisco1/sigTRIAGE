<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asistentesmedicas
 *
 * @author felipe de jesus
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Asistentesmedicas extends Config{
    public function __construct() {
        parent::__construct();
        $this->load->model('asistentesmedicas_mdl');
    }
    public function index() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT os_triage.triage_id, 
            os_triage.triage_nombre, os_triage.triage_nombre_ap, os_triage.triage_nombre_am,os_triage.triage_color,
            os_triage.triage_fecha_clasifica, os_triage.triage_hora_clasifica, 
            os_asistentesmedicas.asistentesmedicas_fecha, os_asistentesmedicas.asistentesmedicas_hora, paciente_info.pic_mt 
            FROM os_triage, os_accesos, os_asistentesmedicas, paciente_info
            WHERE 
            os_accesos.acceso_tipo='Asistente Médica' AND
            os_accesos.triage_id=os_triage.triage_id AND
            os_accesos.areas_id=os_asistentesmedicas.asistentesmedicas_id AND
            os_asistentesmedicas.asistentesmedicas_fecha=CURDATE() AND
            paciente_info.triage_id=os_triage.triage_id
            /* os_accesos.empleado_id=$this->UMAE_USER */
            ORDER BY os_accesos.acceso_id DESC LIMIT 10");
        $this->load->view('index',$sql);
    
    }    
    public function BuscarPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            $info= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
                'triage_id'=> $this->input->post('triage_id')
            ));
            if($sql[0]['triage_fecha_clasifica']!=''){
                if(empty($info)){
                    $this->config_mdl->_insert('os_asistentesmedicas',array('triage_id'=> $this->input->post('triage_id')));
                }
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }
        }else{
            $this->setOutput(array('accion'=>'3'));
        }
    }
    public function Paciente($paciente) {
        $sql['MedicosTratantes']= $this->config_mdl->_query("SELECT * FROM os_empleados WHERE os_empleados.empleado_categoria='MEDICO NO FAMILIAR 80'");
        $sql['info']=  $this->config_mdl->sqlGetDataCondition('os_triage',array(
           'triage_id'=>  $paciente
        ),'triage_id,triage_nombre,triage_nombre_am,triage_nombre_ap,triage_fecha_nac,triage_paciente_sexo,triage_paciente_estadocivil,triage_paciente_curp,triage_color,triage_consultorio_nombre');
        $sql['solicitud']= $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas',array(
           'triage_id'=> $paciente
        ),'asistentesmedicas_hoja,asistentesmedicas_renglon,asistentesmedicas_exectuar_st7');
        $sql['empleado']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
           'empleado_id'=> $this->UMAE_USER
        ),'empleado_nombre,empleado_apellidos');
        $sql['DirPaciente']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'=>  $paciente,
            'directorio_tipo'=>'Paciente'
        ))[0];
        $sql['DirEmpresa']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'=>  $paciente,
            'directorio_tipo'=>'Empresa'
        ))[0];
        $sql['Empresa']=  $this->config_mdl->_get_data_condition('os_triage_empresa',array(
           'triage_id'=>  $paciente,
        ))[0];
        $sql['PINFO']=  $this->config_mdl->sqlGetDataCondition('paciente_info',array(
           'triage_id'=>  $paciente,
        ))[0];
        $this->load->view('paciente',$sql);
    }
    public function AjaxGuardar() {
        $info=  $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id'=>  $this->input->post('triage_id')
        ),'triage_crea_am,triage_consultorio_nombre,triage_nombre,triage_nombre_ap,triage_nombre_am')[0];
        $infoPinfo=  $this->config_mdl->sqlGetDataCondition('paciente_info',array(
            'triage_id'=>  $this->input->post('triage_id')
        ),'pum_nss,pum_nss_agregado')[0];
        $am=  $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas',array(
            'triage_id'=>  $this->input->post('triage_id')
        ),'asistentesmedicas_id,asistentesmedicas_fecha')[0];
        if($info['triage_crea_am']==''){     
            if($this->input->post('pia_lugar_accidente')=='TRABAJO'){
                Modules::run('Asistentesmedicas/DOC_ST7_FOLIO',array(
                    'triage_id'=>  $this->input->post('triage_id')
                ));
            }
            if($info['triage_consultorio_nombre']=='Observación'){
                $this->config_mdl->_insert('doc_43021',array(
                    'doc_fecha'=> date('Y-m-d'),
                    'doc_hora'=> date('H:i:s'),
                    'doc_turno'=>Modules::run('Config/ObtenerTurno'),
                    'doc_destino'=>$info['triage_consultorio_nombre'],
                    'doc_tipo'=>'Ingreso',
                    'empleado_id'=> $this->UMAE_USER,
                    'triage_id'=>  $this->input->post('triage_id')
                ));
            }else{
                $this->config_mdl->_insert('doc_43029',array(
                    'doc_fecha'=> date('Y-m-d'),
                    'doc_hora'=> date('H:i:s'),
                    'doc_turno'=>Modules::run('Config/ObtenerTurno'),
                    'doc_destino'=>$info['triage_consultorio_nombre'],
                    'doc_tipo'=>'Ingreso',
                    'empleado_id'=> $this->UMAE_USER,
                    'triage_id'=>  $this->input->post('triage_id')
                ));
            }
            $this->AccesosUsuarios(array('acceso_tipo'=>'Asistente Médica','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$am['asistentesmedicas_id']));
        }
        $data=array(
            'asistentesmedicas_fecha'=> date('Y-m-d'),
            'asistentesmedicas_hora'=> date('H:i'), 
            'triage_id'=>  $this->input->post('triage_id')
        );
        if($am['asistentesmedicas_fecha']!=''){
            unset($data['asistentesmedicas_fecha']);
            unset($data['asistentesmedicas_hora']);
            
        }
        $this->config_mdl->_update_data('os_asistentesmedicas',$data,
                array('triage_id'=>  $this->input->post('triage_id'))
        );
        $data_triage=array(
            'triage_nombre'=>  $this->input->post('triage_nombre'),
            'triage_nombre_ap'=>$this->input->post('triage_nombre_ap') ,
            'triage_nombre_am'=>$this->input->post('triage_nombre_am') ,
            'triage_paciente_sexo'=> $this->input->post('triage_paciente_sexo'),
            'triage_fecha_nac'=>  $this->input->post('triage_fecha_nac'),
            'triage_paciente_estadocivil'=>  $this->input->post('triage_paciente_estadocivil'),
            'triage_paciente_curp'=>  $this->input->post('triage_paciente_curp'),
            'triage_crea_am'=> $this->UMAE_USER
            
        ); 
        Modules::run('Triage/LogChangesPatient',array(
            'paciente_old'=>$info['triage_nombre'].' '.$info['triage_nombre_ap'].' '.$info['triage_nombre_am'],
            'paciente_new'=> $this->input->post('triage_nombre').' '.$this->input->post('triage_nombre_ap').' '.$this->input->post('triage_nombre_am'),
            'nss_old'=>$infoPinfo['pum_nss'].'-'.$infoPinfo['pum_nss_agregado'],
            'nss_new'=> $this->input->post('pum_nss').'-'.$this->input->post('pum_nss_agregado'),
            'triage_id'=>$this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('paciente_info',array(
            'pum_nss'=>$this->input->post('pum_nss'),
            'pum_nss_agregado'=>$this->input->post('pum_nss_agregado'),
            'pum_umf'=>$this->input->post('pum_umf'),
            'pum_delegacion'=>$this->input->post('pum_delegacion'),
            'pia_lugar_accidente'=>$this->input->post('pia_lugar_accidente'),
            'pia_lugar_procedencia'=>$this->input->post('pia_lugar_procedencia'),
            'pia_dia_pa'=>$this->input->post('pia_dia_pa'),
            'pia_fecha_accidente'=>$this->input->post('pia_fecha_accidente'),
            'pia_hora_accidente'=>$this->input->post('pia_hora_accidente'),
            'pic_identificacion'=>$this->input->post('pic_identificacion'),
            'pic_responsable_nombre'=>$this->input->post('pic_responsable_nombre'),
            'pic_responsable_parentesco'=>$this->input->post('pic_responsable_parentesco'),
            'pic_responsable_telefono'=>$this->input->post('pic_responsable_telefono'),
            'pic_mt'=> $this->input->post('pic_mt'), 
        ),array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        Modules::run('Triage/TriagePacienteDirectorio',array(
            'directorio_tipo'=>'Paciente',
            'directorio_cp'=> $this->input->post('directorio_cp'),
            'directorio_cn'=> $this->input->post('directorio_cn'),
            'directorio_colonia'=> $this->input->post('directorio_colonia'),
            'directorio_municipio'=> $this->input->post('directorio_municipio'),
            'directorio_estado'=> $this->input->post('directorio_estado'),
            'directorio_telefono'=> $this->input->post('directorio_telefono'),
            'triage_id'=>$this->input->post('triage_id')
        ));
        if($this->input->post('directorio_cp_2')!=''){
            Modules::run('Triage/TriagePacienteDirectorio',array(
                'directorio_tipo'=>'Empresa',
                'directorio_cp'=> $this->input->post('directorio_cp_2'),
                'directorio_cn'=> $this->input->post('directorio_cn_2'),
                'directorio_colonia'=> $this->input->post('directorio_colonia_2'),
                'directorio_municipio'=> $this->input->post('directorio_municipio_2'),
                'directorio_estado'=> $this->input->post('directorio_estado_2'),
                'directorio_telefono'=> $this->input->post('directorio_telefono_2'),
                'triage_id'=>$this->input->post('triage_id')
            ));
            Modules::run('Triage/TriagePacienteEmpresa',array(
                'empresa_nombre'=> $this->input->post('empresa_nombre'),
                'empresa_modalidad'=> $this->input->post('empresa_modalidad'),
                'empresa_rp'=> $this->input->post('empresa_rp'),
                'empresa_fum'=> $this->input->post('empresa_fum'),
                'empresa_tel'=> $this->input->post('empresa_tel'),
                'empresa_he'=> $this->input->post('empresa_he'),
                'empresa_hs'=>$this->input->post('empresa_hs'),
                'triage_id'=> $this->input->post('triage_id')
            ));   
        } 
        $this->config_mdl->_update_data('os_triage',$data_triage,
                array('triage_id'=>  $this->input->post('triage_id'))
        );
        $this->setOutput(array('accion'=>'1'));        
        
    }
    public function DOC_ST7_FOLIO($info) {
        $this->config_mdl->_insert('doc_st7_folio',array(
            'st7_folio_fecha'=> date('Y-m-d'),
            'st7_folio_hora'=> date('H:i'),
            'triage_id'=>$info['triage_id'],
            'empleado_id'=> $this->UMAE_USER
        ));
    }
    public function BuscarCodigoPostal() {
       $sql=  $this->config_mdl->_get_data_condition('os_codigospostales',array('CodigoPostal'=>  $this->input->post('cp'))) ;
       $this->setOutput(array('result_cp'=>$sql[0]));
    }
    public function egresos() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_asistentesmedicas_egresos, os_triage WHERE
            os_asistentesmedicas_egresos.triage_id=os_triage.triage_id ORDER BY
            os_asistentesmedicas_egresos.egreso_id DESC LIMIT 10");
        $this->load->view('egresos/index',$sql);
        
    }
    public function AjaxObtenerPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_triage',array(
           'triage_id'=> $this->input->post('triage_id') 
        ));
        $sql_observacion= $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $sql_ce= $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(empty($sql_observacion)){
            if(empty($sql_ce)){
                $egreso_area='Sin Especificar';
            }else{
                $egreso_area='Consultorios';
            }
        }else{
            $egreso_area='Observacion';
        }
        if(!empty($sql)){
            $this->setOutput(array('accion'=>'1','paciente'=>$sql[0],'Destino'=>$egreso_area));
        }else{
            $this->setOutput(array('accion'=>'2')); 
        }
    }
    public function EgresoPaciente() {
        $sql_check= $this->config_mdl->_get_data_condition('os_asistentesmedicas_egresos',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(empty($sql_check)){
            $sql_observacion= $this->config_mdl->_get_data_condition('os_observacion',array(
                'triage_id'=> $this->input->post('triage_id')
            ));
            
            $sql_ce= $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
                'triage_id'=> $this->input->post('triage_id')
            ));
            if(empty($sql_observacion)){
                if(empty($sql_ce)){
                    $egreso_area='Sin Especificar';
                }else{
                    $egreso_area='Consultorios';
                }
            }else{
                $egreso_area='Observacion';
            }
            $this->config_mdl->_insert('os_asistentesmedicas_egresos',array(
                'egreso_fecha'=> date('Y-m-d'),
                'egreso_hora'=> date('H:i:s'),
                'egreso_area'=>$egreso_area,
                'egreso_motivo'=> $this->input->post('egreso_motivo'),
                'egreso_cama'=> $this->input->post('egreso_cama'),
                'egreso_piso'=> $this->input->post('egreso_piso'),
                'egreso_consultaexterna'=> $this->input->post('egreso_consultaexterna'),
                'empleado_id'=>$_SESSION['UMAE_USER'],
                'triage_id'=> $this->input->post('triage_id')
            ));
            $egreso_id= $this->config_mdl->_get_last_id('os_asistentesmedicas_egresos','egreso_id');
            $this->AccesosUsuarios(array('acceso_tipo'=>'Egreso Paciente Asistente Médica','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$egreso_id));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function Indicadores() {
        $this->load->view("Indicadores");
    }
    public function AjaxIndicador() {
        $inputFechaInicio= $this->input->post('inputFechaInicio');
        $sql_total= count($this->config_mdl->_query("SELECT os_asistentesmedicas.asistentesmedicas_id FROM os_asistentesmedicas, os_triage
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio'"));
        $sql_iniciada= count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info
            WHERE
            os_asistentesmedicas.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio' AND paciente_info.pia_lugar_accidente='TRABAJO'"));
        $sql_terminada= count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info
            WHERE
            os_asistentesmedicas.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_omitir='No' AND 
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio' AND paciente_info.pia_lugar_accidente='TRABAJO'"));
        $sql_espontanea= count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info
            WHERE
            os_asistentesmedicas.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio' AND paciente_info.pia_procedencia_espontanea='Si'"));
        $sql_noespontanea= count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info
            WHERE
            os_asistentesmedicas.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio' AND paciente_info.pia_procedencia_espontanea='No'"));
        $this->setOutput(array(
            'TOTAL_ST7_INICIADA'=>$sql_iniciada,
            'TOTAL_ST7_TERMINADA'=>$sql_terminada,
            'TOTAL_ESPONTANEA'=>$sql_espontanea,
            'TOTAL_NOESPONTANEA'=>$sql_noespontanea,
            'TOTAL'=>$sql_total
        ));
    }
    public function IndicadorDetalles() {
        $POR_FECHA_FI= $this->input->get_post('POR_FECHA_FECHA_I');
        if($this->input->get_post('TIPO')=='ST7 INICIADA'){
            $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_triage, paciente_info
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            os_triage.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$POR_FECHA_FI' AND paciente_info.pia_lugar_accidente='TRABAJO'");

        }if($this->input->get_post('TIPO')=='ST7 TERMINADA'){
            $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info, os_triage
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            os_asistentesmedicas.asistentesmedicas_omitir='No' AND 
            os_triage.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$POR_FECHA_FI' AND paciente_info.pia_lugar_accidente='TRABAJO'");

        }if($this->input->get_post('TIPO')=='ESPONTÁNEA'){
            $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info, os_triage
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            os_triage.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$POR_FECHA_FI' AND paciente_info.pia_procedencia_espontanea='Si'");

        }if($this->input->get_post('TIPO')=='NO ESPONTÁNEA'){
            $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, paciente_info, os_triage
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            os_triage.triage_id=paciente_info.triage_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$POR_FECHA_FI' AND paciente_info.pia_procedencia_espontanea='No'");

        }
        $this->load->view('IndicadoresDetalles',$sql);
    }
    public function ChartSt7Iniciada($data) {
        $POR_FECHA_FI= $data['POR_FECHA_FECHA_I'];
        $POR_FECHA_FF= $data['POR_FECHA_FECHA_F'];
        $POR_HORA_F= $data['POR_HORA_FECHA'];
        $POR_HORA_HI= $data['POR_HORA_HORA_I'];
        $POR_HORA_HF= $data['POR_HORA_HORA_F'];
        $COLOR=$data['COLOR'];
        if($data['FILTRO']=='Por Fecha'){
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha BETWEEN '$POR_FECHA_FI' AND '$POR_FECHA_FF' AND os_triage.triage_paciente_accidente_lugar='TRABAJO'"));
        }else{
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha='$POR_HORA_F' AND
                os_asistentesmedicas.asistentesmedicas_hora BETWEEN '$POR_HORA_HI' AND '$POR_HORA_HF' AND os_triage.triage_paciente_accidente_lugar='TRABAJO'"));
        }
    }
    public function ChartSt7Terminada($data) {
        $POR_FECHA_FI= $data['POR_FECHA_FECHA_I'];
        $POR_FECHA_FF= $data['POR_FECHA_FECHA_F'];
        $POR_HORA_F= $data['POR_HORA_FECHA'];
        $POR_HORA_HI= $data['POR_HORA_HORA_I'];
        $POR_HORA_HF= $data['POR_HORA_HORA_F'];
        $COLOR=$data['COLOR'];
        if($data['FILTRO']=='Por Fecha'){
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_asistentesmedicas.asistentesmedicas_omitir='No' AND 
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha BETWEEN '$POR_FECHA_FI' AND '$POR_FECHA_FF' AND os_triage.triage_paciente_accidente_lugar='TRABAJO'"));
        }else{
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_asistentesmedicas.asistentesmedicas_omitir='No' AND 
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha='$POR_HORA_F' AND
                os_asistentesmedicas.asistentesmedicas_hora BETWEEN '$POR_HORA_HI' AND '$POR_HORA_HF' AND os_triage.triage_paciente_accidente_lugar='TRABAJO'"));
        }
    }
    public function ChartEspontanea($data) {
        $POR_FECHA_FI= $data['POR_FECHA_FECHA_I'];
        $POR_FECHA_FF= $data['POR_FECHA_FECHA_F'];
        $POR_HORA_F= $data['POR_HORA_FECHA'];
        $POR_HORA_HI= $data['POR_HORA_HORA_I'];
        $POR_HORA_HF= $data['POR_HORA_HORA_F'];
        $COLOR=$data['COLOR'];
        if($data['FILTRO']=='Por Fecha'){
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha BETWEEN '$POR_FECHA_FI' AND '$POR_FECHA_FF' AND os_triage.triage_procedencia!=''"));
        }else{
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_asistentesmedicas.asistentesmedicas_omitir='No' AND 
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha='$POR_HORA_F' AND
                os_asistentesmedicas.asistentesmedicas_hora BETWEEN '$POR_HORA_HI' AND '$POR_HORA_HF' AND os_triage.triage_procedencia!=''"));
        }
    }
    public function ChartNoEspontanea($data) {
        $POR_FECHA_FI= $data['POR_FECHA_FECHA_I'];
        $POR_FECHA_FF= $data['POR_FECHA_FECHA_F'];
        $POR_HORA_F= $data['POR_HORA_FECHA'];
        $POR_HORA_HI= $data['POR_HORA_HORA_I'];
        $POR_HORA_HF= $data['POR_HORA_HORA_F'];
        $COLOR=$data['COLOR'];
        if($data['FILTRO']=='Por Fecha'){
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha BETWEEN '$POR_FECHA_FI' AND '$POR_FECHA_FF' AND os_triage.triage_procedencia=''"));
        }else{
            return count($this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_asistentesmedicas_rc, os_triage
                WHERE
                os_asistentesmedicas.triage_id=os_triage.triage_id AND
                os_asistentesmedicas.asistentesmedicas_omitir='No' AND
                os_triage.triage_color='$COLOR' AND
                os_asistentesmedicas_rc.asistentesmedicas_id=os_asistentesmedicas.asistentesmedicas_id AND
                os_asistentesmedicas.asistentesmedicas_fecha='$POR_HORA_F' AND
                os_asistentesmedicas.asistentesmedicas_hora BETWEEN '$POR_HORA_HI' AND '$POR_HORA_HF' AND os_triage.triage_procedencia=''"));
        }
    }
    public function AjaxMedicoTratantes() {
        $sql= $this->config_mdl->_query("SELECT * FROM os_empleados, os_empleados_roles, os_roles WHERE
                                        os_empleados.empleado_id=os_empleados_roles.empleado_id AND
                                        os_roles.rol_id=os_empleados_roles.rol_id AND
                                        os_roles.rol_id=2");
        foreach ($sql as $value) {
            $Medico.="'".$value['empleado_nombre'].' '.$value['empleado_apellidos']."',";
            
        }
        $this->setOutput(array('medicos'=>trim($Medico,',')));
    }
}
