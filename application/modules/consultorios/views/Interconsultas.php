<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12" style="margin-top: -20px">
            <div class="panel panel-default ">

                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">INTERCONSULTAS</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row ">
                        <div class="col-md-6">
                            <label class="md-check" style="margin-top: 8px" onclick="location.href=base_url+'Consultorios/ObtenerServicioInterconsulta?Interconsultas=Solicitadas'">
                                <input type="radio" name="radio" class="has-value" <?=$_GET['Interconsultas']=='Solicitadas'? 'checked':''?>>
                                <i class="indigo"></i>MÉDICO INTERCONSULTANTE
                            </label>
                            &nbsp;&nbsp;
                            <label class="md-check" onclick="location.href=base_url+'Consultorios/Interconsultas?Interconsultas=Realizadas'">
                                <input type="radio" name="radio" class="has-value" <?=$_GET['Interconsultas']=='Realizadas'? 'checked':''?>>
                                <i class="indigo"></i>MEDICO TRATANTE
                            </label>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <div class="input-group m-b ">
                                <input type="text" class="form-control" id="TriageIdFilter" placeholder="Buscar...">
                                <span class="input-group-addon back-imss no-border" ><i class="fa fa-user-plus"></i></span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover footable" data-filter="#TriageIdFilter" data-limit-navigation="7"data-page-size="10">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">PACIENTE</th>
                                        <th>ENVIO</th>
                                        <th>ÁREA QUE ENVIA</th>
                                        <th>ÁREA SOLICITADA</th>
                                        <th>MOTIVO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Gestion as $value) {?>
                                    <tr id="<?=$value['triage_id']?>" >
                                        <td class=""  style="font-size: 10px;width: 13%">
                                            <?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
                                        </td>
                                        <td style="width: 16%"><?=$value['doc_fecha']?> <?=$value['doc_hora']?></td>
                                        <td style="width: 18%;text-align: center">
                                            <?=$value['esp_nom2']?><br>
                                            (<?=$value['doc_modulo']?>)
                                        </td>
                                        <td style="width: 18%;text-align: center"><?=$value['esp_nom1']?></td>
                                        <td style="width: 15%" class="ver-texto pointer" data-content-title="DIAGNOSTICO" data-content-text="<?=$value['motivo_interconsulta']?>">
                                            <?= substr($value['motivo_interconsulta'], 0,20)?>...
                                        </td>
                                        <td >

                                            <?php if($value['doc_estatus']=='En Espera'){?>
                                                <?php if($value['empleado_envia']!=$this->UMAE_USER){?>
                                                <a href="<?=  base_url()?>Sections/Documentos/Notas/0/?a=add&TipoNota=Nota de Valoracion&folio=<?=$value['triage_id']?>&via=Interconsulta&doc_id=<?=$value['doc_id']?>" target="_blank">
                                                    <i class="fa fa-pencil-square-o icono-accion tip" data-original-title="Realizar Nota de Valoración"></i>
                                                </a>&nbsp;
                                                <?php }?>
                                            <?php }?>
                                            <a href="<?=  base_url()?>Sections/Documentos/Expediente/<?=$value['triage_id']?>/?tipo=Consultorios&url=Enfermeria" target="_blank">
                                                <i class="fa fa-share-square-o icono-accion tip" data-original-title="VER EXPEDIENTE"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
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
                </div>


            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>

<script src="<?= base_url('assets/js/Consultorios.js?'). md5(microtime())?>" type="text/javascript"></script>
