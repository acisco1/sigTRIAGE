<?= modules::run('Sections/Menu/index'); ?>
<style media="screen">
  .clic-box{
    cursor: pointer;
  }
  th, td{
    text-align: center;
  }
</style>
<div class="box-row">
  <div class="box-cell">
    <div class="box-inner col-md-12 col-centered" style="margin-top: 10px">
      <div class="panel panel-default">
        <div class="panel-heading back-imss" style="text-align: center; font-size: 15px;">
          Actividad del dia <?= date('d-m-Y') ?>
        </div>
        <div style="text-align: center; font-size: 160%;">
          <?php $url_color_estado = 'farmacovigilancia/Farmacologica/AsignarColorEstadoPrescripcion' ?>
          <div class="col-xs-4 clic-box btn_estado_prescripcion" data-value="1"  style="padding: 0px; background-color: <?=modules::run($url_color_estado,'1');?> ; color: rgb(140, 140, 102);">
            Pendientes <br> <?= count($Pendientes) ?>
          </div>
          <div class="col-xs-4 clic-box btn_estado_prescripcion"  data-value="2"  style="padding: 0px; background-color: <?=modules::run($url_color_estado,'2');?> ; color: green;">
            Activas <br> <?= count($Activas) ?>
          </div>
          <div class="col-xs-4 clic-box btn_estado_prescripcion"  data-value="0"  style="padding: 0px; background-color: <?=modules::run($url_color_estado,'0');?>; color: red;">
            Canceladas <br> <?= count($Canceladas) ?>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12" style="padding:20px; padding-right:50px;padding-left:50px;">

            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn btn-default dropdown-toggle back-imss" data-toggle="dropdown">
                  <i class="fa fa-vcard-o"></i> <label id="filtro_busqueda" style="height: 1px;">Filtro de busqueda</label>
                </button>
                <ul class="dropdown-menu back-imss">
                  <li><a class="op_filtro">Todos</a></li>
                  <li><a class="op_filtro">Nombre</a></li>
                  <li><a class="op_filtro">Folio</a></li>
                  <li><a class="op_filtro">Cama</a></li>
                  <li><a class="op_filtro">Area</a></li>
                  <li><a class="op_filtro">Medico</a></li>
                  <li><a class="op_filtro">Meicamento</a></li>
                </ul>
              </div>
              <input type="text" class="form-control" placeholder="Ingresar datos de busqueda">
            </div>
          </div>

        </div>
        <div class="table-responsive" style="padding-left:36px; padding-right: 36px;">
          <table class="table table-hover table-condensed table-bordered"
                 id="tb_pacientes" >
            <thead>
              <tr>
                <th>Folio</th>
                <th>Paciente</th>
                <th>Cama</th>
                <th>Area</th>
                <th>Medico</th>
                <th>Medicamento</th>
              </tr>
            </thead>
            <tbody id="tbl_paciente_prescripcion">
              <?php $contador = 0; ?>
              <?php foreach($PacientePrescripcionPendiente as $value){?>

                <tr class="fila_paciente" style="cursor: pointer" data-value="<?=$contador?>">
                  <td id="id_<?=$contador?>" style="background-color:<?=modules::run($url_color_estado,$value['estado']);?>;" ><?=$value['triage_id']?></td>
                  <td id="paciente_<?=$contador?>"><?=$value['triage_nombre'].' '.$value['triage_nombre_ap'] ?></td>
                  <td id="cama_<?=$contador?>"><?=$value['cama_nombre']?></td>
                  <td id="area_<?=$contador?>"><?=$value['area_nombre']?></td>
                  <td id="medico_<?=$contador?>"><?=$value['empleado_nombre'].' '.$value['empleado_apellidos']?></td>
                  <td id="medicamento_<?=$contador?>"><?=$value['medicamento']?></td>
                </tr>
              <?php $contador = $contador + 1; ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Farmacovigilancia.js?'). md5(microtime())?>" type="text/javascript"></script>
