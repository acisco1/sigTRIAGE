<?php ob_start(); ?>
<page backtop="80mm" backbottom="50mm" backleft="48" backright="1mm">
    <page_header>
        <style>
            th, td {
              padding-left: 3px;
              padding-right: 3px;
              padding-top: 2px;
              padding-bottom: 2px;
            }
        </style>
        <img src="<?=  base_url()?>assets/doc/DOC430128_HF.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">
        <div style="position: absolute;margin-top: 15px">
            <div style="position: absolute;top: 80px;left: 120px;width: 270px;">
                <!--<b><?=_UM_CLASIFICACION?> | <?=_UM_NOMBRE?></b> -->
            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 50px;width: 270px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>NOMBRE DEL PACIENTE:</b>
            </div>
            <div style="position: absolute;margin-left: 435px;margin-top: 61px;width: 270px;text-transform: uppercase;font-size: 14px;text-align: left;">
                <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
            </div>
            <div style="position: absolute;margin-left: 437px;margin-top: 75px;width: 270px;text-transform: uppercase;font-size: 13px;">
                <b>N.S.S:</b> <?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?>
            </div>
            <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac'])); ?>
            <div style="position: absolute;margin-left: 437px;margin-top: 95px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -2px">
                    <b>EDAD:</b> <?=$fecha->y==0 ? $fecha->m.' MESES' : $fecha->y.' AÑOS'?>
                </p>
                <p style="margin-top: -10px">
                    <b>UMF:</b> <?=$PINFO['pum_umf']?>/<?=$PINFO['pum_delegacion']?>
                </p>
                <p style="margin-top: -10px">
                    <b><?=$hoja['hf_atencion']?></b>
                </p>

            </div>
            <div style="position: absolute;margin-left: 540px;margin-top: 95px;width: 270px;text-transform: uppercase;font-size: 11px;">
                <p style="margin-top: -2px">
                    <b>GENERO:</b> <?=$info['triage_paciente_sexo']?>
                </p>
                <p style="margin-top: -10px">
                    <b>PROCEDE:</b> <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEO' : 'REFERENCIADO'?>
                </p>
                <p style="margin-top: -10px">
                    <b>ATENCION:</b><?=$PINFO['pia_tipo_atencion']?>
                </p>
            </div>

            <div style="position: absolute;margin-left: 437px;margin-top: 136px;width: 270px;text-transform: uppercase;font-size: 11px;">
             <?php if($PINFO['pia_procedencia_espontanea']=='No'){?>

                <p style="margin-top: -7px">
                    <b>4-30-8/NM:</b> <?=$PINFO['pia_procedencia_hospital']?> <?=$PINFO['pia_procedencia_hospital_num']?>
                </p>
                 <?php }?>
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

            <div style="position: absolute;margin-left: 437px;margin-top: 263px;width: 270px;text-transform: uppercase;font-size: 13px;">
                <b>NOTA INICIAL</b>
            </div>

            <div style="position: absolute;margin-top:229px;margin-left: 134px ">
                <?php
                $sqlChoque=$this->config_mdl->_get_data_condition('os_choque_v2',array(
                    'triage_id'=>$info['triage_id']
                ));
                $sqlObs=$this->config_mdl->_get_data_condition('os_observacion',array(
                    'triage_id'=>$info['triage_id']
                ));
                if(empty($sqlChoque)){
                    echo $this->config_mdl->_get_data_condition('os_camas',array(
                        'cama_id'=>$sqlObs[0]['observacion_cama']
                    ))[0]['cama_nombre'];
                }else{
                    echo $this->config_mdl->_get_data_condition('os_camas',array(
                        'cama_id'=>$sqlChoque[0]['cama_id']
                    ))[0]['cama_nombre'];
                }
                ?>
            </div>
            <div style="position: absolute;margin-top:228px;margin-left: 44px;text-transform: uppercase ">
                <b>CLASIFICACIÓN:</b> <?=$info['triage_color']?>
            </div>
            <div style="position: absolute;margin-top:237px;margin-left: 360px ">:[[page_cu]]/[[page_nb]]</div>
            <!-- fecha de  creacion del documento -->
            <div style="position: absolute;margin-left: 10px;margin-top: 270px;width: 150px;font-size: 12px;text-align: center;">
                <h5><?=$hoja['hf_fg']?> <?=$hoja['hf_hg']?></h5>
            </div>
            <div style="position: absolute;margin-left: 30px;margin-top: 310px;width: 110px;font-size: 12px;text-align: center">
                <h5 style="margin-top: -5px">Presión Arterial</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_ta']?> mmHg</p>
                <h5 style="margin-top: -5px">Temperatura</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_temp']?> °C</p>
                <h5 style="margin-top: -5px">Frecuencia Cardiaca</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_fc']?> (lpm)</p>
                <h5 style="margin-top: -5px">Frecuencia Respiratoria</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_fr']?> (rpm)</p>
                <?php if($SignosVitales['sv_oximetria']!=''){?>
                <h5 style="margin-top: -5px">Oximetria</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_oximetria']?> (%SpO2)</p>
                <?php }?>
                <?php if($SignosVitales['sv_dextrostix']!=''){?>
                <h5 style="margin-top: -5px">Glucometría</h5>
                <p style="margin-top: -15px"><?=$SignosVitales['sv_dextrostix']?> (mg/dl)</p>
                <?php }?>
                <h5 style="margin-top: -5px">Escala de dolor (EVA):</h5>
                <p style="margin-top: -28px; margin-left: 65px"><?=$hoja['hf_eva']?></p>
                <h5 style="margin-top: -5px">Riesgo de caída</h5>
                <p style="margin-top: -15px"><?=$hoja['hf_riesgocaida']?></p>
                <h5 style="margin-top: -5px">Riesgo de trombosis:</h5>
                <p style="margin-top: -15px"><?=$hoja['hf_riesgo_trombosis']?></p>
                <h5 style="margin-top: -5px">Escala de Glasgow:</h5>
                <p style="margin-top: -28px; margin-left: 75px"><?=$hoja['hf_escala_glasgow']?></p>
                <h5 style="margin-top: -5px">Estado de Salud</h5>
                <p style="margin-top: -15px"><?=$hoja['hf_estadosalud']?></p>
            </div>
            <div style="rotate: 90; position: absolute;margin-left: 13px;margin-top: 336px;text-transform: uppercase;font-size: 12px;">
                ENF:<?=$Enfermera['empleado_nombre']?> <?=$Enfermera['empleado_apellidos']?> <?=$info['triage_fecha']?> <?=$info['triage_hora']?>
            </div>
            <div style="position: absolute;top: 910px;left: 215px;width: 240px;font-size: 9px;text-align: center">
                <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?><br>
                <span style="margin-top: -6px;margin-bottom: -8px">____________________________________</span><br>
                <b>NOMBRE DEL MÉDICO</b>
            </div>
            <div style="position: absolute;top: 910px;left: 430px;width: 160px;font-size: 9px;text-align: center">
                <?=$Medico['empleado_cedula']?> - <?=$Medico['empleado_matricula']?> <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_____________________________</span><br>
                <b>CÉDULA Y MATRICULA</b>
            </div>
            <div style="position: absolute;top: 910px;left: 590px;width: 110px;font-size: 9px;text-align: center">
                <br>
                <span style="margin-top: -6px;margin-bottom: -8px">_________________</span><br>
                <b>FIRMA</b>
            </div>
            <div style="margin-left: 280px;margin-top: 980px">
                <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 40px;" ></barcode>
            </div>
        </div>
    </page_header>

       <div style="left: 1px; right: -2000px; margin-top: -15px; font-size: 12px;">
        <span style="text-align: justify;">
        <?php if($hoja['hf_motivo']!=''){?>
        <h5 style="margin-bottom: -6px">MOTIVO DE CONSULTA</h5>
        <?=$hoja['hf_motivo']?>
        <br>
        <?php }?>
        <?php if($hoja['hf_antecedentes']!=''){?>
        <h5 style="margin-bottom: -6px">ANTECEDENTES</h5>
        <?=$hoja['hf_antecedentes']?>
        <br>
        <?php }?>
        <?php if($PINFO['alergias']!=''){?>
        <h5 style="margin-bottom: -6px">ALERGIAS</h5>
        <?=$PINFO['alergias']?>
        <br>
        <?php }?>
        <?php if($hoja['hf_padecimientoa']!=''){?>
        <h5 style="margin-bottom: -6px">PADECIMIENTO ACTUAL</h5>
        <?=$hoja['hf_padecimientoa']?>
        <br>
        <?php }?>
        <?php if($hoja['hf_exploracionfisica']!=''){?>
        <h5 style="margin-bottom: -6px">EXPLORACIÓN FISICA</h5>
        <?=$hoja['hf_exploracionfisica']?>
        <br>
        <?php }?>
        <?php if($hoja['hf_auxiliares']!=''){?>
        <h5 style="margin-bottom: -6px">AUXILIARES DE DIAGNÓSTICO</h5>
        <?=$hoja['hf_auxiliares']?>
        <br>
        <?php }?>
        <h5 style="margin-bottom: -6px">DIAGNÓSTICO DE INGRESO</h5>
        <?=$Diagnosticos[0]['cie10_clave']?> -
        <?=$Diagnosticos[0]['cie10_nombre']?>
        <h5 style="margin-bottom: -6px">DIAGNÓSTICOS SECUNDARIOS</h5>
        <?php for($x = 1; $x < count($Diagnosticos); $x++){ ?>
          <?=$Diagnosticos[$x]['cie10_clave']?> - <?=$Diagnosticos[$x]['cie10_nombre']?>
          <br>
        <?php } ?>

        <?php if($hoja['hf_diagnosticos']!=''){?>
        <h5 style="margin-bottom: -6px">DIAGNÓSTICOS SECUNDARIOS</h5>
        <?=$hoja['hf_diagnosticos']?>
        <?php }?>
        <h5 style="margin-bottom: -6px">INDICACIONES Y ORDENES MÉDICAS</h5>

        <?php if($hoja['hf_nutricion'] == '0') {
          $nutricion = 'Ayuno';
        }else if($hoja['hf_nutricion'] == '1'){
          $nutricion = 'IB - Normal';
        }else if($hoja['hf_nutricion'] == '2'){
          $nutricion = 'IIA - Blanda';
        }else if($hoja['hf_nutricion'] == '3'){
          $nutricion = 'IIB - Astringente';
        }else if($hoja['hf_nutricion'] == '4'){
          $nutricion = 'III - Diabetica';
        }else if($hoja['hf_nutricion'] == '5'){
          $nutricion = 'IV - Hiposodica';
        }else if($hoja['hf_nutricion'] == '6'){
          $nutricion = 'V - Hipograsa';
        }else if($hoja['hf_nutricion'] == '7'){
          $nutricion = 'VI - Liquida clara';
        }else if($hoja['hf_nutricion'] == '8'){
          $nutricion = 'VIA - Liquida general';
        }else if($hoja['hf_nutricion'] == '9'){
          $nutricion = 'VIB - Licuada por sonda';
        }else if($hoja['hf_nutricion'] == '10'){
          $nutricion = 'VIB - Licuada por sonda artesanal';
        }else if($hoja['hf_nutricion'] == '11'){
          $nutricion = 'VII - Papilla';
        }else if($hoja['hf_nutricion'] == '12'){
          $nutricion = 'VIII - Epecial';
        }else{
          $nutricion = $hoja['hf_nutricion'];
        }
        ?>
        Dieta: <?= $nutricion ?> <br><br>



        <?php
        if($hoja['hf_signosycuidados'] == '1'){
          $toma_signos = 'Por turno';
        }else if($hoja['hf_signosycuidados'] == '2'){
          $toma_signos = 'Cada 4 horas';
        }else{
          $toma_signos = $hoja['hf_signosycuidados'];
        }
        ?>
        SIGNOS:<?=$toma_signos?><br><br>
        <?php if($hoja['hf_cgenfermeria'] == '1'){ ?>
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
        <?php if($hoja['hf_cuidadosenfermeria']!=''){?>
        CUIDADOS ESPECIFICOS DE ENFERMERIA:<br> <?=$hoja['hf_cuidadosenfermeria']?><br><br>
        <?php }?>
        <?php if($hoja['hf_solucionesp']!=''){?>
        SOLUCIONES PARENTERALES:<br><?=$hoja['hf_solucionesp']?>
        <?php }?>
        <?php if(count($Prescripcion) > 0){?>
        <br><br>MEDICAMENTOS:<br><br>
        <style media="screen">
          td,th{
            text-align: center;
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
            <th>Fecha fin</th>
            <th>Dias</th>
          </tr>
        <?php for($x = 0; $x < count($Prescripcion); $x++){ ?>
          <tr>
            <td style="text-align:left;"><?= $Prescripcion[$x]['medicamento']." ".$Prescripcion[$x]['gramaje'] ?></td>
            <td><?= $Prescripcion[$x]['dosis'] ?></td>
            <td style="width: 41px;"><?= $Prescripcion[$x]['via_administracion'] ?></td>
            <td><?= $Prescripcion[$x]['frecuencia'] ?></td>
            <td style="width: 60px;" ><?= $Prescripcion[$x]['aplicacion'] ?></td>
            <td><?= $Prescripcion[$x]['fecha_inicio'] ?></td>
            <td style="width: 50px; height:0px;"><?= $Prescripcion[$x]['fecha_fin'] ?></td>
            <td><?= $Prescripcion[$x]['dias'] ?></td>
          </tr>
          <tr>
            <td colspan="9" style="text-align: left; border-bottom: 1px solid #ddd;"><b>Observación:</b> <?= $Prescripcion[$x]['observacion'] ?></td>
          </tr>
        <?php } ?>
        </table>
        <?php }?>
        <?php if($hoja['hf_indicaciones']!=''){?>
        <h5 style="margin-bottom: -6px">PRONÓSTICO</h5>
        <?=$hoja['hf_indicaciones']?>
        <?php }?>
        <h5 style="margin-bottom: -6px">ACCIÓN:</h5><p style="margin-top: -13px; margin-left: 60"><?=$hoja['hf_alta']?></p>
        <?php $num_interconsultas = count($Interconsultas); ?>
        <?php if($num_interconsultas > 0){ ?>
        <h5 style="margin-bottom: -6px">INTERCONSULTAS</h5>
          Servicios solicitados:
          <?php for($x = 0; $x < $num_interconsultas; $x++){
            $y = $x + 1;
            $separacion = ($y == $num_interconsultas)?".":", ";
            ?>
            <?=$Interconsultas[$x]['especialidad_nombre'].$separacion?>
          <?php } ?>
          <br><br>
          Motivo interconsulta: <?=$Interconsultas[0]['motivo_interconsulta'] ?>
        <?php } ?>

         <?php if($hoja['hf_interconsulta']!=''){?>
        <h5 style="margin-bottom: -6px">VALORACION POR: <?=$hoja['hf_interconsulta']?></h5>
        <?php }?>
       </span>
    </div>
    <page_footer>

    </page_footer>
</page>
<?php
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle('NOTA INICIAL');
    $pdf->Output($Nota['notas_tipo'].'.pdf');
?>
