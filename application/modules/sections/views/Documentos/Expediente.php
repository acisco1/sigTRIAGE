<?= modules::run('Sections/Menu/index'); ?>
<style>
  .li-hover:hover{
    background-color: #14322D;
  }
</style>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12 col-centered">
            <div class="panel panel-default " style="margin-top: 10px">
                <div class="panel-heading p teal-900 back-imss" style="padding-bottom: 0px;">
                    <div class="row" style="margin-top: -20px;">
                        <div style="position: relative">
                            <div style="top: 4px;position: absolute;height: 88px;width: 35px;left: -1px;" class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>"></div>
                        </div>
                        <div class="col-md-9" style="padding-left: 40px;">
                          <input hidden type="text" id="folioPaciente" value="<?=$info['triage_id']?>">
                            <h4>
                                <b>PACIENTE:  <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?> </b>
                            </h4>
                            <h4>
                                <?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| Posible Embarazo' : ''?>
                            </h4>
                            <h4 style="margin-top: -5px;text-transform: uppercase">
                                <?php
                                    if($info['triage_fecha_nac']!=''){
                                        $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                        if($fecha->y<15){
                                            echo 'PEDIATRICO';
                                        }if($fecha->y>15 && $fecha->y<60){
                                            echo 'ADULTO';
                                        }if($fecha->y>60){
                                            echo 'GERIATRICO';
                                        }
                                    }else{
                                        echo 'S/E';
                                    }
                                ?> | <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEA: '.$PINFO['pia_procedencia_espontanea_lugar'] : ': '.$PINFO['pia_procedencia_hospital'].' '.$PINFO['pia_procedencia_hospital_num']?> | <?=$info['triage_color']?>
                            </h4>
                        </div>
                        <div class="col-md-3 text-right">
                            <h4><b>EDAD</b></h4>
                            <h4 style="margin-top: -10px">
                                <?php
                                if($info['triage_fecha_nac']!=''){
                                    $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                    echo $fecha->y.' <span style="font-size:22px">Años</span>';
                                }else{
                                    echo 'S/E';
                                }
                                ?>
                            </h4>
                        </div>
                    </div>

                    <div class="card-tools" style="margin-top: 55px">

                        <ul class="list-inline">
                            <li class="dropdown">
                                <a md-ink-ripple data-toggle="dropdown" class="md-btn md-fab red md-btn-circle tip" data-original-title="Solicitar Documentos" data-placement="bottom">
                                    <i class="mdi-social-person-add i-24 " ></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up top text-color">
                                    <?php if(isset($_GET['url'])){?>
                                    <li class="disabled">
                                        <a href="#">NO PERMITIDO</a>
                                    </li>
                                    <?php }else{?>
                                    <?php if($_GET['tipo']=='Choque'){?>
                                    <li class="<?=$info['triage_fecha_clasifica']!='' ? 'disabled' :''?>">
                                        <a <?php if($info['triage_fecha_clasifica']==''){?>href="<?= base_url()?>Sections/Documentos/HojaClasificacion/<?=$this->uri->segment(4)?>/?tipo=<?=$_GET['tipo']?>" target="_blank" <?php }?>>Hoja de Clasificación</a>
                                    </li>
                                    <?php }?>
                                    <?php if(!empty($DocumentosHoja) && !isset($_GET['via'])){?>
                                    <?php if($this->ConfigHojaInicialAbierta=='No'){?>
                                    <li class="<?=!empty($HojasFrontales)  ? 'disabled' :''?>">
                                        <a <?php if(empty($HojasFrontales)){?>href="<?= base_url()?>Sections/Documentos/HojaFrontal?hf=0&a=add&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>" target="_blank" <?php }?>>Generar Inicial(Hoja Frontal)</a>
                                    </li>
                                    <?php }else{?>
                                    <li class="<?=!empty($HojasFrontales)  ? 'disabled' :''?>">
                                        <a <?php if(empty($HojasFrontales)){?>href="<?= base_url()?>Sections/Documentos/HojaInicialAbierto?hf=0&a=add&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>" target="_blank" <?php }?>>Generar Inicial(Hoja Frontal)</a>
                                    </li>
                                    <?php }?>

                                    <?php }?>
                                    <?php if(!empty($DocumentosNotas)){?>
                                    <li class="">
                                        <a onclick="AbrirVista(base_url+'Sections/Documentos/Notas/0/?a=add&folio=<?=$this->uri->segment(4)?>&via=<?=$_GET['via']?>&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>',1100)" >Generar Nueva Nota Médica</a>
                                    </li>
                                    <?php }?>
                                    <?php }?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 0px">
                            <style>th,td{padding-left: 5px!important;padding-right: 0px!important;}</style>
                            <!-- Inicio navegador para seleccion de tipo de documento -->
                            <ul class="nav navbar-nav back-imss width100 table-hover">
                              <li class="li-hover"><a href="#" id="btnNotasTriage">Notas Triage</a></li>
                              <li class="li-hover"><a href="#">Hoja Clasificación</a></li>
                              <li class="li-hover"><a href="#">Hoja Inicial</a></li>
                              <li class="li-hover"><a href="#">Nota Medica</a></li>
                              <li class="li-hover"><a href="#" id="btnExpedientePrescripcion">Prescripcion</a></li>
                              <li class="li-hover"><a href="#">Imagenología</a></li>
                              <li class="li-hover"><a href="#">Estudio de laboratorio</a></li>
                            </ul>
                            <!-- Tabla con el listado de documentos del paciente -->
                            <table class="table table-bordered table-hover footable">
                              <thead id="cabezaTablaExpediente">

                              </thead>
                              <tbody id="cuerpoTablaExpediente">

                              </tbody>
                            </table>
                            <table  id="tablaNotasTriage" class="table table-bordered table-hover footable"  >
                                <thead>
                                    <tr>
                                        <th style="width: 15%;" data-sort-ignore="true">FECHA & HORA</th>
                                        <th style="width: 22%" data-sort-ignore="true">TIPO</th>
                                        <th style="width: 22%" data-sort-ignore="true">ÁREA</th>
                                        <th style="width: 30%" data-sort-ignore="true">MÉDICO</th>
                                        <th style="width: 10%" data-sort-ignore="true">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($info['triage_fecha_clasifica']!=''):?>
                                    <tr>
                                        <td>
                                            <?php if($info['triage_color']!=''){?>
                                            <?=$info['triage_fecha_clasifica']?> <?=$info['triage_hora_clasifica']?>
                                            <?php }else{?>
                                            No Aplica
                                            <?php }?>
                                        </td>
                                        <td>Hoja de Clasificación</td>
                                        <td>Médico Triage</td>
                                        <td>
                                            <?php $sqlMedicoClass=$this->config_mdl->sqlGetDataCondition('os_empleados',array(
                                                'empleado_id'=>$info['triage_crea_medico']
                                            ),'empleado_nombre, empleado_apellidos')[0];?>
                                            <?=$sqlMedicoClass['empleado_nombre']?> <?=$sqlMedicoClass['empleado_apellidos']?>
                                        </td>

                                        <td>
                                            <?php if($info['triage_color']!=''){?>
                                            <i class="fa fa-file-pdf-o icono-accion pointer tip" data-original-title='Generar Hoja de Clasificación' onclick="AbrirDocumento(base_url+'Inicio/Documentos/Clasificacion/<?=$this->uri->segment(4)?>/?via=<?=$_GET['tipo']?>')"></i>
                                            <?php }else{?>
                                            No Aplica
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php endif;?>
                                    <?php foreach ($HojasFrontales as $value) {?>
                                    <tr>
                                        <td><?=$value['hf_fg']?> <?=$value['hf_hg']?></td>
                                        <td>Hoja Inicial(Hoja Frontal) & ST7</td>
                                        <td>NO APLICA</td>
                                        <td><?= Modules::run('Sections/Documentos/ExpedienteEmpleado',array('empleado_id'=>$value['empleado_id']))?></td>
                                        <td>
                                            <?php if($this->ConfigHojaInicialAbierta=='No'){?>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/HojaFrontalCE/<?=$value['triage_id']?>')" data-original-title="Generar Hoja Frontal"></i>
                                            &nbsp;
                                            <?php }else{?>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/HojaInicialAbierto/<?=$value['triage_id']?>')" data-original-title="Generar Hoja Frontal"></i>
                                            &nbsp;
                                            <?php }?>

                                            <?php if($PINFO['pia_lugar_accidente']=='TRABAJO'):?>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/ST7/<?=$value['triage_id']?>')" data-original-title="Generar ST7"></i>
                                            &nbsp;
                                            <?php endif;?>
                                            <?php if($_GET['via']!='paciente'){?>
                                            <?php if($value['empleado_id']==$_SESSION['UMAE_USER'] || $obs['observacion_medico']==$_SESSION['UMAE_USER']){?>
                                            <?php if($this->ConfigHojaInicialAbierta=='No'){?>
                                            <a href="<?=  base_url()?>Sections/Documentos/HojaFrontal?hf=<?=$value['hf_id']?>&a=edit&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>" target="_blank">
                                                <i class="fa fa-pencil icono-accion"></i>
                                            </a>&nbsp;
                                            <?php }else{?>
                                            <a href="<?=  base_url()?>Sections/Documentos/HojaInicialAbierto?hf=<?=$value['hf_id']?>&a=edit&folio=<?=$this->uri->segment(4)?>&tipo=<?=$_GET['tipo']?>" target="_blank">
                                                <i class="fa fa-pencil icono-accion"></i>
                                            </a>&nbsp;
                                            <?php }?>
                                            <?php }?>
                                            <i class="fa fa-trash-o icono-accion pointer" style="opacity: 0.4"></i>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php foreach ($NotasAll as $value) {?>
                                    <tr>
                                        <td><?=$value['notas_fecha']?> <?=$value['notas_hora']?></td>
                                        <td>
                                            <?=$value['notas_tipo']?>
                                        </td>
                                        <td><?=$value['notas_area']?></td>
                                        <td><?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?></td>

                                        <td>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/GenerarNotas/<?=$value['notas_id']?>?inputVia=<?=$_GET['tipo']?>')" data-original-title="Generar <?=$value['notas_tipo']?>"></i>
                                            &nbsp;
                                            <?php if($value['empleado_id']==$_SESSION['UMAE_USER']){?>
                                                <a onclick="AbrirVista(base_url+'Sections/Documentos/Notas/<?=$value['notas_id']?>/?a=edit&TipoNota=<?=$value['notas_tipo']?>&folio=<?=$this->uri->segment(4)?>&via=<?=$_GET['via']?>&doc_id=<?=$_GET['doc_id']?>&inputVia=<?=$_GET['tipo']?>',1100)">
                                                    <i class="fa fa-pencil icono-accion"></i>
                                                </a>&nbsp;

                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php if($_GET['tipo']=='Observación' || $_GET['tipo']=='Consultorios' ){?>
                                    <tr>
                                        <td>NO APLICA</td>
                                        <td>Consentimiento informado para el ingreso al área de Observacion-Urgencias</td>
                                        <td>NO APLICA</td>
                                        <td>NO APLICA</td>
                                        <td>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/ConsentimientoInformadoIngresoObs/<?=$this->uri->segment(4)?>')" data-original-title="Generar Documento"></i>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php if($_GET['tipo']=='Choque'  ){?>
                                    <tr>
                                        <td>NO APLICA</td>

                                        <td>Consentimiento informado para el ingreso al área de Choque-Urgencias</td>
                                        <td>NO APLICA</td>
                                        <td>NO APLICA</td>
                                        <td>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/ConsentimientoInformadoIngresoObs/<?=$this->uri->segment(4)?>')" data-original-title="Generar Documento"></i>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php foreach ($AvisoMp as $AvisoMp) {?>
                                    <tr>
                                        <td><?=$AvisoMp['mp_fecha']?> <?=$AvisoMp['mp_hora']?></td>
                                        <td>Documento de Avisto al Ministerio Público</td>
                                        <td>NO APLICA</td>
                                        <td><?=$AvisoMp['empleado_nombre']?> <?=$AvisoMp['empleado_apellidos']?></td>
                                        <td>
                                            <i class="fa fa-file-pdf-o icono-accion tip pointer" onclick="AbrirDocumento(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/<?=$this->uri->segment(4)?>')" data-original-title="Generar Documento"></i>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table> <!-- Fin tabla listado de documentos paciente -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/os/observacion.js')?>" type="text/javascript"></script>
<script>
    <?php if(isset($_GET['reload_inter'])){?>
        window.opener.location.reload();
        window.top.close();
    <?php }?>
</script>
