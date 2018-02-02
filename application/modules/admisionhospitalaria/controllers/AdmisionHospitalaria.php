<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of AdmisionHospitalaria
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class AdmisionHospitalaria extends Config{
    public function AsignarCamas() {
        $this->load->view('AsignarCamas');
    }
    public function TotalCamasEstatusPisos($Piso,$Estado) {
        return count($this->config_mdl->_query("SELECT os_camas.cama_id FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id AND os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_camas.cama_status='$Estado' AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id AND os_pisos.piso_id=".$Piso));
        
    }
    public function TotalCamasEstatus($Estado) {
        return count($this->config_mdl->_query("SELECT os_camas.cama_id FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id AND os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_camas.cama_status='$Estado' AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id"));
        
    }

/**
 * Funcion para el contenido de visor de camas e por Asistentes Medicas
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 **/
    public function AjaxVisorCamas() {
        $Pisos= $this->config_mdl->_query("SELECT * FROM os_pisos");
        $Col='';
        $TotalDisponibles= $this->TotalCamasEstatus('Disponible');
        $TotalAsignados= $this->TotalCamasEstatus('Asignado');
        $TotalLimpieza= $this->TotalCamasEstatus('En Limpieza');
        $TotalOcupado= $this->TotalCamasEstatus('Ocupado');
        $TotalMantenimiento= $this->TotalCamasEstatus('En Mantenimiento');
        $TotalContaminada= $this->TotalCamasEstatus('Contaminadas');
        foreach ($Pisos as $value) {
            $Camas= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas, os_pisos, os_pisos_camas
                                            WHERE os_areas.area_id=os_camas.area_id AND os_pisos_camas.cama_id=os_camas.cama_id AND
                                            os_pisos_camas.piso_id=os_pisos.piso_id AND os_pisos.piso_id=".$value['piso_id']);
            $Disponibles= $this->TotalCamasEstatusPisos($value['piso_id'], 'Disponible');
            $Limpieza= $this->TotalCamasEstatusPisos($value['piso_id'], 'En Limpieza');
            $Ocupado= $this->TotalCamasEstatusPisos($value['piso_id'], 'Ocupado');
            $Mantenimiento= $this->TotalCamasEstatusPisos($value['piso_id'], 'En Mantenimiento');
            $Asignado= $this->TotalCamasEstatusPisos($value['piso_id'], 'Asignado');
            $TotalInfectados= count($this->config_mdl->_query("SELECT os_areas_pacientes.ap_id FROM os_camas,os_areas_pacientes, os_pisos, os_pisos_camas WHERE
                                os_camas.cama_id=os_areas_pacientes.cama_id AND 
                                os_pisos.piso_id=os_pisos_camas.piso_id AND 
                                os_camas.cama_id=os_pisos_camas.cama_id AND os_areas_pacientes.ap_infeccion='Infectado' AND
                                os_pisos.piso_id=".$value['piso_id']));
            
/* Realiza el panel en los pisos */
            $Col.=' <div class="panel panel-default">
                        <div class="panel-heading back-imss">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse_'.$value['piso_id'].'"> 
                                    <div class="row">
                                        <div class="col-md-2" style="padding: 0px;">
                                            <span style="text-transform:uppercase">'.$value['piso_nombre'].'</span>
                                        </div>
                                        <div class="col-md-10" style="font-size:14px">
                                            <i class="fa fa-bed"></i> Total '. count($Camas).' Camas&nbsp;&nbsp;
                                            '.$Disponibles.' Disponibles&nbsp;&nbsp;
                                            '.$Ocupado.' Ocupadas&nbsp;&nbsp;
                                            '.$Asignado.' Asignadas&nbsp;&nbsp;
                                            '.$Limpieza.' Limpieza&nbsp;&nbsp;
                                            '.$Mantenimiento.' Mantenimiento&nbsp;&nbsp;
                                            '.$Contaminadas.' Contaminadas
                                        </div>
                                        <div class="col-md-offset-2 col-md-10">
                                            
                                        </div>
                                    </div>
                                </a>
                            </h4>
                        </div>
<!-- Coloca camas en el  panel -->
                        <div id="collapse_'.$value['piso_id'].'" class="panel-collapse collapse ">
                            <div class="panel-body" style=" padding: 5px;">
                                <div class="row">';
                                foreach ($Camas as $value) { 
                                    $InfectadoColor='';
                                    $Accion='';
                                    $Paciente='&nbsp;';
                                    $Enfermera='&nbsp;';
                                    
                                    
                                    $sqlPaciente= $this->config_mdl->sqlGetDataCondition('doc_43051',array(
                                        'ac_estatus_doc'=>'Asignación',
                                        'ac_estatus'=>'Asignación',
                                        'cama_id'=> $value['cama_id'],
                                    ));
                                    $InfoPaciente = $this->config_mdl->_query("SELECT * FROM os_triage, os_areas_pacientes, os_camas WHERE 
                                                    os_areas_pacientes.triage_id=os_triage.triage_id AND
                                                    os_areas_pacientes.cama_id=os_camas.cama_id AND os_triage.triage_id=".$value['cama_id']);
                                    
                                    if(!empty($sqlPaciente)){
                                        $Estado='<span class="label red">Cama Asignada</span>';
                                    }else{
                                        $Estado='';
                                    }
                                    $Triage=$this->config_mdl->_get_data_condition("os_triage",array(
                                        'triage_id'=>$sqlPaciente[0]['triage_id']
                                    ))[0];
                                    $TriageNombre_=$Triage['triage_nombre'].' '.$Triage['triage_nombre_ap'].' '.$Triage['triage_nombre_am'];
                                    if(strlen($Paciente)>35){
                                        $TriageNombre= mb_substr($TriageNombre_, 0,35,'UTF-8');
                                    }else{
                                        $TriageNombre=$TriageNombre_;
                                    }
                                    $Asigna=$this->config_mdl->sqlGetDataCondition("os_empleados",array(
                                        'empleado_id'=>$sqlPaciente[0]['empleado_id']
                                    ),'empleado_id,empleado_nombre,empleado_apellidos')[0];
                                    $EnfermeraNombre_=$Asigna['empleado_nombre'].' '.$Asigna['empleado_apellidos'];
                                    if(strlen($EnfermeraNombre_)>35){
                                        $EnfermeraNombre= mb_substr($EnfermeraNombre_, 0,35,'UTF-8');
                                    }else{
                                        $EnfermeraNombre=$EnfermeraNombre_;
                                    }
/* Boton */                      $Accion1='<button md-ink-ripple="" class="md-btn md-fab m-b bg-white waves-effect tip btn-paciente-agregar" data-accion="Disponible" data-cama="'.$value['cama_id'].'"  data-original-title="Agregar Paciente">
                                                        <i class="mdi-social-person-add i-24 text-color-imss" ></i>
                                                    </button>';
/* Menu para Generar 43051, Liberar Cama, Eliminar 43051 en cama asignada en asistentes medicas*/
                                    $Accion2='<ul class="list-inline">
                                                        <li class="dropdown">
                                                            <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab red md-btn-circle waves-effect" aria-expanded="false">
                                                                <i class="mdi-navigation-more-vert text-color-white" ></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">
                                                                <li><a href="#" class="generar43051" data-triage="'.$sqlPaciente[0]['triage_id'].'" data-cama="'.$value['cama_id'].'"><i class="fa fa-print icono-accion"></i> Generar 43051</a></li>
                                                                <li><a href="#" class="liberar43051" data-triage="'.$sqlPaciente[0]['triage_id'].'" data-cama="'.$value['cama_id'].'"><i class="fa fa-share-square-o icono-accion"></i> Liberar Cama</a></li>
                                                                <li><a href="#" class="eliminar43051" data-triage="'.$sqlPaciente[0]['triage_id'].'" data-cama="'.$value['cama_id'].'"><i class="fa fa-trash-o icono-accion"></i> Eliminar 43051</a></li>
                                                            </ul>
                                                        </li>
                                                    </ul>';
                                    
                                    if($value['cama_status']=='Disponible'){
                                        $CamaStatus='blue';
                                        if(empty($sqlPaciente)){
                                            $Accion=$Accion1;
                                        }else{
                                            $Accion=$Accion2;
                                            $Paciente='<b></b>'.$TriageNombre;
                                            $Enfermera='<b></b>'.$EnfermeraNombre;
                                        }
                                    }else if($value['cama_status']=='En Limpieza' ){
                                        $CamaStatus='orange';
                                        if(empty($sqlPaciente)){
                                            $Accion=$Accion1;
                                        }else{
                                            $Accion=$Accion2;
                                            $Paciente='<b>PACIENTE:</b>'.$TriageNombre;
                                            $Enfermera='<b>ENF.:</b>'.$EnfermeraNombre;
                                        }
                                        
                                    
                                    }else if($value['cama_status']=='En Mantenimiento'){
                                        $CamaStatus='red';
                                    }else if($value['cama_status']=='Descompuesta'){
                                        $CamaStatus='yellow';
                                    }else if($value['cama_status']=='Ocupado'){
                                        $CamaStatus='green';
                                        if(empty($sqlPaciente)){
                                            $Accion=$Accion1;
                                        }else{
                                            $Accion=$Accion2;
                                            $Paciente='<b>PACIENTE:</b>'.$TriageNombre;
                                            $Enfermera='<b>ENF.:</b>'.$EnfermeraNombre;
                                        }
                                        
                                    }else if($value['cama_status']=='En Espera'){
                                        $CamaStatus='blue-grey-700';    
                                    }

    /* DIBUJA CUADRO DE CAMAS */
    /*                        $Col.=' <div class="col-md-4" style="margin-bottom:-5px">
                                        <div class="card '.$CamaStatus.' color-white" style="border-radius:3px">
                                            <div style="position:relative">
                                                <div style="position: absolute;width: 10px;height: 81px;top: 25px;" class="'.$InfectadoColor.'">b</div>
                                            </div>
                                        <div class="row" style=" background: #256659!important;padding: 4px 2px 2px 12px;width: 100%;margin-left: 0px;">
                                            <div class="col-md-12">  <!-- Pone el titulo de nombre de area -->
                                                <b style="text-transform:uppercase;font-size:10px;margin-left:-14px"><i class="fa fa-window-restore"></i> '.$value['area_nombre'].'</b>
                                                </div>
                                            </div>
                                            <div class="card-heading" style="margin-top:-10px">
                                                <h5 class="font-thin color-white" style="font-size:19px!important;margin-left: -10px;margin-top: 0px;text-transform: uppercase">
                                                    <i class="fa fa-bed " ></i> <b>'.$value['cama_nombre'].' | '.$value['cama_status'].'</b>
                                                </h5>
                                            </div>
                                            <div class="card-tools" style="right:2px;top:2px">'.$Accion.'</div>
                                            <div style="position:relative">
                                                <div style="position: absolute;right: 0px;">'.$Estado.'</div>
                                            </div>
                                            <div class="card-body" style="margin-top:-20px;margin-left:-11px;padding:0px 24px 3px;">
                                                <p style="font-size: 10px;">'.$Paciente.'</p>
                                                <p style="margin-top: -7px;font-size: 10px;margin-bottom: 5px;">'.$Enfermera.'</p>
                                            </div>
                                        </div>
                                    </div>';      */  
                                
        $Col.=' <div class="col-md-2" style="padding: 3px; margin-bottom:-10px">
                    <div class="card '.$CamaStatus.' color-white" style="border-radius:5px">
                        <div style="position:relative">
                            <div style="position: absolute;width: 10px;height: 81px;top: 25px;" class="'.$InfectadoColor.'"></div>
                        </div>
                        <div class="row" style="padding: 4px 2px 2px 12px;width: 100%;margin-left:-6px;">
                            <i class="fa fa-bed " ></i><b> '.$value['cama_nombre'].'</b>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-left: -21px;margin-top:-21px">
                                <small style="opacity: 1;font-size: 10px"> 
                                    <b class="text-right pull-right">12/12/2018</b>
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card-body" style="margin-top:-5px;margin-left:-3px;padding:0px 24px 3px;">
                                <p style="font-size: 10px;">'.$Paciente.'</p> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-left: 6px;margin-top:-6px">
                                <small style="opacity: 1;font-size: 11px"> 
                                    <b class="text-left">699 dias 23 hrs 36 min</b>
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-left: 6px;margin-top:-6px">
                                <small style="opacity: 1;font-size: 10px"> 
                                    <b class="text-left">CIRUGIA DE CABEZA Y CUELLO</b>
                                </small>
                            </div>
                        </div>
                        
                        <div class="card-tools" style="right:2px;top:2px">'.$Accion.'</div>
                        <div class="card-heading" style="margin-top:-10px">
                        <!--    <h5 class="font-thin color-white" style="font-size:19px!important;margin-left: -10px;margin-top: 0px;text-transform: uppercase">
                                <i class="fa fa-bed " ></i> '.$value['cama_nombre'].'
                            </h5> -->
                        </div>
                        <div class="card-body" style="margin-top:-21px;margin-left:-17px;padding:0px 24px 3px;">
                            <p style="margin-top: -7px;font-size: 10px;margin-bottom: 5px;">Médico:</p>
                            <p style="margin-top: -7px;font-size: 10px;margin-bottom: 5px;">'.$Enfermera.'</p> 
                        </div>
                    </div>
                </div>';
                                
        }



                                
            $Col.='             </div>
                            </div>
                        </div>
                    </div>';
        }
        $this->setOutput(array('accion'=>'1',
            'Col'=>$Col,
            'TotalDisponibles'=>$TotalDisponibles,
            'TotalLimpieza'=>$TotalLimpieza,
            'TotalOcupado'=>$TotalOcupado,
            'TotalMantenimiento'=>$TotalMantenimiento,
            'TotalAsignados'=>$TotalAsignados
        ));
    }
    public function AjaxBuscarPaciente() {
        $sql= $this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'triage_id'=> $this->input->post('triage_id'),
            'ac_estatus'=>'Asignación'
        ));
        if(!empty($sql)){
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AsignarCama() {
        $sql['info']= $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id'=>$_GET['triage_id']
        ))[0];
        $this->load->view('AsignarCama',$sql);
    }
    public function AjaxAsignarCama_v2() {
        $sqlEmpleado= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ),'empleado_id');
        if(!empty($sqlEmpleado)){
            $this->AccesosUsuarios(array('acceso_tipo'=>'Admisión Hospitalaria AC','triage_id'=>$this->input->post('triage_id'),'areas_id'=>0));
            $this->config_mdl->_insert('doc_43051',array(
                'ac_estatus'=>'Asignación',
                'ac_estatus_doc'=>'Asignación',
                'ac_fecha'=> date('Y-m-d H:i:s'),
                'cama_id'=> $this->input->post('cama_id'),
                'ac_ingreso_servicio'=> $this->input->post('ac_ingreso_servicio'),
                'ac_ingreso_medico'=> $this->input->post('ac_ingreso_medico'),
                'ac_ingreso_matricula'=> $this->input->post('ac_ingreso_matricula'),
                'ac_salida_servicio'=> $this->input->post('ac_salida_servicio'),
                'ac_salida_medico'=> $this->input->post('ac_ingreso_servicio'),
                'ac_salida_matricula'=> $this->input->post('ac_salida_matricula'),
                'ac_infectado'=> $this->input->post('ac_infectado'),
                'ac_cama_estatus'=> $this->input->post('ac_cama_estatus'),
                'cama_id'=> $this->input->post('cama_id'),
                'empleado_id'=> $sqlEmpleado[0]['empleado_id'],
                'triage_id'=> $this->input->post('triage_id')
            ));
            Modules::run('Triage/TriagePacienteDirectorio',array(
                'directorio_tipo'=>'Familiar',
                'directorio_cp'=> $this->input->post('directorio_cp'),
                'directorio_cn'=> $this->input->post('directorio_cn'),
                'directorio_colonia'=> $this->input->post('directorio_colonia'),
                'directorio_municipio'=> $this->input->post('directorio_municipio'),
                'directorio_estado'=> $this->input->post('directorio_estado'),
                'directorio_telefono'=> '',
                'triage_id'=>$this->input->post('triage_id')
            ));
            
            $this->setOutput(array('accion'=>'1'));
        
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxEliminar43051() {
        $this->config_mdl->_delete_data('doc_43051',array(
            'triage_id'=> $this->input->post('triage_id'),
            'cama_id'=> $this->input->post('cama_id'),
        ));
        
        $this->setOutputV2(array('accion'=>'1'));
    }
    public function AjaxLiberarCama43051() {
        $this->config_mdl->_update_data('doc_43051',array(
            'ac_estatus_doc'=>'Liberado'
        ),array(
            'ac_estatus_doc'=>'Asignación',
            'triage_id'=> $this->input->post('triage_id'),
            'cama_id'=> $this->input->post('cama_id'),
        ));
        $this->setOutputV2(array('accion'=>'1'));
    }
    public function PasesdeVisitas() {
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE os_areas.area_id=os_camas.area_id AND os_camas.cama_status='Ocupado'");
        $this->load->view('Pases/PasesDeVisitas',$sql);
    }
    public function PasesdeVisitasFamiliares() {
        $sql['Gestion']= $this->config_mdl->sqlGetDataCondition("um_poc_familiares",array(
            'triage_id'=>$_GET['folio'],
            'familiar_tipo'=>$_GET['tipo']
        ));
        $this->load->view('Pases/PasesdeVisitasFamiliares',$sql);
    }
    public function AgregarFamiliar() {
        $sql['info']= $this->config_mdl->sqlGetDataCondition('um_poc_familiares',array(
            'familiar_id'=>$_GET['familiar']
        ))[0];
        $this->load->view('Pases/PasesdeVisitasFamiliaresAgregar',$sql);
    }
    public function AjaxAgregarFamiliar() {
        $data=array(
            'familiar_nombre'=> $this->input->post('familiar_nombre'),
            'familiar_nombre_ap'=> $this->input->post('familiar_nombre_ap'),
            'familiar_nombre_am'=> $this->input->post('familiar_nombre_am'),
            'familiar_parentesco'=> $this->input->post('familiar_parentesco'),
            'familiar_registro'=> date('Y-m-d H:i:s'),
            'familiar_tipo'=> $this->input->post('familiar_tipo'),
            'triage_id'=> $this->input->post('triage_id')
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('um_poc_familiares',$data);
        }else{
            unset($data['familiar_registro']);
            $this->config_mdl->_update_data('um_poc_familiares',$data,array(
                'familiar_id'=> $this->input->post('familiar_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxEliminarFamiliar() {
        $this->config_mdl->_delete_data('um_poc_familiares',array(
            'familiar_id'=> $this->input->post('familiar_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AgregarFamiliarFoto() {
        $this->load->view('Pases/PasesdeVisitasFamiliaresAgregarFoto');
    }
    public function AjaxGuardarPerfilFamiliar() {
        $data = $this->input->post('familiar_perfil');
        $data = str_replace('data:image/jpeg;base64,', '', $data);
        $url_save='assets/img/familiares/';
        $data = base64_decode($data);
        $familiar_perfil = $url_save.$this->input->post('familiar_id').'_'.$this->input->post('triage_id').'.jpeg';
        file_put_contents($familiar_perfil, $data);
        $data = base64_decode($data); 
        $source_img = imagecreatefromstring($data);
        $rotated_img = imagerotate($source_img, 90, 0); 
        $familiar_perfil = $url_save.$this->input->post('familiar_id').'_'.$this->input->post('triage_id').'.jpeg';
        imagejpeg($rotated_img, $familiar_perfil, 10);
        imagedestroy($source_img);
        $this->config_mdl->_update_data('um_poc_familiares',array(
            'familiar_perfil'=>$this->input->post('familiar_id').'_'.$this->input->post('triage_id').'.jpeg'
        ),array(
            'familiar_id'=> $this->input->post('familiar_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
}
