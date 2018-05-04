<?= modules::run('Sections/Menu/index'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-11 col-centered" style="margin-top: 10px ">
            <div class="box-inner">
               <style type="text/css">
                fieldset.scheduler-border {
                border: solid 1px #DDD !important;
                padding: 0 10px 10px 10px;
                border-bottom: none;
            }

            legend.scheduler-border {
                width: auto !important;
                border: none;
            font-size: 14px;
            }
              .text-on-pannel {
              background: #fff none repeat scroll 0 0;
              height: auto;
              margin-left: 20px;
              padding: 3px 5px;
              position: absolute;
              margin-top: -47px;
              border: 1px solid #337ab7;
              border-radius: 8px;
            }

            /*    .panel {
            /* for text on pannel
            margin-top: 27px !important;
            } */

            .panel-body {
            padding-top: 30px !important;
            }

            .scroll-box {
            position: relative;
            }
            .scrollspy-body {
                position: relative;
                overflow-y: scroll;
                height: 520px;
            }
                #modalTamanioT {
                    width: 80% !important;
                }
                #modalTamanioG {
                    width: 67% !important;
                }
                td,th{
                  text-align: center;
                  border-bottom: 1px solid #ddd;
                  color: black;
                }
                .label-input{
                  text-align: center;
                  border:none;
                  background:none;
                  margin:0;
                  outline:0;
                  width: 100%;
                }
            </style>
                <?php if($SignosVitales['sv_ta']==''){?>
                <div class="row " style="margin-top: -10px;padding: 16px;">
                    <div class="col-md-12 col-centered back-imss" style="padding:10px;margin-bottom: -7px;">
                        <h6 style="font-size: 20px;text-align: center">
                            <b>EN ESPERA DE CAPTURA DE SIGNOS VITALES</b>
                        </h6>
                    </div>
                </div>
                <?php } else{ ?>
                <div class="row " style="margin-top: -30px;padding: 16px;">
                    <div class="col-md-12 col-centered " style="padding: 0px;margin-bottom: -7px;">
                        <h6 style="font-size: 8px;text-align: right">
                            FECHA Y HORA DE REGISTRO:
                            <b>
                                <span style="font-size: 12px">
                                <?=$info['triage_horacero_f']?> <?=$info['triage_horacero_h']?>
                                </span>
                            </b>
                        </h6>
                    </div>
                    <div class="panel-heading p teal-900 back-imss" style="padding-bottom: 6px;">
                        <span style="font-size: 18px;font-weight: 500;text-transform: uppercase">
                            <div class="row" style="margin-top: -20px;">
                                <div style="position: relative">
                                    <div style="top: 4px;margin-left: -1px;position: absolute;height: 80px;width: 35px;" class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>"></div>
                                </div>
                                <div class="col-md-10" style="padding-left: 40px">
                                    <h4>

                                        <b>PACIENTE:  <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?></b>
                                    </h4>
                                    <h5>
                                        <?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| Posible Embarazo' : ''?>
                                    </h5>
                                    <h5 style="margin-top: -5px;text-transform: uppercase">
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
                                    </h5>
                                </div>
                                <div class="col-md-2 text-right">
                                    <h5>
                                        <b>EDAD</b>
                                    </h5>
                                    <h3 style="margin-top: -10px">
                                        <?php
                                        if($info['triage_fecha_nac']!=''){
                                            $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                            echo $fecha->y.' <span style="font-size:20px"><b>Años</b></span>';
                                        }else{
                                            echo 'S/E';
                                        }
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
                <?php }?>

                <div class="panel panel-default " style="margin-top: -16px">
                    <div class="col-md-2 text-center back-imss" style="padding-left: 0px;padding: 5px;">
                        <h5 class=""><b>P.A</b></h5>
                        <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_ta']?></h4>
                    </div>
                    <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
                        <h5><b>TEMP.</b></h5>
                        <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_temp']?> °C</h4>
                    </div>
                    <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
                        <h5><b>FREC. CARD. </b></h5>
                        <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_fc']?> (lpm)</h4>
                    </div>
                    <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
                        <h5><b>FREC. RESP</b></h5>
                        <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_fr']?> (rpm)</h4>
                    </div>
                    <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
                        <h5><b>SpO2</b></h5>
                        <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_oximetria']?> (%)</h4>
                    </div>
                    <div class="col-md-2  text-center back-imss" style="border-left: 1px solid white;padding: 5px;">
                        <h5><b>GLUCEMIA</b></h5>
                        <h4 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_dextrostix']?> (mg/dL)</h4>
                    </div>
                    <div class="panel-body b-b b-light">
                        <div class="card-body" style="padding: 20px 0px;">
                            <form class="guardar-solicitud-hi-abierto" style="margin-top: 45px" oninput="x.value=parseInt(hf_eva.value)">
                                <div class="row" >
                                    <div class="col-md-12 hide">
                                        <div class="input-group m-b">
                                            <span class="input-group-addon">FORMATO DE HOJA FRONTAL</span>
                                            <select class="form-control" name="hf_documento">
                                                <option value="HOJA FRONTAL 4 30 128" selected="">HOJA FRONTAL 4 30 128</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                       <h4><span class = "label back-imss border-back-imss">MOTIVO DE CONSULTA</span></h4>                      <textarea class="form-control hf_motivo_abierto" rows="5" name="hf_motivo" placeholder="Escriba aquí el Motivo de la consulta"><?=$hojafrontal[0]['hf_motivo']?>
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                           <h4><span class = "label back-imss border-back-imss">ANTECEDENTES</span></h4>
                                            <textarea class="form-control hf_antecedentes" rows="6" name="hf_antecedentes" placeholder="Escriba aquí los antecedentes"><?=$hojafrontal[0]['hf_antecedentes']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <h4><span class = "label back-imss border-back-imss">PADECIMIENTO ACTUAL</span></h4>
                                            <textarea class="form-control" rows="5" name="hf_padecimientoa" placeholder="Escriba aquí el/los pacedimiento actual"><?=$hojafrontal[0]['hf_padecimientoa']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <h4><span class = "label back-imss border-back-imss">EXPLORACIÓN FISICA</span></h4>
                                            <textarea class="form-control" rows="8" name="hf_exploracionfisica"><?=$hojafrontal[0]['hf_exploracionfisica']?></textarea>
                                        </div>
                                    </div>
                                </div>
                    <div class="row">
                    <div class="col-md-3">
