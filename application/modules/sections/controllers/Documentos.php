<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Documentos
 *
 * @author bienTICS
 */
require_once APPPATH.'modules/config/controllers/Config.php';
class Documentos extends Config{
    public function index() {
        die('ACCESO NO PERMITIDO');
    }
    public function Expediente($paciente) {
        if($_GET['tipo']=='Choque'){
            $choque= $this->config_mdl->_get_data_condition('os_choque_v2',array(
                'triage_id'=>$paciente
            ));
            if($choque[0]['medico_id']==''){
                $this->config_mdl->_update_data('os_choque_v2',array(
                    'medico_id'=> $this->UMAE_USER
                ),array(
                    'triage_id'=>$paciente
                ));
                $this->AccesosUsuarios(array('acceso_tipo'=>'Médico Choque','triage_id'=>$paciente,'areas_id'=>$choque[0]['choque_id']));
            }
        }
        $sql['HojaClasificacion']= $this->config_mdl->_get_data_condition('os_triage_clasificacion',array(
            'triage_id'=>$paciente
        ));
        $sql['HojasFrontales']= $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'triage_id'=> $paciente
        ));
        $sql['ce']= $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=> $paciente
        ))[0];
        $sql['obs']= $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $paciente
        ))[0];
        $sql['NotasAll']= $this->config_mdl->_query("SELECT * FROM doc_notas, os_empleados WHERE
            doc_notas.empleado_id=os_empleados.empleado_id AND
            doc_notas.triage_id=".$paciente." ORDER BY notas_fecha DESC");
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $paciente
        ))[0];
        $sql['AvisoMp']= $this->config_mdl->_query("SELECT * FROM os_empleados, ts_ministerio_publico WHERE
            os_empleados.empleado_id=ts_ministerio_publico.medico_familiar AND
            ts_ministerio_publico.triage_id=".$paciente);
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$paciente
        ))[0];
        $sql['DocumentosHoja']= $this->config_mdl->_get_data('pc_documentos',array(
            'doc_nombre'=>'Hoja Frontal'
        ));
        $sql['DocumentosNotas']= $this->config_mdl->_query("SELECT * FROM pc_documentos WHERE doc_nombre!='Hoja Frontal'");
        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT count(prescripcion_id)total_prescripcion
                                                          FROM prescripcion WHERE estado = 0 and triage_id = ".$paciente);
        $this->load->view('Documentos/Expediente',$sql);
    }
    public function AjaxRegistrarBitacoraPrescripcion(){
      $datos = array(
        "empleado_id" => $this->UMAE_USER,
        "prescripcion_id" => $_GET['prescripcion_id'],
        "fecha" => date('Y-m-d')." ".date('H:i'),
        "tipo_accion" => $_GET['tipo_accion'],
        "motivo" => $_GET['motivo']
      );
      $sql = $this->config_mdl->_insert("btcr_prescripcion" , $datos);
      print json_encode($sql);
    }


    /*Retorna JSON con las prescripciones del paciente, ordenadas por fecha de prescripcion y estado*/
    public function AjaxHistorialPrescripcion(){
      $paciente = $this->input->get('paciente');
      $estado = $this->input->get('estado');
      $sql = $this->config_mdl->_query("SELECT DISTINCT prescripcion_id,fecha_prescripcion,
                                        CONCAT(empleado_nombre,empleado_apellidos)empleado,
                                        CONCAT(medicamento,' ',gramaje)medicamento,
                                        dosis,via_administracion,frecuencia,
                                        aplicacion, fecha_inicio, fecha_fin, estado
                                        FROM prescripcion INNER JOIN os_empleados
                                        ON prescripcion.empleado_id = os_empleados.empleado_id
                                        INNER JOIN catalogo_medicamentos
                                        ON prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                        WHERE prescripcion.triage_id = ".$paciente."
                                        AND estado = ".$estado."
                                        ORDER BY fecha_prescripcion DESC");
      print json_encode($sql);
    }
    public function AjaxCambiarEstadoPrescripcion(){
      $paciente = $this->input->get('paciente');
      $variables = array(
        'estado' => $this->input->get('estado'),
        'fecha_fin' => date('d/m/Y'),
        'tiempo' => $this->input->get('dias')
      );
      $condiciones = array(
        'prescripcion_id' => $this->input->get('prescripcion_id')
      );
      $sql = $this->config_mdl->_update_data('prescripcion', $variables, $condiciones);

      $medicamento_inactivo = $this->config_mdl->_query("SELECT count(prescripcion_id)total_prescripcion
                                                        FROM prescripcion WHERE estado = 0
                                                        AND triage_id = ".$paciente);
      if($sql){
        $mensaje = array(
          "mensaje" => "El estado de la prescripcion se modifico exitosamente",
          "medicamento_inactivo" => $medicamento_inactivo[0]['total_prescripcion']
        );
      }else{
        $mensaje = array(
          "mensaje" => "El estado no pudo modificarse",
          "medicamento_inactivo" => $medicamento_inactivo[0]['total_prescripcion']
        );
      }
      print json_encode($mensaje);
    }

    public function ExpedienteEmpleado($data) {
        $sql= $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=> $data['empleado_id']
        ));
        if(empty($sql)){
            return 'No Especificado';
        }else{
            return $sql[0]['empleado_nombre'].' '.$sql[0]['empleado_apellidos'];
        }
    }
    public function HojaFrontal() {
        $sql['Especialidades']= $this->config_mdl->_query("SELECT * FROM um_especialidades GROUP BY um_especialidades.especialidad_nombre");
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get_post('folio')
        ))[0];
        $sql['hojafrontal']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'hf_id'=>  $this->input->get_post('hf')
        ));
        $sql['am']=  $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=>  $this->input->get_post('folio')
        ));
        $sql['DirEmpresa']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Empresa',
            'triage_id'=>  $this->input->get_post('folio')
        ))[0];
        $sql['ce']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=>  $this->input->get_post('folio')
        ));
        $sql['INFO_USER']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>  $_SESSION['UMAE_USER']
        ));
        $sql['Empresa']= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$this->input->get_post('folio')
        ))[0];
        $sql['MinisterioPublico']= $this->config_mdl->_get_data_condition('ts_ministerio_publico',array(
            'triage_id'=>$this->input->get_post('folio')
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$this->input->get_post('folio')
        ))[0];
        $sql['SignosVitales']= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
            'triage_id'=>$this->input->get_post('folio')
        ))[0];
        $sql['Documentos']= $this->config_mdl->_get_data_condition('pc_documentos',array(
            'doc_nombre'=>'Hoja Frontal'
        ));
        $this->load->view('Documentos/Doc_HojaFrontal',$sql);

    }
    public function GuardarHojaFrontal() {
        $consultorio= $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=>  $this->input->post('triage_id')
        ))[0];
        foreach ($this->input->post('hf_mecanismolesion') as $value) {
            $hf_mecanismolesion.=$value.',';
        }
        foreach ($this->input->post('hf_quemadura') as $value) {
            $hf_quemadura.=$value.',';
        }
        foreach ($this->input->post('hf_trataminentos') as $value) {
            $hf_trataminentos.=$value.',';
        }
        $data=array(
            'hf_ce'=> ($this->input->post('tipo')=='Consultorios' ? '1': '0'),
            'hf_obs'=> ($this->input->post('tipo')=='Observación' ? '1': '0'),
            'hf_choque'=> ($this->input->post('tipo')=='Choque' ? '1': '0'),
            'hf_fg'=> date('Y-m-d'),
            'hf_hg'=> date('H:i'),
            'hf_documento'=> $this->input->post('hf_documento'),
            'hf_intoxitacion'=>  $this->input->post('hf_intoxitacion'),
            'hf_intoxitacion_descrip'=>  $this->input->post('hf_intoxitacion_descrip'),
            'hf_urgencia'=>  $this->input->post('hf_urgencia'),
            'hf_atencion'=> $this->input->post('hf_atencion'),
            'hf_especialidad'=>  $this->input->post('hf_especialidad'),
            'hf_motivo'=>  $this->input->post('hf_motivo'),
            'hf_mecanismolesion'=>rtrim($hf_mecanismolesion,','),
            'hf_mecanismolesion_mtrs'=>  $this->input->post('hf_mecanismolesion_mtrs'),
            'hf_mecanismolesion_otros'=>  $this->input->post('hf_mecanismolesion_otros'),
            'hf_quemadura'=>  rtrim($hf_quemadura,','),
            'hf_quemadura_otros'=>  $this->input->post('hf_quemadura_otros'),
            'hf_antecedentes'=>  $this->input->post('hf_antecedentes'),
            'hf_exploracionfisica'=>  $this->input->post('hf_exploracionfisica'),
            'hf_estadosalud'=>  $this->input->post('hf_estadosalud'),
            'hf_diagnosticos'=>  $this->input->post('hf_diagnosticos'),
            'hf_diagnosticos_lechaga'=>  $this->input->post('hf_diagnosticos_lechaga'),
            'hf_trataminentos'=> rtrim($hf_trataminentos,','),
            'hf_trataminentos_otros'=>  $this->input->post('hf_trataminentos_otros'),
            'hf_trataminentos_por'=>  $this->input->post('hf_trataminentos_por'),
            'hf_receta_por'=>  $this->input->post('hf_receta_por'),
            'hf_indicaciones'=>  $this->input->post('hf_indicaciones'),
            'hf_ministeriopublico'=>  $this->input->post('hf_ministeriopublico'),
            'hf_alta'=> $this->input->post('hf_alta'),
            'hf_alta_otros'=> $this->input->post('hf_alta_otros'),
            'hf_incapacidad_dias'=>  $this->input->post('hf_incapacidad_dias'),
            'hf_incapacidad_ptr_eg'=>  $this->input->post('hf_incapacidad_ptr_eg'),
            'triage_id'=>  $this->input->post('triage_id'),
            'empleado_id'=> $this->UMAE_USER
        );
        $data_am=array(
            'asistentesmedicas_da'=>  $this->input->post('asistentesmedicas_da'),
            'asistentesmedicas_dl'=>  $this->input->post('asistentesmedicas_dl'),
            'asistentesmedicas_ip'=>  $this->input->post('asistentesmedicas_ip'),
            'asistentesmedicas_tratamientos'=>  $this->input->post('asistentesmedicas_tratamientos'),
            'asistentesmedicas_ss_in'=>  $this->input->post('asistentesmedicas_ss_in'),
            'asistentesmedicas_ss_ie'=>  $this->input->post('asistentesmedicas_ss_ie'),
            'asistentesmedicas_oc_hr'=>  $this->input->post('asistentesmedicas_oc_hr'),
            'asistentesmedicas_am'=>  $this->input->post('asistentesmedicas_am'),
            'asistentesmedicas_incapacidad_am'=>  $this->input->post('asistentesmedicas_incapacidad_am'),
            'asistentesmedicas_incapacidad_ga'=> $this->input->post('asistentesmedicas_incapacidad_ga'),
            'asistentesmedicas_incapacidad_tipo'=> $this->input->post('asistentesmedicas_incapacidad_tipo'),
            'asistentesmedicas_incapacidad_dias_a'=> $this->input->post('asistentesmedicas_incapacidad_dias_a'),
            'asistentesmedicas_incapacidad_fi'=>  $this->input->post('asistentesmedicas_incapacidad_fi'),
            'asistentesmedicas_incapacidad_da'=>  $this->input->post('asistentesmedicas_incapacidad_da'),
            'asistentesmedicas_mt'=>  $this->input->post('asistentesmedicas_mt'),
            'asistentesmedicas_mt_m'=>  $this->input->post('asistentesmedicas_mt_m'),
            'asistentesmedicas_incapacidad_folio'=>  $this->input->post('asistentesmedicas_incapacidad_folio'),
            'asistentesmedicas_omitir'=>  $this->input->post('asistentesmedicas_omitir')
        );
        if($this->input->post('tipo')=='Consultorios'){
            if($consultorio['ce_status']=='Salida'){
                unset($data['hf_alta']);
            }else{
                $this->config_mdl->_update_data('os_consultorios_especialidad',array(
                    'ce_hf'=>($this->input->post('hf_alta')!='Otros' ? $this->input->post('hf_alta') : $this->input->post('hf_alta_otros'))
                ),array(
                   'triage_id'=>  $this->input->post('triage_id')
                ));
            }
        }
        $sqlCheckHojaFrontal= $this->config_mdl->sqlGetDataCondition('os_consultorios_especialidad_hf',array(
            'triage_id'=> $this->input->post('triage_id')
        ),'hf_id');
        if(empty($sqlCheckHojaFrontal)){
            $this->config_mdl->_insert('os_consultorios_especialidad_hf',$data);
        }else{
            unset($data['hf_fg']);
            unset($data['hf_hg']);
            unset($data['empleado_id']);
            $this->config_mdl->_update_data('os_consultorios_especialidad_hf',$data,array(
                'hf_id'=>  $this->input->post('hf_id')
            ));

        }

        $this->config_mdl->_update_data('os_asistentesmedicas',$data_am,array(
           'triage_id'=>  $this->input->post('triage_id')
        ));
        if($this->input->post('hf_ministeriopublico')=='Si'){
            $sqlMP= $this->config_mdl->_get_data_condition('ts_ministerio_publico',array(
                'triage_id'=> $this->input->post('triage_id')
            ));
            if(empty($sqlMP)){
                $this->config_mdl->_insert('ts_ministerio_publico',array(
                    'mp_estatus'=>'Enviado',
                    'mp_fecha'=> date('Y-m-d'),
                    'mp_hora'=> date('H:i:s'),
                    'mp_area'=> $this->input->post('tipo'),
                    'triage_id'=> $this->input->post('triage_id'),
                    'medico_familiar'=> $this->UMAE_USER
                ));
            }
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function HojaInicialAbierto() {
        $sql['Especialidades']= $this->config_mdl->_query("SELECT * FROM um_especialidades WHERE especialidad_interconsulta = 1 GROUP BY um_especialidades.especialidad_nombre");
        $sql['info']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get_post('folio')
        ))[0];
        $sql['hojafrontal']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad_hf',array(
            'hf_id'=>  $this->input->get_post('hf')
        ));
        $sql['am']=  $this->config_mdl->_get_data_condition('os_asistentesmedicas',array(
            'triage_id'=>  $this->input->get_post('folio')
        ));
        $sql['DirEmpresa']=  $this->config_mdl->_get_data_condition('os_triage_directorio',array(
            'directorio_tipo'=>'Empresa',
            'triage_id'=>  $this->input->get_post('folio')
        ))[0];
        $sql['ce']=  $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=>  $this->input->get_post('folio')
        ));
        $sql['INFO_USER']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=>  $_SESSION['UMAE_USER']
        ));
        $sql['Empresa']= $this->config_mdl->_get_data_condition('os_triage_empresa',array(
            'triage_id'=>$this->input->get_post('folio')
        ))[0];
        $sql['MinisterioPublico']= $this->config_mdl->_get_data_condition('ts_ministerio_publico',array(
            'triage_id'=>$this->input->get_post('folio')
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$this->input->get_post('folio')
        ))[0];
        $sql['SignosVitales']= $this->config_mdl->_get_data_condition('os_triage_signosvitales',array(
            'triage_id'=>$this->input->get_post('folio')
        ))[0];
        $sql['Documentos']= $this->config_mdl->_get_data_condition('pc_documentos',array(
            'doc_nombre'=>'Hoja Frontal'
        ));
        $sql['Medicamentos'] = $this->config_mdl->_query("SELECT medicamento_id,
                                                                 CONCAT(medicamento,' ',gramaje)medicamento,
                                                                 interaccion_amarilla,interaccion_roja
                                                          FROM catalogo_medicamentos
                                                          WHERE existencia = 1");
        $sql['Vias'] = array(IV,VO,IT,Enema,IM,Coliris,SC,Rectal,SB,IP,Tupilco,ID,Inhalatoria,Nasal,Otorrino,Ocular);
        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT prescripcion_id, medicamento, dosis,fecha_prescripcion,via_administracion,
                                                          frecuencia,aplicacion,fecha_inicio,tiempo,fecha_fin,estado
                                                          FROM prescripcion INNER JOIN catalogo_medicamentos ON
                                                          prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                          INNER JOIN os_triage ON prescripcion.triage_id = os_triage.triage_id
                                                          WHERE os_triage.triage_id =".$_GET['folio']);
        $sql['Prescripciones_activas'] = $this->config_mdl->_query("SELECT COUNT(prescripcion_id)activas FROM prescripcion
                                                                    WHERE estado = 1 AND triage_id = ".$_GET['folio']);

        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT cie10_clave, cie10_nombre FROM paciente_diagnosticos
                                                          INNER JOIN diagnostico_hoja_frontal
                                                          	ON paciente_diagnosticos.diagnostico_id = diagnostico_hoja_frontal.diagnostico_id
                                                          INNER JOIN um_cie10
                                                          	ON um_cie10.cie10_id = paciente_diagnosticos.cie10_id
                                                          WHERE triage_id = ".$_GET['folio']." ORDER BY tipo_diagnostico");

        $sql['Prescripciones_canceladas'] = $this->config_mdl->_query("SELECT prescripcion.prescripcion_id
                                                                      FROM prescripcion
                                                                      INNER JOIN catalogo_medicamentos ON
                                                                      prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                      INNER JOIN os_triage ON
                                                                      prescripcion.triage_id = os_triage.triage_id
                                                                      INNER JOIN btcr_prescripcion ON
                                                                      prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                                                      WHERE os_triage.triage_id =".$_GET['folio']." GROUP BY prescripcion_id");

        $sql['Interconsultas'] = $this->config_mdl->_query("SELECT * FROM interconsulta_hoja_frontal
                                                            INNER JOIN doc_430200
                                                            	ON doc_430200.doc_id = interconsulta_hoja_frontal.doc_id
                                                            WHERE triage_id = ".$_GET['folio']);

        $this->load->view('Documentos/HojaInicialAbierto',$sql);
    }

    public function AjaxUltimasOrdenes(){
      $folio = $_GET['folio'];
      $consultaNota = "SELECT nota_nutricion, nota_svycuidados, nota_cgenfermeria,
                          nota_cuidadosenfermeria, nota_solucionesp
                   FROM doc_nota
                   INNER JOIN doc_notas
                  	 ON doc_nota.notas_id = doc_notas.notas_id
                   WHERE triage_id = ".$folio."
                   ORDER BY nota_id DESC LIMIT 1";
      $consultaHFrontal = "SELECT hf_nutricion, hf_signosycuidados, hf_cgenfermeria,
                           hf_cuidadosenfermeria, hf_solucionesp
                           FROM os_consultorios_especialidad_hf
                           WHERE triage_id = ".$folio." ";
      $sql = $this->config_mdl->_query($consultaNota);
      if(COUNT($sql) < 1){
        $sql = $this->config_mdl->_query($consultaHFrontal);
      }
      print json_encode($sql);
    }

    public function AjaxDiagnosticos(){
      $diagnostico_solicitado = $_GET['diagnostico_solicitado'];
      $sql = $this->config_mdl->_query("SELECT * FROM um_cie10
                                        WHERE cie10_nombre LIKE '%$diagnostico_solicitado%' ORDER BY cie10_nombre LIMIT 30 ");
      print json_encode($sql);
    }
    public function AjaxDiagnosticosFrecuentes(){

    }
    public function AjaxHojaInicialAbierto() {
        $consultorio= $this->config_mdl->_get_data_condition('os_consultorios_especialidad',array(
            'triage_id'=>  $this->input->post('triage_id')
        ))[0];

        // Se determina si el valor a registrar es del select o del textarea
        $select_alergias = $this->input->post('select_alergias');
        $textarea_alergias = $this->input->post('alergias');
        $alergias = "";

        if($select_alergias == '1'){
          $alergias = $textarea_alergias;
        }else if($select_alergias == '2'){
          $alergias = "Negadas";
        }

        $this->config_mdl->_update_data('paciente_info',
                                        array('alergias' => $alergias),
                                        array('triage_id' => $this->input->post('triage_id'))
                                      );


        // Se toman los valores del formulario 'Instrucciones de nutricion'
        $hf_nutricion = "";
        $radio_nutricion = $this->input->post('dieta');
        $select_nutricion = $this->input->post('tipoDieta');
        $otros_nutricion = $this->input->post('otraDieta');
        /* las siguiendes condiciones son para indexar el campo 'nota_nutricion'
          de esta forma se conoce el origen del dato.*/

        //Indica que el valor viene de una caja de texto
        if($otros_nutricion != "" & $select_nutricion == 13){
          $hf_nutricion = $otros_nutricion;
        // Indica que el valor viene de un select
        }else if($select_nutricion >= 1 || $select_nutricion <=12 ){
          $hf_nutricion = $select_nutricion;
        // Indica que el valor viene de un radio
        }else if($radio_nutricion == 0){
          $hf_nutricion = $radio_nutricion;
        }


        $select_signos = $this->input->post("tomaSignos");
        $otros_signos = $this->input->post("otrasIndicacionesSignos");
        $hf_svycuidados = $select_signos;
        if($select_signos == "3"){
          $hf_svycuidados = $otros_signos;
        }

        $hf_cgenfermeria = 1;
        if($this->input->post("nota_cgenfermeria") != 1){
          $hf_cgenfermeria = 0;
        }

        $data=array(
            'hf_ce'=> ($this->input->post('tipo')=='Consultorios' ? '1': '0'),
            'hf_obs'=> ($this->input->post('tipo')=='Observación' ? '1': '0'),
            'hf_choque'=> ($this->input->post('tipo')=='Choque' ? '1': '0'),
            'hf_fg'=> date('d-m-Y'),
            'hf_hg'=> date('H:i'),
            'hf_documento'=> $this->input->post('hf_documento'),
            'hf_motivo'=> $this->input->post('hf_motivo'),//Motivo de Consulta
            'hf_antecedentes'=> $this->input->post('hf_antecedentes'), //Antecedentes
            'hf_padecimientoa'=> $this->input->post('hf_padecimientoa'), // Padecimiento actual
            'hf_exploracionfisica'=> $this->input->post('hf_exploracionfisica'), // Eploracion fisica
            // ESCALA DE GLASGOW
            'hf_glasgow_expontanea'=> $this->input->post('hf_glasgow_expontanea'),//Apertura Ocular
            'hf_glasgow_hablar'=> $this->input->post('hf_glasgow_hablar'),
            'hf_glasgow_dolor'=> $this->input->post('hf_glasgow_dolor'),
            'hf_glasgow_ausente'=> $this->input->post('hf_glasgow_ausente'),
            'hf_glasgow_obedece'=> $this->input->post('hf_glasgow_obedece'), // Respuesta Motora
            'hf_glasgow_localiza'=> $this->input->post('hf_glasgow_localiza'),
            'hf_glasgow_retira'=> $this->input->post('hf_glasgow_retira'),
            'hf_glasgow_flexion'=> $this->input->post('hf_glasgow_flexion'),
            'hf_glasgow_extension'=> $this->input->post('hf_glasgow_extension'),
            'hf_glasgow_ausencia'=> $this->input->post('hf_glasgow_ausencia'),
            'hf_glasgow_orientado'=> $this->input->post('hf_glasgow_orientado'),// Respuesta Verbal
            'hf_glasgow_confuso'=> $this->input->post('hf_glasgow_confuso'),
            'hf_glasgow_incoherente'=> $this->input->post('hf_glasgow_incoherente'),
            'hf_glasgow_sonidos'=> $this->input->post('hf_glasgow_sonidos'),
            'hf_glasgow_arespuesta'=> $this->input->post('hf_glasgow_arespuesta'),
            'hf_escala_glasgow'=> $this->input->post('hf_escala_glasgow'),
            'hf_auxiliares'=>$this->input->post('hf_auxiliares'), // Auxiliares Diagnóstico
            'hf_diagnosticos_lechaga'=>  $this->input->post('hf_diagnosticos_lechaga'), //Diagnóstico de Ingreso
            'hf_diagnosticos'=> $this->input->post('hf_diagnosticos'), // Comorbilidades
            'hf_riesgocaida'=> $this->input->post('hf_riesgocaida'),
            'hf_eva'=> $this->input->post('hf_eva'),
            'hf_riesgo_trombosis'=> $this->input->post('hf_riesgo_trombosis'),
            // PLAN MEDICO
            'hf_nutricion'=> $hf_nutricion,
            'hf_signosycuidados'=> $hf_svycuidados,
            'hf_cgenfermeria' => $hf_cgenfermeria,
            'hf_cuidadosenfermeria'=> $this->input->post('hf_cuidadosenfermeria'),
            'hf_solucionesp'=> $this->input->post('hf_solucionesp'),
            'hf_medicamentos'=> $this->input->post('hf_medicamentos'),
            'hf_indicaciones'=> $this->input->post('hf_indicaciones'),//Pronosticos
            'hf_estadosalud'=> $this->input->post('hf_estadosalud'),//Estado de salud
            'hf_interconsulta'=> $this->input->post('hf_interconsulta'),
            'hf_alta'=> $this->input->post('hf_alta'),
            'hf_alta_otros'=> $this->input->post('hf_alta_otros'),
            'triage_id'=>  $this->input->post('triage_id'),
            'empleado_id'=> $this->UMAE_USER
        );
        $data_am=array(
            'asistentesmedicas_da'=>  $this->input->post('asistentesmedicas_da'),
            'asistentesmedicas_dl'=>  $this->input->post('asistentesmedicas_dl'),
            'asistentesmedicas_ip'=>  $this->input->post('asistentesmedicas_ip'),
            'asistentesmedicas_tratamientos'=>  $this->input->post('asistentesmedicas_tratamientos'),
            'asistentesmedicas_ss_in'=>  $this->input->post('asistentesmedicas_ss_in'),
            'asistentesmedicas_ss_ie'=>  $this->input->post('asistentesmedicas_ss_ie'),
            'asistentesmedicas_oc_hr'=>  $this->input->post('asistentesmedicas_oc_hr'),
            'asistentesmedicas_am'=>  $this->input->post('asistentesmedicas_am'),
            'asistentesmedicas_incapacidad_am'=>  $this->input->post('asistentesmedicas_incapacidad_am'),
            'asistentesmedicas_incapacidad_ga'=> $this->input->post('asistentesmedicas_incapacidad_ga'),
            'asistentesmedicas_incapacidad_tipo'=> $this->input->post('asistentesmedicas_incapacidad_tipo'),
            'asistentesmedicas_incapacidad_dias_a'=> $this->input->post('asistentesmedicas_incapacidad_dias_a'),
            'asistentesmedicas_incapacidad_fi'=>  $this->input->post('asistentesmedicas_incapacidad_fi'),
            'asistentesmedicas_incapacidad_da'=>  $this->input->post('asistentesmedicas_incapacidad_da'),
            'asistentesmedicas_mt'=>  $this->input->post('asistentesmedicas_mt'),
            'asistentesmedicas_mt_m'=>  $this->input->post('asistentesmedicas_mt_m'),
            'asistentesmedicas_incapacidad_folio'=>  $this->input->post('asistentesmedicas_incapacidad_folio'),
            'asistentesmedicas_omitir'=>  $this->input->post('asistentesmedicas_omitir')
        );
        if($this->input->post('tipo')=='Consultorios'){
            if($consultorio['ce_status']=='Salida'){
                unset($data['hf_alta']);
            }else{
                $this->config_mdl->_update_data('os_consultorios_especialidad',array(
                    'ce_hf'=>($this->input->post('hf_alta')!='Otros' ? $this->input->post('hf_alta') : $this->input->post('hf_alta_otros'))
                ),array(
                   'triage_id'=>  $this->input->post('triage_id')
                ));
            }
        }
        $sqlCheckHojaFrontal= $this->config_mdl->sqlGetDataCondition('os_consultorios_especialidad_hf',array(
            'triage_id'=> $this->input->post('triage_id')
        ),'hf_id');
        if(empty($sqlCheckHojaFrontal)){

            for($x = 0; $x < count($this->input->post('cie10_id')); $x++){
              $datos_diagnostico = array(
                'triage_id' => $this->input->post('triage_id'),
                'cie10_id' => $this->input->post("cie10_id[$x]"),
                'tipo_diagnostico' => $this->input->post("tipo_diagnostico[$x]")
              );
              $this->config_mdl->_insert('paciente_diagnosticos',$datos_diagnostico);

            }

            $this->config_mdl->_insert('os_consultorios_especialidad_hf',$data);
            for($x = 0; $x < count($this->input->post('nota_interconsulta')); $x++){
              $existencia_interconsuta = $this->config_mdl->_query(
               "SELECT doc_id
                FROM doc_430200
                WHERE doc_servicio_solicitado = ".$this->input->post("nota_interconsulta[$x]")
              );

              $this->config_mdl->_update_data('os_consultorios_especialidad',array(
                  'ce_status'=>'Interconsulta',
                  'ce_interconsulta'=>'Si'
              ),array(
                  'triage_id'=>  $this->input->post('triage_id')
              ));

                $datos_interconsulta = array(
                  'doc_estatus' => 'En Espera',
                  'doc_fecha'=> date('Y-m-d'),
                  'doc_hora' => date('H:i'),
                  'doc_area' => $this->UMAE_AREA,
                  'doc_servicio_envia'=> Modules::run('Consultorios/ObtenerEspecialidadID',array('Consultorio'=>$this->UMAE_AREA)),
                  'doc_servicio_solicitado' => $this->input->post("nota_interconsulta[$x]"),
                  'triage_id' => $this->input->post('triage_id'),
                  'doc_modulo' => "Consultorios",
                  'motivo_interconsulta' => $this->input->post('motivo_interconsulta'),
                  'empleado_envia'=> $this->UMAE_USER
                );
                $this->config_mdl->_insert('doc_430200',$datos_interconsulta);

            }

            /*
            Se consultan las interconsultas realizdas en la nota inicial, para
            ser registrados en el historial de interconsultas de la nota
            */
            $interconsultas_hf = $this->config_mdl->_query("SELECT doc_id FROM doc_430200
                                                            WHERE triage_id = ".$this->input->post('triage_id'));
            for($x = 0; $x < count($interconsultas_hf); $x++){
              $datos = array(
                "hf_id" => $this->config_mdl->_get_last_id('os_consultorios_especialidad_hf','hf_id'),
                "doc_id" => $interconsultas_hf[$x]['doc_id']
              );
              $this->config_mdl->_insert('interconsulta_hoja_frontal',$datos);
            }

            // Numero de prescripciones ingresadas, almacena en arreglo y registra en la
            // tabla "prescripcio"
            for($x = 0; $x < count($this->input->post('idMedicamento')); $x++){
              $datosPrescripcion = array(
                'empleado_id' => $this->UMAE_USER,
                'triage_id' => $this->input->post('triage_id'),
                'medicamento_id' => $this->input->post("idMedicamento[$x]"),
                'dosis' => $this->input->post("dosis[$x]"),
                'fecha_prescripcion' => date('d-m-Y')." ".date('H:i'),
                'via_administracion' => $this->input->post("via_administracion[$x]"),
                'frecuencia' => $this->input->post("frecuencia[$x]"),
                'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                'tiempo' => $this->input->post("duracion[$x]"),
                'periodo' => $this->input->post("periodo[$x]"),
                'fecha_fin' => $this->input->post("fechaFin[$x]"),
                'observacion' => $this->input->post("observacion[$x]"),
                'estado' => "1"
              );
              $this->config_mdl->_insert('prescripcion',$datosPrescripcion);
            }
            // Se toma el ID de las precripcines activas
            $Prescripciones = $this->config_mdl->_query("SELECT prescripcion_id
                                                         FROM prescripcion
                                                         WHERE estado = 1 AND triage_id = ".$this->input->post('triage_id').";");
            for($x = 0; $x < count($Prescripciones); $x++){
              $FrontalPrescripcion = array(
                'hf_id' => $this->config_mdl->_get_last_id('os_consultorios_especialidad_hf','hf_id'),
                'prescripcion_id' => $Prescripciones[$x]['prescripcion_id']
              );
              // Se registra la relacion entre notas y prescripcion
              $this->config_mdl->_insert('nm_hojafrontal_prescripcion', $FrontalPrescripcion);
            }

            /*
            Se consultan los diagnosticos del paciente registrados
            para ser asignados en la hoja frontal
            */
            $diagnostico = $this->config_mdl->_query("SELECT diagnostico_id
                                                      FROM paciente_diagnosticos
                                                      WHERE triage_id =".$this->input->post('triage_id'));

            for($x = 0; $x < count($diagnostico); $x++){
              $datos = array(
                'hf_id' => $this->config_mdl->_get_last_id('os_consultorios_especialidad_hf','hf_id'),
                'diagnostico_id' => $diagnostico[$x]['diagnostico_id']
              );
              $this->config_mdl->_insert('diagnostico_hoja_frontal',$datos);
            }

            /*
            Se consultan las interconsultas realizadas en la hoja frontal, para ingresarse
            en la tabla que distinguira su origen
            */




        }else{
            unset($data['hf_fg']);
            unset($data['hf_hg']);
            unset($data['empleado_id']);
            $this->config_mdl->_update_data('os_consultorios_especialidad_hf',$data,array(
                'hf_id'=>  $this->input->post('hf_id')
            ));
        }
        $this->config_mdl->_update_data('os_asistentesmedicas',$data_am,array(
           'triage_id'=>  $this->input->post('triage_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    /*DOCUMENTOS OBSERVACIÓN*/
    public function TratamientoQuirurgico($Paciente) {
        $sql['tratamientos']=  $this->config_mdl->_get_data_condition('os_observacion_tratamientos',array(
            'triage_id'=> $Paciente
        ));
        $this->load->view('Documentos/TratamientoQuirurgico',$sql);
    }
    public function AjaxTratamientosQuirurgicos() {
        $data=array(
            'tratamiento_nombre'=> $this->input->post('tratamiento_nombre'),
            'tratamiento_fecha'=> date('d/m/Y'),
            'tratamiento_hora'=> date('H:i'),
            'triage_id'=> $this->input->post('triage_id'),
            'empleado_id'=> $this->UMAE_USER
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('os_observacion_tratamientos',$data);
        }else{
            unset($data['tratamiento_fecha']);
            unset($data['tratamiento_hora']);
            unset($data['empleado_id']);
            $this->config_mdl->_update_data('os_observacion_tratamientos',$data,array(
                'tratamiento_id'=> $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function DocumentosTratamientoQuirurgico($Tratamiento) {
        $sql['triage']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get('folio')
        ));
        $sql['observacion']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->get('folio')
        ));
        $sql['st']=  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion',array(
            'tratamiento_id'=> $Tratamiento
        ));
        $sql['cs']=  $this->config_mdl->_get_data_condition('os_observacion_cirugiasegura',array(
            'tratamiento_id'=> $Tratamiento
        ));
        $sql['si']=  $this->config_mdl->_get_data_condition('os_observacion_ci',array(
            'tratamiento_id'=> $Tratamiento
        ));
        $sql['cci']=  $this->config_mdl->_get_data_condition('os_observacion_cci',array(
            'tratamiento_id'=> $Tratamiento
        ));
        $sql['isq']=  $this->config_mdl->_get_data_condition('os_observacion_isq',array(
            'tratamiento_id'=> $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/ComboQuirurgico',$sql);
    }
    public function SolicitudTransfusion($Tratamiento) {
        $sql['triage']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get('folio')
        ));
        $sql['observacion']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->get('folio')
        ));
        $sql['empleado']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=> $sql['observacion'][0]['observacion_medico']
        ));
        $sql['st']=  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion',array(
            'tratamiento_id'=> $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/SolicitudTransfusion',$sql);
    }
    public function AjaxSolicitudTransfusion() {
        $data=array(
            'solicitudtransfucion_sangre'=>  $this->input->post('solicitudtransfucion_sangre'),
            'solicitudtransfucion_plasma'=>  $this->input->post('solicitudtransfucion_plasma'),
            'solicitudtransfucion_suspensionconcentrada'=>  $this->input->post('solicitudtransfucion_suspensionconcentrada'),
            'solicitudtransfucion_otros'=>  $this->input->post('solicitudtransfucion_otros'),
            'solicitudtransfucion_otros_val'=>  $this->input->post('solicitudtransfucion_otros_val'),
            'solicitudtransfucion_ordinaria'=>  $this->input->post('solicitudtransfucion_ordinaria'),
            'solicitudtransfucion_urgente'=>  $this->input->post('solicitudtransfucion_urgente'),
            'solicitudtransfucion_urgente_vol'=>  $this->input->post('solicitudtransfucion_urgente_vol'),
            'solicitudtransfucion_operacion_dia'=>  $this->input->post('solicitudtransfucion_operacion_dia'),
            'solicitudtransfucion_operacion_hora'=>  $this->input->post('solicitudtransfucion_operacion_hora'),
            'solicitudtransfucion_disponible'=>  $this->input->post('solicitudtransfucion_disponible'),
            'solicitudtransfucion_reserva'=>  $this->input->post('solicitudtransfucion_reserva'),
            'solicitudtransfucion_gs_abo'=>  $this->input->post('solicitudtransfucion_gs_abo'),
            'solicitudtransfucion_gs_rhd'=>  $this->input->post('solicitudtransfucion_gs_rhd'),
            'solicitudtransfucion_gs_ignora'=>  $this->input->post('solicitudtransfucion_gs_ignora'),
            'solicitudtransfucion_diagnostico'=>  $this->input->post('solicitudtransfucion_diagnostico'),
            'solicitudtransfucion_hb'=>  $this->input->post('solicitudtransfucion_hb'),
            'solicitudtransfucion_ht'=>  $this->input->post('solicitudtransfucion_ht'),
            'solicitudtransfucion_transfuciones_previas'=>  $this->input->post('solicitudtransfucion_transfuciones_previas'),
            'solicitudtransfucion_reacciones_postransfuncionales'=>  $this->input->post('solicitudtransfucion_reacciones_postransfuncionales'),
            'solicitudtransfucion_fecha_ultima'=>  $this->input->post('solicitudtransfucion_fecha_ultima'),
            'solicitudtransfucion_embarazo_previo'=>  $this->input->post('solicitudtransfucion_embarazo_previo'),
            'solicitudtransfucion_pfh'=>  $this->input->post('solicitudtransfucion_pfh'),
            'solicitudtransfucion_solicita_f'=>  $this->input->post('solicitudtransfucion_solicita_f'),
            'solicitudtransfucion_solicita_h'=>  $this->input->post('solicitudtransfucion_solicita_h'),
            'solicitudtransfucion_recibio_nombre'=>  $this->input->post('solicitudtransfucion_recibio_nombre'),
            'solicitudtransfucion_recibio_f'=>  $this->input->post('solicitudtransfucion_recibio_f'),
            'solicitudtransfucion_recibio_h'=>  $this->input->post('solicitudtransfucion_recibio_h'),
            'tratamiento_id'=> $this->input->post('tratamiento_id'),
            'triage_id'=>  $this->input->post('triage_id')
        );
        if(empty($this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion',array('tratamiento_id'=>  $this->input->post('tratamiento_id'))))){
            $this->config_mdl->_insert('os_observacion_solicitudtransfucion',$data);
        }else{
            $this->config_mdl->_update_data('os_observacion_solicitudtransfucion',$data,array(
                'tratamiento_id'=>  $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function CirugiaSegura($Tratamiento) {
        $sql['triage']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get('folio')
        ));
        $sql['observacion']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->get('folio')
        ));
        $sql['empleado']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=> $sql['observacion'][0]['observacion_medico']
        ));
        $sql['cs']=  $this->config_mdl->_get_data_condition('os_observacion_cirugiasegura',array(
            'triage_id'=> $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/CirugiaSegura',$sql);
    }
    public function AjaxCirugiaSegura() {
        $data=array(
            'cirugiasegura_procedimiento'=>  $this->input->post('cirugiasegura_procedimiento'),
            'triage_id'=>  $this->input->post('triage_id'),
            'tratamiento_id'=> $this->input->post('tratamiento_id')
        );
        if(empty($this->config_mdl->_get_data_condition('os_observacion_cirugiasegura',array('tratamiento_id'=>  $this->input->post('tratamiento_id'))))){
            $this->config_mdl->_insert('os_observacion_cirugiasegura',$data);
        }else{
            $this->config_mdl->_update_data('os_observacion_cirugiasegura',$data,array(
                'tratamiento_id'=>  $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function SolicitudeIntervencion($Tratamiento) {
        $sql['triage']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get('folio')
        ));
        $sql['observacion']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->get('folio')
        ));
        $sql['empleado']=  $this->config_mdl->_get_data_condition('os_empleados',array(
            'empleado_id'=> $sql['observacion'][0]['observacion_medico']
        ));
        $sql['si']=  $this->config_mdl->_get_data_condition('os_observacion_ci',array(
            'tratamiento_id'=> $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/SolicitudeIntervencion',$sql);
    }
    public function AjaxSolicitudeIntervencion() {
        $data=array(
            'ci_servicio'=>  $this->input->post('ci_servicio'),
            'ci_fecha_solicitud'=>  $this->input->post('ci_fecha_solicitud'),
            'ci_fecha_solicitada'=>  $this->input->post('ci_fecha_solicitada'),
            'ci_hora_deseada'=>  $this->input->post('ci_hora_deseada'),
            'ci_prioridad'=>  $this->input->post('ci_prioridad'),
            'ci_diagnostico'=>  $this->input->post('ci_diagnostico'),
            'ci_operacion_planeada'=>  $this->input->post('ci_operacion_planeada'),
            'ci_operacion_eu'=>  $this->input->post('ci_operacion_eu'),
            'ci_ap'=>  $this->input->post('ci_ap'),
            'ci_tec'=>  $this->input->post('ci_tec'),
            'ci_njs'=>  $this->input->post('ci_njs'),
            'ci_nmc'=>  $this->input->post('ci_nmc'),
            'ci_mmc'=>  $this->input->post('ci_mmc'),
            'triage_id'=>  $this->input->post('triage_id'),
            'tratamiento_id'=> $this->input->post('tratamiento_id')
        );
        if(empty($this->config_mdl->_get_data_condition('os_observacion_ci',array('tratamiento_id'=>  $this->input->post('tratamiento_id'))))){
            $this->config_mdl->_insert('os_observacion_ci',$data);
        }else{
            $this->config_mdl->_update_data('os_observacion_ci',$data,array(
                'tratamiento_id'=>  $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function ConsentimientoInformado($Tratamiento) {
        $sql['triage']=  $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=> $this->input->get('folio')
        ));
        $sql['observacion']=  $this->config_mdl->_get_data_condition('os_observacion',array(
            'triage_id'=> $this->input->get('folio')
        ));
        $sql['cci']=  $this->config_mdl->_get_data_condition('os_observacion_cci',array(
            'triage_id'=> $Tratamiento
        ));
        $sql['st']=  $this->config_mdl->_get_data_condition('os_observacion_solicitudtransfucion',array(
            'tratamiento_id'=> $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/ConsentimientoInformado',$sql);
    }
    public function AjaxConsentimientoInformado() {
        $data=array(
            'cci_fecha'=>  $this->input->post('cci_fecha'),
            'cci_la_que_suscribe'=>  $this->input->post('cci_la_que_suscribe'),
            'cci_caracter'=>  $this->input->post('cci_caracter'),
            'cci_tipo_ct'=>  $this->input->post('cci_tipo_ct'),
            'cci_pronostico'=>  $this->input->post('cci_pronostico'),
            'triage_id'=>  $this->input->post('triage_id'),
            'tratamiento_id'=> $this->input->post('tratamiento_id')
        );
        if(empty($this->config_mdl->_get_data_condition('os_observacion_cci',array('tratamiento_id'=>  $this->input->post('tratamiento_id'))))){
            $this->config_mdl->_insert('os_observacion_cci',$data);
        }else{
            $this->config_mdl->_update_data('os_observacion_cci',$data,array(
                'tratamiento_id'=>  $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function ListaVerificacionISQ($Tratamiento) {

        $sql['isq']=  $this->config_mdl->_get_data_condition('os_observacion_isq',array(
            'tratamiento_id'=> $Tratamiento
        ));
        $this->load->view('Documentos/TratamientoQuirurgico/ListaVerificacionISQ',$sql);
    }
    public function AjaxListaVerificacionISQ() {
        $data=array(
            'isq_servicio_area'=>  $this->input->post('isq_servicio_area'),
            'isq_turno'=>  $this->input->post('isq_turno'),
            'triage_id'=>  $this->input->post('triage_id'),
            'tratamiento_id'=> $this->input->post('tratamiento_id')
        );
        if(empty($this->config_mdl->_get_data_condition('os_observacion_isq',array('tratamiento_id'=>  $this->input->post('tratamiento_id'))))){
            $this->config_mdl->_insert('os_observacion_isq',$data);
        }else{
            $this->config_mdl->_update_data('os_observacion_isq',$data,array(
                'tratamiento_id'=>  $this->input->post('tratamiento_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    public function HojaClasificacion($Paciente) {
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$Paciente
        ))[0];
        $this->load->view('Documentos/Doc_HojaClasificacion',$sql);
    }
    public function AjaxHojaClasificacion() {
        $triege_preg_puntaje_s1=0;
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
        $data=array(
            'triage_via_registro'=>'Choque',
            'triage_fecha_clasifica'=> date('Y-m-d'),
            'triage_hora_clasifica'=> date('H:i'),
            'triage_status'=>'Finalizado',
            'triage_etapa'=>'2',
            'triage_color'=>$color_name,
            'triage_crea_enfemeria'=> $this->UMAE_USER,
            'triage_crea_medico'=> $this->UMAE_USER,
        );
        $data_clasificacion=array(
            'triage_preg1_s1'=>  0,
            'triage_preg2_s1'=>  0,
            'triage_preg3_s1'=>  0,
            'triage_preg4_s1'=>  0,
            'triage_preg5_s1'=>  0,
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
            'triage_preg10_s2'=> $this->input->post('triage_preg10_s2'),
            'triage_preg11_s2'=> $this->input->post('triage_preg11_s2'),
            'triage_preg12_s2'=> $this->input->post('triage_preg12_s2'),
            'triege_preg_puntaje_s2'=>$triege_preg_puntaje_s2,
            'triage_preg1_s3'=>  $this->input->post('triage_preg1_s3'),
            'triage_preg2_s3'=>  $this->input->post('triage_preg2_s3'),
            'triage_preg3_s3'=>  $this->input->post('triage_preg3_s3'),
            'triage_preg4_s3'=>  $this->input->post('triage_preg4_s3'),
            'triage_preg5_s3'=>  $this->input->post('triage_preg5_s3'),
            'triege_preg_puntaje_s3'=>$triege_preg_puntaje_s3,
            'triage_puntaje_total'=>$total_puntos,
            'triage_color'=>$color_name,
            'triage_id'=> $this->input->post('triage_id')
        );
        $this->config_mdl->_update_data('os_triage',$data,array(
            'triage_id'=>  $this->input->post('triage_id')
        ));

        $this->config_mdl->_insert('os_triage_clasificacion',$data_clasificacion);
        Modules::run('Sections/Api/TriageMedico',$data_clasificacion);
        $this->AccesosUsuarios(array('acceso_tipo'=>'Triage Enfermería (Choque)','triage_id'=>$this->input->post('triage_id'),'areas_id'=> $this->input->post('triage_id')));
        $this->AccesosUsuarios(array('acceso_tipo'=>'Triage Médico (Choque)','triage_id'=>$this->input->post('triage_id'),'areas_id'=> $this->input->post('triage_id')));

        $this->setOutput(array('accion'=>'1'));
    }

    /*NUEVAS FUNCIONES NOTAS CONSULTORIOS Y OBSERVACIÓN*/
    public function Notas($Nota) {
        $sql['info']= $this->config_mdl->_get_data_condition('os_triage',array(
            'triage_id'=>$_GET['folio']
        ))[0];
        $sql['PINFO']= $this->config_mdl->_get_data_condition('paciente_info',array(
            'triage_id'=>$_GET['folio']
        ))[0];
        $sql['Documentos']= $this->config_mdl->_query("SELECT * FROM pc_documentos WHERE doc_nombre!='Hoja Frontal'");

        $sql['Nota']= $this->config_mdl->_query("SELECT * FROM doc_notas, doc_nota, um_especialidades WHERE
            doc_notas.notas_id=doc_nota.notas_id AND
            doc_notas.notas_id=".$Nota)[0];
        $sql['SignosVitales']= $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales',array(
            'triage_id'=>$_GET['folio'],
            'sv_tipo'=>$_GET['inputVia']
        ))[0];
        $sql['Especialidades']=  $this->config_mdl->sqlGetData('um_especialidades');
        $sql['Usuario'] = $this->config_mdl->_query("SELECT * FROM os_empleados WHERE empleado_id ='$this->UMAE_USER'" );
        $sql['Medicos']= $this->config_mdl->_query("SELECT * FROM os_empleados, os_empleados_roles, os_roles WHERE
                                                    os_empleados_roles.empleado_id=os_empleados.empleado_id AND
                                                    os_empleados_roles.rol_id=os_roles.rol_id AND
                                                    os_roles.rol_id=2");
        $sql['MedicosBase']= $this->config_mdl->_query("SELECT empleado_matricula,empleado_nombre, empleado_apellidos FROM os_empleados
                                                        WHERE empleado_servicio =
                                                          (SELECT empleado_servicio
                                                           FROM os_empleados
                                                           WHERE empleado_id = '$this->UMAE_USER')"
                                                         );
        $sql['Medicamentos'] = $this->config_mdl->_query("SELECT medicamento_id,
                                                                 CONCAT(medicamento,' ',gramaje)medicamento,
                                                                 interaccion_amarilla,interaccion_roja
                                                          FROM catalogo_medicamentos
                                                          WHERE existencia = 1");
        $sql['Residentes'] = $this->config_mdl->_query("SELECT notas_id,nombre_residente,apellido_residente,cedulap_residente
                                                           FROM um_notas_residentes
                                                           WHERE notas_id = $Nota");

        $sql['Vias'] = array("INTRAVENOSA","ORAL","TOPICO","OFTALMICO","SUBCUTANEA","INHALATORIA","RECTAL",
                             "NASAL","INTRAMUSCULAR","TRANSDÉRMICO","VAGINAL","INTRATECAL","SUBLINGUAL",
                             "DERMICO","PERFUCION INTRAVENOSA","GASTROENTÉRICA","PARENTAL","OFTÁLMICA","ÓTICA");

        $sql['MedicosBaseNota'] = $this->config_mdl->_query("SELECT empleado_nombre,empleado_apellidos,empleado_matricula
                                                             FROM os_empleados
                                                             WHERE empleado_id = (
                                                               SELECT empleado_id FROM doc_notas WHERE notas_id = $Nota
                                                             )");
        $sql['Prescripcion'] = $this->config_mdl->_query("SELECT prescripcion_id, concat(medicamento, ' ', gramaje)medicamento,
                                                          dosis,fecha_prescripcion,via_administracion,
                                                          frecuencia,aplicacion,fecha_inicio,tiempo,fecha_fin,estado
                                                          FROM prescripcion INNER JOIN catalogo_medicamentos ON
                                                          prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                          INNER JOIN os_triage ON prescripcion.triage_id = os_triage.triage_id
                                                          WHERE os_triage.triage_id =".$_GET['folio']);
        $sql['Prescripciones_activas'] = $this->config_mdl->_query("SELECT COUNT(prescripcion_id)activas FROM prescripcion
                                                                    WHERE estado = 1 AND triage_id = ".$_GET['folio']);
        $sql['Prescripciones_canceladas'] = $this->config_mdl->_query("SELECT prescripcion.prescripcion_id
                                                                      FROM prescripcion
                                                                      INNER JOIN catalogo_medicamentos ON
                                                                      prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                      INNER JOIN os_triage ON
                                                                      prescripcion.triage_id = os_triage.triage_id
                                                                      INNER JOIN btcr_prescripcion ON
                                                                      prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                                                      WHERE os_triage.triage_id =".$_GET['folio']." GROUP BY prescripcion_id");
        $sql['Diagnosticos'] = $this->config_mdl->_query("SELECT diagnostico_id, cie10_clave, cie10_nombre
                                                         FROM paciente_diagnosticos
                                                         INNER JOIN um_cie10
                                                        	 ON paciente_diagnosticos.cie10_id = um_cie10.cie10_id
                                                         WHERE triage_id = ".$_GET['folio']);
        $sql['UltimosSignosVitales'] = $this->config_mdl->_query("SELECT sv_tipo,CONCAT(sv_fecha,' ',sv_hora) AS fecha,sv_ta,sv_temp,sv_fc,sv_fr,sv_oximetria,sv_talla,sv_dextrostix,sv_peso
                                                                  FROM os_triage_signosvitales
                                                                  WHERE triage_id = ".$_GET['folio']." AND
                                                                        sv_tipo = 'Consultorios'
                                                                  ORDER BY fecha DESC");

        $sql['DiagnosticoPaciente'] = $this->config_mdl->_query("SELECT * FROM `paciente_diagnosticos`
                                                                INNER JOIN um_cie10
                                                                    ON paciente_diagnosticos.cie10_id = um_cie10.cie10_id
                                                                WHERE triage_id = ".$_GET['folio']." AND tipo_diagnostico = 1;");
        //En caso de no existir una nota con signos vitales, se toman de la hoja frontal
        if(COUNT($sql['UltimosSignosVitales']) == 0 ){
          $sql['UltimosSignosVitales'] = $this->config_mdl->_query("SELECT sv_tipo,CONCAT(sv_fecha,' ',sv_hora) AS fecha,sv_ta,sv_temp,sv_fc,sv_fr,sv_oximetria,sv_talla,sv_dextrostix,sv_peso
                                                                    FROM os_triage_signosvitales
                                                                    WHERE triage_id = ".$_GET['folio']." AND
                                                                          sv_tipo = 'Triage'
                                                                    ORDER BY fecha DESC");
        }




        $this->load->view('Documentos/Doc_Notas',$sql);
    }

    public function AjaxConteoEstadoPrescripciones(){
      $sql['Prescripciones_activas'] = $this->config_mdl->_query("SELECT COUNT(prescripcion_id)activas FROM prescripcion
                                                                  WHERE estado = 1 AND triage_id = ".$_GET['folio']);
      $sql['Prescripciones_canceladas'] = $this->config_mdl->_query("SELECT prescripcion.prescripcion_id
                                                                    FROM prescripcion
                                                                    INNER JOIN catalogo_medicamentos ON
                                                                    prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                                    INNER JOIN os_triage ON
                                                                    prescripcion.triage_id = os_triage.triage_id
                                                                    INNER JOIN btcr_prescripcion ON
                                                                    prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                                                    WHERE os_triage.triage_id =".$_GET['folio']." GROUP BY prescripcion_id");
      print json_encode($sql);
    }
    public function AjaxModificarPrescripcion(){
      $datos = array(
        'via_administracion' => $this->input->get('via_administracion'),
        'frecuencia' => $this->input->get('frecuencia'),
        'aplicacion' => $this->input->get('aplicacion'),
        'fecha_inicio' => $this->input->get('fecha_inicio'),
        'observacion' => $this->input->get('observacion'),
        'dosis' => $this->input->get('dosis')
      );

      $condicion = array(
        'prescripcion_id' => $this->input->get('prescripcion_id')
      );

      $sql = $this->config_mdl->_update_data('prescripcion', $datos, $condicion);
      print json_encode($sql);
    }
    public function AjaxPrescripciones(){
      $estado = $_GET['estado'];
      $sql['Prescripcion'] = $this->config_mdl->_query("SELECT prescripcion_id, catalogo_medicamentos.medicamento_id,
                                                        concat(medicamento, ' ', gramaje)medicamento,categoria_farmacologica,
                                                        dosis,fecha_prescripcion,via_administracion,observacion,
                                                        frecuencia,aplicacion,fecha_inicio,tiempo,periodo,fecha_fin,estado
                                                        FROM prescripcion INNER JOIN catalogo_medicamentos ON
                                                        prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                                        INNER JOIN os_triage ON prescripcion.triage_id = os_triage.triage_id
                                                        WHERE os_triage.triage_id =".$_GET['folio']." AND estado =".$estado);

      print json_encode($sql['Prescripcion']);
    }
    public function AjaxBitacoraPrescripciones(){
      $sql = $this->config_mdl->_query("SELECT prescripcion.prescripcion_id,fecha_prescripcion, CONCAT(medicamento, ' ', gramaje)medicamento
                                        FROM prescripcion
                                        INNER JOIN catalogo_medicamentos ON
                                        prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                        INNER JOIN os_triage ON
                                        prescripcion.triage_id = os_triage.triage_id
                                        INNER JOIN btcr_prescripcion ON
                                        prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                        WHERE os_triage.triage_id =".$_GET['folio']." GROUP BY prescripcion_id");
      print json_encode($sql);
    }
    // Obtenemos un numero que determina si el medicamento es de safe, infectologia
    // o una solucion.
    public function AjaxTipoMedicamento(){
      $sql = $this->config_mdl->_query("SELECT safe,categoria_farmacologica FROM catalogo_medicamentos
                                        WHERE medicamento_id = ".$_GET['medicamento_id']);
      print json_encode($sql);
    }
    public function AjaxBitacoraHistorialMedicamentos(){
      $sql = $this->config_mdl->_query("SELECT fecha_prescripcion,
                                        via_administracion, dosis,
                                        frecuencia, aplicacion, fecha_inicio,
                                        fecha_fin, observacion, fecha,
                                        tipo_accion, motivo FROM prescripcion
                                        INNER JOIN catalogo_medicamentos ON
                                        prescripcion.medicamento_id = catalogo_medicamentos.medicamento_id
                                        INNER JOIN os_triage ON
                                        prescripcion.triage_id = os_triage.triage_id
                                        INNER JOIN btcr_prescripcion ON
                                        prescripcion.prescripcion_id = btcr_prescripcion.prescripcion_id
                                        WHERE os_triage.triage_id =".$_GET['folio']."
                                        AND prescripcion.prescripcion_id=".$_GET['prescripcion_id']."
                                        ORDER BY medicamento");
      print json_encode($sql);
    }


    /*Funcion para insertar el estado del paciente en la nota medica o editarla*/
    public function AjaxNotas() {
      $id_nota = '';
      foreach ($this->input->post('nota_interconsulta') as $interconsulta_select) {
              $interconsulta.=$interconsulta_select.',';
      }
      if($this->input->post('residente')=='Si'){
        $matricula = $this->input->post('medicoMatricula');
        $sql['empleadoID'] = $this->config_mdl->_query("SELECT empleado_id
                                                        FROM os_empleados
                                                        WHERE empleado_matricula = '$matricula'");
        $empleado_id =   $sql['empleadoID'][0]['empleado_id'];
      }else{
        $empleado_id = $this->UMAE_USER;
      }

        $dataNotas=array(
            'notas_fecha'=> date('d-m-Y'), //date('Y-m-d')
            'notas_hora'=> date('H:i'),
            'notas_tipo'=> $this->input->post('notas_tipo'),
            'notas_area'=> $this->UMAE_AREA,
            'empleado_id'=>$empleado_id,
            'notas_medicotratante'=> $this->input->post('notas_medicotratante'),
            'triage_id'=> $this->input->post('triage_id')
        );

        // Se toman los valores del formulario 'Instrucciones de nutricion'
        $nota_nutricion = "";
        $radio_nutricion = $this->input->post('dieta');
        $select_nutricion = $this->input->post('tipoDieta');
        $otros_nutricion = $this->input->post('otraDieta');
        /* las siguiendes condiciones son para indexar el campo 'nota_nutricion'
          de esta forma se conoce el origen del dato.*/

        //Indica que el valor viene de una caja de texto
        if($otros_nutricion != "" & $select_nutricion == 13){
          $nota_nutricion = $otros_nutricion;
        // Indica que el valor viene de un select
        }else if($select_nutricion >= 1 || $select_nutricion <=12 ){
          $nota_nutricion = $select_nutricion;
        // Indica que el valor viene de un radio
        }else if($radio_nutricion == 0){
          $nota_nutricion = $radio_nutricion;
        }


        $select_signos = $this->input->post("tomaSignos");
        $otros_signos = $this->input->post("otrasIndicacionesSignos");
        $nota_svycuidados = $select_signos;
        if($select_signos == "3"){
          $nota_svycuidados = $otros_signos;
        }

        $nota_cgenfermeria = 1;
        if($this->input->post("nota_cgenfermeria") != 1){
          $nota_cgenfermeria = 0;
        }


        if($this->input->post('accion')=='add'){

          $this->config_mdl->_insert('doc_notas',$dataNotas);
          $id_nota = $this->config_mdl->_get_last_id('doc_notas','notas_id');
          for($i = 0; $i < count($this->input->post('nombre_residente')); $i++){
            $datosResidente = array(
              'notas_id' => $this->config_mdl->_get_last_id('doc_notas','notas_id'),
              'nombre_residente' => $this->input->post("nombre_residente[$i]"),
              'apellido_residente' => $this->input->post("apellido_residente[$i]"),
              'cedulap_residente' => $this->input->post("cedula_residente[$i]")
            );

            if(count($datosResidente) > 0){
                $this->config_mdl->_insert('um_notas_residentes',$datosResidente);
            }
          }

          $accion_diagnosticos = $this->input->post('accion_diagnostico_principal');

          $consulta = "SELECT cie10_id FROM paciente_diagnosticos
                       WHERE triage_id = ".$this->input->post('triage_id')." AND tipo_diagnostico = 1";
          $sqlResult = $this->config_mdl->_query($consulta);

          if($accion_diagnosticos == "add"){
            if(COUNT($sqlResult) == 0){
                $data = array(
                    'triage_id' => $this->input->post('triage_id'),
                    'cie10_id' => $this->input->post('cie10_id_principal'),
                    'tipo_diagnostico' => 1
                );
                $this->config_mdl->_insert('paciente_diagnosticos',$data);
            }
          }
          else if ($accion_diagnosticos == "edit"){
              $dataInsert = array(
                'triage_id' => $this->input->post('triage_id'),
                'cie10_id' => $sqlResult[0]['cie10_id'],
                'tipo_diagnostico' => 2
              );
              $this->config_mdl->_insert('paciente_diagnosticos',$dataInsert);

              $this->config_mdl->_update_data('paciente_diagnosticos',
              array('cie10_id' => $this->input->post('cie10_id_principal')),
              array('triage_id' => $this->input->post('triage_id'), 'tipo_diagnostico' => 1)
              );

          }



          for($x = 0; $x < count($this->input->post('cie10_id')); $x++){
            $datos_diagnostico = array(
              'triage_id' => $this->input->post('triage_id'),
              'cie10_id' => $this->input->post("cie10_id[$x]"),
              'tipo_diagnostico' => $this->input->post("tipo_diagnostico[$x]")
            );
            $this->config_mdl->_insert('paciente_diagnosticos',$datos_diagnostico);

          }


          //Consultar los diagnosticos y registrarlos en la nota para generar el historial

          $consulta = "SELECT diagnostico_id, tipo_diagnostico, cie10_id
                       FROM paciente_diagnosticos
                       WHERE triage_id = ".$this->input->post('triage_id');
          $sqlResult = $this->config_mdl->_query($consulta);

          for($x = 0; $x < COUNT($sqlResult); $x++){
            $this->config_mdl->_insert('diagnostico_notas',array(
              'notas_id' => $this->config_mdl->_get_last_id('doc_notas','notas_id'),
              'diagnostico_id' => $sqlResult[$x]['diagnostico_id'],
              'tipo_diagnostico' => $sqlResult[$x]['tipo_diagnostico'],
              'cie10_id' => $sqlResult[$x]['cie10_id']));
          }


          for($x = 0; $x < count($this->input->post('nota_interconsulta')); $x++){
            $existencia_interconsuta = $this->config_mdl->_query(
             "SELECT doc_id
              FROM doc_430200
              WHERE doc_servicio_solicitado = ".$this->input->post("nota_interconsulta[$x]")
            );

            $this->config_mdl->_update_data('os_consultorios_especialidad',array(
                'ce_status'=>'Interconsulta',
                'ce_interconsulta'=>'Si'
            ),array(
                'triage_id'=>  $this->input->post('triage_id')
            ));

              $datos_interconsulta = array(
                'doc_estatus' => 'En Espera',
                'doc_fecha'=> date('Y-m-d'),
                'doc_hora' => date('H:i'),
                'doc_area' => $this->UMAE_AREA,
                'doc_servicio_envia'=> Modules::run('Consultorios/ObtenerEspecialidadID',array('Consultorio'=>$this->UMAE_AREA)),
                'doc_servicio_solicitado' => $this->input->post("nota_interconsulta[$x]"),
                'triage_id' => $this->input->post('triage_id'),
                'doc_modulo' => "Consultorios",
                'motivo_interconsulta' => $this->input->post('motivo_interconsulta'),
                'empleado_envia'=> $this->UMAE_USER
              );
              $this->config_mdl->_insert('doc_430200',$datos_interconsulta);

          }

          /*
          Se consultan las interconsultas realizadas en el momento en que se genero
          la nota medica
          */
          $Interconsultas = $this->config_mdl->_query("SELECT doc_id FROM doc_430200
                                                      WHERE triage_id = ".$this->input->post('triage_id'));
          for($x = 0; $x < count($Interconsultas); $x++){
            $datos = array(
              'notas_id' => $this->config_mdl->_get_last_id('doc_notas','notas_id'),
              'doc_id' => $Interconsultas[$x]['doc_id']
            );
            $this->config_mdl->_insert('interconsulta_notas',$datos);
          }
          /*
          Se consultan los diagnosticos del paciente registrados
          para ser asignados en la nota evolucion
          */
          $diagnostico = $this->config_mdl->_query("SELECT diagnostico_id
                                                    FROM paciente_diagnosticos
                                                    WHERE triage_id =".$this->input->post('triage_id'));

          for($x = 0; $x < count($diagnostico); $x++){
            $datos = array(
              'notas_id' => $this->config_mdl->_get_last_id('doc_notas','notas_id'),
              'diagnostico_id' => $diagnostico[$x]['diagnostico_id']
            );
            $this->config_mdl->_insert('diagnostico_notas',$datos);
          }



            $sqlMax= $this->config_mdl->_get_last_id('doc_notas','notas_id');
            $this->config_mdl->_insert('doc_nota',array(
                //'nota_motivoInterconsulta' => $this->input->post('nota_motivoInterconsulta'),
                'nota_interrogatorio'=> $this->input->post('nota_interrogatorio'),
                'nota_exploracionf'=> $this->input->post('nota_exploracionf'),
                'nota_escala_glasgow'=> $this->input->post('hf_escala_glasgow'),
                'hf_riesgo_caida'=> $this->input->post('hf_riesgo_caida'),
                'nota_eva'=> $this->input->post('nota_eva'),
                'nota_riesgotrombosis'=> $this->input->post('nota_riesgotrombosis'),
                'nota_auxiliaresd'=> $this->input->post('nota_auxiliaresd'),
                'nota_procedimientos'=> $this->input->post('nota_procedimientos'),
                'nota_diagnostico'=> $this->input->post('nota_diagnostico'),
                'nota_pronosticos'=> $this->input->post('nota_pronosticos'),
                'nota_estadosalud'=> $this->input->post('nota_estadosalud'),
                'nota_nutricion'=> $nota_nutricion,
                'nota_svycuidados'=> $nota_svycuidados,
                'nota_cgenfermeria' => $nota_cgenfermeria,
                'nota_cuidadosenfermeria'=> $this->input->post('nota_cuidadosenfermeria'),
                'nota_solucionesp'=> $this->input->post('nota_solucionesp'),
                'nota_medicamentos'=> $this->input->post('nota_medicamentos'),
                'nota_problema' => $this->input->post('nota_problema'),
                'nota_analisis' => $this->input->post('nota_analisis'),
                'nota_interconsulta'=> trim($interconsulta, ','),
                'nota_solicitud_laboratorio' => $this->input->post('nota_solicitud_laboratorio'),
                'notas_id'=>$sqlMax
            ));
            // Numero de prescripciones ingresadas, almacena en arreglo y registra en la
            // tabla "prescripcio"
            for($x = 0; $x < count($this->input->post('idMedicamento')); $x++){
              $datosPrescripcion = array(
                'empleado_id' => $this->UMAE_USER,
                'triage_id' => $this->input->post('triage_id'),
                'medicamento_id' => $this->input->post("idMedicamento[$x]"),
                'dosis' => $this->input->post("dosis[$x]"),
                'fecha_prescripcion' => date('d-m-Y')." ".date('H:i'),
                'via_administracion' => $this->input->post("via_administracion[$x]"),
                'frecuencia' => $this->input->post("frecuencia[$x]"),
                'aplicacion' => $this->input->post("horaAplicacion[$x]"),
                'fecha_inicio' => $this->input->post("fechaInicio[$x]"),
                'tiempo' => $this->input->post("duracion[$x]"),
                'periodo' => $this->input->post("periodo[$x]"),
                'fecha_fin' => $this->input->post("fechaFin[$x]"),
                'observacion' => $this->input->post("observacion[$x]"),
                'estado' => "1"
              );
              $this->config_mdl->_insert('prescripcion',$datosPrescripcion);
            }
            // Se toma el ID de las precripcines activas
            $Prescripciones = $this->config_mdl->_query("SELECT prescripcion_id
                                                         FROM prescripcion
                                                         WHERE estado = 1 and triage_id = ".$this->input->post('triage_id').";");
            for($x = 0; $x < count($Prescripciones); $x++){
              $NotaPrescripcion = array(
                'notas_id' => $this->config_mdl->_get_last_id('doc_notas','notas_id'),
                'prescripcion_id' => $Prescripciones[$x]['prescripcion_id']
              );
              // Se registra la relacion entre notas y prescripcion
              $this->config_mdl->_insert('nm_notas_prescripcion', $NotaPrescripcion);
            }
            $MaxNota=$sqlMax;
            $dataSV=array(
                'sv_tipo'=> $this->input->post('inputVia'),
                'sv_fecha'=> date('Y-m-d'),
                'sv_hora'=>date('H:i:s'),
                'sv_ta'=> $this->input->post('sv_ta'),
                'sv_temp'=> $this->input->post('sv_temp'),
                'sv_fc'=> $this->input->post('sv_fc'),
                'sv_fr'=> $this->input->post('sv_fr'),
                'sv_oximetria'=> $this->input->post('sv_oximetria'),
                'sv_dextrostix'=> $this->input->post('sv_dextrostix'),
                'sv_peso'=> $this->input->post('sv_peso'),
                'sv_talla'=> $this->input->post('sv_talla'),
                'triage_id'=> $this->input->post('triage_id'),
                'empleado_id'=> $this->UMAE_USER,
                'nota_id' => $this->config_mdl->_get_last_id('doc_notas','notas_id')
            );
            $this->config_mdl->_insert('os_triage_signosvitales',$dataSV);
        }else{

            $this->config_mdl->_update_data('doc_notas',array(
                'notas_medicotratante'=> $this->input->post('notas_medicotratante'),
            ),array(
                'notas_id'=> $this->input->post('notas_id')
            ));
            $id_nota = $this->input->post('notas_id');
            $this->config_mdl->_update_data('doc_nota',array(
                'nota_motivoInterconsulta' => $this->input->post('nota_motivoInterconsulta'),
                'nota_interrogatorio'=> $this->input->post('nota_interrogatorio'),
                'nota_exploracionf'=> $this->input->post('nota_exploracionf'),
                'nota_escala_glasgow'=> $this->input->post('hf_escala_glasgow'),
                'hf_riesgo_caida'=> $this->input->post('hf_riesgo_caida'),
                'nota_eva'=> $this->input->post('nota_eva'),
                'nota_riesgotrombosis'=> $this->input->post('nota_riesgotrombosis'),
                'nota_auxiliaresd'=> $this->input->post('nota_auxiliaresd'),
                'nota_procedimientos'=> $this->input->post('nota_procedimientos'),
                'nota_diagnostico'=> $this->input->post('nota_diagnostico'),
                'nota_pronosticos'=> $this->input->post('nota_pronosticos'),
                'nota_estadosalud'=> $this->input->post('nota_estadosalud'),
                'nota_nutricion'=> $nota_nutricion,
                'nota_svycuidados'=> $nota_svycuidados,
                'nota_cgenfermeria' => $nota_cgenfermeria,
                'nota_cuidadosenfermeria'=> $this->input->post('nota_cuidadosenfermeria'),
                'nota_solucionesp'=> $this->input->post('nota_solucionesp'),
                'nota_medicamentos'=> $this->input->post('nota_medicamentos'),
                'nota_problema' => $this->input->post('nota_problema'),
                'nota_analisis' => $this->input->post('nota_analisis'),
                'nota_interconsulta'=> $this->input->post('nota_interconsulta'),
                'nota_interconsulta'=> trim($interconsulta, ',')
            ),array(
                'notas_id'=> $this->input->post('notas_id')
            ));
            $MaxNota=$this->input->post('notas_id');
        }
        if($this->input->post('via')=='Interconsulta'){
            $this->config_mdl->_update_data('doc_430200',array(
                'doc_estatus'=>'Evaluado',
                'doc_fecha_r'=> date('Y-m-d'),
                'doc_hora_r'=> date('H:i:s'),
                'doc_nota_id'=>$MaxNota,
                'empleado_recive'=> $this->UMAE_USER
            ),array(
                'doc_id'=> $this->input->post('doc_id')
            ));
        }
        $sqlCheck= $this->config_mdl->sqlGetDataCondition('os_triage_signosvitales',array(
            'triage_id'=>$this->input->post('triage_id'),
            'sv_tipo'=> $this->input->post('inputVia')
        ),'sv_id');



        $this->setOutput(array('accion'=>'1','notas_id'=>$id_nota));
    }
    public function TarjetaDeIdentificacion($Paciente) {
        $sql['info']= $this->config_mdl->sqlGetDataCondition('os_tarjeta_identificacion',array(
            'triage_id'=>$Paciente
        ))[0];
        $this->load->view('Documentos/Doc_TarjetaIdentificacion',$sql);
    }



    public function AjaxConsultarDiagnosticos(){
      $folio = $this->input->get('folio');
      $consulta = "SELECT *
                   FROM paciente_diagnosticos
                   INNER JOIN um_cie10
                  	 ON paciente_diagnosticos.cie10_id = um_cie10.cie10_id
                   WHERE triage_id =".$folio." ORDER BY tipo_diagnostico";
      $sql = $this->config_mdl->_query($consulta);
      print json_encode($sql);
    }

    public function AjaxTarjetaDeIdentificacion() {
        $check= $this->config_mdl->sqlGetDataCondition('os_tarjeta_identificacion',array(
            'triage_id'=> $this->input->post('triage_id')
        ),'ti_id');
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
            $this->config_mdl->_update_data('os_tarjeta_identificacion',$data,array(
                'triage_id'=> $this->input->post('triage_id')
            ));
        }
        $this->setOutput(array('accion'=>'1'));
    }
    /*Obtener Diagnosticos*/
    public function AjaxObtenerDiagnosticosKey() {

    }
    public function AjaxGuardarDiagnosticos() {
        $sqlDiagnostico= $this->config_mdl->sqlGetDataCondition('um_cie10',array(
            'cie10_nombre'=> $this->input->post('cie10_nombre')
        ));
        $data=array(
            'cie10hf_fecha'=> date('Y-m-d H:i:s'),
            'cie10hf_tipo'=> $this->input->post('cie10hf_tipo'),
            'cie10hf_estado'=> $this->input->post('cie10hf_estado'),
            'cie10hf_obs'=> $this->input->post('cie10hf_obs'),
            'triage_id'=> $this->input->post('triage_id'),
            'cie10_id'=> $sqlDiagnostico[0]['cie10_id']
        );
        if($this->input->post('accion')=='add'){
            $this->config_mdl->_insert('um_cie10_hojafrontal',$data);
        }else{
            unset($data['cie10hf_fecha']);
            $this->config_mdl->_update_data('um_cie10_hojafrontal',$data,array(
                'cie10hf_id'=> $this->input->post('cie10hf_id')
            ));
        }
        $this->setOutput(array('accion'=>'1','post'=> $this->input->post()));
    }
    public function AjaxObtenerDiagnosticos() {
        $sql= $this->config_mdl->_query("SELECT * FROM um_cie10_hojafrontal, um_cie10 WHERE
                    um_cie10_hojafrontal.cie10_id=um_cie10.cie10_id AND
                    um_cie10_hojafrontal.triage_id=".$this->input->post('triage_id')." ORDER BY cie10hf_tipo='Primario' DESC");
        foreach ($sql as $value) {
            $row.='<div class="col-md-12" style="margin-top: -10px;">
                    <div class="alert alert-info alert-dismissable fade in">
                        <div class="row" style="margin-right: -36px;    margin-top: -10px;margin-bottom: -9px;">
                            <div class="col-md-9 text-mayus">
                                <strong>Diagnostico:</strong> '.$value['cie10_nombre'].'<br>
                                <h6 style="font-size:9px"><strong>Observaciones:</strong> '.($value['cie10hf_obs']!='' ? $value['cie10hf_obs'] : 'Sin Observaciones').'</h6>
                            </div>
                            <div class="col-md-2 text-mayus">
                                <h6 style="font-size:9px"><strong>'.$value['cie10hf_tipo'].'</strong></h6>
                                <h6 style="font-size:12px;margin-top: -6px;"><strong>'.($value['cie10hf_estado']=='Presuntivo' ? '<span class="label green">Presuntivo</span>' : '<span class="label amber">Definitivo</span>').'</strong></h6>
                            </div>
                            <div class="col-md-1">
                                <i class="fa fa-pencil icono-accion pointer editar-diagnostico-cie10" data-id="'.$value['cie10hf_id'].'" data-obs="'.$value['cie10hf_obs'].'" data-nombre="'.$value['cie10_nombre'].'"></i>&nbsp;
                                <i class="fa fa-trash-o icono-accion pointer tip eliminar-diagnostico-cie10" data-id="'.$value['cie10hf_id'].'"></i>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        $this->setOutputV2(array('row'=>$row));
    }
    public function AjaxEliminarDiagnostico() {
        $this->config_mdl->_delete_data('um_cie10_hojafrontal',array(
            'cie10hf_id'=> $this->input->post('cie10hf_id')
        ));
        $this->setOutput(array('accion'=>'1'));
    }
    public function AjaxCIE10() {
        $cie10_nombre= $this->input->post('cie10_nombre');
        $sql= $this->config_mdl->_query("SELECT * FROM um_cie10 WHERE cie10_nombre LIKE '%$cie10_nombre%' LIMIT 50");
        foreach ($sql as $value) {
            $um_cie10.='<li>'.$value['cie10_nombre'].'</li>';
        }
        $this->setOutput(array('um_cie10'=>$um_cie10));
    }
    public function AjaxCheckCIE10() {
        $sql= $this->config_mdl->sqlGetDataCondition('um_cie10',array(
            'cie10_nombre'=> $this->input->post('cie10_nombre')
        ));
        if(!empty($sql)){
            $this->setOutput(array('accion'=>'1'));
        }else{
            $this->setOutput(array('accion'=>'2'));
        }
    }
    public function GuardarGlasgowHfAbierto()
    {
         //apertura ocular
         $hf_abierto_glasgow_s1=$this->input->post('hf_glasgow_expontanea')+
                                $this->input->post('hf_glasgow_hablar')+
                                $this->input->post('hf_glasgow_dolor')+
                                $this->input->post('hf_glasgow_ausente');
        //Respuesta motora
         $hf_abierto_glasgow_s2=$this->input->post('hf_glasgow_obedece')+
                                $this->input->post('hf_glasgow_localiza')+
                                $this->input->post('hf_glasgow_retira')+
                                $this->input->post('hf_glasgow_flexion')+
                                $this->input->post('hf_glasgow_extension')+
                                $this->input->post('hf_glasgow_ausencia');
        // Respuesta verbal
         $hf_abierto_glasgow_s3=$this->input->post('hf_glasgow_orientado')+
                                $this->input->post('hf_glasgow_confuso')+
                                $this->input->post('hf_glasgow_incoherente')+
                                $this->input->post('hf_glasgow_sonidos')+
                                $this->input->post('hf_glasgow_arespuesta');

        $total_glasgow=$hf_abierto_glasgow_s1+$hf_abierto_glasgow_s2+$hf_abierto_glasgow_s3;
        $data_totalGlasgow=array(
            'triage_puntaje_total'=>$total_glasgow
            );

        $this->config_mdl->_insert('os_consultorios_especialidad_hf',$data_totalGlasgow);
    }
    public function GuardarRiesgoTrobosisHfAbierto() {

         //Edad

    }

    public function ObtenerMedicamentos(){
       $sql['medicamentos'] = $this ->config_mdl-> _get_data('catalogo_medicamentos');
       return json_encode($sql);
    }
}
