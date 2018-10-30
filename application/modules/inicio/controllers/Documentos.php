<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Documentos
 *
 * @author felipe de jesus
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Documentos extends Config{
    public function index() {
        $this->load->view('documentos/index');
    }
    public function Clasificacion($paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $paciente
        ));
        $sql['clasificacion']=  $this->config_mdl->_get_data_condition('os_triage_clasificacion',array(
            'triage_id'=>  $paciente
        ));
        $sql['medico']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>$sql['info'][0]['triage_crea_medico']
        ));
        if($_GET['via']=='Choque'){
            $sql['class_choque']= $this->config_mdl->_query("SELECT * FROM os_triage_signosvitales
            WHERE
            os_triage_signosvitales.sv_tipo='Choque' AND
            os_triage_signosvitales.triage_id=".$paciente." ORDER BY os_triage_signosvitales.sv_id ASC LIMIT 1");

        }
        $sql['SignosVitales']= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
            'sv_tipo'=>'Triage',
            'triage_id'=>$paciente
        ))[0];
        $sql['AdmisionContinua']= $this->config_mdl->_get_data_condition('or_admision_continua',array(
            'triage_id'=>$paciente
        ))[0];
        if($sql['info'][0]['triage_consultorio_nombre']=='Ortopedia-Admisión Continua'){
            $this->load->view('documentos/ClasificacionOrtopedia',$sql);
        }else{
            $this->load->view('documentos/Clasificacion',$sql);
        }

    }
    public function ST7($Paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['am']=  $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['ST7_FOLIO']=  $this->config_mdl->_get_data_condition('doc_st7_folio',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['hojafrontal']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['DirEmpresa']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Empresa',
            'triage_id'=>$Paciente
        ))[0];
        $sql['DirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Paciente',
            'triage_id'=>$Paciente
        ))[0];
        $sql['Empresa']= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $this->load->view('documentos/st7',$sql);
    }
    public function HojaFrontal($Paciente) {
        $sql['info']=  $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id'=>  $Paciente
        ),'triage_id,triage_nombre,triage_nombre_ap,triage_nombre_am,triage_paciente_sexo,triage_fecha_nac')[0];
        $sql['am']=  $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas',array(
            'triage_id'=>  $Paciente
        ),'asistentesmedicas_fecha,asistentesmedicas_hora,asistentesmedicas_hoja,asistentesmedicas_renglon')[0];
        $sql['DirEmpresa']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Empresa',
            'triage_id'=>$Paciente
        ))[0];
        $sql['DirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Paciente',
            'triage_id'=>$Paciente
        ))[0];
        $sql['Empresa']= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $this->load->view('documentos/hojafrontal',$sql);
    }
    public function HojaFrontalCE($Paciente) {
        $sql['hoja']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['am']=  $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas',array(
            'triage_id'=>  $Paciente
        ),'asistentesmedicas_fecha,asistentesmedicas_hora,asistentesmedicas_incapacidad_am,asistentesmedicas_incapacidad_tipo,asistentesmedicas_incapacidad_folio,asistentesmedicas_incapacidad_fi,asistentesmedicas_incapacidad_da')[0];
        $sql['DirEmpresa']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Empresa',
            'triage_id'=>$Paciente
        ))[0];
        $sql['DirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Paciente',
            'triage_id'=>$Paciente
        ))[0];
        $sql['Empresa']= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['Medico']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=>$sql['hoja']['empleado_id']
        ),'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['AsistenteMedica']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=>$sql['info']['triage_crea_am']
        ),'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['Enfermera']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=>$sql['info']['triage_crea_enfemeria']
        ),'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['SignosVitales']= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
            'sv_tipo'=>'Triage',
            'triage_id'=>$Paciente
        ))[0];
        $sql['DiagnosticosCIE10']= $this->config_mdl->_query("SELECT * FROM um_cie10_hojafrontal, um_cie10 WHERE
                    um_cie10_hojafrontal.cie10_id=um_cie10.cie10_id AND
                    um_cie10_hojafrontal.triage_id=".$Paciente." ORDER BY cie10hf_tipo='Primario' DESC");
        $this->load->view('documentos/HojaFrontal430128',$sql);

    }
    public function HojaInicialAbierto($Paciente){
        $sql['hoja']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['am']=  $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas',array(
            'triage_id'=>  $Paciente
        ),'asistentesmedicas_fecha,asistentesmedicas_hora,asistentesmedicas_incapacidad_am,asistentesmedicas_incapacidad_tipo,asistentesmedicas_incapacidad_folio,asistentesmedicas_incapacidad_fi,asistentesmedicas_incapacidad_da')[0];
        $sql['DirEmpresa']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Empresa',
            'triage_id'=>$Paciente
        ))[0];
        $sql['DirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Paciente',
            'triage_id'=>$Paciente
        ))[0];
        $sql['Empresa']= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['Medico']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=>$sql['hoja']['empleado_id']
        ),'empleado_nombre,empleado_apellidos,empleado_matricula,empleado_cedula')[0];
        $sql['AsistenteMedica']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=>$sql['info']['triage_crea_am']
        ),'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['Enfermera']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=>$sql['info']['triage_crea_enfemeria']
        ),'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['SignosVitales']= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
            'sv_tipo'=>'Triage',
            'triage_id'=>$Paciente
        ))[0];

        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT *
          FROM prescripcion INNER JOIN nm_hojafrontal_prescripcion ON
          prescripcion.prescripcion_id = nm_hojafrontal_prescripcion.prescripcion_id
          INNER JOIN catalogo_medicamentos
	        ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
          WHERE triage_id = ".$Paciente);
        /*
        Consulta para las prescripciones de cuadro basico
        antibioticos NPT y Oncologico o antimicrobiano
        */
        $sql['Prescripcion_Basico'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                 INNER JOIN prescripcion
                                                                	 ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                 WHERE triage_id =$Paciente AND safe = 0;");
        $sql['Prescripcion_NPT'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                              INNER JOIN prescripcion
                                                              	ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                              INNER JOIN prescripcion_npt
                                                              	ON prescripcion.prescripcion_id = prescripcion_npt.prescripcion_id
                                                              WHERE triage_id =$Paciente AND safe = 1 AND categoria_safe = 'npt';");
        $sql['Prescripcion_Onco_Anti'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                    INNER JOIN prescripcion
                                                                    	ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                    INNER JOIN prescripcion_onco_antimicrobianos
                                                                    	ON prescripcion.prescripcion_id = prescripcion_onco_antimicrobianos.prescripcion_id
                                                                    WHERE triage_id =$Paciente AND safe = 1;");
        //fin consultas para la prescripción
        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT cie10_clave, cie10_nombre, tipo_diagnostico FROM um_cie10
                                    INNER JOIN paciente_diagnosticos
                                    	ON um_cie10.cie10_id = paciente_diagnosticos.cie10_id
                                    INNER JOIN diagnostico_hoja_frontal
                                    	ON paciente_diagnosticos.diagnostico_id = diagnostico_hoja_frontal.diagnostico_id
                                    WHERE  hf_id = (SELECT hf_id FROM os_consultorios_especialidad_hf
                                    WHERE triage_id = $Paciente)");

        $sql['Interconsultas'] = $this->config_mdl-> _query("SELECT * FROM interconsulta_hoja_frontal
                                                            INNER JOIN doc_430200
                                                            	ON interconsulta_hoja_frontal.doc_id = doc_430200.doc_id
                                                            INNER JOIN um_especialidades
                                                            	ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
                                                            WHERE triage_id = $Paciente AND hf_id = (
                                                            	SELECT hf_id FROM os_consultorios_especialidad_hf
                                                            	WHERE triage_id = $Paciente	)");

        $this->load->view('documentos/HojaFrontal430128Abierto',$sql);
    }
    public function FormatosJefaAsistentesMedicas() {
        $Turno=$_GET['turno'];
        $Fecha=$_GET['fecha_inicio'];
        $Tipo2=$_GET['tipo2'];
        if($_GET['tipo']=='Consultorios'){
            if($Turno=='Noche'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM doc_43029, os_triage, os_asistentesmedicas WHERE
                    os_triage.triage_id=os_asistentesmedicas.triage_id AND
                    os_triage.triage_id=doc_43029.triage_id AND
                    doc_43029.doc_turno='Noche A' AND doc_43029.doc_fecha='$Fecha' AND doc_tipo='Ingreso' ORDER BY os_asistentesmedicas.asistentesmedicas_hora ASC");
            $sql['Gestion2']= $this->config_mdl->_query("SELECT * FROM doc_43029, os_triage, os_asistentesmedicas WHERE
                    os_triage.triage_id=os_asistentesmedicas.triage_id AND
                    os_triage.triage_id=doc_43029.triage_id AND
                    doc_43029.doc_turno='Noche B' AND doc_43029.doc_fecha=INTERVAL 1 DAY +'$Fecha' AND doc_tipo='Ingreso' ORDER BY os_asistentesmedicas.asistentesmedicas_hora ASC");
            }else{
                $sql['Gestion2']='';
                $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM doc_43029, os_triage, os_asistentesmedicas WHERE
                    os_triage.triage_id=os_asistentesmedicas.triage_id AND
                    os_triage.triage_id=doc_43029.triage_id AND
                    doc_43029.doc_turno='$Turno' AND doc_43029.doc_fecha='$Fecha' AND doc_tipo='Ingreso' ORDER BY os_asistentesmedicas.asistentesmedicas_hora ASC");
            }

            $this->load->view('documentos/JAM_43029_IE',$sql);
        }else{
            if($Turno=='Noche'){
                $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM doc_43021, os_triage WHERE
                    os_triage.triage_id=doc_43021.triage_id AND doc_43021.doc_tipo='$Tipo2' AND
                    doc_43021.doc_turno='Noche A' AND doc_43021.doc_fecha='$Fecha'");
                $sql['Gestion2']= $this->config_mdl->_query("SELECT * FROM doc_43021, os_triage WHERE
                    os_triage.triage_id=doc_43021.triage_id AND doc_43021.doc_tipo='$Tipo2' AND
                    doc_43021.doc_turno='Noche B' AND doc_43021.doc_fecha=INTERVAL 1 DAY+'$Fecha'");
            }else{
                $sql['Gestion2']='';
                $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM doc_43021, os_triage WHERE
                    os_triage.triage_id=doc_43021.triage_id AND doc_43021.doc_tipo='$Tipo2' AND
                    doc_43021.doc_turno='$Turno' AND doc_43021.doc_fecha='$Fecha'");
            }
            if($Tipo2=='Ingreso'){
                $this->load->view('documentos/JAM_43021_I',$sql);
            }else{
                $this->load->view('documentos/JAM_43021_E',$sql);
            }
        }
    }
    public function ObtenerCamasObsChoque($data) {
        if($data['tipo']=='Choque'){
            $sql= $this->config_mdl->_query("SELECT * FROM os_observacion, os_camas WHERE os_camas.cama_id=os_observacion.observacion_cama AND
                os_observacion.triage_id=".$data['triage_id'])[0];
            return $sql['cama_nombre'];
        }else{
            $sql= $this->config_mdl->_query("SELECT * FROM os_choque_v2, os_camas WHERE os_camas.cama_id=os_choque_v2.cama_id AND
                os_choque_v2.triage_id=".$data['triage_id'])[0];
            return $sql['cama_nombre'];
        }
    }
    public function HojaFrontalPacientes($data) {
        $sql=$this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'triage_id'=>$data['triage_id']
        ))[0];
        if(empty($sql)){
            return '';
        }else{
            return $sql['hf_diagnosticos_lechaga'];
        }
    }
    public function SolicitudServicioTransfusion($Tratamiento) {
        $sql['st']=  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['observacion']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->get('folio')
        ))[0];
        $sql['triage']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get('folio')
        ))[0];
        $this->load->view('documentos/SolicitudServicioTransfusion',$sql);
    }
    public function CirugiaSegura($Tratamiento) {
        $sql['cs']=  $this->config_mdl->_get_data_condition('os_observacion_cirugiasegura',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['observacion']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->get('folio')
        ))[0];
        $sql['triage']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get('folio')
        ))[0];
        $this->load->view('documentos/CirugiaSegura',$sql);
    }
    public function SolicitudIntervencionQuirurgica($Tratamiento) {
        $sql['cs']=  $this->config_mdl->_get_data_condition('os_observacion_cirugiasegura',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['st']=  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['observacion']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->get('folio')
        ))[0];
        $sql['triage']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get('folio')
        ))[0];
        $sql['ci']=  $this->config_mdl->_get_data_condition('os_observacion_ci',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['DirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Paciente',
            'triage_id'=>$this->input->get('folio')
        ))[0];
        $this->load->view('documentos/SolicitudIntervencionQuirurgica',$sql);
    }
    public function CartaConsentimientoInformado($Tratamiento) {
        $sql['observacion']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->get('folio')
        ))[0];
        $sql['triage']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get('folio')
        ))[0];
        $sql['ci']=  $this->config_mdl->_get_data_condition('os_observacion_ci',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['cci']=  $this->config_mdl->_get_data_condition('os_observacion_cci',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['st']=  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $this->load->view('documentos/CartaConsentimientoInformado',$sql);
    }
    public function ISQ($Tratamiento) {
        $sql['isq']=  $this->config_mdl->_get_data_condition('os_observacion_isq',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['triage']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get('folio')
        ))[0];
        $sql['ci']=  $this->config_mdl->_get_data_condition('os_observacion_ci',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['cci']=  $this->config_mdl->_get_data_condition('os_observacion_cci',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['st']=  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion',array(
            'tratamiento_id'=> $Tratamiento
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=> $this->input->get('folio')
        ))[0];
        $this->load->view('documentos/ISQ',$sql);
    }
    /*NUEVOS FORMATOS*/
    public function FormatoIngreso_Egreso() {
        $turno=$this->input->get('turno');
        $fecha=$this->input->get('fecha');

        if($this->input->get('tipo')=='Ingreso'){
            $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_accesos, os_triage, os_asistentesmedicas
                                        WHERE
                                        os_accesos.areas_id=os_asistentesmedicas.asistentesmedicas_id AND
                                        os_triage.triage_id=os_accesos.triage_id AND
                                        os_triage.triage_id=os_asistentesmedicas.triage_id AND
                                        os_triage.triage_consultorio_nombre!='Observación' AND
                                        os_accesos.acceso_tipo='Asistente Médica' AND
                                        os_accesos.acceso_turno='$turno' AND
                                        os_accesos.acceso_fecha='$fecha'"
                );
                $this->load->view('documentos/JAM_Ingresos',$sql);
        }else{
            $sql['Gestion']=$this->config_mdl->_query("SELECT * FROM os_accesos, os_triage,  os_asistentesmedicas_egresos
                    WHERE
                    os_accesos.acceso_tipo='Egreso Paciente Asistente Médica' AND
                    os_accesos.acceso_turno='$turno' AND
                    os_accesos.acceso_fecha='$fecha' AND
                    os_accesos.triage_id=os_triage.triage_id AND
                    os_asistentesmedicas_egresos.triage_id=os_triage.triage_id AND
                    os_asistentesmedicas_egresos.egreso_area='Observacion' AND
                    os_accesos.triage_id=os_triage.triage_id"
                );
                $this->load->view('documentos/JAM_Egresos',$sql);
        }
    }
    public function ListaPacientesEnEspera() {
        $hoy= date('d/m/Y');
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_asistentesmedicas, os_triage, os_consultorios_especialidad, os_accesos,os_empleados
            WHERE
            os_triage.triage_id=os_asistentesmedicas.triage_id AND
            os_asistentesmedicas.asistentesmedicas_id=os_consultorios_especialidad.asistentesmedicas_id AND
            os_accesos.acceso_tipo='Asistente Médica' AND
            os_consultorios_especialidad.ce_status='En Espera' AND
            os_asistentesmedicas.asistentesmedicas_id=os_accesos.areas_id AND
            os_empleados.empleado_id=os_accesos.empleado_id AND
            os_asistentesmedicas.asistentesmedicas_fecha='$hoy' ");
        $this->load->view('documentos/ListaPacientesEspera',$sql);
    }
    public function ListaPacientesAsignados() {
        $sql['Gestion']=  $this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad, os_consultorios_especialidad_llamada, os_triage, os_empleados
            WHERE os_consultorios_especialidad.ce_status='Asignado' AND os_triage.triage_id=os_consultorios_especialidad.triage_id AND
            os_empleados.empleado_id=os_consultorios_especialidad.ce_crea AND
            os_consultorios_especialidad.ce_id=os_consultorios_especialidad_llamada.ce_id_ce ORDER BY os_consultorios_especialidad_llamada.cel_id DESC");
        $this->load->view('documentos/ListaPacientesAsignados',$sql);
    }
    public function LechugaConsultorios() {
        $inputFechaInicio= $this->input->get_post('inputFechaInicio');
        $sql['Notas']= $this->config_mdl->_query("SELECT * FROM doc_notas, os_triage WHERE doc_notas.triage_id=os_triage.triage_id AND
                    doc_notas.empleado_id=$this->UMAE_USER  AND doc_notas.notas_fecha='$inputFechaInicio'");
        $sql['HojasFrontales']= $this->config_mdl->_query("SELECT * FROM os_consultorios_especialidad_hf, os_triage WHERE os_consultorios_especialidad_hf.triage_id=os_triage.triage_id AND
                    os_consultorios_especialidad_hf.empleado_id=$this->UMAE_USER  AND os_consultorios_especialidad_hf.hf_fg='$inputFechaInicio'");
        $sql['medico']= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=> $this->UMAE_USER
        ))[0];
        $this->load->view('documentos/LechugaConsultorios',$sql);
    }

    public function TarjetaDeIdentificacion($Paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['obs']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['tarjeta']=  $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['hojafrontal']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['AreaCama']=  $this->config_mdl->_query("SELECT * FROM os_areas, os_camas WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_id=".$sql['obs']['observacion_cama'])[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $this->load->view('documentos/TarjetaDeIdentificacion',$sql);
    }
    public function TarjetaDeIdentificacionChoque($Paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $Paciente
        ))[0];
        if($_GET['via']=='ChoqueV2'){
            $sql['choque']=  $this->config_mdl->_get_data_condition('os_choque_v2',array(
                'triage_id'=>  $Paciente
            ))[0];
        }else{
            $sql['choque']=  $this->config_mdl->_get_data_condition('os_choque_camas',array(
                'triage_id'=>  $Paciente
            ))[0];
        }
        $sql['tarjeta']=  $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['hojafrontal']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['cama']= $this->config_mdl->_query("SELECT * FROM os_areas, os_camas
            WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_id=".$sql['choque']['cama_id'])[0];
        $this->load->view('documentos/TarjetaDeIdentificacionChoque',$sql);
    }
    public function TarjetaDeIdentificacionAreas($Paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['areas']=  $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['tarjeta']=  $this->config_mdl->_get_data_condition('os_tarjeta_identificacion',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['hojafrontal']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['cama']= $this->config_mdl->_query("SELECT * FROM os_areas, os_camas
            WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_id=".$sql['areas']['cama_id'])[0];
        $this->load->view('documentos/TarjetaDeIdentificacionAreas',$sql);
    }
    public function ConsentimientoInformadoIngresoObs($Paciente) {
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>  $Paciente
        ))[0];
        $sql['obs']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=>  $Paciente,
        ))[0];
        $this->load->view('documentos/ConsentimientoInformadoIngresoObs',$sql);
    }

    public function AsistentesMedicas() {
        $inputFechaInicio= $this->input->get_post('POR_FECHA_FECHA_I');
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_asistentesmedicas,paciente_info, os_triage, os_empleados
            WHERE
            os_asistentesmedicas.triage_id=os_triage.triage_id AND
            paciente_info.triage_id=os_triage.triage_id AND
            os_triage.triage_crea_am=os_empleados.empleado_id AND
            os_asistentesmedicas.asistentesmedicas_omitir='No' AND
            os_asistentesmedicas.asistentesmedicas_fecha='$inputFechaInicio' AND paciente_info.pia_lugar_accidente='TRABAJO'");
        $sql['Am']= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>$this->UMAE_USER
        ))[0];
        $this->load->view("documentos/AsistentesMedicas",$sql);
    }
    public function Medico($data) {
        $sql= $this->config_mdl->_query('SELECT * FROM os_consultorios_especialidad_hf, os_triage, os_empleados
                WHERE
                os_consultorios_especialidad_hf.triage_id=os_triage.triage_id AND
                os_consultorios_especialidad_hf.empleado_id=os_empleados.empleado_id AND
                os_triage.triage_id='.$data['triage_id']);
        return $sql[0]['empleado_nombre'].' '.$sql[0]['empleado_apellidos'];
    }
    public function IndicadorPisos() {
        $by_fecha_inicio= $this->input->get_post('by_fecha_inicio');
        $by_fecha_fin= $this->input->get_post('by_fecha_fin');
        $by_hora_fecha= $this->input->get_post('by_hora_fecha');
        $by_hora_inicio= $this->input->get_post('by_hora_inicio');
        $by_hora_fin= $this->input->get_post('by_hora_fin');
        if($this->input->get_post('TipoBusqueda')=='POR_FECHA'){
            if($this->input->get_post('TIPO_ACCION')=='INGRESO'){
                $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_pisos, os_camas, os_areas, os_areas_pacientes, os_pisos_camas
                                                WHERE
                                                os_areas_pacientes.triage_id=os_triage.triage_id AND
                                                os_areas_pacientes.cama_id=os_camas.cama_id AND
                                                os_pisos_camas.piso_id=os_pisos.piso_id AND
                                                os_pisos_camas.cama_id=os_camas.cama_id AND
                                                os_areas.area_id=os_camas.area_id AND
                                                os_areas_pacientes.ap_f_ingreso BETWEEN '$by_fecha_inicio' AND '$by_fecha_fin'");
            }else{
                $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_pisos, os_camas, os_areas, os_areas_pacientes, os_pisos_camas
                                                WHERE
                                                os_areas_pacientes.triage_id=os_triage.triage_id AND
                                                os_areas_pacientes.cama_id=os_camas.cama_id AND
                                                os_pisos_camas.piso_id=os_pisos.piso_id AND
                                                os_pisos_camas.cama_id=os_camas.cama_id AND
                                                os_areas.area_id=os_camas.area_id AND
                                                os_areas_pacientes.ap_f_salida BETWEEN '$by_fecha_inicio' AND '$by_fecha_fin'");
            }


        }else{
            if($this->input->get_post('TIPO_ACCION')=='INGRESO'){
                $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_pisos, os_camas, os_areas, os_areas_pacientes, os_pisos_camas
                                                WHERE
                                                os_areas_pacientes.triage_id=os_triage.triage_id AND
                                                os_areas_pacientes.cama_id=os_camas.cama_id AND
                                                os_pisos_camas.piso_id=os_pisos.piso_id AND
                                                os_pisos_camas.cama_id=os_camas.cama_id AND
                                                os_areas.area_id=os_camas.area_id AND
                                                os_areas_pacientes.ap_f_ingreso='$by_hora_fecha' AND
                                                os_areas_pacientes.ap_h_ingreso BETWEEN '$by_hora_inicio' AND '$by_hora_fin'");
            }else{
                $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_triage, os_pisos, os_camas, os_areas, os_areas_pacientes, os_pisos_camas
                                                WHERE
                                                os_areas_pacientes.triage_id=os_triage.triage_id AND
                                                os_areas_pacientes.cama_id=os_camas.cama_id AND
                                                os_pisos_camas.piso_id=os_pisos.piso_id AND
                                                os_pisos_camas.cama_id=os_camas.cama_id AND
                                                os_areas.area_id=os_camas.area_id AND
                                                os_areas_pacientes.ap_f_salida='$by_hora_fecha' AND
                                                os_areas_pacientes.ap_h_salida BETWEEN '$by_hora_inicio' AND '$by_hora_fin'");
            }
        }
        $this->load->view('documentos/IndicadorPisos',$sql);
    }
    public function DOC43051($Paciente) {
        $sql['Diagnostico']= $this->config_mdl->sqlGetDataCondition('os_consultorios_especialidad_hf',array(
            'triage_id'=> $Paciente
        ),'hf_diagnosticos')[0];
        $sql['Asignacion']= $this->config_mdl->sqlGetDataCondition('doc_43051',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $Paciente
        ))[0];
        $sql['area']= $this->config_mdl->_get_data_condition('os_areas_pacientes',array(
            'triage_id'=> $Paciente
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=> $Paciente
        ))[0];
        $sql['dirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Paciente',
            'triage_id'=> $Paciente
        ))[0];
        $sql['dirEmpresa']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Empresa',
            'triage_id'=> $Paciente
        ))[0];
        $sql['dirFamiliar']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Familiar',
            'triage_id'=> $Paciente
        ))[0];
        $sql['Empresa']= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=> $Paciente
        ))[0];
        $sql['AsistenteMedicaIngreso']= $this->config_mdl->sqlGetDataCondition('os_asistentesmedicas',array(
            'triage_id'=> $Paciente
        ),'asistentesmedicas_fecha,asistentesmedicas_hora')[0];
        $sql['AsistenteMedica']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=> $sql['Asignacion']['empleado_id']
        ),'empleado_nombre','empleado_apellidos')[0];
        $sql['cama']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE
            os_camas.area_id=os_areas.area_id AND os_camas.cama_id=".$sql['Asignacion']['cama_id'])[0];
        $sql['Piso']= $this->config_mdl->_query("SELECT * FROM os_pisos, os_pisos_camas WHERE os_pisos.piso_id=os_pisos_camas.piso_id AND
            os_pisos_camas.cama_id=".$sql['cama']['cama_id'])[0];
        $this->load->view('documentos/DOC43051',$sql);
    }
    public function CamasOcupadas() {
        if($this->input->get('tipo')=='Total'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id  AND os_areas.area_id=".$this->input->get('area'));
        }if($this->input->get('tipo')=='Disponibles'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='Disponible'  AND os_areas.area_id=".$this->input->get('area'));
        }if($this->input->get('tipo')=='Ocupados'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='Ocupado'  AND os_areas.area_id=".$this->input->get('area')." ORDER BY cama_ingreso_f ASC, cama_ingreso_h ASC");
        }if($this->input->get('tipo')=='Mantenimiento'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='En Mantenimiento'  AND os_areas.area_id=".$this->input->get('area'));
        }if($this->input->get('tipo')=='Limpieza'){
            $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_camas, os_areas
                    WHERE os_camas.area_id=os_areas.area_id AND os_camas.cama_status='En Limpieza'  AND os_areas.area_id=".$this->input->get('area'));
        }
        $this->load->view('Inicio/documentos/CamasOcupadas',$sql);
    }
    public function ImprimirPulsera($Paciente) {
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $this->load->view('documentos/ImprimirPulsera',$sql);
    }
    public function DOC430200($Doc) {
        $sql['doc']= $this->config_mdl->_get_data_condition('doc_430200',array(
           'doc_id'=>$Doc
        ))[0];
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$sql['doc']['triage_id']
        ))[0];

        $sql['am']= $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
           'triage_id'=>$sql['doc']['triage_id']
        ))[0];
        $sql['medico']= $this->config_mdl->_get_data_condition('os_empleados',array(
           'empleado_id'=>$sql['doc']['empleado_envia']
        ))[0];
        $this->load->view('documentos/DOC430200',$sql);
    }
    public function GenerarNotas($Nota) {
        $sql['Nota']= $this->config_mdl->_query("SELECT * FROM doc_notas, doc_nota WHERE
            doc_notas.notas_id=doc_nota.notas_id AND
            doc_notas.notas_id=".$Nota)[0];
        $sql['Residentes'] = $this->config_mdl->_query("SELECT nombre_residente,apellido_residente,cedulap_residente
                                                        FROM um_notas_residentes
                                                        WHERE notas_id =".$Nota);
        $sql['ServicioM'] = $this->config_mdl->_query("SELECT empleado_servicio, especialidad_nombre
                                              FROM os_empleados
                                              INNER JOIN um_especialidades
                                               ON os_empleados.empleado_servicio = um_especialidades.especialidad_id
                                              WHERE empleado_id =".$sql['Nota']['empleado_id']);
        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT cie10_clave, cie10_nombre, diagnostico_notas.tipo_diagnostico AS tipodiag FROM diagnostico_notas
                                                          INNER JOIN um_cie10
                                                          	ON diagnostico_notas.cie10_id = um_cie10.cie10_id
                                                          WHERE notas_id = ".$Nota." ORDER BY tipodiag");
        $sql['info']= $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id'=>$sql['Nota']['triage_id']
        ))[0];
        $sql['PINFO']= $this->config_mdl->sqlGetDataCondition('paciente_info',array(
            'triage_id'=>$sql['Nota']['triage_id']
        ))[0];
        $sql['DirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
           'triage_id'=> $sql['Nota']['triage_id']
        ))[0];
        $sql['Medico']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=>$sql['Nota']['empleado_id']
        ),'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sql['AsistenteMedica']= $this->config_mdl->sqlGetDataCondition('os_empleados',array(
            'empleado_id'=>$sql['info']['triage_crea_am']
        ),'empleado_nombre,empleado_apellidos,empleado_matricula')[0];
        $sqlSV= $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales',array(
            'triage_id'=>$sql['Nota']['triage_id'],
            'sv_tipo'=>$_GET['inputVia'],
            'nota_id' => $Nota
        ));



        $sql['Interconsultas'] = $this->config_mdl->_query("SELECT especialidad_nombre, motivo_interconsulta
                                                            FROM interconsulta_notas
                                                            INNER JOIN doc_430200
                                                            	ON interconsulta_notas.doc_id = doc_430200.doc_id
                                                            INNER JOIN um_especialidades
                                                            	ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
                                                            WHERE notas_id =".$Nota);

          $sql['Interconsultas_Evaluadas'] = $this->config_mdl->_query("SELECT especialidad_nombre
                                                              FROM interconsulta_notas
                                                              INNER JOIN doc_430200
                                                              	ON interconsulta_notas.doc_id = doc_430200.doc_id
                                                              INNER JOIN um_especialidades
                                                              	ON doc_430200.doc_servicio_solicitado = um_especialidades.especialidad_id
                                                              WHERE notas_id =".$Nota." AND doc_estatus = 'Evaluado'");

        $sql['Prescripcion'] = $this->config_mdl->_query(
          "SELECT fecha_prescripcion,CONCAT(empleado_nombre,empleado_apellidos)empleado,
          CONCAT(medicamento,' ',gramaje)medicamento, dosis, prescripcion.via AS via_administracion, frecuencia,
          aplicacion, fecha_inicio, tiempo, observacion,fecha_fin, estado,doc_notas.notas_id
          FROM prescripcion
          INNER JOIN nm_notas_prescripcion
          	ON prescripcion.prescripcion_id = nm_notas_prescripcion.prescripcion_id
          INNER JOIN doc_notas
          	ON nm_notas_prescripcion.notas_id = doc_notas.notas_id
          INNER JOIN catalogo_medicamentos
          	ON catalogo_medicamentos.medicamento_id = prescripcion.medicamento_id
          INNER JOIN os_empleados
          	ON prescripcion.empleado_id = os_empleados.empleado_id
          WHERE prescripcion.triage_id = ".$sql['Nota']['triage_id']." AND doc_notas.notas_id = ".$Nota."
          ORDER BY fecha_prescripcion DESC"
        );

        /*
        Consulta para las prescripciones de cuadro basico
        antibioticos NPT y Oncologico o antimicrobiano
        */
        $sql['Prescripcion_Basico'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                 INNER JOIN prescripcion
                                                                	 ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                 WHERE triage_id = ".$sql['Nota']['triage_id']." AND safe = 0;");
        $sql['Prescripcion_NPT'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                              INNER JOIN prescripcion
                                                              	ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                              INNER JOIN prescripcion_npt
                                                              	ON prescripcion.prescripcion_id = prescripcion_npt.prescripcion_id
                                                              WHERE triage_id = ".$sql['Nota']['triage_id']." AND safe = 1 AND categoria_safe = 'npt';");
        $sql['Prescripcion_Onco_Anti'] = $this->config_mdl->_query("SELECT * FROM catalogo_medicamentos
                                                                    INNER JOIN prescripcion
                                                                    	ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                    INNER JOIN prescripcion_onco_antimicrobianos
                                                                    	ON prescripcion.prescripcion_id = prescripcion_onco_antimicrobianos.prescripcion_id
                                                                    WHERE triage_id = ".$sql['Nota']['triage_id']." AND safe = 1;");

        $sql['valores'] = array($sql['Nota']['triage_id'], $Nota);
        if($sqlSV[0]['sv_temp']!='' && !empty($sqlSV)){
            $sql['SignosVitales']=$sqlSV[0];
        }else{
            $sql['SignosVitales']= $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales',array(
                'triage_id'=>$sql['Nota']['triage_id'],
                'sv_tipo'=>'Triage'
            ))[0];
        }

        $this->load->view('documentos/Notas',$sql);
    }
    public function NotaConsultoriosEspecialidad($Nota) {
        $sql['Nota']= $this->config_mdl->_query("SELECT * FROM doc_notas, doc_nota WHERE
            doc_notas.notas_id=doc_nota.notas_id AND
            doc_notas.notas_id=".$Nota)[0];
        $sql['Medico']= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=> $sql['Nota']['empleado_id']
        ))[0];
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$sql['Nota']['triage_id']
        ))[0];
        $sql['am']=  $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=>  $sql['Nota']['triage_id']
        ))[0];
        $sql['DirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Paciente',
            'triage_id'=>$sql['Nota']['triage_id']
        ))[0];
        $sql['DirEmpresa']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Empresa',
            'triage_id'=>$sql['Nota']['triage_id']
        ))[0];
        $sql['Empresa']= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$sql['Nota']['triage_id']
        ))[0];
        $this->load->view('documentos/NotaConsultoriosEspecialidad',$sql);
    }
    public function AvisarAlMinisterioPublico($Paciente) {
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['AvisoMp']= $this->config_mdl->_get_data_condition('ts_ministerio_publico',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['Medico']= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>$sql['AvisoMp']['medico_familiar']
        ))[0];
        $sql['Ts']= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>$sql['AvisoMp']['trabajosocial']
        ))[0];
        $this->load->view('documentos/AvisarAlMinisterioPublico',$sql);
    }
    public function ExpedienteAmarillo($Paciente){
        $sql['info']=$this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['PINFO']=$this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['DirPaciente']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Paciente',
            'triage_id'=>$Paciente
        ))[0];
        $sql['DirEmpresa']= $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Empresa',
            'triage_id'=>$Paciente
        ))[0];
        $sql['Empresa']= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$Paciente
        ))[0];
        $this->load->view('documentos/ExpedienteAmarillo',$sql);
    }
    public function ExpedienteAmarilloBack($Paciente){
        $sql['info']=$this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $this->load->view('documentos/ExpedienteAmarilloBack',$sql);
    }
    public function PaseDeVisita($Paciente) {
        $sql['info']= $this->config_mdl->sqlGetDataCondition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $sql['Cama']=$this->config_mdl->_query("SELECT * FROM os_camas, os_areas WHERE os_camas.area_id=os_areas.area_id AND
                                                            os_camas.cama_dh=".$Paciente)[0];
        $sql['Familiares']= $this->config_mdl->sqlGetDataCondition('um_poc_familiares',array(
            'familiar_tipo'=>$_GET['tipo'],
            'triage_id'=>$Paciente
        ));
        $this->load->view('documentos/PaseDeVisita',$sql);
    }
}