<!-- Glasgow -->      <label><b>ESCALA DE GLASGOW</b></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-toggle="modal" data-target='#myModal1' placeholder="Clic para valor" name="hf_escala_glasgow" value="<?=$hojafrontal[0]['hf_escala_glasgow']?>">
                                <span class="input-group-addon">Puntos</span>
                            </div>
                    </div>

 <!-- Modal Escala de glasgow -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" id="modalTamanioG">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Puntuación de la Escala de Glasgow</h4>
      </div>
      <div class="modal-body">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border"><b>APERTURA OCULAR</b></legend>
                <div class="form-group">
                    <label class="md-check">
                        <input type="checkbox" class='sum' name="hf_glasgow_expontanea" value="4" data-value="<?=$hojafrontal[0]['hf_glasgow_expontanea']?>" class="has-value"><i class="indigo"></i>Espontánea</label>&nbsp;&nbsp;
                    <label class="md-check">
                    <input type="checkbox" class='sum' name="hf_glasgow_hablar" value="3" data-value="<?=$hojafrontal[0]['hf_glasgow_hablar']?>" class="has-value"><i class="indigo"></i>Hablar</label>&nbsp;&nbsp;
                    <label class="md-check">
                    <input type="checkbox" class='sum' name="hf_glasgow_dolor" value="2" data-value="<?=$hojafrontal[0]['hf_glasgow_dolor']?>" class="has-value"><i class="indigo"></i>Dolor</label>&nbsp;&nbsp;
                    <label class="md-check">
                    <input type="checkbox" class='sum' name="hf_glasgow_ausente" value="1" data-value="<?=$hojafrontal[0]['hf_glasgow_ausente']?>" class="has-value"><i class="indigo"></i>Ausente</label>
                </div>
        </fieldset>
        <fieldset class="scheduler-border">
            <legend class="scheduler-border"><B>RESPUESTA MOTORA</B></legend>
                <div class="form-group">
                    <label class="md-check">
                        <input type="checkbox" class='sum' name="hf_glasgow_obedece" value="6" data-value="<?=$hojafrontal[0]['hf_glasgow_obedece']?>" class="has-value"><i class="indigo"></i>Obedece</label>&nbsp;&nbsp;
                        <label class="md-check">
                        <input type="checkbox" class='sum' name="hf_glasgow_localiza" value="5" data-value="<?=$hojafrontal[0]['hf_glasgow_localiza']?>" class="has-value"><i class="indigo"></i>Localiza</label>&nbsp;&nbsp;
                        <label class="md-check">
                        <input type="checkbox" class='sum' name="hf_glasgow_retira" value="4" data-value="<?=$hojafrontal[0]['hf_glasgow_retira']?>" class="has-value"><i class="indigo"></i>Retira</label>
                        <label class="md-check">
                        <input type="checkbox" class='sum' name="hf_glasgow_flexion" value="3" data-value="<?=$hojafrontal[0]['hf_glasgow_flexion']?>" class="has-value"><i class="indigo"></i>Flexión normal</label>&nbsp;&nbsp;
                        <label class="md-check">
                        <input type="checkbox" class='sum' name="hf_glasgow_extension" value="2" data-value="<?=$hojafrontal[0]['hf_glasgow_extension']?>" class="has-value"><i class="indigo"></i>Extensión anormal</label>&nbsp;&nbsp;
                        <label class="md-check">
                        <input type="checkbox" class='sum' name="hf_glasgow_ausencia" value="1" data-value="<?=$hojafrontal[0]['hf_glasgow_ausencia']?>" class="has-value"><i class="indigo"></i>Ausencia de repuesta</label>
                </div>
        </fieldset>
        <fieldset class="scheduler-border">
            <legend class="scheduler-border"><b>RESPUESTA VERBAL</b></legend>
                <div class="form-group">
                    <label class="md-check">
                    <input type="checkbox" class='sum' name="hf_glasgow_orientado" value="5" data-value="<?=$hojafrontal[0]['hf_glasgow_orientado']?>" class="has-value"><i class="indigo"></i>Orientado&nbsp;&nbsp;</label>
                    <label class="md-check">
                    <input type="checkbox" class='sum' name="hf_glasgow_confuso" value="4" data-value="<?=$hojafrontal[0]['hf_glasgow_confuso']?>" class="has-value"><i class="indigo"></i>Confuso&nbsp;&nbsp;</label>
                    <label class="md-check">
                    <input type="checkbox" class='sum' name="hf_glasgow_incoherente" value="3" data-value="<?=$hojafrontal[0]['hf_glasgow_incoherente']?>" class="has-value"><i class="indigo"></i>Incoherente&nbsp;&nbsp;</label>
                    <label class="md-check">
                    <input type="checkbox" class='sum' name="hf_glasgow_sonidos" value="2" data-value="<?=$hojafrontal[0]['hf_glasgow_sonidos']?>" class="has-value"><i class="indigo"></i>Sonidos Incomprensibles&nbsp;&nbsp;</label>
                    <label class="md-check">
                    <input type="checkbox" class='sum' name="hf_glasgow_arespuesta" value="1" data-value="<?=$hojafrontal[0]['hf_glasgow_arespuesta']?>" class="has-value"><i class="indigo"></i>Ausencia de respuesta</label>
                </div>

                    <div class="form-group">PUNTUACIÓN TOTAL: &nbsp;<input type="text" name="hf_escala_glasgow" size="3" data-value="<?=$hojafrontal[0]['hf_escala_glasgow']?>" disable></div>
        </fieldset>
    </div> <!-- div del cuerpo del modal -->
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
    </div>
  </div>
 </div>
