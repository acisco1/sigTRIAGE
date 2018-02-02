<?php ob_start(); ?>
<page>
    <page_header>
       <img src="<?=  base_url()?>assets/doc/Clasificacion_.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
       <div style="position: absolute;">
            <div style="position: absolute;top: 10px;left: 43px;font-size: 10px;width: 645px;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: center;font-weight: bold">
                DESTINO: <?=$info[0]['triage_consultorio_nombre']?>
            </div>
            <div style="position: absolute;top: 155px;left: 184px;font-size: 10px"><?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?></div>
            <div style="position: absolute;top: 155px;left: 440px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[2]?></div>
            <div style="position: absolute;top: 155px;left: 490px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[1]?></div>
            <div style="position: absolute;top: 155px;left: 530px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[0]?></div>
            <div style="position: absolute;top: 155px;left: 640px;font-size: 10px"><?=  explode(':', $info[0]['triage_hora_clasifica'])[0]?></div>
            <div style="position: absolute;top: 155px;left: 655px;font-size: 10px"><?=  explode(':', $info[0]['triage_hora_clasifica'])[1]?></div>
            <!---Seccion 2-->
            <div style="position: absolute;top: 178px;left: 105px;font-size: 10px"><?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?> <?=$info[0]['triage_nombre']?></div>
            <!---Seccion 3-->
            <?php if($_GET['via']=='Choque'){?>
            <div style="position: absolute;top: 225px;left: 145px;font-size: 10px"><?=$class_choque[0]['sv_ta']?></div> 
            <div style="position: absolute;top: 225px;left: 280px;font-size: 10px"><?=$class_choque[0]['sv_temp']?></div>
            <div style="position: absolute;top: 225px;left: 455px;font-size: 10px"><?=$class_choque[0]['sv_fc']?></div>
            <div style="position: absolute;top: 225px;left: 630px;font-size: 10px"><?=$class_choque[0]['sv_fr']?></div>
            <?php }else{?>
            <div style="position: absolute;top: 225px;left: 145px;font-size: 10px"><?=$SignosVitales['sv_ta']?></div> 
            <div style="position: absolute;top: 225px;left: 260px;font-size: 10px"><?=$SignosVitales['sv_temp']?> °C</div>
            <div style="position: absolute;top: 225px;left: 465px;font-size: 10px"><?=$SignosVitales['sv_fc']?></div>
            <div style="position: absolute;top: 225px;left: 645px;font-size: 10px"><?=$SignosVitales['sv_fr']?></div>
            <?php }?>
            <?php if($this->ConfigSolicitarOD=='Si'){?>
            <div style="position: absolute;top: 208px;left: 50px;font-size: 10px">
                <b>Oximetría:</b> <?=$SignosVitales['sv_oximetria']?>
            </div>
            <div style="position: absolute;top: 208px;left: 530px;font-size: 10px">
                <b>Dextrostix:</b> <?=$SignosVitales['sv_dextrostix']?>
            </div>
            <?php }?>
            <!--Seccion 4 Pregunta 1-->
            <div style="position: absolute;top: 292px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg1_s1']==0){echo 'X';}?></div>
            <div style="position: absolute;top: 292px;left: 570px;font-size: 10px"><?php if($info[0]['triage_preg1_s1']!=0){echo 'X';}?></div>
            <!--Seccion 4 Pregunta 2-->
            <div style="position: absolute;top: 310px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg2_s1']==0){echo 'X';}?></div>
            <div style="position: absolute;top: 310px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg2_s1']!=0){echo 'X';}?></div>
            <!--Seccion 4 Pregunta 3-->
            <div style="position: absolute;top: 326px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg3_s1']==0){echo 'X';}?></div>
            <div style="position: absolute;top: 326px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg3_s1']!=0){echo 'X';}?></div>
            <!--Seccion 4 Pregunta 4-->
            <div style="position: absolute;top: 340px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg4_s1']==0){echo 'X';}?></div>
            <div style="position: absolute;top: 340px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg4_s1']!=0){echo 'X';}?></div>
            <!--Seccion 4 Pregunta 5-->
            <div style="position: absolute;top: 355px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg5_s1']==0){echo 'X';}?></div>
            <div style="position: absolute;top: 355px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg5_s1']!=0){echo 'X';}?></div>
            <!--Seccion 4 Total-->
            <div style="position: absolute;top: 370px;left: 595px;font-size: 10px"><?=$clasificacion[0]['triege_preg_puntaje_s1']?></div>

            <!--Seccion 5 Pregunta 1-->
            <div style="position: absolute;top: 440px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg1_s2']?></div>
            <!--Seccion 5 Pregunta 2-->
            <div style="position: absolute;top: 453px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg2_s2']?></div>
            <!--Seccion 5 Pregunta 3-->
            <div style="position: absolute;top: 468px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg3_s2']?></div>
            <!--Seccion 5 Pregunta 4-->
            <div style="position: absolute;top: 486px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg4_s2']?></div>
            <!--Seccion 5 Pregunta 5-->
            <div style="position: absolute;top: 498px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg5_s2']?></div>
            <!--Seccion 5 Pregunta 6-->
            <div style="position: absolute;top: 510px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg6_s2']?></div>
            <!--Seccion 5 Pregunta 7-->
            <div style="position: absolute;top: 528px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg7_s2']?></div>
            <!--Seccion 5 Pregunta 8-->
            <div style="position: absolute;top: 545px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg8_s2']?></div>
            <!--Seccion 5 Pregunta 9-->
            <div style="position: absolute;top: 557px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg9_s2']?></div>
            <!--Seccion 5 Pregunta 10-->
            <div style="position: absolute;top: 575px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg10_s2']?></div>
            <!--Seccion 5 Pregunta 11-->
            <div style="position: absolute;top: 590px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg11_s2']?></div>
            <!--Seccion 5 Pregunta 12-->
            <div style="position: absolute;top: 608px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg12_s2']?></div>
            <!--Seccion 5 Total-->
            <div style="position: absolute;top: 626px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triege_preg_puntaje_s2']?></div>

            <!--Seccion 6 Pregunta l-->
            <div style="position: absolute;top: 676px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg1_s3']?></div>
            <!--Seccion 6 Pregunta 2-->
            <div style="position: absolute;top: 690px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg2_s3']?></div>
            <!--Seccion 6 Pregunta 3-->
            <div style="position: absolute;top: 702px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg3_s3']?></div>
            <!--Seccion 6 Pregunta 4-->
            <div style="position: absolute;top: 714px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg4_s3']?></div>
            <!--Seccion 6 Pregunta 4-->
            <div style="position: absolute;top: 726px;left: 648px;font-size: 10px"><?=$clasificacion[0]['triage_preg5_s3']?></div>
            <!--Seccion 6 Total Final-->
            <div style="position: absolute;top: 740px;left: 646px;font-size: 10px"><?=$clasificacion[0]['triage_puntaje_total']?></div>

            <div style="position: absolute;top: 848px;left: 60px;font-size:9px;width: 200px;text-align: center;">
                <?=$medico[0]['empleado_nombre']?> <?=$medico[0]['empleado_apellidos']?>
            </div>
            <div style="position: absolute;top: 848px;left: 280px;font-size:9px;width:200px;text-align: center;">
                <?=$medico[0]['empleado_matricula']?>
            </div>
            <?php if($this->ConfigExcepcionCMT=='Si' && $clasificacion[0]['triage_observacion']!=''){?>
            <div style="width: 660px;margin: auto;font-size: 11px;top: 905px;padding: 0px;position: absolute;left: 43px;padding: 0px;text-align: justify">
                <b>Observaciones: </b><?=$clasificacion[0]['triage_observacion']?>
            </div>
            <?php }?>
            <div style="position: absolute;left: 280px;top: 970px">
                <barcode type="C128A" value="<?=$info[0]['triage_id']?>" style="height: 40px;" ></barcode>
            </div>
        </div> 
    </page_header>
    
    <page_footer>

        <?php 
        if($clasificacion[0]['triage_color']=='Rojo'){
            $color='#E50914';
            $color_name='Rojo';
            $tiempo='Inmediatamente';
        }if($clasificacion[0]['triage_color']=='Naranja'){
            $color='#FF7028';
            $color_name='Naranja';
            $tiempo='10 Minutos';
        }if($clasificacion[0]['triage_color']=='Amarillo'){
            $color_name='Amarillo';
            $tiempo='11-60 Minutos';
        }if($clasificacion[0]['triage_color']=='Verde'){
            $color='#4CBB17';
            $color_name='Verde';
            $tiempo='61-120 Minutos';
        }if($clasificacion[0]['triage_color']=='Azul'){
            $color='#0000FF';
            $color_name='Azul';
            $tiempo='121-240 Minutos';
        }

        ?>
        
        <div style="height: 15px;width: 645px;background: black;margin: auto;color: white;text-align: center;padding: 10px;border-radius: 5px;font-weight: bold;text-transform: uppercase">
            Puntaje Total:<?=$clasificacion[0]['triage_puntaje_total']?> | Color : <?=$color_name?> <?=$tiempo?>
        </div>
    </page_footer>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->SetTitle('CLASIFICACIÓN DE PACIENTES');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('CLASIFICACIÓN DE PACIENTES (TRIAGE).pdf');
?>