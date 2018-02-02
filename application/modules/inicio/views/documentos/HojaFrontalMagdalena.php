<?php ob_start(); ?>
<page >
    <page_header>
        <img src="<?=  base_url()?>assets/doc/ce.png" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
    </page_header>
    <div style="position: absolute;">
        <div style="position: absolute;top: 86px;left: 67px;font-size: 11px"><?=$am['asistentesmedicas_fecha']?></div>
        <div style="position: absolute;top: 86px;left: 250px;font-size: 11px"><?=$am['asistentesmedicas_hora']?></div>
        <div style="position: absolute;top: 86px;left: 430px;font-size: 11px"><?=$am['asistentesmedicas_hoja']?></div>
        <div style="position: absolute;top: 86px;left: 580px;font-size: 11px"><?=$am['asistentesmedicas_renglon']?></div>
        <!--2 fila-->
        <div style="position: absolute;top: 106px;left: 80px;font-size: 11px;text-transform: uppercase">
            <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
        </div>
        <div style="position: absolute;top: 106px;left: 417px;font-size: 11px;text-transform: uppercase">
            <?=$info['triage_paciente_sexo']?>
        </div>
        <?php 
        $ObtenerEdad= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
        ?>
        <div style="position: absolute;top: 106px;left: 514px;font-size: 11px">
            <?=$ObtenerEdad->y?>
        </div>
        <div style="position: absolute;top: 106px;left: 575px;font-size: 11px">
            <?=$ObtenerEdad->m?> 
        </div>
        <!--3 fila-->
        <div style="position: absolute;top: 126px;left: 109px;font-size: 11px;;text-transform: uppercase">
            <?=$PINFO['pum_nss']!='' ? $PINFO['pum_nss'].' - '.$PINFO['pum_nss_agregado'] : $PINFO['pum_nss_armado']?>
        </div>
        <div style="position: absolute;top: 126px;left: 435px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pum_umf']?>
        </div>
        <div style="position: absolute;top: 146px;left: 85px;font-size: 11px;text-transform: uppercase">
            <?=$DirPaciente['directorio_cn']?> <?=$DirPaciente['directorio_colonia']?> <?=$DirPaciente['directorio_cp']?> <?=$DirPaciente['directorio_municipio']?> <?=$DirPaciente['directorio_estado']?> 
        </div>  
        <div style="position: absolute;top: 165px;left: 186px;font-size: 11px;;text-transform: uppercase">
            <?=$PINFO['pic_responsable_nombre']?> <?=$PINFO['pic_responsable_parentesco']!='' ? '(' .$PINFO['pic_responsable_parentesco'].')' : ''?>
        </div>
        <div style="position: absolute;top: 165px;left: 500px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pic_responsable_telefono']?>
        </div>
        <div style="position: absolute;top: 185px;left: 80px;font-size: 11px;text-transform: uppercase">
            <?=  substr($Empresa['empresa_nombre'], 0,50)?>
        </div>
        <?php 
        $DirecccionEmpresa=$DirEmpresa['directorio_cn'].' '.$DirEmpresa['directorio_colonia'].' '.$DirEmpresa['directorio_cp'].' '.$DirEmpresa['directorio_municipio'].' '.$DirEmpresa['directorio_estado'];
        if(strlen($DirecccionEmpresa)>=54){
        ?>
        <div style="position: absolute;top: 178px;left: 400px;font-size: 9px;text-transform: uppercase;width: 310px;">
            <?=$DirecccionEmpresa?>
        </div>
        <?php }else{?>
        <div style="position: absolute;top: 185px;left: 400px;font-size: 10px;text-transform: uppercase;">
            <?=$DirecccionEmpresa?>
        </div>
        <?php }?>
        <div style="position: absolute;top: 205px;left: 130px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pic_mt']?>
        </div>
        <div style="position: absolute;top: 205px;left: 505px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pic_am']?>
        </div>
        <div style="position: absolute;top: 245px;left: 135px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pia_fecha_accidente']?>
        </div>
        <div style="position: absolute;top: 245px;left: 263px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pia_hora_accidente']?>
        </div>
        <div style="position: absolute;top: 245px;left: 380px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pia_lugar_accidente']?>
        </div>
        <div style="position: absolute;top: 245px;left: 554px;font-size: 11px;text-transform: uppercase">
            <?=$PINFO['pia_lugar_procedencia']?>
        </div> 
        <!--Intoxicación-->
        <div style="position: absolute;top: 287px;left: 137px;font-size: 11px">
            <?=$hoja['hf_intoxitacion']=='Si'?'X':''?>
        </div>
        <div style="position: absolute;top: 287px;left: 191px;font-size: 11px">
            <?=$hoja['hf_intoxitacion']=='No'?'X':''?>
        </div>
        <div style="position: absolute;top: 285px;left: 280px;font-size: 11px">
            <?=$hoja['hf_intoxitacion_descrip']?>
        </div>
        <!--Urgencia-->
        <div style="position: absolute;top: 311px;left: 307px;font-size: 11px">
            <?=$hoja['hf_urgencia']=='Urgencia Real'? 'X':''?>
        </div>
        <div style="position: absolute;top: 311px;left: 505px;font-size: 11px">
            <?=$hoja['hf_urgencia']!='Urgencia Real'? 'X':''?>
        </div>
        <!--Especialidad}-->
        <div style="position: absolute;top: 349px;left: 293px;font-size: 11px;">
            <?=$hoja['hf_especialidad']=='Traumatologia' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 349px;left: 474px;font-size: 11px;">
            <?=$hoja['hf_especialidad']=='Neurologia' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 349px;left: 654px;font-size: 11px;">
            <?=$hoja['hf_especialidad']=='C. General' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 362px;left: 293px;font-size: 11px;">
            <?=$hoja['hf_especialidad']=='C. Reconstructiva' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 362px;left: 474px;font-size: 11px;">
            <?=$hoja['hf_especialidad']=='C. Maxilofacial' ? 'X' : ''?>
        </div>
        <!--Motivo de Urgencia-->
        <div style="position: absolute;top: 405px;left: 145px;font-size: 10px;line-height: 1.6;width: 560px">
            <?=$hoja['hf_motivo']?>
        </div>
        <div style="position: absolute;top: 461px;left: 230px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_mecanismolesion_caida']!='' ? $hoja['hf_mecanismolesion_caida']:''?>
        </div>
        <div style="position: absolute;top: 461px;left: 500px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_mecanismolesion_ab']!='' ? 'X':''?>
        </div>
        <div style="position: absolute;top: 461px;left: 650px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_mecanismolesion_td']!='' ? 'X':''?>
        </div>
        <div style="position: absolute;top: 475px;left: 120px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_mecanismolesion_av']!='' ? 'X':''?>
        </div>
        <div style="position: absolute;top: 475px;left: 230px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_mecanismolesion_maquinaria']!='' ? 'X':''?>
        </div>
        <div style="position: absolute;top: 475px;left: 340px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_mecanismolesion_mordedura']!='' ? 'X':''?>
        </div>
        <div style="position: absolute;top: 475px;left: 420px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_mecanismolesion_otros']!='' ? $hoja['hf_mecanismolesion_otros']:''?>
        </div>
        <div style="position: absolute;top: 487px;left: 220px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_quemadura_fd']!='' ? 'X':''?>
        </div>
        <div style="position: absolute;top: 487px;left: 330px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_quemadura_ce']!='' ? 'X':''?>
        </div>
        <div style="position: absolute;top: 487px;left: 430px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_quemadura_e']!='' ? 'X':''?>
        </div>
        <div style="position: absolute;top: 487px;left: 500px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_quemadura_q']!='' ? 'X':''?>
        </div>
        <div style="position: absolute;top: 487px;left: 555px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_quemadura_otros']!='' ? $hoja['hf_quemadura_otros']:''?>
        </div>
        <div style="position: absolute;top: 523px;left: 110px;font-size: 11px;line-height: 1.6;width: 590px">
            <?=$hoja['hf_antecedentes']?>
        </div>
        <div style="position: absolute;top: 545px;left: 150px;font-size: 11px;line-height: 1.6">
            <?=$info['triage_tension_arterial']?>
        </div>
        <div style="position: absolute;top: 545px;left: 300px;font-size: 11px;line-height: 1.6">
            <?=$info['triage_frecuencia_cardiaco']?>
        </div>
        <div style="position: absolute;top: 545px;left: 440px;font-size: 11px;line-height: 1.6">
            <?=$info['triage_frecuencia_respiratoria']?>
        </div>
        <div style="position: absolute;top: 545px;left: 550px;font-size: 11px;line-height: 1.6">
            <?=$info['triage_temperatura']?>
        </div>
        <div style="position: absolute;top: 565px;left: 143px;font-size: 11px;line-height: 1.6;width: 570px">
            <?=$hoja['hf_exploracionfisica']?>
            
        </div>
         <div style="position: absolute;top: 625px;left:50px;font-size: 11px;line-height: 1.6">
            <?php foreach ($rx as $value) {
                $cc.=$value['casoclinico_nombre'].', ';
            }
            echo trim($cc, ', ');
            ?>
        </div>
        
        <div style="position: absolute;top: 645px;left: 120px;font-size: 10px;line-height: 1.6;width: 590px">
            <?=$hoja['hf_interpretacion']?>
        </div>
        <div style="position: absolute;top: 684px;left:110px;font-size: 10px;line-height: 1.6;width: 600px">
            <?=$hoja['hf_diagnosticos']?>
        </div>
        <div style="position: absolute;top: 765px;left: 185px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_trataminentos_curacion']!='' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 765px;left: 265px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_trataminentos_sutura']!='' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 765px;left: 355px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_trataminentos_vendaje']!='' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 765px;left: 430px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_trataminentos_ferula']!='' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 765px;left: 510px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_trataminentos_vacunas']!='' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 765px;left: 575px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_trataminentos_otros']!='' ? $hoja['hf_trataminentos_otros'] : ''?>
        </div>
        <div style="position: absolute;top: 785px;left: 160px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_trataminentos_por']!='' ? $hoja['hf_trataminentos_por'] : ''?>
        </div>
        <div style="position: absolute;top: 805px;left: 97px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_receta_por']?>
        </div>
        <div style="position: absolute;top: 824px;left: 110px;font-size: 10px;line-height: 1.6;width: 600px">
            <?=$hoja['hf_indicaciones']?>
        </div>
        <div style="position: absolute;top: 864px;left: 290px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_ministeriopublico']=='Si' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 864px;left: 380px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_ministeriopublico']=='No' ? 'X' : ''?>
        </div>
        <div style="position: absolute;top: 906px;left: 109px;font-size: 11px;line-height: 1.6">
            <?=$ce['ce_hf']?>
        </div>
        <div style="position: absolute;top: 918px;left: 186px;font-size: 11px;line-height: 1.6">
            <?=$am['asistentesmedicas_incapacidad_folio']?>
        </div>
        <div style="position: absolute;top: 918px;left: 380px;font-size: 11px;line-height: 1.6">
            <?=$am['asistentesmedicas_incapacidad_da']?>
        </div>
        <div style="position: absolute;top: 918px;left: 468px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_incapacidad_ptr_eg']=='PTR' ? 'X': ''?>
        </div>
        <div style="position: absolute;top: 918px;left: 525px;font-size: 11px;line-height: 1.6">
            <?=$hoja['hf_incapacidad_ptr_eg']=='EG' ? 'X': ''?>
        </div>
        <div style="position: absolute;top: 960px;left: 280px;font-size: 11px">
            <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?> <?=$Medico['empleado_matricula']?>
        </div>
        <div style="position: absolute;left: 280px;top: 1020px">
            <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 20px;" ></barcode>
        </div>
    </div>
    <page_footer></page_footer>       
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','en','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->SetTitle('HOJA FRONTAL EMITIDA POR CE');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('HOJA FRONTAL EMITIDA POR CE.pdf');
?>