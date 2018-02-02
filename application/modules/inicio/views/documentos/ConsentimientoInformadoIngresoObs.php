<?php ob_start(); ?>
<page backtop="85mm" backbottom="7mm" backleft="10mm" backright="10mm">
    <page_header>
        <img src="<?=  base_url()?>assets/doc/CONSENTIMIENTO_INFORMADO.png" style="position: absolute;width: 100%;margin-top: 0px;margin-left: -5px;">
        <div style="position: absolute;margin-top: 15px">
            <div style="position: absolute;top: 184px;left: 450px;font-size: 12px;text-transform: uppercase;width: 190px;">
                <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
            </div>
            <div style="position: absolute;top: 217px;left: 480px;font-size: 10px;text-transform: uppercase;width: 160px;">
                <?php
                $sqlPUM=$this->config_mdl->_get_data_condition('paciente_info',array(
                    'triage_id'=>$info['triage_id']
                ))[0];
                ?>
                
                <b><?=$sqlPUM['pum_nss']?> - <?=$sqlPUM['pum_nss_agregado']?></b>
            </div>
            <div style="position: absolute;top: 233px;left: 440px;font-size: 12px;text-transform: uppercase;">
                <b><?=$info['triage_paciente_sexo']?></b>
            </div>
            <div style="position: absolute;top: 233px;left: 580px;font-size: 12px;text-transform: uppercase;">
              <?php 
                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));?>
                <b><?=$fecha->y?> AÑOS</b>
            </div>
            <div style="position: absolute;top: 307px;left: 120px;font-size: 10px;text-transform: uppercase;">
                <b><?=$info['triage_nombre']?> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?></b>
            </div>
        </div>
         <div style="position: absolute;top: 870px;left: 127px;width: 240px;font-size: 9px;text-align: center">
         <?php $sqlMedicoClass=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                                                'empleado_id'=>$obs['observacion_medico']
                                            ),'empleado_nombre, empleado_apellidos, empleado_matricula')[0];?>
                                            <?=$sqlMedicoClass['empleado_nombre']?> <?=$sqlMedicoClass['empleado_apellidos']?>  <?=$sqlMedicoClass['empleado_matricula']?>
         </div> 
        <div style="position: absolute;top: 1000px">
            <div style="margin-left: 280px;">
                <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 20px;" ></barcode>
            </div>
        </div>
    </page_header>
    
    <page_footer>
        
    </page_footer>

        
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->SetTitle('Consentimiento Informado');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('Consentimiento Informado.pdf');
?>