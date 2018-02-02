<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12">   
            <div class="panel panel-default" style="margin-top: 10px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">MÉDICO OBSERVACIÓN</span>
                    
                </div>
                <div class="panel-body b-b b-light">
                    <div class="" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group m-b ">
                                    <span class="input-group-addon back-imss border-back-imss" >
                                        <i class="fa fa-user-plus"></i>
                                    </span>
                                    <input type="text" class="form-control" name="triage_id" placeholder="Ingresar N° de Folio">
                                </div>
                            </div>
                            <div class="col-md-offset-2 col-md-4">
                                <div class="input-group m-b ">
                                    <span class="input-group-addon back-imss border-back-imss" >
                                        <i class="fa fa-search"></i></span>
                                    <input type="text" class="form-control" id="filter" placeholder="Filtro General">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 0px">
                                <table class="table footable table-bordered table-hover table-no-padding"   data-limit-navigation="10" data-filter="#filter" data-page-size="10">
                                    <thead>
                                        <tr>
                                            <th>N° DE FOLIO</th>
                                            <th style="width: 30%">NOMBRE DEL PACIENTE</th>
                                            <th>INGRESO</th>
                                            <th style="width: 15%">CAMA</th>
                                            <th >ESTATUS</th>
                                            <th style="width: 15%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Gestion as $value) {?>
                                        <tr>
                                            <td><?=$value['triage_id']?></td>
                                            <td><?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?></td>
                                            <td><?=$value['observacion_mfa']?> <?=$value['observacion_mha']?></td>
                                            <td><?=($sql_cama['cama_nombre']=='' ? 'No Asignado' : $sql_cama['cama_nombre'])?></td>
                                            <td>
                                                <?=$value['observacion_status_v2']?>
                                                <?php if($value['observacion_status_v2']=='Interconsulta'){
                                                    echo '<br>';
                                                    $sqlInterconsulta=$this->config_mdl->_get_data_condition('doc_430200',array(
                                                        'triage_id'=>$value['triage_id'],
                                                        'doc_modulo'=>'Observación'
                                                    ));
                                                    $Total= count($sqlInterconsulta);
                                                    $Evaluados=0;
                                                    foreach ($sqlInterconsulta as $value_st) {
                                                ?>
                                                        <?php 
                                                        if($value_st['doc_estatus']=='En Espera'){
                                                        ?>
                                                        <span class="label amber pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/DOC430200/<?=$value_st['doc_id']?>')"><?=$value_st['doc_servicio_solicitado']?></span><br>
                                                        
                                                        <?php   
                                                        }else{
                                                            $Evaluados++;
                                                        ?>
                                                           
                                                        <a href="<?= base_url()?>Consultoriosespecialidad/InterconsultasDetalles?inter=<?=$value_st['doc_id']?>" target="_blank">
                                                            <span class="label green"><?=$value_st['doc_servicio_solicitado']?></span>
                                                        </a>
                                                        <br>
                                                        <?php
                                                        }

                                                    }
                                                }?>
                                            </td>
                                            <td >
                                                <i class="fa fa-reply-all icono-accion tip interconsulta-paciente pointer" data-ce="<?=$value['ce_id']?>" data-consultorio="<?=$_SESSION['OBSERVACION_SERVICIO_ID']?>;<?=$_SESSION['OBSERVACION_SERVICIO_NOMBRE']?>" data-id="<?=$value['triage_id']?>" data-original-title="Interconsulta"></i>&nbsp;
                                                <a href="<?= base_url()?>Sections/Documentos/Expediente/<?=$value['triage_id']?>/?tipo=Observación" target="_blank">
                                                    <i class="fa fa-pencil-square-o icono-accion"></i>
                                                </a>&nbsp;
                                                <a href="<?= base_url()?>Sections/Documentos/TratamientoQuirurgico/<?=$value['triage_id']?>" target="_blank">
                                                    <i class="fa fa-medkit icono-accion tip" data-original-title="Requiere tratamiento quirúrgico"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot class="hide-if-no-paging">
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <ul class="pagination"></ul>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    <input type="hidden" name="observacion_alta">
                    <input type="hidden" name="accion_area_acceso" value="Observación">
                    <input type="hidden" name="accion_rol" value="Médico">
                    <input type="hidden" name="empleado_servicio" value="<?=$info['empleado_servicio']?>">
                </div>
                </div>
                
            </div>
            
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Observacion.js?'). md5(microtime())?>" type="text/javascript"></script>