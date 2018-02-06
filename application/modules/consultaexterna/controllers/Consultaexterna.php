<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Consultaexterna
 *
 * @author bienTICS
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Consultaexterna extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->view('consultaexterna_index');
    }
    public function AsistenteMedica($Paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
           'triage_id'=>  $Paciente
        ));
        $sql['solicitud']= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
           'triage_id'=> $Paciente
        ));
        $sql['empleado']= $this->config_mdl->_get_data_condition('os_empleados',array(
           'empleado_id'=> $this->UMAE_USER
        ));
        $sql['DirPaciente']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'=>  $Paciente,
            'directorio_tipo'=>'Paciente'
        ))[0];
        $sql['DirEmpresa']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'=>  $Paciente,
            'directorio_tipo'=>'Empresa'
        ))[0];
        $sql['Empresa']=  $this->config_mdl->_get_data_condition('os_triage_empresa',array(
           'triage_id'=>  $Paciente,
        ))[0];
        $sql['PINFO']=  $this->config_mdl->_get_data_condition('paciente_info',array(
           'triage_id'=>  $Paciente,
        ))[0];
        $sql['Especialidades'] = $this->config_mdl->_query("SELECT especialidad_id,especialidad_nombre
                                                            FROM um_especialidades
                                                            ORDER BY especialidad_nombre");
        $sql['Doc43051'] = $this->config_mdl->_get_data_condition("doc_43051",array(
          'triage_id' => $Paciente,
        ))[0];
        $sql['Medicos']= $this->config_mdl->_query("SELECT * FROM os_empleados, os_empleados_roles, os_roles WHERE
                                                    os_empleados_roles.empleado_id=os_empleados.empleado_id AND
                                                    os_empleados_roles.rol_id=os_roles.rol_id AND
                                                    os_roles.rol_id=2");

        $this->load->view('consultaexterna_am',$sql);
    }
    public function AjaxAsistenteMedica() {
        $data=array(
            'asistentesmedicas_fecha'=> date('Y-m-d'),
            'asistentesmedicas_hora'=> date('H:i'),
            'asistentesmedicas_hoja'=>  $this->input->post('asistentesmedicas_hoja'),
            'asistentesmedicas_renglon'=>  $this->input->post('asistentesmedicas_renglon'),
            'triage_id'=>  $this->input->post('triage_id')
        );
        $check_am= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $info=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $this->input->post('triage_id')
        ))[0];
        $infoPinfo=  $this->config_mdl->sqlGetDataCondition('paciente_info',array(
            'triage_id'=>  $this->input->post('triage_id')
        ),'pum_nss,pum_nss_agregado')[0];
        if(empty($check_am)){
            if($this->input->post('pia_lugar_accidente')=='TRABAJO'){
                Modules::run('Asistentesmedicas/DOC_ST7_FOLIO',array(
                    'triage_id'=>  $this->input->post('triage_id')
                ));
            }
            $this->config_mdl->_insert('os_asistentesmedicas',$data);
            $asistentesmedicas_id= $this->config_mdl->_get_last_id('os_asistentesmedicas','asistentesmedicas_id');
        }else{
            unset($data['asistentesmedicas_fecha']);
            unset($data['asistentesmedicas_hora']);
            $this->config_mdl->_update_data('os_asistentesmedicas',$data,
                array('triage_id'=>  $this->input->post('triage_id'))
            );
            $asistentesmedicas_id= $this->input->post('asistentesmedicas_id');
        }
        $data_triage=array(
            'triage_via_registro'=>'Consulta Externa',
            'triage_fecha'=> date('Y-m-d'),
            'triage_hora'=> date('H:i'),
            'triage_fecha_clasifica'=> date('Y-m-d'),
            'triage_hora_clasifica'=> date('H:i'),
            'triage_nombre'=>  $this->input->post('triage_nombre'),
            'triage_nombre_ap'=>$this->input->post('triage_nombre_ap') ,
            'triage_nombre_am'=>$this->input->post('triage_nombre_am') ,
            'triage_paciente_sexo'=> $this->input->post('triage_paciente_sexo'),
            'triage_fecha_nac'=>  $this->input->post('triage_fecha_nac'),
            'triage_paciente_estadocivil'=>  $this->input->post('triage_paciente_estadocivil'),
            'triage_paciente_curp'=>  $this->input->post('triage_paciente_curp'),
            'triage_crea_enfemeria'=> $this->UMAE_USER,
            'triage_crea_medico'=> $this->UMAE_USER,
            'triage_crea_am'=> $this->UMAE_USER,
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
            'pic_am'=> $this->input->post('pic_am'),
            'pia_vigencia' => $this->input->post('pia_vigencia'),
            'pia_documento' => $this->input->post('pia_documento'),
            'pia_procedencia_hospital' => $this->input->post('pia_procedencia_hospital')
        ),array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        //Arreglo con los valores que se registraran en la tabla doc_43051
        $empleado_matricula = $this->input->post('interConMedicoBase');
        $query['Empleado'] = $this->config_mdl->_query("SELECT CONCAT(empleado_nombre,' ',empleado_apellidos)empleado,empleado_matricula
                                                        FROM os_empleados
                                                        WHERE empleado_matricula ='".$empleado_matricula."' ");
        $dataDoc_43051 = array(
          'ac_fecha' => date('Y-m-d'),
          'ac_ingreso_servicio' => $this->input->post('empleado_servicio'),
          'ac_ingreso_medico' => $query['Empleado'][0]['empleado'],
          'ac_ingreso_matricula' => $query['Empleado'][0]['empleado_matricula'],
          'ac_diagnostico' => $this->input->post('ac_diagnostico'),
          'ac_procedimiento' => $this->input->post('ac_procedimiento'),
          'triage_id' => $this->input->post('triage_id'),
          'empleado_id' => $this->UMAE_USER
        );
        $this->config_mdl->_insert("doc_43051",$dataDoc_43051);
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
        if(empty($check_am)){
            $this->AccesosUsuarios(array('acceso_tipo'=>'Asistente Médica Consulta Externa','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$asistentesmedicas_id));
        }else{
            unset($data_triage['triage_fecha']);
            unset($data_triage['triage_hora']);
            unset($data_triage['triage_fecha_clasifica']);
            unset($data_triage['triage_hora_clasifica']);
            unset($data_triage['triage_crea_enfemeria']);
            unset($data_triage['triage_crea_medico']);
            unset($data_triage['triage_crea_am']);
        }

        $this->setOutput(array('accion'=>'1'));
    }
}
