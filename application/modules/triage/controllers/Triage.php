<?php
/**
 * Description of Triage
 *
 * @author felipe de jesus | itifjpp@gmail.com 
 */
include_once APPPATH.'modules/config/controllers/Config.php';
class Triage extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function Enfermeriatriage() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_accesos, os_empleados
                                                    WHERE 
                                                    os_accesos.acceso_tipo='Triage Enfermería' AND
                                                    os_accesos.triage_id=os_triage.triage_id AND
                                                    os_accesos.empleado_id=os_empleados.empleado_id AND
                                                    os_empleados.empleado_id=$this->UMAE_USER ORDER BY os_accesos.acceso_id DESC LIMIT 10");
        if($this->ConfigEnfermeriaHC=='Si'){
            $this->load->view('Enfermeriatrige/Horacero',$sql);
        }else{
            $this->load->view('Enfermeriatrige/index',$sql);
        }
    }
    public function Medicotriage() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_accesos, os_empleados
                                                    WHERE 
                                                    os_accesos.acceso_tipo='Triage Médico' AND
                                                    os_accesos.triage_id=os_triage.triage_id AND
                                                    os_accesos.empleado_id=os_empleados.empleado_id AND
                                                    os_empleados.empleado_id=$this->UMAE_USER ORDER BY os_accesos.acceso_id DESC LIMIT 10");
        $this->load->view('Medicotriage/index',$sql);
    }
    public function EtapaPaciente($paciente) {
        $sql=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $paciente
        ));
        if($this->UMAE_AREA=='Enfermeria Triage'){
            if(!empty($sql)){
                $this->setOutput(array('accion'=>'1'));
            }else{
                $this->setOutput(array('accion'=>'2'));
            }
        }else{
            if($sql[0]['triage_fecha_clasifica']==''){
                if($sql[0]['triage_nombre']==''){
                    $this->setOutput(array('accion'=>'3'));
                }else{
                    $this->setOutput(array('accion'=>'1'));
                }
                
            }else{
                $Medico= $this->config_mdl->_get_data_condition('os_empleados',array(
                    'empleado_id'=>$sql[0]['triage_crea_medico']
                ));
                $this->setOutput(array('accion'=>'2','info'=>$sql[0],'medico'=>$Medico[0]));
            }
        }
        
    }
    public function Paciente($paciente) {
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$paciente
        ))[0];
        $sql['SignosVitales']= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
            'sv_tipo'=>'Triage',
            'triage_id'=>$paciente
        ))[0];
        $sql['PINFO']=$this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$paciente
        ))[0];
        if($this->UMAE_AREA=='Enfermeria Triage' || $_GET['via']=='Paciente'){
            $this->load->view('Enfermeriatrige/paciente',$sql);
        }else{
            $this->load->view('Medicotriage/paciente',$sql);
        }
    }
    /*Guardar datos*/
    public function EnfemeriatriageGuardar() {
        $data=array(
            'triage_via_registro'=>'Hora Cero',
            'triage_fecha'=> date('Y-m-d'), 
            'triage_hora'=> date('H:i'), 
            'triage_nombre'=> $this->input->post('triage_nombre'),
            'triage_nombre_ap'=>$this->input->post('triage_nombre_ap'),
            'triage_nombre_am'=>$this->input->post('triage_nombre_am'),
            'triage_paciente_sexo'=> $this->input->post('triage_paciente_sexo'),
            'triage_fecha_nac'=> $this->input->post('triage_fecha_nac'),
            'triage_crea_enfemeria'=> $this->UMAE_USER
        );
        $this->SignosVitales(array(
            'sv_ta'=> $this->input->post('sv_ta'),
            'sv_temp'=> $this->input->post('sv_temp'),
            'sv_fc'=> $this->input->post('sv_fc'),
            'sv_fr'=> $this->input->post('sv_fr'),
            'sv_oximetria'=> $this->input->post('sv_oximetria'),
            'sv_dextrostix'=> $this->input->post('sv_dextrostix'),
            'triage_id'=> $this->input->post('triage_id')
        ));
        $info=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $this->input->post('triage_id')
        ))[0];
        if($info['triage_fecha']!=''){ 
            unset($data['triage_fecha']);
            unset($data['triage_hora']); 
            unset($data['triage_crea_enfemeria']);
        }else{
            $this->AccesosUsuarios(array('acceso_tipo'=>'Triage Enfermería','triage_id'=>$this->input->post('triage_id'),'areas_id'=> $this->input->post('triage_id')));
        }
        $this->config_mdl->_update_data('paciente_info',array(
            'pic_indicio_embarazo'=>$this->input->post('pic_indicio_embarazo'),
            'pia_procedencia_espontanea'=>$this->input->post('pia_procedencia_espontanea'),
            'pia_procedencia_espontanea_lugar'=>$this->input->post('pia_procedencia_espontanea_lugar'),
            'pia_procedencia_hospital'=>$this->input->post('pia_procedencia_hospital'),
            'pia_procedencia_hospital_num'=>$this->input->post('pia_procedencia_hospital_num')
        ),array(
            'triage_id'=>$this->input->post('triage_id')
        ));
        Modules::run('Triage/LogChangesPatient',array(
            'paciente_old'=>$info['triage_nombre'].' '.$info['triage_nombre_ap'].' '.$info['triage_nombre_am'],
            'paciente_new'=> $this->input->post('triage_nombre').' '.$this->input->post('triage_nombre_ap').' '.$this->input->post('triage_nombre_am'),
            'nss_old'=>'NO APLICA',
            'nss_new'=>'NO APLICA',
            'triage_id'=>$this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('os_triage',$data,array('triage_id'=>  $this->input->post('triage_id')));
        $this->setOutput(array('accion'=>'1'));
        
    }
    public function AjaxCalcularEdad() {
        $this->setOutput(array(
            'Anio'=> $this->CalcularEdad_($this->input->post('triage_fecha_nac'))->y,
            'Mes'=> $this->CalcularEdad_($this->input->post('triage_fecha_nac'))->m,
            'Dia'=> $this->CalcularEdad_($this->input->post('triage_fecha_nac'))->d,
        ));
    }
    public function GuardarClasificacion() {
        $triege_preg_puntaje_s1=$this->input->post('triage_preg1_s1')+
                                $this->input->post('triage_preg2_s1')+
                                $this->input->post('triage_preg3_s1')+
                                $this->input->post('triage_preg4_s1')+
                                $this->input->post('triage_preg5_s1');
        $triege_preg_puntaje_s2=$this->input->post('triage_preg1_s2')+
                                $this->input->post('triage_preg2_s2')+
                                $this->input->post('triage_preg3_s2')+
                                $this->input->post('triage_preg4_s2')+
                                $this->input->post('triage_preg5_s2')+
                                $this->input->post('triage_preg6_s2')+
                                $this->input->post('triage_preg7_s2')+
                                $this->input->post('triage_preg8_s2')+
                                $this->input->post('triage_preg9_s2')+
                                $this->input->post('triage_preg10_s2')+
                                $this->input->post('triage_preg11_s2')+ 
                                $this->input->post('triage_preg12_s2');
        
        $triege_preg_puntaje_s3=$this->input->post('triage_preg1_s3')+
                                $this->input->post('triage_preg2_s3')+
                                $this->input->post('triage_preg3_s3')+
                                $this->input->post('triage_preg4_s3')+
                                $this->input->post('triage_preg5_s3');
        $total_puntos=$triege_preg_puntaje_s1+$triege_preg_puntaje_s2+$triege_preg_puntaje_s3;
        if($total_puntos>30){
            $color='#E50914';
            $color_name='Rojo';
        }if($total_puntos>=21 && $total_puntos<=30){
            $color='#FF7028';
            $color_name='Naranja';
        }if($total_puntos>=11 && $total_puntos<=20){
            $color='#FDE910';
            $color_name='Amarillo';
        }if($total_puntos>=6 && $total_puntos<=10){
            $color='#4CBB17';
            $color_name='Verde';
        }if($total_puntos<=5){
            $color='#0000FF';
            $color_name='Azul';
        }
        if($this->input->post('inputOmitirClasificacion')=='Si'){
            $color_name= $this->input->post('clasificacionColor');
        }
        $data=array(
            'triage_fecha_clasifica'=>  date('Y-m-d'),
            'triage_hora_clasifica'=>  date('H:i'),
            'triage_color'=>$color_name,
            'triage_consultorio'=>  $this->input->post('triage_consultorio'),
            'triage_consultorio_nombre'=>  $this->input->post('triage_consultorio_nombre'),
            'triage_crea_medico'=> $this->UMAE_USER
        );
        
        $data_clasificacion=array(
            'triage_preg1_s1'=>  $this->input->post('triage_preg1_s1'),
            'triage_preg2_s1'=>  $this->input->post('triage_preg2_s1'),
            'triage_preg3_s1'=>  $this->input->post('triage_preg3_s1'),
            'triage_preg4_s1'=>  $this->input->post('triage_preg4_s1'),
            'triage_preg5_s1'=>  $this->input->post('triage_preg5_s1'),
            'triege_preg_puntaje_s1'=> $triege_preg_puntaje_s1,
            'triage_preg1_s2'=>  $this->input->post('triage_preg1_s2'),
            'triage_preg2_s2'=>  $this->input->post('triage_preg2_s2'),
            'triage_preg3_s2'=>  $this->input->post('triage_preg3_s2'),
            'triage_preg4_s2'=>  $this->input->post('triage_preg4_s2'),
            'triage_preg5_s2'=>  $this->input->post('triage_preg5_s2'),
            'triage_preg6_s2'=>  $this->input->post('triage_preg6_s2'),
            'triage_preg7_s2'=>  $this->input->post('triage_preg7_s2'),
            'triage_preg8_s2'=>  $this->input->post('triage_preg8_s2'),
            'triage_preg9_s2'=>  $this->input->post('triage_preg9_s2'),
            'triage_preg10_s2'=>  $this->input->post('triage_preg10_s2'),
            'triage_preg11_s2'=>  $this->input->post('triage_preg11_s2'),
            'triage_preg12_s2'=>  $this->input->post('triage_preg12_s2'),
            'triege_preg_puntaje_s2'=>$triege_preg_puntaje_s2,
            'triage_preg1_s3'=>  $this->input->post('triage_preg1_s3'),
            'triage_preg2_s3'=>  $this->input->post('triage_preg2_s3'),
            'triage_preg3_s3'=>  $this->input->post('triage_preg3_s3'),
            'triage_preg4_s3'=>  $this->input->post('triage_preg4_s3'),
            'triage_preg5_s3'=>  $this->input->post('triage_preg5_s3'),
            'triege_preg_puntaje_s3'=>$triege_preg_puntaje_s3,
            'triage_puntaje_total'=>$total_puntos,
            'triage_color'=>$color_name,
            'triage_observacion'=> $this->input->post('clasificacionObservacion'),
            'triage_id'=> $this->input->post('triage_id')
        );
        if($this->input->post('triage_consultorio_nombre')=='Ortopedia-Admisión Continua'){
            $this->config_mdl->_insert('or_admision_continua',array(
                'ac_envio_fecha'=> date('Y-m-d'),
                'ac_envio_hora'=> date('H:i:s'),
                'ac_ingreso_fecha'=>'',
                'ac_ingreso_hora'=>'',
                'ac_diagnostico'=> $this->input->post('ac_diagnostico'),
                'triage_id'=> $this->input->post('triage_id')
            ));
        }
        $this->AccesosUsuarios(array('acceso_tipo'=>'Triage Médico','triage_id'=>$this->input->post('triage_id'),'areas_id'=> $this->input->post('triage_id')));
        $this->config_mdl->_update_data('os_triage',$data,array('triage_id'=>  $this->input->post('triage_id')));
        $this->config_mdl->_insert('os_triage_clasificacion',$data_clasificacion);
        $this->setOutput(array('accion'=>'1','triage_id'=>  $this->input->post('triage_id') ));
    }    
    public function Indicador() {
        if($this->UMAE_AREA=='Enfermeria Triage'){
            $this->load->view('Enfermeriatrige/indicador');
        }else{
            $this->load->view('Medicotriage/indicador');
        }
    }
    public function AjaxIndicadorMedico() {
        $by_fecha_inicio= $this->input->post('inputFecha');
        
         if($this->UMAE_AREA=='Enfermeria Triage'){
            $ConditionCre='triage_crea_enfemeria';
            $ConditionFecha='triage_fecha';
            $ConditionHora='triage_hora';
        }else{
            $ConditionCre='triage_crea_medico';
            $ConditionFecha='triage_fecha_clasifica';
            $ConditionHora='triage_hora_clasifica';
        }
        $TOTAL_CAP= count($this->config_mdl->_query("SELECT * FROM os_triage WHERE os_triage.$ConditionCre=$this->UMAE_USER AND 
            os_triage.$ConditionFecha='$by_fecha_inicio' AND
            os_triage.$ConditionFecha!=''"));
        $this->setOutput(array(
            'TOTAL_INFO_CAP'=>$TOTAL_CAP
        ));
    }
    public function TriagePacienteDirectorio($data) {
        $sql= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'triage_id'=>$data['triage_id'],
            'directorio_tipo'=>$data['directorio_tipo']
        ));
        $datos=array(
            'directorio_cp'=> $data['directorio_cp'],
            'directorio_cn'=> $data['directorio_cn'],
            'directorio_colonia'=> $data['directorio_colonia'],
            'directorio_municipio'=> $data['directorio_municipio'],
            'directorio_estado'=> $data['directorio_estado'],
            'directorio_telefono'=> $data['directorio_telefono'],
            'directorio_tipo'=>$data['directorio_tipo'],
            'triage_id'=>$data['triage_id']
        );
        if(empty($sql)){
            $this->config_mdl->_insert('os_triage_directorio',$datos);
        }else{
            $this->config_mdl->_update_data('os_triage_directorio',$datos,array(
                'triage_id'=>$data['triage_id'],
                'directorio_tipo'=>$data['directorio_tipo']
            ));
        }
    }
    public function TriagePacienteEmpresa($data) {
        $sql= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$data['triage_id']
        ));
        $datos=array(
            'empresa_nombre'=> $data['empresa_nombre'],
            'empresa_modalidad'=> $data['empresa_modalidad'],
            'empresa_rp'=> $data['empresa_rp'],
            'empresa_fum'=> $data['empresa_fum'],
            'empresa_he'=> $data['empresa_he'],
            'empresa_hs'=>$data['empresa_hs'],
            'triage_id'=>$data['triage_id']
        );
        if(empty($sql)){
            $this->config_mdl->_insert('os_triage_empresa',$datos);
        }else{
            $this->config_mdl->_update_data('os_triage_empresa',$datos,array(
                'triage_id'=>$data['triage_id']
            ));
        }
    }
    public function SignosVitales($data) {
        // <editor-fold defaultstate="collapsed" desc="Signos Vitales">
        $sqlSv= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
            'sv_tipo'=>'Triage',
            'triage_id'=>$data['triage_id']
        ));
        $svData=array(
            'sv_tipo'=>'Triage',
            'sv_fecha'=> date('Y-m-d'),
            'sv_hora'=> date('H:i'),
            'sv_ta'=>$data['sv_ta'],
            'sv_temp'=>$data['sv_temp'],
            'sv_fc'=>$data['sv_fc'],
            'sv_fr'=>$data['sv_fr'],
            'sv_oximetria'=>$data['sv_oximetria'],
            'sv_dextrostix'=>$data['sv_dextrostix'],
            'triage_id'=>$data['triage_id'],
            'empleado_id'=> $this->UMAE_USER
        );
        if(empty($sqlSv)){
            $this->config_mdl->_insert('os_triage_signosvitales',$svData);
        }else{
            $this->config_mdl->_update_data('os_triage_signosvitales',$svData,array(
                'sv_tipo'=>'Triage',
                'triage_id'=>$data['triage_id']
            ));
        }
        // </editor-fold>
    }
    public function LogChangesPatient($data) {
        // <editor-fold defaultstate="collapsed" desc="Registro de Cambios">
        $dataPaciente=array(
            'log_fecha'=> date('Y-m-d H:i:s'),
            'log_nombre_paciente'=>$data['paciente_old'].'->'.$data['paciente_new'],
            'log_nss'=>$data['nss_old'].'->'.$data['nss_new'],
            'log_area'=> $this->UMAE_AREA,
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=> $data['triage_id']
        );
        
        if($data['paciente_old']!=$data['paciente_new']){
            $this->config_mdl->_insert('um_pacientes_log',$dataPaciente);
        }
        if($data['nss_old']!=$data['nss_new']){
            $this->config_mdl->_insert('um_pacientes_log',$dataPaciente);
        }
        // </editor-fold>
    }
    public function AjaxObtenerEdad() {
        $fecha= $this->CalcularEdad_($this->input->post('fechaNac'));
        $this->setOutput(array(
            'Anios'=>$fecha->y
        ));
    }
}