</div>
<!-- Riesgo caida -->        <div class="col-md-3">
                        <div class="form-group">
                                            <b>RIESGO DE CAÍDA</b><br>
                                            <label class="md-check">
                                            <input type="radio" name="hf_riesgocaida" data-value="<?=$hojafrontal[0]['hf_riesgocaida']?>" value="Alta" class="has-value"><i class="red"></i>Alta
                                            </label>&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                            <input type="radio" name="hf_riesgocaida" data-value="<?=$hojafrontal[0]['hf_riesgocaida']?>" value="Media" class="has-value"><i class="red"></i>Media
                                            </label>&nbsp;&nbsp;
                                            <label class="md-check">
                                            <input type="radio" name="hf_riesgocaida" data-value="<?=$hojafrontal[0]['hf_riesgocaida']?>" value="Baja" class="has-value"><i class="red"></i>Baja
                                            </label>
                        </div>
                    </div>
<!-- EVA -->                 <div class="col-md-3">
                        <div class="form-group">
                            <label><b>ESCALA DE DOLOR (EVA)</b></label><br>
                            <div class="row">
                            <div class="col-sm-6">
                             <input type="range" name="hf_eva" value="<?=$hojafrontal['hf_eva']?>" min="0" max="10" value="0">
                            </div>
                            <div class="col-sm-6" style="width:10px;height:30px;border:1px solid blue;">
                                <output name="x" for="hf_eva"><?=$hojafrontal['hf_eva']?></output>
                            </div>
                            </div>
                        </div>
                    </div>
