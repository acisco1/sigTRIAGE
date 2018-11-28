<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asistentesmedicas
 *
 * @author Gerardo Santillan
 */
include_once APPPATH.'modules/config/controllers/Config.php';

class Farmacovigilancia extends Config{

  public function __construct()
  {
    parent::__construct();
  }

  public function index(){
    $sql['Activas'] = $this->PacientePrescripcion('estado','2'); //activas
    $sql['Pendientes'] = $this->PacientePrescripcion('estado','1');//pendientes
    $sql['Canceladas'] = $this->PacientePrescripcion('estado','0');//canceladas
    $sql['PacientePrescripcionPendiente'] = $this->PacientePrescripcion();
    $this->load->view('index',$sql);
  }

  public function AjaxPrescripcionesPaciente(){
    $folio = $_GET['folio'];
    $consulta = "SELECT prescripcion_id, medicamento, prescripcion.via AS pr_via, frecuencia, dosis FROM prescripcion
                 INNER JOIN os_triage
                  ON os_triage.triage_id = prescripcion.triage_id
                 INNER JOIN catalogo_medicamentos
                  ON catalogo_medicamentos.medicamento_id = prescripcion.medicamento_id
                 WHERE os_triage.triage_id = $folio";
    $sql = $this->config_mdl->_query($consulta);
    print json_encode($sql);
  }

  public function PacientePrescripcion($filtro, $dato){

    $condicion = "";
    $val1 = $filtro;
    $val2 = $dato;
    echo "CONDICION $val1 DATO: $val2";
    if($vall == '0' || $vall == '1' || $vall == '2' ){
      $condicion = "WHERE $val1 = $val2";
    }


    /*
    else if($filtro == 'triage_nombre'){
      $condicion = "$condicion $filtro LIKE '%$dato%' "; // Nombre paciente
    }else if($filtro == 'medicamento'){
      $condicion = "$condicion $filtro LIKE '%$dato%' "; // Medicamento
    }else if($filtro == 'cama_nombre'){
      $condicion = "$condicion $filtro LIKE '%$dato%' "; // Cama paciente
    }else if($filtro == 'empleado_nombre'){
      $condicion = "$condicion $filtro LIKE '%$dato%' "; // Médico
    }else if($filtro == 'area_nombre'){
      $condicion = "$condicion $filtro LIKE '%$dato%' "; // Area
    }
    */
    $consulta = "SELECT os_triage.triage_id, area_nombre, triage_nombre, triage_nombre_ap,
                 medicamento , cama_nombre, empleado_nombre,
                 empleado_apellidos,estado
                 FROM prescripcion
                 INNER JOIN os_triage
                 	ON os_triage.triage_id = prescripcion.triage_id
                 INNER JOIN catalogo_medicamentos
                 	ON catalogo_medicamentos.medicamento_id = prescripcion.medicamento_id
                 INNER JOIN os_camas
                 	ON os_camas.triage_id = os_triage.triage_id
                 INNER JOIN os_areas
                 	ON os_areas.area_id = os_camas.area_id
                 INNER JOIN um_medico_tratante
                 	ON um_medico_tratante.triage_id = os_triage.triage_id
                 INNER JOIN os_empleados
                 	ON os_empleados.empleado_id = um_medico_tratante.empleado_id
                 $condicion";

    $sql = $this->config_mdl->_query($consulta);

    return $sql;
  }
  public function AjaxPacientePrescripcion(){

    $val = $this->PacientePrescripcion($_GET['filtro'],$_GET['estado']);
    print json_encode($val);
  }

  public function AsignarColorEstadoPrescripcion($estado){

    switch ($estado) {
      case '0':
        return 'rgb(242, 222, 222)';
      case '1':
        return 'rgb(252, 248, 227)';
      case '2':
        return 'rgb(223, 240, 216)';

    }

  }



}
