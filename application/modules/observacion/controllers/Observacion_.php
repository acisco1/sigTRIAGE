<?php
/**
 * Description of Observacion
 *
 * @author felipe de jesus
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Observacion extends Config{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $sqlGetRol= $this->config_mdl->sqlGetDataCondition('os_areas_acceso',array(
            'areas_acceso_nombre'=> $this->UMAE_AREA
        ),'areas_acceso_rol')[0];
        if($sqlGetRol['areas_acceso_rol']=='3'){
            $this->load->view('enfermeria');
        }else{
            $sql['info']= $this->config_mdl->_get_data_condition('os_empleados',array(
                'empleado_id'=> $this->UMAE_USER
            ))[0];
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_observacion, os_observacion_llamada, os_triage
                            WHERE 
                            os_observacion.triage_id=os_triage.triage_id AND
                            os_observacion.observacion_id=os_observacion_llamada.observacion_id AND
                            os_observacion.observacion_status_v2!='Salida' AND
                            os_observacion.empleado_id='$this->UMAE_USER' ORDER BY os_observacion_llamada.observacion_llamada_id DESC");
            $this->load->view('medico',$sql);
        }
    }
    public function AreasObservacion() {
        $sqlArea= $this->config_mdl->sqlGetDataCondition('os_areas',array(
            'area_modulo'=>'Observación',
            'area_nombre'=> $this->UMAE_AREA
        ),'area_id')[0];
        echo $sqlArea['area_id'];
    }
    public function GetArea() {
        if(CONFIG_ENFERMERIA_OBSERVACION=='Si'){
            $sql= $this->config_mdl->sqlGetDataCondition('os_areas',array(
                'area_modulo'=>'Observación'
            ),'area_id')[0];
            return $sql['area_id'];
        }else{
            $sql= $this->config_mdl->sqlGetDataCondition('os_areas',array(
                'area_modulo'=>'Observación'
            ),'area_id');
            return $sql['area_id'];
            
        }
    }
    public function UMAE_AREA() {
		if($this->UMAE_AREA=='Enfermería Observación Pediatría'){
            return 3;
        }if($this->UMAE_AREA=='Enfermería Observación Adultos Mujeres'){
            return 4;
        }if($this->UMAE_AREA=='Enfermería Observación Adultos Hombres'){
            return 5;
        }
		if($this->UMAE_AREA=='Enfermería Observación Urgencias'){
            return 1;
        }
    }
    public function CargarCamas(){
        $Camas=  $this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE os_areas.area_id=os_camas.area_id AND os_camas.area_id=".$this->UMAE_AREA());
        if(!empty($Camas)){
            
            foreach ($Camas as $value) {
                $Accion='';
                $Alta='';
                $Anexos='';
                $LimpiezaMantenimiento='';
                $Tarjeta='';
                $CambiarCama='';
                $StatusCama='';
                $Enfermera='<br><br>';
                $Paciente='';
                $Pulsera='';
                if($value["cama_status"]=='Disponible'){
                    $Color='blue';
                    $Accion='<button md-ink-ripple="" class="md-btn md-fab m-b green waves-effect tip btn-paciente-agregar" data-cama="'.$value['cama_id'].'"  data-original-title="Agregar Paciente">
                                <i class="mdi-content-add i-24" ></i>
                            </button>';
                }else if($value["cama_status"]=='Ocupado'){
                    $Color='green';
                    $sqlPaciente= $this->config_mdl->_get_data_condition("os_triage",array(
                        'triage_id'=>$value['cama_dh']
                    ))[0];
                    $sqlObs= $this->config_mdl->_get_data_condition('os_observacion',array(
                        'triage_id'=>$sqlPaciente['triage_id']
                    ))[0];
                    $sql_ti= $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array(
                        'triage_id'=>$sqlPaciente['triage_id']
                    ))[0];
                    $sql_enf= $this->config_mdl->_get_data_condition('os_empleados',array(
                        'empleado_id'=>$sqlObs['observacion_crea']
                    ))[0];
                    
                    $StatusCama=$value['cama_ingreso_f'].' '.$value['cama_ingreso_h'];
                    $Alta='<li><a class="alta-paciente" data-alta="'.$sqlObs['observacion_alta'].'" data-cama="'.$value['cama_id'].'" data-triage="'.$sqlPaciente['triage_id'].'"><i class="fa fa-share-square-o icono-accion"></i> Alta Paciente</a></li>';
                    $Anexos='<li><a href="'.  base_url().'Sections/Documentos/Expediente/'.$sqlPaciente['triage_id'].'/?tipo=Observación&url=Enfermeria" target="_blank"><i class="fa fa-files-o icono-accion"></i> Archivos Anexos</a></li>';    
                    $Tarjeta='<li><a href="" class="add-tarjeta-identificacion" data-id="'.$sqlPaciente['triage_id'].'" data-enfermedad="'.$sql_ti['ti_enfermedades'].'" data-alergia="'.$sql_ti['ti_alergias'].'"><i class="fa fa-address-card-o icono-accion"></i> Tarjeta de Identificación</a></li>';
                    $CambiarCama='<li><a href="" class="cambiar-cama-paciente" data-id="'.$sqlPaciente['triage_id'].'" data-area="'.$value['area_id'].'" data-cama="'.$value['cama_id'].'"><i class="fa fa-bed icono-accion"></i> Cambiar Cama</a></li>';
                    
                    $Pulsera='<li><a href="'. base_url().'Inicio/Documentos/ImprimirPulsera/'.$sqlPaciente['triage_id'].'" data-id="'.$sqlPaciente['triage_id'].'" class="imprimir-pulsera"><i class="fa fa-print icono-accion"></i> Imprimir Pulsera</a></li>';
                    $PacienteNombre= $sqlPaciente['triage_nombre'].' '.$sqlPaciente['triage_nombre_ap'].' '.$sqlPaciente['triage_nombre_am'];
                    $Paciente='<b>PACIENTE:</b> '. $PacienteNombre.'<br>';
                    $Enfermera='<b>ENF:</b> '.$sql_enf['empleado_nombre'].' '.$sql_enf['empleado_apellidos'].' <i class="fa fa-user-md pull-right pointer cambiar-enfermera i-16" style="margin-top:-3px" data-id="'.$sqlPaciente['triage_id'].'"></i>';
                        

                    $Accion='<ul class="list-inline" style="margin-top: -9px;">
                                    <li class="dropdown">
                                        <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                            <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">'.$Alta.' '.$Anexos.' '.$LimpiezaMantenimiento.' '.$Tarjeta.' '.$CambiarCama.' '.$Pulsera.'</ul>
                                    </li>
                                </ul>';
                }else if($value["cama_status"]=='En Mantenimiento'){
                    $Color='red';
                    $LimpiezaMantenimiento='<li><a class="finalizar-mantenimiento" data-id="'.$value['cama_id'].'"><i class="fa fa-wrench icono-accion"></i> Finalizar Limpieza / Mantenimiento</a></li>';
                    $Accion='<ul class="list-inline">
                                    <li class="dropdown">
                                        <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                            <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">'.$LimpiezaMantenimiento.'</ul>
                                    </li>
                                </ul>';   
                }else if($value["cama_status"]=='En Limpieza'){
                    $Color='orange';
                    $LimpiezaMantenimiento='<li><a class="finalizar-mantenimiento" data-id="'.$value['cama_id'].'"><i class="fa fa-wrench icono-accion"></i> Finalizar Limpieza / Mantenimiento</a></li>';
                    $Accion='<ul class="list-inline">
                                    <li class="dropdown">
                                        <a md-ink-ripple="" data-toggle="dropdown" class="md-btn md-fab bg-white md-btn-circle waves-effect" aria-expanded="false">
                                            <i class="mdi-navigation-more-vert text-md" style="color:black"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">'.$LimpiezaMantenimiento.'</ul>
                                    </li>
                                </ul>';
                }
                
                $col_md_3.='<div class="col-md-4 cols-camas '.$value['cama_display'].'" style="padding: 3px;margin-top:-10px">
                                    <div class="card '.$Color.' color-white">
                                        <div class="row" style="    background: #256659!important;padding: 4px 2px 2px 12px;width: 100%;margin-left: 0px;">
                                            <div class="col-md-12" style="padding-left:0px;"><b style="text-transform:uppercase;font-size:10px"><i class="fa fa-window-restore"></i> '.$this->UMAE_AREA.'</b></div>
                                        </div>
                                        <div class="card-heading" >
                                            <h5 class="font-thin color-white" style="font-size:19px!important;margin-left: -15px;margin-top: 0px;text-transform: uppercase;margin-bottom:-2px">
                                                <i class="fa fa-bed " ></i> <b>'.$value['cama_nombre'].'</b>
                                            </h5>
                                            <div class="row">
                                                <div class="col-md-12" style="margin-left: -14px;">
                                                    <small style="opacity: 1;font-size: 11px"> 
                                                        <i class="fa fa-clock-o"></i> '.$value['cama_status'].'
                                                        <span class="pull-right">'.$StatusCama.'</span>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-tools" style="right:2px;top:9px">'.$Accion.'</div>
                                        <div class="card-body" style="margin-top:-20px;font-size:10px;margin-left: -14px;padding: 10px 24px;">
                                            <span>'.$Paciente.'</span>
                                            <span>'.$Enfermera.'</span>
                                        </div>
                                    </div>
                                </div>';
            }
            
        }else{
            $col_md_3='NO_HAY_CAMAS';
        }
        $this->setOutput(array('result_camas'=>$col_md_3));
    }
    public function FinalizarLimpiezaMantenimiento() {
        $sql=$this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>  'Disponible',
            'cama_ingreso_f'=> '',
            'cama_ingreso_h'=> '',
            'cama_fh_estatus'=> date('Y-m-d H:i:s')
        ),array(
            'cama_id'=>  $this->input->post('id')
        ));
        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'Disponible',
            'cama_id'=>$this->input->post('id')
        ));
        if($sql){
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxTarjetaIdentificacion() {
        $check= $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $data=array(
            'ti_enfermedades'=> $this->input->post('ti_enfermedades'),
            'ti_alergias'=> $this->input->post('ti_alergias'),
            'ti_fecha'=> date('d/m/Y'),
            'ti_hora'=> date('H:i'),
            'empleado_id'=> $this->UMAE_USER,
            'triage_id'=> $this->input->post('triage_id')
        );
        if(empty($check)){
            $this->config_mdl->_insert('os_tarjeta_identificacion',$data);
        }else{
            unset($data['ti_fecha']);
            unset($data['ti_hora']);
            unset($data['empleado_id']);
            $this->config_mdl->_update_data('os_tarjeta_identificacion',$data,array(
                'triage_id'=> $this->input->post('triage_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    
    
    /*NUEVOS CAMBIOS AL MODULO DE OBSERVACIÓN :v*/
    public function ObtenerCamas() {
        $sql= $this->config_mdl->_get_data_condition('os_camas',array(
            'area_id'=> $this->input->post('area_id'),
            'cama_status'=>'Disponible'
        ));
        foreach ($sql as $value) {
            $option.='<option value="'.$value['cama_id'].'">'.$value['cama_nombre'].'</option>';
        }
        $this->setOutput(array('option'=>$option));
    }
    public function AjaxCambiarCama() {
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'En Limpieza',
            'cama_ingreso_f'=> '',
            'cama_ingreso_h'=> '',
            'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            'cama_dh'=>0
        ),array(
            'cama_id'=>  $this->input->post('cama_id_old')
        ));
        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'En Limpieza',
            'cama_id'=>$this->input->post('cama_id_old')
        ));
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'Ocupado',
            'cama_ingreso_f'=> date('d/m/Y'),
            'cama_ingreso_h'=> date('H:i'),
            'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            'cama_dh'=> $this->input->post('triage_id')
        ),array(
            'cama_id'=>  $this->input->post('cama_id_new')
        ));
        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'Ocupado',
            'cama_id'=>$this->input->post('cama_id_new')
        ));
        $camas= $this->config_mdl->_get_data_condition('os_camas',array(
            'cama_id'=> $this->input->post('cama_id_new')
        ))[0];
        $this->config_mdl->_update_data('os_observacion',array(
            'observacion_cama'=>  $this->input->post('cama_id_new'),
            'observacion_cama_nombre'=>  $camas['cama_nombre'],
            'observacion_fac'=> date('d/m/Y'),
            'observacion_hac'=>  date('H:i') 
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('os_camas_log',array(
            'cama_log_fecha'=> date('d/m/Y'),
            'cama_log_hora'=> date('H:i'),
            'cama_log_tipo'=>'Cambio de Cama',
            'cama_log_modulo'=>'Observación',
            'cama_id'=> $this->input->post('cama_id_new'),
            'triage_id'=> $this->input->post('triage_id'),
            'empleado_id'=> $this->UMAE_USER
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function CambiarEnfermera() {
        $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($sql)){
            $obs= $this->config_mdl->_get_data_condition('os_observacion',array(
                'triage_id'=>  $this->input->post('triage_id')
            ))[0];
            $this->config_mdl->_insert('os_log_cambio_enfermera',array(
                'cambio_fecha'=> date('d/m/Y'),
                'cambio_hora'=> date('H:i'),
                'cambio_modulo'=>'Observación',
                'cambio_cama'=>$obs['observacion_cama'],
                'empleado_new'=> $sql[0]['empleado_id'],
                'empleado_old'=> $obs['observacion_crea'],
                'empleado_cambio'=> $this->UMAE_USER,
                'triage_id'=>$this->input->post('triage_id')
            ));
            
            $this->config_mdl->_update_data('os_observacion',array(
                'observacion_crea'=>$sql[0]['empleado_id'],
                'observacion_crea_nombre'=>$sql[0]['empleado_nombre'].' '.$sql[0]['empleado_apellidos']
            ),array(
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $this->AccesosUsuarios(array('acceso_tipo'=>'Cambio de Enfermeroa Observación','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$obs['observacion_id']));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxAltaPaciente() {
        $obs= $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        if($this->input->post('observacion_alta')=='Alta e ingreso quirófano'){
            $this->config_mdl->_update_data('os_observacion',array(
                'observacion_alta'=>  $this->input->post('observacion_alta'),
                'observacion_fs'=> date('d/m/Y'),
                'observacion_hs'=>  date('H:i') ,
                'observacion_status_v2'=>'Ingreso a Quirófano'
            ),array(
                'triage_id'=>  $this->input->post('triage_id'),
            )); 
            $this->AccesosUsuarios(array('acceso_tipo'=>'Alta e ingreso a Quirofano','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$obs['observacion_id']));
        }else{
            $this->config_mdl->_update_data('os_observacion',array(
                'observacion_alta'=>  $this->input->post('observacion_alta'),
                'observacion_fs'=> date('d/m/Y'),
                'observacion_hs'=>  date('H:i') ,
                'observacion_status_v2'=>'Salida'
            ),array(
                'triage_id'=>  $this->input->post('triage_id'),
            ));
            $this->config_mdl->_insert('doc_43021',array(
                'doc_fecha'=> date('Y-m-d'),
                'doc_hora'=> date('H:i:s'),
                'doc_turno'=>Modules::run('Config/ObtenerTurno'),
                'doc_destino'=> $this->input->post('observacion_alta'),
                'doc_tipo'=>'Egreso',
                'empleado_id'=> $this->UMAE_USER,
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $this->AccesosUsuarios(array('acceso_tipo'=>'Egreso Enfermería Observación','triage_id'=>$this->input->post('triage_id'),'areas_id'=>$obs['observacion_id']));
        }
        $this->config_mdl->_update_data('os_camas',array(
            'cama_status'=>'En Limpieza',
            'cama_ingreso_f'=> '',
            'cama_ingreso_h'=> '',
            'cama_fh_estatus'=> date('Y-m-d H:i:s'),
            'cama_dh'=>0,
        ),array(
            'cama_dh'=>  $this->input->post('triage_id')
        ));
        Modules::run('Areas/LogCamas',array(
            'log_estatus'=>'En Limpieza',
            'cama_id'=>$this->input->post('observacion_cama')
        ));
        $this->EgresoCamas($egreso=array(
            'cama_egreso_cama'=>$this->input->post('observacion_cama'),
            'cama_egreso_destino'=>$this->input->post('observacion_alta'),
            'cama_egreso_table'=>'os_observacion',
            'cama_egreso_table_id'=>$obs['observacion_id'],
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxObtenerPaciente() {
        $sql= $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->get_post('triage_id')
        ));
        $info=$this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        if($info['triage_crea_am']!=''){
            if(!empty($sql)){
                $observacion_area= $this->AsignarAreaPaciente(array('triage_id'=> $this->input->post('triage_id')));
                $this->config_mdl->_update_data('os_observacion',array(
                    'observacion_area'=>$observacion_area
                ),array(
                    'triage_id'=> $this->input->post('triage_id')
                ));
                $medico= $this->config_mdl->_get_data_condition('os_empleados',array(
                    'empleado_id'=>$sql[0]['observacion_medico']
                ))[0];
                if($sql[0]['observacion_status_v2']=='En Espera' || $sql[0]['observacion_status_v2']==''){
                    $this->setOutput(array('accion'=>'1','status'=>'EN_ESPERA','triage_id'=>$this->input->get_post('triage_id'),'info'=>$info));
                }if($sql[0]['observacion_status_v2']=='Asignado'){
                    $this->setOutput(array('accion'=>'1','status'=>'ASIGNADO','triage_id'=>$this->input->get_post('triage_id'),'info'=>$info,'medico'=>$medico,'obs'=>$sql[0]));
                }if($sql[0]['observacion_status_v2']=='Salida'){
                    $this->setOutput(array('accion'=>'1','status'=>'SALIDA','triage_id'=>$this->input->get_post('triage_id'),'info'=>$info,'medico'=>$medico,'obs'=>$sql[0]));
                }
            }else{
                $this->setOutput(array('accion'=>'2','triage_id'=>$this->input->get_post('triage_id')));
            }
            
        }else{
            $this->setOutput(array('accion'=>'4'));
        }
        
    }
    public function ObtenerArea() {
        if($this->UMAE_AREA=='Observación Pediatría'){
            return "3";
        }if($this->UMAE_AREA=='Observación Adultos Mujeres'){
            return "4";
        }if($this->UMAE_AREA=='Observación Adultos Hombres'){
            return "5";
        }
		if($this->UMAE_AREA=='Enfermería Observación Urgencias'){
            return "1";
        }
    }
    public function ObtenerAreaEnfermeria() {
        if($this->UMAE_AREA=='Enfermería Observación Pediatría'){
            return 3;
        }if($this->UMAE_AREA=='Enfermería Observación Adultos Mujeres'){
            return 4;
        }if($this->UMAE_AREA=='Enfermería Observación Adultos Hombres'){
            return 5;
        }
		if($this->UMAE_AREA=='Enfermería Observación Urgencias'){
            return 1;
        }
    }
    public function AjaxAsociarMedico() {
        $sql=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=>  $this->input->post('empleado_matricula')
        ));
        if(!empty($sql)){
            
            $this->config_mdl->_update_data('os_observacion',array(
                'observacion_mfa'=> date('d/m/Y'),
                'observacion_mha'=>  date('H:i'),
                'observacion_medico'=>$sql[0]['empleado_id'],
                'observacion_status_v2'=>'Asignado',
                'observacion_medico_nombre'=>$sql[0]['empleado_nombre'].' '.$sql[0]['empleado_apellidos'],
                'empleado_id'=> $this->UMAE_USER,
            ),array(
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $obs= $this->config_mdl->_get_data_condition('os_observacion',array(
                'triage_id'=> $this->input->post('triage_id')
            ))[0];
            $this->config_mdl->_insert('os_observacion_llamada',array(
                'triage_id'=>  $this->input->post('triage_id'),
                'observacion_id'=>$obs['observacion_id']
            ));
            $this->AccesosUsuarios(array(
                'acceso_tipo'=>'Médico Observación',
                'triage_id'=>$this->input->post('triage_id'),
                'areas_id'=>$obs['observacion_id']));
            
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
        
    }
    public function AjaxObtenerPacienteEnf() {//ASIGNAR CAMA AL PACIENTE POR ENFERMERIA
        $sql= $this->config_mdl->_query("SELECT * FROM os_observacion WHERE os_observacion.triage_id=".$this->input->post('triage_id'));
        $info= $this->config_mdl->_query("SELECT * FROM os_triage WHERE triage_id=".$this->input->post('triage_id'))[0];
        if($info['triage_crea_am']!=''){
            if(!empty($sql)){
                if($sql[0]['observacion_area']== $this->ObtenerAreaEnfermeria()){
                    if($sql[0]['observacion_status_v2']=='En Espera' || $sql[0]['observacion_status_v2']=='Asignado' || $sql[0]['observacion_status_v2']=='Interconsulta' ){
                        if($sql[0]['observacion_cama']==''){
                            $this->setOutput(array('accion'=>'1','observacion_id'=>$sql[0]['observacion_id']));//NO TIENE CAMA ASIGNADA
                        }else{
                            if($sql[0]['observacion_alta']=='Alta e ingreso quirófano'){
                                $this->setOutput(array('accion'=>'7','paciente'=>$info));//Alta e ingreso a quirófano
                            }else{
                                $this->setOutput(array('accion'=>'2'));//TIENE CAMA ASIGNADO
                            }
                            
                        }
                    }else if ($sql[0]['observacion_status_v2']=='Ingreso a Quirófano'){
                        $this->setOutput(array('accion'=>'7','paciente'=>$info));//Reingreso de paciente por alta e ingreso a quirófano
                    }else{
                        $this->setOutput(array('accion'=>'5','observacion_id'=>$sql[0]['observacion_id']));//REINGRESO DE PACIENTE A OBSERVACIÓN
                    }
                }else{//NO CORRESPONDE AL ÁREA DE ASIGNACIÓN
                    $this->setOutput(array('accion'=>'3','triage_paciente_sexo'=>$info['triage_paciente_sexo'],'triage_fecha_nac'=>$info['triage_fecha_nac']));
                }
            }else{
                $this->setOutput(array('accion'=>'4'));//EL PACIENTE NO EXISTE EN OBSERVACIÓN + AREA
            }
        }else{
            $this->setOutput(array('accion'=>'6'));//DATOS NO CAPTURADOS POR AM
        }
    }
    public function AjaxAsociarCama() {
        $info=  $this->config_mdl->_get_data_condition('os_camas',array(
            'cama_id'=>  $this->input->post('cama_id')
        ))[0];
        $empleado= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($empleado)){
            $this->config_mdl->_update_data('os_observacion',array(
                'observacion_cama'=> $this->input->post('cama_id'),
                'observacion_cama_nombre'=>  $info['cama_nombre'],
                'observacion_fac'=> date('d/m/Y'),
                'observacion_hac'=>  date('H:i') ,
                'observacion_crea'=> $empleado[0]['empleado_id'],
                'observacion_crea_nombre'=>$empleado[0]['empleado_nombre'].' '.$empleado[0]['empleado_apellidos']
            ),array(
                'triage_id'=>  $this->input->post('triage_id')
            ));
            $obs= $this->config_mdl->_get_data_condition('os_observacion',array(
                'triage_id'=> $this->input->post('triage_id')
            ))[0];
            $this->config_mdl->_update_data('os_camas',array(
                'cama_status'=>'Ocupado',
                'cama_ingreso_f'=> date('d/m/Y'),
                'cama_ingreso_h'=> date('H:i'),
                'cama_fh_estatus'=> date('Y-m-d H:i:s'),
                'cama_dh'=>$obs['triage_id']
            ),array(
                'cama_id'=>  $this->input->post('cama_id')
            ));
            Modules::run('Areas/LogCamas',array(
                'log_estatus'=>'Ocupado',
                'cama_id'=>$this->input->post('cama_id')
            ));
            $this->AccesosUsuarios(array('acceso_tipo'=>'Ingreso Enfermería Observación','triage_id'=>$obs['triage_id'],'areas_id'=>$obs['observacion_id']));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxAgregarPacienteObs() {
        $info= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        
        if(!empty($info)){
            $observacion_area= $this->AsignarAreaPaciente(array('triage_id'=> $this->input->post('triage_id')));
            $this->config_mdl->_insert('os_observacion',array(
                'observacion_fe'=>  date('d/m/Y'),
                'observacion_he'=>date('H:i'),
                'triage_id'=>$this->input->post('triage_id'),
                'observacion_area'=>$observacion_area,
                'observacion_status_v2'=>'En Espera'
            ));
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxReingreso(){
        $sql= $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->config_mdl->_insert('os_camas_log',array(
            'cama_log_fecha'=> date('d/m/Y'),
            'cama_log_hora'=> date('H:i'),
            'cama_log_tipo'=>'Reingreso',
            'cama_log_modulo'=>'Observación',
            'cama_id'=> $sql[0]['observacion_cama'],
            'triage_id'=> $sql[0]['triage_id'],
            'empleado_id'=> $this->UMAE_USER
        ));
        $this->config_mdl->_update_data('os_observacion',array(
            'observacion_cama'=>'',
            'observacion_cama_nombre'=>  '',
            'observacion_fac'=>'',
            'observacion_hac'=>  '' ,
            'observacion_crea'=> '',
            'observacion_crea_nombre'=>'',
            'observacion_status_v2'=>'Asignado'
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function CrearNuevasCamas() {
        $AreaId= $this->ObtenerAreaEnfermeria();
        $Camas= $this->config_mdl->_query("SELECT * FROM os_camas WHERE os_camas.area_id=$AreaId  ORDER BY cama_id ASC");
        foreach ($Camas as $value) {
            $this->config_mdl->_insert('os_camas',array(
                'cama_nombre'=>$value['cama_nombre'].'-Bis',
                'cama_status'=>'Disponible',
                'cama_aislado'=>'No',
                'cama_genero'=>'Sin Especificar',
                'cama_tipo'=>'Automático',
                'area_id'=> $this->ObtenerAreaEnfermeria(),
                'cama_dh'=>0
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxActualizarDatosPaciente() {
        $data=array(
            'triage_paciente_sexo'=> strtoupper($this->input->post('triage_paciente_sexo')),
            'triage_fecha_nac'=>  $this->input->post('triage_fecha_nac')
        );
        $this->config_mdl->_update_data('os_triage',$data,array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $paciente= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->post('triage_id')
        ))[0];
        if($this->CalcularEdad_($this->input->post('triage_fecha_nac'))->y<15){
            $observacion_area='3';
        }else{
            if($paciente['triage_paciente_sexo']=='MUJER'){
                $observacion_area='4';
            }else{
                $observacion_area='5';
            }
        }
        $this->config_mdl->_update_data('os_observacion',array(
            'observacion_area'=>$observacion_area
        ),array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AsignarAreaPaciente($data) {
        $paciente= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $data['triage_id']
        ))[0];
        if($this->CalcularEdad_($this->input->post('triage_fecha_nac'))->y<15){
            return 3;
        }else{
            if($paciente['triage_paciente_sexo']=='MUJER'){
                return 4;
            }else{
                return 5;
            }
        }
    }
    public function AjaxVerificaMatricula() {
        $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ));
        if(!empty($sql)){
            $info= $this->config_mdl->_get_data_condition('os_triage',array(
                'triage_id'=> $this->input->post('triage_id')
            ))[0];
            $pinfo= $this->config_mdl->_get_data_condition('paciente_info',array(
                'triage_id'=> $this->input->post('triage_id')
            ))[0];
            $this->setOutput(array('accion'=>'1','info'=>$info,'pinfo'=>$pinfo));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function AjaxConfirmarDatos() {
        $this->config_mdl->_update_data('os_triage',array(
            'triage_nombre'=> $this->input->post('triage_nombre'),
            'triage_nombre_ap'=> $this->input->post('triage_nombre_ap'),
            'triage_nombre_am'=> $this->input->post('triage_nombre_am'),
        ),array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->config_mdl->_update_data('paciente_info',array(
            'pum_nss'=> $this->input->post('pum_nss'),
            'pum_nss_agregado'=> $this->input->post('pum_nss_agregado')
        ),array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        $empleado= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_matricula'=> $this->input->post('empleado_matricula')
        ))[0];
        $this->config_mdl->_insert('os_triage_pulseras',array(
            'pulsera_fecha'=> date('d/m/Y'),
            'pulsera_hora'=> date('H:i'),
            'pulsera_tipo'=> $this->input->post('pulsera_tipo'),
            'empleado_id'=>$empleado['empleado_id'],
            'triage_id'=> $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxInterConsulta() {
        $sqlEmpleado= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=> $this->UMAE_USER
        ))[0];
        $this->config_mdl->_update_data('os_observacion',array(
            'observacion_status_v2'=>'Interconsulta'
        ),array(
            'triage_id'=>  $this->input->post('triage_id')
        ));
        $sqlInterconsulta= $this->config_mdl->_get_data_condition('doc_430200',array(
            'triage_id'=> $this->input->post('triage_id'),
            'doc_modulo'=>'Observación',
            'doc_servicio_solicitado'=>$this->input->post('doc_servicio_solicitado'),
        ));
        if(empty($sqlInterconsulta)){
            $this->config_mdl->_insert('doc_430200',array(
                'doc_estatus'=>'En Espera',
                'doc_fecha'=> date('Y-m-d'),
                'doc_hora'=> date('H:i'),
                'doc_area'=> $this->UMAE_AREA,
                'doc_servicio_envia'=> $sqlEmpleado['empleado_servicio'],
                'doc_servicio_solicitado'=>$this->input->post('doc_servicio_solicitado'),
                'doc_diagnostico'=> $this->input->post('doc_diagnostico'),
                'doc_modulo'=>'Observación',
                'triage_id'=> $this->input->post('triage_id'),
                'empleado_envia'=> $this->UMAE_USER
            ));
            $sqlInterconsulta= $this->config_mdl->_get_last_id('doc_430200','doc_id');
            $this->setOutput(array('accion'=>'1','Interconsulta'=>$sqlInterconsulta));
        }else{
            $this->setOutput(array('accion'=>'2'));
        } 
    }
    public function AjaxCrearSessionServicio() {
        $this->config_mdl->_update_data('os_empleados',array(
            'empleado_servicio'=>$this->input->post('observacion_servicio')
        ),array(
            'empleado_id'=> $this->UMAE_USER
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    /*Consultorios por servicio*/
    public function AjaxConsultoriosServicio() {
        $especialidad=$this->config_mdl->_get_data_condition('os_consultorios',array(
            'consultorio_especialidad'=>'Si'
        ));
        foreach ($especialidad as $value) {
            $option.='<option value="'.$value['consultorio_id'].';'.$value['consultorio_nombre'].'">'.$value['consultorio_nombre'].'</option>';
        }
        $option.='<option selected value="0;Primer Contacto/Filtro">Primer Contacto/Filtro</option>';
        $this->setOutput(array('option'=>$option));
    }
    public function AjaxEliminarPacienteObs() {
        $sql= $this->config_mdl->sqlGetDataCondition('os_observacion',array(
            'triage_id'=> $this->input->post('triage_id')
        ));
        if(!empty($sql)){
            if($sql[0]['observacion_cama']!=''){
                $sqlCama=$this->config_mdl->sqlGetDataCondition('os_camas',array('cama_id'=>$sql[0]['observacion_cama']))[0];
                if($sqlCama['cama_status']=='Ocupado'){
                    $this->config_mdl->_update_data('os_camas',array(
                        'cama_status'=>'Disponible',
                        'cama_ingreso_f'=> date('d/m/Y'),
                        'cama_ingreso_h'=> date('H:i'),
                        'cama_fh_estatus'=> date('Y-m-d H:i:s'),
                        'cama_dh'=>0
                    ),array(
                        'cama_id'=>  $sql[0]['observacion_cama']
                    ));
                    Modules::run('Pisos/Camas/LogCamas',array(
                        'estado_tipo'=>'Disponible',
                        'cama_id'=> $sql[0]['observacion_cama'],
                        'triage_id'=> $this->input->post('triage_id')
                    ));
                }
            }
            $this->config_mdl->_insert('um_observacion_log_del',array(
                'log_fecha'=> date('Y-m-d H:i:s'),
                'log_area'=> $this->UMAE_AREA,
                'triage_id'=> $this->input->post('triage_id'),
                'empleado_id'=> $this->UMAE_USER
            ));
            $this->config_mdl->_delete_data('os_observacion',array('triage_id'=> $this->input->post('triage_id')));
        }
        $this->setOutput(array('accion'=>'1'));
    }
}
