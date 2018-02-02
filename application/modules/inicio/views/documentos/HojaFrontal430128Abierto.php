<?php ob_start(); ?>
<page backtop="80mm" backbottom="50mm" backleft="56" backright="15mm">
    <page_header>
        <style>
            table, td, th {text-align: left;}
            table {border-collapse: collapse;width: 100%;}
            th, td {padding: 5px;}
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
            <!-- fecha de  creacion del cocumento -->
            <div style="position: absolute;margin-left: 45px;margin-top: 276px;width: 150px;font-size: 7px;text-align: center;">
                <h5><?=$hoja['hf_fg']?> <?=$hoja['hf_hg']?></h5>
            </div>
            <div style="position: absolute;margin-left: 66px;margin-top: 310px;width: 110px;font-size: 12px;text-align: center">
                <h5>Tensión Arterial</h5>
                <h4 style="margin-top: -10px"><?=$SignosVitales['sv_ta']?> mmHg</h4>
                <h5 style="margin-top: -5px">Temperatura</h5>
                <h4 style="margin-top: -10px"><?=$SignosVitales['sv_temp']?> °C</h4>
                <h5 style="margin-top: -5px">Frecuencia Cardiaca</h5>
                <h4 style="margin-top: -10px"><?=$SignosVitales['sv_fc']?> (lpm)</h4>
                <h5 style="margin-top: -5px">Frecuencia Respiratoria</h5>
                <h4 style="margin-top: -10px"><?=$SignosVitales['sv_fr']?> (rpm)</h4>
                <?php if($SignosVitales['sv_oximetria']!=''){?>
                <h5 style="margin-top: -5px">Oximetria</h5>
                <h4 style="margin-top: -10px"><?=$SignosVitales['sv_oximetria']?> (%SpO2)</h4>
                <?php }?>
                <?php if($SignosVitales['sv_dextrostix']!=''){?>
                <h5 style="margin-top: -5px">Glucometría</h5>
                <h4 style="margin-top: -10px"><?=$SignosVitales['sv_dextrostix']?> (mg/dl)</h4>
                <?php }?>
                <h5 style="margin-top: -5px">Escala de dolor (EVA):</h5>
                <h4 style="margin-top: -10px"><?=$hoja['hf_eva']?></h4>
                <h5 style="margin-top: -5px">Riesgo de caída:</h5>
                <h4 style="margin-top: -10px"><?=$hoja['hf_riesgocaida']?></h4>
                <h5 style="margin-top: -5px">Riesgo de trombosis:</h5>
                <h4 style="margin-top: -10px"><?=$hoja['hf_riesgo_trombosis']?></h4>
            </div>
            <div style="rotate: 90; position: absolute;margin-left: 50px;margin-top: 336px;text-transform: uppercase;font-size: 12px;">
                <?=$Enfermera['empleado_nombre']?> <?=$Enfermera['empleado_apellidos']?> <?=$info['triage_fecha']?> <?=$info['triage_hora']?><br><br><br>
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
        <span style="text-align: justify">
        <?php if($hoja['hf_motivo']!=''){?>
        <h4 style="margin-bottom: -6px">MOTIVO DE CONSULTA</h4>
        <?=$hoja['hf_motivo']?>
        <br>
        <?php }?>
        <?php if($hoja['hf_antecedentes']!=''){?>
        <h4 style="margin-bottom: -6px">ANTECEDENTES</h4>
        <?=$hoja['hf_antecedentes']?>
        <br>
        <?php }?>
        <?php if($hoja['hf_padecimientoa']!=''){?>
        <h4 style="margin-bottom: -6px">PADECIMIENTO ACTUAL</h4>
        <?=$hoja['hf_padecimientoa']?>
        <br>
        <?php }?>
        <?php if($hoja['hf_exploracionfisica']!=''){?>
        <h4 style="margin-bottom: -6px">EXPLORACIÓN FISICA</h4>
        <?=$hoja['hf_exploracionfisica']?>
        <br>
        <?php }?>
        <h5 style="margin-bottom: -5px">ESCALA DE GLASGOW: <?=$hoja['hf_escala_glasgow']?></h5>
        <?php if($hoja['hf_auxiliares']!=''){?>
        <h4 style="margin-bottom: -6px">AUXILIARES DE DIAGNÓSTICO</h4>
        <?=$hoja['hf_auxiliares']?>
        <br>
        <?php }?>
        <h4 style="margin-bottom: -6px">DIAGNÓSTICO DE INGRESO</h4>
        <?=$hoja['hf_diagnosticos_lechaga']?>
        <br>
        <?php if($hoja['hf_diagnosticos']!=''){?>
        <h4 style="margin-bottom: -6px">DIAGNÓSTICOS SECUNDARIOS</h4>
        <?=$hoja['hf_diagnosticos']?>
        <br>
        <?php }?>
        <h4 style="margin-bottom: -6px">INDICACIONES Y ORDENES MÉDICAS</h4>
        <?php if($hoja['hf_ayuno']!=''){?>
        DIETA: <?=$hoja['hf_ayuno']?><BR>
        <br>
        <?php }?>
        <?php if($hoja['hf_signosycuidados']!=''){?>
        SIGNOS:  <?=$hoja['hf_signosycuidados']?><BR>
        <br>
        <?php }?>
        <?php if($hoja['hf_cuidadosenfermeria']!=''){?>
        CUIDADOS ESPECIFICOS DE ENFERMERIA: <?=$hoja['hf_cuidadosenfermeria']?><BR>
        <br>
        <?php }?>
        <?php if($hoja['hf_solucionesp']!=''){?>
        SOLUCIONES PARENTERALES: <?=$hoja['hf_solucionesp']?><BR>
        <br>
        <?php }?>
        <?php if($hoja['hf_medicamentos']!=''){?>
        MEDICAMENTOS: <?=$hoja['hf_medicamentos']?><BR> 
        <?php }?>
         <?php if($hoja['hf_indicaciones']!=''){?>  
        <h4 style="margin-bottom: -6px">PRONÓSTICO</h4>
        <?=$hoja['hf_indicaciones']?><?php }?>
        <br>
         <?php if($hoja['hf_interpretacion']!=''){?>
        <h4 style="margin-bottom: -6px">ESTADO DE SALUD</h4>
        <?=$hoja['hf_interpretacion']?>
        <br>
        <?php }?>
        <h4 style="margin-bottom: -6px">ACCIÓN: <?=$hoja['hf_alta']?></h4>
        <br>
         <?php if($hoja['hf_interconsulta']!=''){?>
        <h4 style="margin-bottom: -6px">VALORACION POR: <?=$hoja['hf_interconsulta']?></h4>
        <?php }?>
    </span>
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