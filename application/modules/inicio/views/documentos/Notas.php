<?php ob_start();
$margenBajo = "50mm";
if(count($Residentes) == 3){
  $margenBajo = "78mm";
}else if(count($Residentes) == 2){
  $margenBajo = "71mm";
}else if(count($Residentes) == 1){
  $margenBajo = "60mm";
}?>
<page backtop="80mm" backbottom="<?=$margenBajo ?>" backleft="49" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/DOC430128.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">
        <div style="position: absolute;margin-top: 15px">
           <div style="position: absolute;margin-left: 435px;margin-top: 50px;width: 270px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>NOMBRE DEL PACIENTE:</b>
            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 62px;width: 270px;text-transform: uppercase;font-size: 14px;">
                <?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?>
            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 77px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <b>N.S.S:</b> <?=$PINFO['pum_nss']?> <?=$PINFO['pum_nss_agregado']?>
            </div>
            <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac'])); ?>
            <div style="position: absolute;margin-left: 435px;margin-top: 92px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <b>EDAD:</b> <?=$fecha->y==0 ? $fecha->m.' MESES' : $fecha->y.' AÑOS'?>
            </div>
            <div style="position: absolute;margin-left: 550px;margin-top: 92px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <b>GENERO:</b> <?=$info['triage_paciente_sexo']?>
            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 107px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <b>UMF:</b> <?=$PINFO['pum_umf']?>/<?=$PINFO['pum_delegacion']?>
            </div>
            <div style="position: absolute;margin-left: 550px;margin-top: 107px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <b>PROCEDENCIA:</b> <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEO' : 'REFERENCIADO'?>
            </div>
            <div style="position: absolute;margin-left: 550px;margin-top: 122px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <b>ATENCIÓN:</b> <?=$PINFO['pia_tipo_atencion']?>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 154px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -10px">
                   <b>DOMICILIO: </b> <?=$DirPaciente['directorio_cn']?>, <?=$DirPaciente['directorio_colonia']?>, <?=$DirPaciente['directorio_cp']?>, <?=$DirPaciente['directorio_municipio']?>, <?=$DirPaciente['directorio_estado']?> <B>TEL:</B><?=$DirPaciente['directorio_telefono']?>
                </p>
            </div>

            <div style="position: absolute;margin-left: 437px;margin-top: 185px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -1px">
                    <b>FOLIO:</b> <?=$info['triage_id']?>
                </p>
                <p style="margin-top: -10px">
                    <b>HORA CERO:</b> <?=$info['triage_horacero_f']?> <?=$info['triage_horacero_h']?>
                </p>
                <p style="margin-top: -7px">
                    <b>MÉD.:</b> <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?>
                </p>
                <p style="margin-top: -9px">
                    <b>AM:</b> <?=$AsistenteMedica['empleado_nombre']?> <?=$AsistenteMedica['empleado_apellidos']?>
                </p>
                <p style="margin-top: -11px">
                    <b>HORA A.M:</b> <?=$am['asistentesmedicas_fecha']?> <?=$am['asistentesmedicas_hora']?>
                </p>
            </div>

            <div style="position: absolute;margin-top:229px;margin-left: 134px ">
                <?php
                $sqlChoque=$this->config_mdl->sqlGetDataCondition('os_choque_v2',array(
                    'triage_id'=>$info['triage_id']
                ),'cama_id');
                $sqlObs=$this->config_mdl->sqlGetDataCondition('os_observacion',array(
                    'triage_id'=>$info['triage_id']
                ),'observacion_cama');
                if(empty($sqlChoque)){
                    echo $this->config_mdl->sqlGetDataCondition('os_camas',array(
                        'cama_id'=>$sqlObs[0]['observacion_cama']
                    ),'cama_nombre')[0]['cama_nombre'];
                }else{
                    echo $this->config_mdl->sqlGetDataCondition('os_camas',array(
                        'cama_id'=>$sqlChoque[0]['cama_id']
                    ),'cama_nombre')[0]['cama_nombre'];
                }
                ?>
            </div>
            <div style="position: absolute;margin-top:238px;margin-left: 302px ">[[page_cu]]/[[page_nb]]</div>
            <div style="position: absolute;margin-left: 40px;margin-top: 290px;width: 270px;text-transform: uppercase;font-size: 12px;">
                <?=$Nota['notas_fecha']?> <?=$Nota['notas_hora']?><br>
            </div>
            <div style="position: absolute;margin-left: 15px;margin-top: 320px;width: 130px;font-size: 12px;text-align: center">
                <h5>PANI</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_ta']?> mm Hg</p>
                <h5>Temperatura</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_temp']?> °C</p>
                <h5>Frecuencia Cardíaca</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_fc']?> lpm</p>
                <h5>Frecuencia Respiratoria</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_fr']?> rpm</p>
                <h5>Peso:</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_peso']?> Kg</p>
                <h5>Talla:</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_talla']?> cm</p>
                <h5>Oximetria</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_oximetria']?> % Sp0<sub>2</sub></p>
                <h5>Glucosa</h5><p style="margin-top: -15px"><?=$SignosVitales['sv_dextrostix']?> mg/dl</p>
                <h5>EVA</h5><p style="margin-top: -15px"><?=$Nota['nota_eva']?></p>
                <h5>Riesgo de Caida</h5><p style="margin-top: -15px"><?=$Nota['hf_riesgo_caida']?></p>
                <h5>Riesgo de Trombosis</h5><p style="margin-top: -15px"><?=$Nota['nota_riesgotrombosis']?></p>
            </div>
            <div style="rotate: 90; position: absolute;margin-left: 50px;margin-top: 336px;text-transform: uppercase;font-size: 12px;">
                <?php $sqlEmpleadoSV=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                    'empleado_id'=>$SignosVitales['empleado_id']
                ),'empleado_nombre,empleado_apellidos')[0];?>
                <?php $sqlEmpleadoSV['empleado_nombre']?> <?php $sqlEmpleadoSV['empleado_apellidos']?> <?php $SignosVitales['sv_fecha']?> <?php $SignosVitales['sv_hora']?><br><br><br>
            </div>
            <?php
            $sqlMedico=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                'empleado_id'=>$Nota['notas_medicotratante']
            ))[0];
            if(count($MedicoBase) > 0){
              $NombreMedico=$MedicoBase['empleado_nombre'].' '.$MedicoBase['empleado_apellidos'];
              $MatriculaMedico=$MedicoBase['empleado_matricula'];
            }else{
              if(empty($sqlMedico)){
                  $NombreMedico=$Medico['empleado_nombre'].' '.$Medico['empleado_apellidos'];
                  $MatriculaMedico=$Medico['empleado_matricula'];
              }else{
                  $NombreMedico=$sqlMedico['empleado_nombre'].' '.$sqlMedico['empleado_apellidos'];
                  $MatriculaMedico=$sqlMedico['empleado_matricula'];
              }
            }

            ?>
            <?php
            if(count($Residentes) > 0){ ?>
              <?php if(count($Residentes) == 3){
                $top = 783;
              }else if( count($Residentes) == 2){
                $top = 813;
              }else if( count($Residentes) == 1){
                $top = 853;
              }?>
            <div style="position: absolute;top: <?=$top?>px;left: 215px;width: 240px;font-size: 11px;text-align: center">
            <b>NOMBRE MÉDICO RESIDENTE</b><br><br>
            <?php foreach ($Residentes as $value){?>
                  <?=$value['nombre_residente']?> <?=$value['apellido_residente']?><br><br><br>
            <?php } ?>

            </div>
            <div style="position: absolute;top: <?=$top?>px;left: 480px;width: 110px;font-size: 11px;text-align: center">
            <b>CEDULA</b><br><br>

            <?php foreach ($Residentes as $value){?>
                  <?=$value['cedulap_residente']?><br><br><br>
            <?php } ?>

            </div>
            <div style="position: absolute;top: <?=$top?>px;left: 590px;width: 110px;font-size: 11px;text-align: center">
            <b>FIRMA</b><br><br>
            <?php for($i = 0; $i < count($Residentes); $i++){ ?>
              _________________<br><br><br>
            <?php }?>

            </div>
            <?php } ?>
            <div style="position: absolute;top: 895px;left: 215px;width: 493px;font-size: 5px;text-align: center" >
              <?php if(count($Residentes) > 0){ ?>
                <span style="margin-top: -6px;margin-bottom: -8px;" ><br><hr style="border-top: 0.3px solid #8c8b8b;"></span>
              <?php } ?>
            </div>
            <div style="position: absolute;top: 905px;left: 215px;width: 240px;font-size: 11px;text-align: center">
                <?=$NombreMedico?><br>
                <span style="margin-top: -6px;margin-bottom: -8px">____________________________________</span><br>
                <b>NOMBRE DEL MÉDICO TRATANTE</b>
            </div>
            <div style="position: absolute;top: 905px;left: 480px;width: 110px;font-size: 11px;text-align: center">
                <?=$MatriculaMedico?> <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_________________</span><br>
                <b>MATRICULA</b>
            </div>
            <div style="position: absolute;top: 905px;left: 590px;width: 110px;font-size: 11px;text-align: center">
                <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_________________</span><br>
                <b>FIRMA</b>
            </div>
            <div style="margin-left: 280px;margin-top: 980px">
                <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
            </div>
            <div style="position: absolute;top: 262px;;width: 500px;;left: 205px;font-size: 12px;text-transform: uppercase;text-align: center;font-weight: bold">
                <?=$Nota['notas_tipo']?> SERVICIO: <?=$ServicioM[0]['empleado_servicio'] ?>
            </div>
        </div>

    </page_header>

    <span style="text-align: justify">
        <?php if($_GET['indicaciones'] == 1){ ?>
            <h4>INDICACIONES Y ORDENES MEDICAS</h4>
        <?php }else{ ?> <!-- Informacion general de la nota evolucion -->
          <?php if($Nota['nota_problema']!=''){?>
              <h5 style="margin-bottom: -6px">PROBLEMA</h5>
              <?=$Nota['nota_problema']?>
          <?php }?>
          <?php if($Nota['nota_interrogatorio']!=''){?>
            <?php
            // Asigna nombre subjetivo y objetivo si es Nota evolucion
            // o interrogatorio y exploracion fisica si es interconsulta
            $subjetivo = 'SUBJETIVO';
            $objetivo = 'OBJETIVO';
            if($Nota['notas_tipo'] == 'NOTA DE INTERCONSULTA'){
              $subjetivo = 'INTERROGATORIO';
              $objetivo = 'EXPLORACION FISICA';
            } ?>

              <h5 style="margin-bottom: -6px"><?= $subjetivo ?></h5>
              <?= $Nota['nota_interrogatorio'] ?>
          <?php }?>
          <?php if($Nota['nota_exploracionf']!=''){?>
              <h5 style="margin-bottom: -6px"><?= $objetivo ?></h5>
              <?=$Nota['nota_exploracionf']?>
          <?php }?>
          <?php if($Nota['nota_analisis']!=''){?>
              <h5 style="margin-bottom: -6px">ANALISIS</h5>
              <?=$Nota['nota_analisis']?>
          <?php }?>
          <?php if($Nota['nota_escala_glasgow']!=''){?>
              <h5 style="margin-bottom: -6px">ESCALA DE GLASGOW: <?=$Nota['nota_escala_glasgow']?> </h5>
          <?php }?>
          <?php if($Nota['nota_auxiliaresd']!=''){?>
              <h5 style="margin-bottom: -6px">RESULTADOS DE SERVICIOS AUXILIARES DE DIAGNOSTICO</h5>
              <?=$Nota['nota_auxiliaresd']?>
          <?php }?>
          <?php if($Nota['nota_procedimientos']!=''){?>
              <h5 style="margin-bottom: -6px">PROCEDIMIENTOS REALIZADOS</h5>
              <?=$Nota['nota_procedimientos']?>
          <?php }?>
          <?php if($Nota['nota_diagnostico']!=''){?>
              <h5 style="margin-botton: -6px">ACTUALIZACIÓN DE DIAGNOSTICO(S) Y PROBLEMAS CLÍNICOS</h5>
              <?=$Nota['nota_diagnostico']?>
          <?php }?>
          <?php if($Nota['nota_pronosticos']!=''){?>
                 <h5 style="margin-botton: -6px">PRONOSTICOS</h5>
                 <?=$Nota['nota_pronosticos']?>
          <?php }?>
          <?php if($Nota['nota_estadosalud']!=''){ ?>
             <h5 style="margin-botton: -6px">ESTADO DE SALUD: <?=$Nota['nota_estadosalud']?> </h5>
          <?php } ?>
          <h5 style="margin-botton: -6px">ORDENES MEDICAS:</h5>
        <?php } ?>

        <?php if($Nota['nota_nutricion'] == '0') {
          $nutricion = 'Ayuno';
        }else if($Nota['nota_nutricion'] == '1'){
          $nutricion = 'IB - Normal';
        }else if($Nota['nota_nutricion'] == '2'){
          $nutricion = 'IIA - Blanda';
        }else if($Nota['nota_nutricion'] == '3'){
          $nutricion = 'IIB - Astringente';
        }else if($Nota['nota_nutricion'] == '4'){
          $nutricion = 'III - Diabetica';
        }else if($Nota['nota_nutricion'] == '5'){
          $nutricion = 'IV - Hiposodica';
        }else if($Nota['nota_nutricion'] == '6'){
          $nutricion = 'V - Hipograsa';
        }else if($Nota['nota_nutricion'] == '7'){
          $nutricion = 'VI - Liquida clara';
        }else if($Nota['nota_nutricion'] == '8'){
          $nutricion = 'VIA - Liquida general';
        }else if($Nota['nota_nutricion'] == '9'){
          $nutricion = 'VIB - Licuada por sonda';
        }else if($Nota['nota_nutricion'] == '10'){
          $nutricion = 'VIB - Licuada por sonda artesanal';
        }else if($Nota['nota_nutricion'] == '11'){
          $nutricion = 'VII - Papilla';
        }else if($Nota['nota_nutricion'] == '12'){
          $nutricion = 'VIII - Epecial';
        }else{
          $nutricion = $Nota['nota_nutricion'];
        }
        ?>
        NUTRICION: <?= $nutricion ?> <br><br>

        <?php if($Nota['nota_svycuidados'] == '1'){
          $toma_signos = 'Por turno';
        }else if($Nota['nota_svycuidados'] == '2'){
          $toma_signos = 'Cada 4 horas';
        }else{
          $toma_signos = $Nota['nota_svycuidados'];
        }
        ?>

        <?php if($goma_signos != 0){ ?>
          TOMA DE SIGNOS: <?= $toma_signos ?> <br><br>
        <?php } ?>

        <?php if($Nota['nota_cgenfermeria'] == '1'){ ?>
          CUIDADOS GENERALES:<br><br>
          <label style="margin-left:20px;" >a. Estado neurológico</label><br>
          <label style="margin-left:20px;" >b. Cama Con barandales</label><br>
          <label style="margin-left:20px;" >c. Calificación del dolor</label><br>
          <label style="margin-left:20px;" >d. Calificación de riesgo de caida</label><br>
          <label style="margin-left:20px;" >e. Control de liquidos por turno</label><br>
          <label style="margin-left:20px;" >f. Vigilar riesgo de ulceras por presión</label><br>
          <label style="margin-left:20px;" >g. Aseo bucal</label><br>
          <label style="margin-left:20px;" >h. Lavado de manos</label><br><br>
        <?php } ?>

        <?php if($Nota['nota_cuidadosenfermeria'] != ''){ ?>
        CUIDADOS ESPECIALES:<br> <?= $Nota['nota_cuidadosenfermeria'] ?><br><br>
        <?php } ?>

        <?php if($Nota['nota_solucionesp'] != ''){ ?>
        SOLUCIONES PARENTERALES:<br> <?= $Nota['nota_solucionesp'] ?><br>
        <?php } ?>

        <h5 style="margin-bottom: -6px">PRESCRIPCIONES:</h5><br>
        <?php if(count($Prescripcion) > 0){?>
        <style media="screen">
          
          th{
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
            padding-left: 3px;
            padding-right: 3px;
           }
        </style>
        <table style="font-size:10;">
          <tr>
            <th style="text-align:left;">Medicamento</th>
            <th>Dosis</th>
            <th>Via</th>
            <th>Frecuencia</th>
            <th>Aplicacion</th>
            <th>Fecha inicio</th>
            <th>Tiempo transcurrido</th>
          </tr>
        <?php
         for($x = 0; $x < count($Prescripcion); $x++){
          $new_format_fecha_prescripcion = str_replace('/','-',$Prescripcion[$x]['fecha_inicio']);
          $new_fecha_prescripcion = date('Y-m-d',strtotime($new_format_fecha_prescripcion));

          $calcular_tiempo = Modules::run('Config/CalcularTiempoTranscurrido',
          array('Tiempo1' => $new_fecha_prescripcion,
                'Tiempo2' => $Nota['notas_fecha']));

          $tiempo = $calcular_tiempo->format('%R%a');
          if($tiempo < 0 ){
            $tiempo = "Sin iniciar";
          }else{
            $tiempo = str_replace('+','',$tiempo)." días";
          }
          ?>

          <tr>
            <td><?= $Prescripcion[$x]['medicamento']." ".$Prescripcion[$x]['gramaje'] ?></td>
            <td><?= $Prescripcion[$x]['dosis'] ?></td>
            <td><?= $Prescripcion[$x]['via_administracion'] ?></td>
            <td><?= $Prescripcion[$x]['frecuencia'] ?></td>
            <td><?= $Prescripcion[$x]['aplicacion'] ?></td>
            <td><?= $Prescripcion[$x]['fecha_inicio'] ?></td>
            <td><?= $tiempo ?></td>
          </tr>
          <tr>
            <td colspan="8" style="text-align: left; border-bottom: 1px solid #ddd;">Observacion: <?= $Prescripcion[$x]['observacion'] ?></td>
          </tr>
        <?php } ?>
        </table>
        <?php }?>

        <?php if($Nota['nota_interconsultas']!=''){?>
         <h5 style="margin-botton: -6px">INTERCONSULTAS</h5>
            <?=$Nota['nota_interconsulta']?>
        <?php }?>

    </span>
    <page_footer>

    </page_footer>
</page>
<?php
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','en',true,'UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle($Nota['notas_tipo']);
    $pdf->Output($Nota['notas_tipo'].'.pdf');
?>