<!-- Riesgo de trombosis --> <div class="col-md-3">
                        <label><b>RIESGO DE TROMBOSIS</b></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-toggle="modal" data-target='#myModal2' placeholder="Clic para colocar valor" name="hf_riesgo_trombosis" id="puntos_rt" value='<?=$hojafrontal[0]['hf_riesgo_trombosis']?>'>
                            </div>
                    </div>

    <!-- Modal Riesgo de Trombosis -->

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modalTamanioT">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="myModalLabel">Escala Para Evaluar El Riesgo de Trombosis</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                        <div class="col-md-4">
                            <label><b>SELECCIONAR SEXO</b></label>
                            <div class="radio">
                                <label><input type="radio" name="rt_sexo" value="m">Masculino</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input type="radio" name="rt_sexo" value="f">Femenino</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <label><b>EDAD</b></label>
                        <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="1">Entre 40-60 años. <b>(1 pto).</b></label></div>
                        <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="2">Entre 61-74 años. <b>(2 ptos).</b></label></div>
                        <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="3">75 años o más. <b>(3 ptos).</b></label></div>
                        </div>
                        <div class="col-md-4 col-mujer hidden">
                            <div class="checkbox">
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt4" value="1">Uso de terapia de remplazo hormonal. <b>(1 pto)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt5" value="1">Embarazo o parto en el último mes. <b>(1 pto)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt6" value="1">Historia de muerte inexplicable de recién nacidos, abortos expontáneos (más de 3), hijos prematuros o con restricción del crecimento. <b>(1 pto)</b></label>
                            </div>
                        </div>
                    <div class="col-md-4">
                        <label><b>CIRUGÍAS</b></label>
                        <div class="checkbox">
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt7" value="1">Cirugía menor prevista (≤ 45 minutos). <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt8"  value="1">Antecedentes de cirugía mayor (≥ 45 minutos) en el último mes. <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt9" value="2">Cirugía mayor a 45 minutos (incluyendo laparoscopía o artroscopia). <b>(2 ptos)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt10" value="5">Cirugía de remplazo de cadera o rodilla. <b>(5 ptos)</b></label></div>
                    </div>
                    <div class="col-md-4">
                        <label><b>HISTORIA DE...</b></label>
                        <div class="checkbox">
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt11" value="3">Historia de trombosis, trombosis venosa profunda (TVP) o tromboembolia pulmonar (TEP). <b>(3 ptos)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt12" value="3">Historia familiar de trombosis. <b>(3 ptos)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt13" value="3">Historia familiar o personal de pruebas de sangre positivas que indican incremento en el riesgo de trombosis. <b>(3 ptos)</b></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label><b>ANTECEDENTES CON MENOS DE 1 MES</b></label>
                        <div class="checkbox">
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt14" value="1">Infarto de miocardio ( ≤ 1 mes). <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:left"><input type="checkbox" class="suma_rt" name="rt15" value="1">Insuficiencia cardiaca congestiva ( ≤ 1 mes). <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt16" value="1">Infección grave (neumonía) ( ≤ 1 mes). <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt17" value="1">Enfermedad pulmonar (Enfisema o EPOC). ( ≤ 1 mes) <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt18" value="1">Transfusión  sanguínea ( ≤ 1 mes). <b>(1 pto)</b></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label><b>COMORBILIDADES</b></label>
                        <div class="checkbox">
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt19" value="1">Historia de enfermedad inflamatoria intestinal (CUCI o Crohn). <b>(1 pto)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt20" value="2">Antecedente de cáncer (excluyendo cáncer de piel, no melanoma). <b>(2 ptos)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt21" value="1">Obesidad (índice de masa corporal ≥ de 30 y ≤ de 40). <b>(1 pto)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt22" value="2">Obesidad mórbida (índice de masa corporal mayor a 40). <b>(2 ptos)</b></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <label><b>ORTOPEDIA Y TRAUMATISMOS</b></label>
                        <div class="checkbox">
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt23" value="5">Fractura de cadera pelvis o pierna. <b>(5 ptos)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt24" value="5">Traumatismo grave (accidente automovilístico, fracturas múltiples). <b>(5 ptos)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt25" value="5">Lesión de la médula espinal con parálisis. <b>(5 ptos)</b></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label><b>EXPLORACIÓN</b></label>
                        <div class="checkbox">
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt26" value="1">Venas varicosas visibles. <b>(1 pto)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt27" value="1">Edema de piernas. <b>(1 pto)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt28" value="2">Inmovilizador o yeso en miembros inferiores que no permite movilización en el último mes. <b>(2 ptos)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt29" value="2">Catéter en vasos sanguíneos del cuello o tórax que lleva sangre o medicamentos al corazón en el último mes. <b>(2 ptos)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt30" value="2">Confinado en cama por  72 horas o más. <b>(2 ptos)</b></label>
                        </div>
                    </div>
                </div>
            </div> <!-- modal-body  de riesgo de trombosis-->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
                </div> <!-- cierre de fila de escalas medicas -->
                <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                           <h4><span class = "label back-imss border-back-imss">MÉTODOS AUXILARES DE DIAGNÓSTICO</span></h4>
                            <textarea class="form-control" rows="2" name="hf_auxiliares" placeholder="Anote los análisis clínicos de laboratorio, los estudios de gabinete radiológico y otros"><?=$hojafrontal[0]['hf_auxiliares']?></textarea>
                        </div>
                        <div class="form-group">
                           <h4><span class = "label back-imss border-back-imss">DIAGNÓSTICO DE INGRESO</span></h4>
                            <textarea class="form-control hf_textarea" rows="3" name="hf_diagnosticos_lechaga" required><?=$hojafrontal[0]['hf_diagnosticos_lechaga']?></textarea>
                         </div>
                        <div class="form-group">
                            <h4><span class = "label back-imss border-back-imss">DIAGNÓSTICOS SECUNDARIOS (COMORBILIDADES)</span></h4>
                            <i class="fa fa-plus-circle pointer plantilla-add icono-accion" onclick="AbrirDocumento(base_url+'Sections/Plantillas/SeleccionarContenido?plantilla=Diagnosticos&input=hf_diagnosticos&type=textarea')"></i>
                            <textarea class="form-control hf_diagnosticos" rows="10" name="hf_diagnosticos"><?=$hojafrontal[0]['hf_diagnosticos']?></textarea>
                        </div>
                        <div class="form-group">
                            <h4><span class = "label back-imss border-back-imss">PLAN Y ORDENES MÉDICAS</span></h4>

                              <div class="col-sm-12" id="divNutricion" style="padding:0">
                                  <div class="col-sm-3" style="padding:0" id="divRadioNutricion">
                                    <label><b>a) Instrucciones de nutricion:</b></label>
                                    <?php
                                    // Declara estado original del radio cuando se realiza nueva nota
                                    $checkAyuno = '';
                                    $checkDieta = '';
                                    $divSelectDietas = 'hidden';
                                    $select_dietas = '0';
                                    $otraDieta = '';
                                    $divOtraDieta = 'hidden';
                                    if($_GET['a'] == 'edit'){
                                      if($Nota['nota_nutricion'] == '0'){
                                        $checkAyuno = 'checked';
                                      }else if($Nota['nota_nutricion'] == '1' || $Nota['nota_nutricion'] == '2'
                                      || $Nota['nota_nutricion'] == '3'|| $Nota['nota_nutricion'] == '4'|| $Nota['nota_nutricion'] == '5'
                                      || $Nota['nota_nutricion'] == '6'|| $Nota['nota_nutricion'] == '7'|| $Nota['nota_nutricion'] == '8'
                                      || $Nota['nota_nutricion'] == '9'|| $Nota['nota_nutricion'] == '10'|| $Nota['nota_nutricion'] == '11'
                                      || $Nota['nota_nutricion'] == '12'){
                                        $checkDieta = 'checked';
                                        $divSelectDietas = '';
                                        $select_dietas = $Nota['nota_nutricion'];
                                      }else{
                                        $divSelectDietas = '';
                                        $checkDieta = 'checked';
                                        $divOtraDieta = '';
                                        $select_dietas = '13';
                                        $otraDieta = $Nota['nota_nutricion'];
                                      }
                                    }
                                     ?>
                                    <div class="form-group radio">
                                      <label class="md-check">
                                        <input type="radio" class="has-value" value="0" id='radioAyuno' name="dieta" <?= $checkAyuno ?> ><i class="red"></i>Ayuno
                                      </label>
                                      <label class="md-check">
                                        <input type="radio" class="has-value" value="" id='radioDieta' name="dieta" <?= $checkDieta ?> ><i class="red"></i>Dieta
                                      </label>
                                    </div>

                                  </div>
                                  <div  id="divSelectDietas" class="col-sm-3"  <?= $divSelectDietas ?>>
                                    <div class="form-group">
                                      <label>Tipos de dieta:</label>
                                      <!-- El valor es numerico para distinguir si la opcion pertenece a los
                                           radios, selects o input -->
                                      <select name="tipoDieta" id="selectDietas" class="form-control" data-value="<?= $select_dietas ?>">
                                        <option value="0">Seleccionar Dieta</option>
                                        <option value="1">IB - Normal</option>
                                        <option value="2">IIA - Blanda</option>
                                        <option value="3">IIB - Astringente</option>
                                        <option value="4">III - Diabetica</option>
                                        <option value="5">IV - Hiposodica</option>
                                        <option value="6">V - Hipograsa</option>
                                        <option value="7">VI - Liquida clara</option>
                                        <option value="8">VIA - Liquida general</option>
                                        <option value="9">VIB - Licuada por sonda</option>
                                        <option value="10">VIB - Licuada por sonda artesanal</option>
                                        <option value="11">VII - Papilla</option>
                                        <option value="12">VIII - Epecial</option>
                                        <option value="13">Otros</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div  id='divOtraDieta' class="col-sm-6" style="padding:0" <?= $divOtraDieta ?> >
                                    <div class="form-group">
                                      <label>Otra dieta:</label>
                                      <input type="text" class="form-control" name="otraDieta" value="<?= $otraDieta ?>" id="inputOtraDieta" placeholder="Otra dieta">
                                    </div>
                                  </div>
                                </div>

                                <?php
                                  // Declara estado original del select cuando se realiza nueva nota
                                  $select_signos = 0;
                                  $otras_indicaciones = 'hidden';
                                  // El estado de las variables cambia al realizar un cambio, esto para determinar si el valor corresponde al select o textarea
                                  if($_GET['a'] == 'edit'){
                                    if($Nota['nota_svycuidados'] == '0' || $Nota['nota_svycuidados'] == '1' || $Nota['nota_svycuidados'] == '2' ){
                                      $select_signos = $Nota['nota_svycuidados'];
                                    }else{
                                      $select_signos = "3";
                                      $otras_indicaciones = '';
                                    }
                                  }
                                ?>

                                <div class="col-sm-12" id="divSignos" style="padding:0">
                                  <div class="col-sm-4 form-group" style="padding:0" id="divTomaSignos">
                                    <label><b>b) Toma de signos vitales: </b></label>
                                    <select  id="selectTomaSignos" class="form-control" data-value="<?= $select_signos ?>" name="tomaSignos">
                                      <option value="0">Toma de signos</option>
                                      <option value="1">Por turno</option>
                                      <option value="2">Cada 4 horas</option>
                                      <option value="3">Otros</option>
                                    </select>
                                  </div>

                                  <div id="divOtrasInidcacionesSignos"  <?= $otras_indicaciones ?>>
                                    <div class="col-sm-8 form-group" style="padding-right: 0">
                                    <label>Otras inidcaciones:</label>
                                    <input type="text" name="otrasIndicacionesSignos" class="form-control" placeholder="Otras indicaciones" value="<?=$Nota['nota_svycuidados']?>">
                                    </div>
                                  </div>
                                </div>

                                <div class="col-sm-12" style="padding:0">
                                  <div class="col-sm-12" style="padding:0" id="divCuidadosGenerales">
                                    <div class="form-group ">
                                      <label><b>c) Cuidades Generales de enfermeria:</b>
                                          <?php
                                          // Declara el estado original checkbox de cuidados generales de enfermeria
                                          $labelCheck = 'NO';
                                          $hiddenCheck = 'hidden';
                                          // Al editar, modifica el estado del checkbox
                                          if($Nota['nota_cgenfermeria'] == 1){
                                            $check_generales = 'checked';
                                            $labelCheck = 'SI';
                                            $hiddenCheck = '';
                                          }
                                          ?>
                                        <input type="checkbox" id="checkCuidadosGenerales" name="nota_cgenfermeria" value="1" <?= $check_generales ?> > -
                                        <label id="labelCheckCuidadosGenerales"><?= $labelCheck ?></label>
                                      </label>
                                      <ul id="listCuidadosGenerales" <?= $hiddenCheck ?> >
                                        <li>a. Estado neurológico</li>
                                        <li>b. Cama Con barandales</li>
                                        <li>c. Calificación del dolor</li>
                                        <li>d. Calificación de riesgo de caida</li>
                                        <li>e. Control de liquidos por turno</li>
                                        <li>f. Vigilar riesgo de ulceras por presión</li>
                                        <li>g. Aseo bucal</li>
                                        <li>h. Lavado de manos</li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>


                                <div class="col-sm-12" id="divCuidadesEspeciales" style="padding:0">
                                  <div class="col-sm-12" style="padding:0">
                                    <div class="form-group">
                                      <label><b>d) Cuidades especiales de enfermeria</b></label>
                                      <textarea class="form-control" name="nota_cuidadosenfermeria" placeholder="Cuidados especiales de enfermeria"><?=$Nota['nota_cuidadosenfermeria']?></textarea>
                                    </div>
                                  </div>
                                </div>


                                <div class="col-sm-12" id="divCuidadosGenerales" style="padding:0">
                                  <div class="col-sm-12" style="padding:0">
                                    <div class="form-group">
                                      <label><b>e) Soluciones Parenterales</b></label>
                                      <textarea class="form-control" name="nota_solucionesp" placeholder="Soluciones Parenterales"><?=$Nota['nota_solucionesp']?></textarea>
                                    </div>
                                  </div>
                                </div>

                                <label><b>f) Prescripcion</b></label>
                                <div>
                                  <div class="col-sm-12" style="padding:0">
                                    <div class="col-sm-10" style="padding: 0;">
                                      <div class="form-group">
                                      <label><b>Medicamento</b>
                                        <button type="button" class="back-imss" onclick="agregarPrescripcion()"> Nueva </button>
                                        <button type="button" hidden id="btnActualizarPrescripcion" class="back-imss" onclick="actualizarPrescripcion()"> Actualizar </button>
                                      </label>
                                      <div id="borderMedicamento">
                                        <select id="select_medicamento" onchange="indicarInteraccion()" class="form control select2 selectpicker" style="width: 100%" >
                                            <option value="0">-Seleccionar-</option>
                                            <?php foreach ($Medicamentos as $value) {?>
                                            <option value="<?=$value['medicamento_id']?>" ><?=$value['medicamento']?></option>
                                            <?php } ?>
                                        </select>
                                      </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-2" style="padding-right: 0;">
                                      <div class="form-group">
                                        <label >Dosis</label>
                                        <input type="text" class="form-control">
                                      </div>
                                    </div>
                                    <!-- identificador de los medicamentos con interaccion interaccion_amarilla,
                                         el select se llena al seleccionar un medicamento -->
                                    <div hidden class="col-sm-2" style="padding: 1;">
                                        <label><b>interaccion_amarilla</b></label>
                                        <div id="borderMedicamento">
                                          <select id="interaccion_amarilla" class="" style="width: 100%" >
                                              <option value="0">-Seleccionar-</option>
                                              <?php foreach ($Medicamentos as $value) {?>
                                              <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_amarilla']?></option>
                                              <?php } ?>
                                          </select>
                                        </div>
                                    </div>
                                    <div hidden class="col-sm-2" style="padding: 1;">
                                        <label><b>interaccion_roja</b></label>
                                        <div id="borderMedicamento">
                                          <select id="interaccion_roja" class="" style="width: 100%" >
                                              <option value="0">-Seleccionar-</option>
                                              <?php foreach ($Medicamentos as $value) {?>
                                              <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_roja']?></option>
                                              <?php } ?>
                                          </select>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-12" style="padding:0">
                                    <div class="col-sm-2" style="padding: 0;">
                                        <label><b>Via Administración</b></label>
                                        <div id="borderVia">
                                        <select class="select2 selectpicker" id="via_administracion" style="width: 100%" >
                                            <option value="0">-Seleccionar-</option>
                                            <?php foreach ($Vias as $value) {?>
                                            <option ><?=$value?></option>
                                            <?php } ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                      <label><b>Frecuencia</b></label>
                                      <div id="borderFrecuencia">
                                      <select class="form-control" id="frecuencia" onchange="asignarHorarioAplicacion()" >
                                        <option value="0">- Frecuencia -</option>
                                        <option value="6 hrs">6 hrs</option>
                                        <option value="8 hrs">8 hrs</option>
                                        <option value="12 hrs">12 hrs</option>
                                        <option value="24 hrs">24 hrs</option>
                                        <option value="48 hrs">48 hrs</option>
                                        <option value="72 hrs">72 hrs</option>
                                      </select>
                                      </div>
                                    </div>
                                    <div class="col-sm-3" style="padding-left: 0;">
                                      <label><b>Aplicacion</b></label>
                                      <div id="borderAplicacion">
                                      <input id="aplicacion" class="form-control" type="text" name="" placeholder="Indicar frecuencia">
                                      </div>
                                    </div>
                                    <div class="col-sm-2" style="padding: 1; padding-left: 0;">
                                      <label><b>Fecha Inicio</b></label>
                                      <div id="borderFechaInicio">
                                      <input id="fechaInicio" onchange="mostrarFechaFin()" class="form-control dd-mm-yyyy"  name="" placeholder="06/10/2016">
                                      </div>
                                    </div>
                                    <div class="col-sm-1" style="padding: 0;" >
                                      <label><b>Dias</b></label>
                                      <div id="borderDuracion">
                                      <select id="duracion" onchange="mostrarFechaFin()" class="form-control ">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                      </select>
                                      </div>
                                    </div>
                                    <div class="col-sm-2" style="padding-right: 0; padding-left: 1;">
                                      <label><b>Fecha Fin</b></label>
                                      <div id="borderFechaFin">
                                      <input class="form-control" id="fechaFin"   name="" >
                                      </div>
                                    </div>
                                  </div>



                                  <div class="col-sm-12" style="padding: 0;" >
                                    <label><b>Observaciones para la Prescripcion</b></label>
                                    <div id="borderFechaFin">
                                    <input name="observacion_prescripcion" class="form-control" id="observacion"   name="" >
                                    </div>
                                  </div>
                                  <table style="width:100%;">
                                    <thead >
                                      <tr>
                                        <th hidden >ID</th>
                                        <th>Medicamento</th>
                                        <th>Via</th>
                                        <th>Frecuencia</th>
                                        <th>Aplicacion</th>
                                        <th>Fecha Inicio</th>
                                        <th>Dias</th>
                                        <th>Fecha Fin</th>
                                        <th>Opciones  </th>
                                      </tr>
                                    </thead>
                                    <tbody id="tablaPrescripcion">
                                    </tbody>
                                  </table>
                                  <br/>

                                </div>

                        </div>
                        <div class="col-sm-12" style="padding: 0;">
                          <div class="form-group">
                              <h4><span class = "label back-imss border-back-imss">PRONÓSTICOS</span></h4>
                              <!-- tabla de hf_indicaciones en -->
                              <textarea class="form-control" rows="3" name="hf_indicaciones"><?=$hojafrontal[0]['hf_indicaciones']?></textarea>
                          </div>
                        </div>
                        <div class="col-sm-12" style="padding: 0;">
                          <div class="form-group">
                              <h4><span class = "label back-imss border-back-imss">ESTADO DE SALUD</span></h4>
                              <textarea class="form-control" rows="3" name="hf_interpretacion"><?=$hojafrontal[0]['hf_interpretacion']?></textarea>
                          </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-6">
                        <?php if( $_GET['tipo']=='Consultorios'){?>
                            <div class="form-group">
                                            <?php if($ce[0]['ce_status']=='Salida'){?>
                                            <label><b>ALTA A :</b> </label> <?=$ce[0]['ce_hf']?>
                                            <?php }else{?>
                                            <h4><span class = "label back-imss border-back-imss">ACCIÓN: </span></h4>
                                            <select name="hf_alta" data-value="<?=$hojafrontal[0]['hf_alta']?>" class="form-control" required>
                                                <option value="">Seleccione una acción</option>
                                                <option value="Alta a Domicilio">Alta a Domicilio</option>
                                                <option value="Observación Admisión Continua">Enviar a observación Admisión Continua</option>
                                                <option value="Observación corta estancia">Enviar a observación corta estancia</option>
                                                <option value="Alta a Domicilio">Alta a Domicilio</option>
                                                <option value="Alta a UMF">Alta a UMF</option>
                                                <option value="Alta a HGZ">Alta a HGZ</option>
                                                <option value="Alta a HRZ">Alta a HRZ</option>
                                                <option value="Otros">Otros</option>
                                            </select>
                                            <?php }?>
                            </div>
                                    <?php }?>
                        </div>
                    <div class="col-md-6 hf_alta_otros hide">
                        <div class="form-group">
                            <label class="text-color-white"><b>ACCION</b></label>
                            <input type="text" name="hf_alta_otros" placeholder="Indique otra acción" value="<?=$hojafrontal[0]['hf_alta_otros']?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                           <h4><span class = "label back-imss border-back-imss">VALORACION POR:</span></h4>
                <!--               <div class="input-group m-b">
                                  <span class="input-group-addon back-imss border-back-imss"><i class="fa fa-user-plus"></i></span>
                                    <select class="select2" multiple="" name="nota_interconsulta[]" id="nota_interconsulta" data-value="<?=$hojafrontal[0]['hf_interconsulta']?>" style="width: 100%">
                                    <?php foreach ($Especialidades as $value) {?>
                                   <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                                    <?php }?>
                                      </select>
                                </div> -->
                            <input type="text" name="hf_interconsulta" placeholder="Indique si necesita interconsulta" value="<?=$hojafrontal[0]['hf_interconsulta']?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><b>MÉDICO TRATANTE</b></label>
                                        <input type="text" name="asistentesmedicas_mt" value="<?=$INFO_USER[0]['empleado_nombre'].' '.$INFO_USER[0]['empleado_apellidos']?>" readonly="" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label><b>MATRICULA</b></label>
                                        <input type="text" name="asistentesmedicas_mt_m" value="<?=$INFO_USER[0]['empleado_matricula']?>" readonly="" class="form-control">
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>

                    <input type="hidden" name="pia_lugar_accidente" value="<?=$PINFO['pia_lugar_accidente']?>">
                                    <div class="row col-hojafrontal-info hide" style="padding: 6px;">
                                        <div class="col-md-12 back-imss text-center">
                                            <h6>
                                                <b>DATOS DE TRABAJO REQUISITADOS POR LA ASISTENTE MÉDICA</b>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-12 hide col-hojafrontal-info">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><b>EMPRESA</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_nombre']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label><b>REGISTRO PATRONAL</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_rp']?>" readonly="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><b>MODALIDAD</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_modalidad']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label><b>FECHA DE ÚLTIMO MOVIMIENTO</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_fum']?>" readonly="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><b>TELÉFONO (LADA)</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_telefono']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label><b>COLONIA</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_colonia']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label><b>HORA ENTRADA</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_he']?>" readonly="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><b>CÓDIGO POSTAL</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_cp']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label><b>MUNICIPIO</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_municipio']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label><b>HORA SALIDA</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_he']?>" readonly="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><b>CALLE Y NÚMERO</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_cn']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label><b>ESTADO</b></label>
                                                    <input type="text" value="<?=$DirEmpresa['directorio_estado']?>" readonly="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label><b>DÍA DE DESCANCO P. AL ACCIDENTE</b></label>
                                                    <input type="text" value="<?=$Empresa['empresa_he']?>" readonly="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-hojafrontal-info hide" style="padding: 6px;">
                                        <div class="col-md-12 back-imss text-center">
                                            <h6>
                                                <b>DATOS DE LA ST7</b>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-12 hide col-hojafrontal-info">
                                        <div class="form-group">
                                            <label><b>OMITIR DATOS DE ST7</b></label><br>
                                            <label class="md-check">
                                                <input type="radio" name="asistentesmedicas_omitir" data-value="<?=$am[0]['asistentesmedicas_omitir']?>" value="Si" class="has-value  hojafrontal-info">
                                                <i class="amber"></i>Si
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                                <input type="radio" name="asistentesmedicas_omitir" data-value="<?=$am[0]['asistentesmedicas_omitir']?>" checked="" value="No" class="has-value  hojafrontal-info">
                                                <i class="amber"></i>No
                                            </label>
                                        </div>
                                        <div class="form-group asistentesmedicas_omitir">
                                            <label><b>SEÑALAR CLARAMENTE COMO OCURRIO EL ACCIDENTE</b></label>
                                            <textarea name="asistentesmedicas_da" required="" maxlength="500" class="form-control hojafrontal-info" rows="3"><?=$am[0]['asistentesmedicas_da']?></textarea>
                                        </div>
                                        <div class="form-group asistentesmedicas_omitir">
                                            <label><b>DESCRIPCIÓN DE LA(S) LESIÓN(ES) Y TEMPO DE EVOLUCIÓN</b></label>
                                            <textarea name="asistentesmedicas_dl" required="" maxlength="500" class="form-control  hojafrontal-info" rows="3"><?=$am[0]['asistentesmedicas_dl']?></textarea>
                                        </div>
                                        <div class="form-group asistentesmedicas_omitir">
                                            <label><b>IMPRESIÓN DIAGNÓSTICA</b></label>
                                            <textarea name="asistentesmedicas_ip" required="" maxlength="400" class="form-control  hojafrontal-info" rows="3"><?=$am[0]['asistentesmedicas_ip']?></textarea>
                                        </div>
                                        <div class="form-group asistentesmedicas_omitir">
                                            <label><b>TRATAMIENTOS</b></label>
                                            <textarea name="asistentesmedicas_tratamientos" required="" maxlength="400" class="form-control  hojafrontal-info" rows="3"><?=$am[0]['asistentesmedicas_tratamientos']?></textarea>
                                        </div>
                                        <div class="form-group asistentesmedicas_omitir">

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label><b>SIGNOS Y SINTOMAS</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Intoxicación Alcohólica</label>&nbsp;&nbsp;&nbsp;
                                                            <label class="md-check">
                                                                <input type="radio" name="asistentesmedicas_ss_in" data-value="<?=$am[0]['asistentesmedicas_ss_in']?>" required="" value="Si" class="has-value  hojafrontal-info">
                                                                <i class="amber"></i>Si
                                                            </label>
                                                            <label class="md-check">
                                                                <input type="radio" name="asistentesmedicas_ss_in" checked="" data-value="<?=$am[0]['asistentesmedicas_ss_in']?>" required="" value="No" class="has-value  hojafrontal-info">
                                                                <i class="amber"></i>No
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Intoxicación por Enervantes</label>&nbsp;&nbsp;&nbsp;
                                                            <label class="md-check">
                                                                <input type="radio" name="asistentesmedicas_ss_ie" data-value="<?=$am[0]['asistentesmedicas_ss_ie']?>" required="" value="Si" class="has-value  hojafrontal-info">
                                                                <i class="pink"></i>Si
                                                            </label>
                                                            <label class="md-check">
                                                                <input type="radio" name="asistentesmedicas_ss_ie" checked="" data-value="<?=$am[0]['asistentesmedicas_ss_ie']?>" required="" value="No" class="has-value  hojafrontal-info">
                                                                <i class="pink"></i>No
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label><b>OTRAS CONDICIONES</b></label><br>
                                                    <label>Hubo riña</label>&nbsp;&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="asistentesmedicas_oc_hr" data-value="<?=$am[0]['asistentesmedicas_oc_hr']?>" value="Si" required="" class="has-value  hojafrontal-info">
                                                        <i class="orange"></i>Si
                                                    </label>
                                                    <label class="md-check">
                                                        <input type="radio" name="asistentesmedicas_oc_hr" checked="" data-value="<?=$am[0]['asistentesmedicas_oc_hr']?>" value="No" required="" class="has-value  hojafrontal-info">
                                                        <i class="orange"></i>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group asistentesmedicas_omitir">
                                            <label><b>ATENCIÓN MÉDICA PREVIA EXTRAINSTITUCIONAL</b></label>
                                            <textarea name="asistentesmedicas_am" maxlength="200" class="form-control hojafrontal-info" required="" rows="2"><?=$am[0]['asistentesmedicas_am']?></textarea>
                                        </div>
                                    </div>
                                    <?php if($_GET['tipo']=='Choque'){?>
                                    <hr style="margin-top: 30px;">
                                    <div class="col-md-4" style="margin-top: 10px">
                                        <div class="form-group">
                                            <label><b>POSIBLE DONADOR</b></label>&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                                <input type="radio" name="po_donador"  data-value="<?=$po[0]['po_donador']?>" value="Si" class="has-value">
                                                <i class="indigo"></i>Si
                                            </label>&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                                <input type="radio" name="po_donador" checked="" value="No" class="has-value">
                                                <i class="indigo"></i>No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-8" style="margin-top: 10px">
                                        <div class="form-group po_donador hide" style="margin-top: -10px">
                                            <select class="form-control" name="po_criterio" data-value="<?=$po[0]['po_criterio']?>">
                                                <option value="">Seleccionar</option>
                                                <option value="Lesión encefalica severa">Lesión encefalica severa</option>
                                                <option value="Glasgow">Glasgow</option>
                                            </select>
                                        </div>
                                    </div>

                                    <?php }?>
                                    <div class="col-md-offset-6 col-md-3">
                                        <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="hidden" name="csrf_token" >
                                        <input type="hidden" name="triage_id" value="<?=$_GET['folio']?>">
                                        <input type="hidden" name="hf_id" value="<?=$_GET['hf']?>">
                                        <input type="hidden" name="accion" value="<?=$_GET['a']?>">
                                        <input type="hidden" name="tipo" value="<?=$_GET['tipo']?>">
                                        <input type="hidden" name="ce_status" value="<?=$ce[0]['ce_status']?>">
                                        <button class="btn back-imss btn-block" type="submit">Guardar</button>
                                    </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script type="text/javascript" src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js"></script>
<script src="<?= base_url('assets/js/sections/CIE10.js?md5='). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Documentos.js?md5'). md5(microtime())?>" type="text/javascript"></script>
