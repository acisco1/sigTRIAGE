<?= modules::run('Sections/Menu/HeaderBasico'); ?>
<style>
            hr.style-eight{
              border: 0;
              border-top: 4px double #8c8c8c;
              text-align: center;
              }
              .glyphicon.glyphicon-menu-up, .glyphicon.glyphicon-menu-down{
                font-size: 8px;
              }
              hr.style-eight:after{
                content: attr(data-titulo);
                display: inline-block;
                position: relative;
                top: -0.7em;
                font-size: 1.2em;
                padding: 0 0.20em;
                background: white;
              }
              #acordeon_prescripciones_activas, #acordeon_prescripciones_canceladas,
              #acordeon_alergia_medicamentos,#acordeon_reacciones, #acordeon_notificaciones{
                color: rgb(255,255,255);
                font-size: 16px;
                padding-top: -4px;
                padding-button: -4px;

              }
              #acordeon_prescripciones_activas:hover, #acordeon_prescripciones_canceladas:hover,
              #acordeon_alergia_medicamentos:hover, #acordeon_reacciones:hover,#acordeon_notificaciones:hover{
                background-color: rgba(0, 0, 0, 0.12);
              }
              .lista_resultado_diagnosticos{
                margin: 0px;
                padding-left: 16px;
              }
              .lista_diagnosticos{
                list-style: none;
                padding: 5px;
                border-left: 1px solid #000;
                border-right: 1px solid #000;
                color: black;
                background-color: #fff;
              }
              .lista_diagnosticos:hover{
                background-color: #256659;
                color: white;
              }
              .contenedor_consulta_diagnosticos{
                max-width: 2000px;
                max-height: 200px;
                position:absolute;
                left:0px;
                z-index: 1;
                overflow: auto;
              }
          </style>
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

            .panel {
            /* for text on pannel */
            margin-top: 27px !important;
            }

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
              border-top:  1px solid #ddd;
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

            .panel-heading .accordion-toggle:after {
                font-family: 'Glyphicons Halflings';
                content: "\e114";
                float: right;
                color: #256659;
            }
            .tipo_nota{
              text-align: center;
              border:none;
              background:none;
              margin:0;
              outline:0;
              width: 100%;
              color: white;
            }
            .tipo_nota:-moz-read-only{
              background: none;
            }
            .tipo_nota:read-only{
              background: none;
            }
            .btn_agregarDiagnostico{
              height:42px;
              width: 60px;
            }
            .panel-heading .accordion-toggle.collapsed:after {
                font-family: 'Glyphicons Halflings';
                content: "\e080";
            }
            .panel-heading{
              padding: 3px 24px;
            }
            .panel-body{
              padding-top: 4px !important;
            }
            .panel-container{
              border-bottom: 1px solid #ddd;
            }
            #label_total_activas, #label_total_canceladas, #label_total_alergia_medicamentos,
            #label_total_reacciones, #label_total_notificaciones{
              display: inline-block;
            }
            </style>
            <style> .wysiwyg-text-align-center {text-align: center;}</style>
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-11 col-centered" style="margin-top: 10px">
        <div class="box-inner">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss text-center scroll-box" style="">
                    <div class="row" style="margin-top: -15px!important; padding-top: 12px;">
                        <div style="position: relative;">
                          <!-- Color franja -->
                            <div style="top: 0px; margin-left: -9px;position: absolute; height: 105px; width: 35px;" class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>"></div>
                        </div>
                        <div class="col-sm-10 text-left" style="padding-left: 40px">
                            <div class="col-sm-12">
                              <h4>
                                <b>PACIENTE</b>: <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
                                | <b>SEXO: </b><?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| - Posible Embarazo' : ''?>
                                | <b>PROCEDENCIA:</b> <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEA '.$PINFO['pia_procedencia_espontanea_lugar'] : ' '.$PINFO['pia_procedencia_hospital'].' '.$PINFO['pia_procedencia_hospital_num']?>
                            </h4>
                            </div>
                            <div class="col-sm-12">
                              <h4><b>ALERGIAS : </b><?=$PINFO['alergias'] ?></h4>
                            </div>
                        </div>
                        <div class="col-sm-2">

                            <h3 class="text-center">
                                <?php
                                if($info['triage_fecha_nac']!=''){
                                    $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                    echo ' <span ><b>Edad: '. $fecha->y.' Años</b></span>';
                                }else{
                                    echo 'S/E';
                                }
                                ?>
                                <?php
                                      $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info['triage_codigo_atencion']);
                                      echo ($codigo_atencion != '')?"<br><span style='font-size:20px'><b>Código $codigo_atencion</b></span>":"";
                                  ?>
                            </h3>
                        </div>
                    </div>
                    
                <div class="back-imss" style="margin-top: -4px; margin-left:-24px; margin-right:-24px;">
                    <div class="col-sm-12 back-imss" >
                      <h5>Fecha de última toma de signos: <?=$UltimosSignosVitales[0]['fecha']?></h5>
                    </div>
                    <div class="col-md-1 text-center back-imss" style="width: 12.5%;">
                        <h5 style="margin-top: -5px;"><b>P.A</b></h5>
                        <h4 style="margin-top: -6px;font-weight: bold"> <?=$UltimosSignosVitales[0]['sv_ta']?>(mmhg)</h4>
                    </div>
                    <div class="col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                        <h5 style="margin-top: -5px;"><b>TEMP.</b></h5>
                        <h4 style="margin-top: -6px;font-weight: bold"> <?=$UltimosSignosVitales[0]['sv_temp']?> (°C)</h4>
                    </div>
                    <div class="col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                        <h5 style="margin-top: -5px;"><b>FREC. CARD. </b></h5>
                        <h4 style="margin-top: -6px;font-weight: bold"> <?=$UltimosSignosVitales[0]['sv_fc']?> (lpm)</h4>
                    </div>
                    <div class="col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                        <h5 style="margin-top: -5px;"><b>FREC. RESP</b></h5>
                        <h4 style="margin-top: -6px;font-weight: bold"> <?= [0]['sv_fr']?> (rpm)</h4>
                    </div>
                    <div class="col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                        <h5 style="margin-top: -5px;"><b>SpO2</b></h5>
                        <h4 style="margin-top: -6px;font-weight: bold"> <?=$UltimosSignosVitales[0]['sv_oximetria']?> (%)</h4>
                    </div>
                    <div class="col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                        <h5 style="margin-top: -5px;"><b>GLUCEMIA</b></h5>
                        <h4 style="margin-top: -6px;font-weight: bold"> <?=$UltimosSignosVitales[0]['sv_dextrostix']?> (mg/dL)</h4>
                    </div>
                    <div class="col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                        <h5 style="margin-top: -5px;"><b>PESO</b></h5>
                        <h4 style="margin-top: -6px;font-weight: bold"> <?=$UltimosSignosVitales[0]['sv_peso']?> (kg)</h4>
                    </div>
                    <div class="col-md-1 text-center back-imss" style="border-left: 1px solid white; width: 12.5%;">
                        <h5 style="margin-top: -5px;"><b>TALLA</b></h5>
                        <h4 style="margin-top: -6px;font-weight: bold"> <?=$UltimosSignosVitales[0]['sv_talla']?>(cm)</h4>
                    </div>
                    <div class="col-sm-12" ></div>
                </div>
                <!--</div>-->
              </div>

                <div class="panel-body b-b b-light scrollspy-body">
                    <div class="card-body" style="padding: 20px 0px;">
                        <form class="Form-Notas-COC" oninput="x.value=parseInt(nota_eva.value)">
                            <div class="row" >
                                <div class="col-md-12" style="margin-top: -15px">
                                    <div class="form-group">
                                        <div class="input-group m-b">
                                            <?php
                                            $tipo_nota = ' NOTA DE EVOLUCIÓN ';
                                            if($_GET['via'] == 'Interconsulta'){
                                              $tipo_nota = 'NOTA DE INTERCONSULTA';
                                            }
                                             ?>
                                            <span class="input-group-addon back-imss border-back-imss" >
                                              <input readonly type="text" readonly class="tipo_nota form-control width100" name="notas_tipo" value="<?=$tipo_nota?>">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-12">
                                <h4><span class = "label back-imss border-back-imss">ACTUALIZACION DE SIGNOS VITALES</span></h4>
                              </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><b>PRESION ARTERIAL (mmHg)</b></label>
                                        <input class="form-control"  name="sv_ta" value="">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><b>TEMPERATURA (°C)</b></label>
                                        <input class="form-control" name="sv_temp"  value="">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><b>FRECUENCIA CARDIACA (lpm)</b></label>
                                        <input class="form-control" name="sv_fc"  value="">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><b>FREC. RESPIRATORIA (rpm)</b></label>
                                        <input class="form-control" name="sv_fr"  value="">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><b>SP02 (%)</b></label>
                                        <input class="form-control" name="sv_oximetria"  value="">
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="control-group">
                                        <label><b>GLUCOSA (mg/dl)</b></label>
                                        <input class="form-control" name="sv_dextrostix"  value="">
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="control-group">
                                        <label><b>PESO (kg)</b></label>
                                        <input class="form-control" name="sv_peso"  value="">
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="control-group">
                                        <label><b>TALLA (cm)</b></label>
                                        <input class="form-control" name="sv_talla"  value="">
                                    </div>

                                </div>
       <!-- COMIENZA LOS CAMPOS DEL FORMULARIO PARA LA NOTA MEDICA -->
                <?php

                $sololectura = "";
                if($Nota['notas_tipo']=='NOTA DE INTERCONSULTA' || isset($_GET['via']) && $_GET['via'] == 'Interconsulta'){
                  $visibleInterconsulta = "";
                  $MotivoInterconsulta = $this->config_mdl->_query("SELECT motivo_interconsulta FROM doc_430200 WHERE triage_id = ". $_GET['folio']." AND doc_servicio_solicitado = (SELECT empleado_servicio
                  FROM os_empleados WHERE empleado_id = $this->UMAE_USER)");
                  // En caso que se realice nota interconsulta el problema sera el diagnostico de ingreso y el motivo de interconsulta
                  $problema ="Diagnóstico de Ingreso: ".$Diagnosticos[0]['cie10_clave']." - ".$Diagnosticos[0]['cie10_nombre']."\n".    "Motivo interconsulta: ".$MotivoInterconsulta[0]['motivo_interconsulta'];

                  $sololectura = "readonly";
                }else{
                  $problema = $Nota['nota_problema'];
                ?>
                <script type="text/javascript">
                  $('textarea[name=nota_problema]').wysihtml5();
                </script>
                <?php } ?>

                    <div class="col-sm-12" >
                      <h4><span class = "label back-imss border-back-imss">EVOLUCION Y/O ACTUALIZACION DEL CUADRO CLINICO</span></h4>
                      <div class="form-group evolucion-psoap ">
                        <label><b>PROBLEMA (Diagnóstico):</b></label>
                        <textarea class="form-control" name="nota_problema" rows="5" placeholder="Problema o Diagnosticos" <?=$sololectura ?> ><?=$problema?></textarea>
                      </div>
                      <div class="form-group">
                        <label><b id="psoap_subjetivo" >SUBJETIVO (Interrogatorio):</b></label>
                        <textarea class="form-control" name="nota_interrogatorio" rows="5" placeholder="Interrogatorio directo o indirecto"> <?=$Nota['nota_interrogatorio']?> </textarea>
                      </div>
                      <div class="form-group">
                        <label><b id="psoap_objetivo" >OBJETIVO (Exploracion fisica):</b></label>
                        <textarea class="form-control" name="nota_exploracionf" rows="5" placeholder=""><?=$Nota['nota_exploracionf']?></textarea>
                      </div>

                    </div>
                    <div class="col-md-3">
                        <label><b>ESCALA DE GLASGOW</b></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-toggle="modal" data-target='#myModal1' placeholder="Clic para colocar valor" name="hf_escala_glasgow" value="<?=$Nota['nota_escala_glasgow']?>" required>
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

                                    <div class="form-group">PUNTUACIÓN TOTAL: &nbsp;<input type="text" name="hf_escala_glasgow" size="3" data-value="<?=$Nota[0]['hf_escala_glasgow']?>" disable></div>
                    </fieldset>

        </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>

            </div>
        </div>
    </div>
</div>
                                <div class="col-md-3">
                                        <div class="form-group">
                                            <b>RIESGO DE CAÍDA</b><br>
                                            <label class="md-check">
                                            <input type="radio" name="hf_riesgo_caida" data-value="<?=$Nota['hf_riesgo_caida']?>" value="Alta" class="has-value" required><i class="red"></i>Alta
                                            </label>&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                            <input type="radio" name="hf_riesgo_caida" data-value="<?=$Nota['hf_riesgo_caida']?>" value="Media" class="has-value"><i class="red"></i>Media
                                            </label>&nbsp;&nbsp;
                                            <label class="md-check">
                                            <input type="radio" name="hf_riesgo_caida" data-value="<?=$Nota['hf_riesgo_caida']?>" value="Baja" class="has-value"><i class="red"></i>Baja
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><b>ESCALA DE DOLOR (EVA)</b></label><br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                  <?php if($Nota['nota_eva'] == ''){
                                                    $nota_eva = 0;
                                                  }else{
                                                    $nota_eva = $Nota['nota_eva'];
                                                  }?>
                                                 <input type="range" name="nota_eva" value="<?=$nota_eva?>" min="0" max="10" value="0">
                                                </div>
                                                <div class="col-sm-6" style="width:10px;height:30px;border:1px solid blue;">
                                                    <output name="x" for="nota_eva"><?=$nota_eva?></output>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                        <div class="col-md-3">
                        <label><b>RIESGO DE TROMBOSIS</b></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-toggle="modal" data-target='#myModal2' placeholder="Clic para colocar valor" name="nota_riesgotrombosis" id="puntos_rt" value='<?=$Nota['nota_riesgotrombosis']?>' required>
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
                       <div class="col-md-12">
                                <div class="form-group">
                                    <h4><span class = "label back-imss border-back-imss">RESULTADOS DE SERVICIOS AUXILIARES DE DIAGNOSTICO</span></h4>
                                        <textarea class="form-control" name="nota_auxiliaresd" rows="5" placeholder=""><?=$Nota['nota_auxiliaresd']?></textarea>
                                    </div>
                                <div class="form-group">
                                    <h4><span class = "label back-imss border-back-imss">PROCEDIMIENTOS REALIZADOS</span></h4>
                                        <textarea class="form-control textWysihtml5" name="nota_procedimientos" rows="5" placeholder="Incluye intervencionismo en servicios auxiliares de diágnóstico"><?=$Nota['nota_procedimientos']?></textarea>
                                </div>
                                <div class="form-group evolucion-psoap ">
                                  <label><b>ANALISIS:</b></label>
                                  <textarea class="form-control" name="nota_analisis" rows="2" placeholder=""><?=$Nota['nota_analisis']?></textarea>
                                </div>
                                <div class="form-group">
                                  <h4><span class = "label back-imss border-back-imss">ACTUALIZACION DE DIAGNÓSTICO(S)</span></h4>

                                  <!-- <textarea class="form-control" name="nota_diagnostico" rows="5" placeholder="Anote diagnóstico y problemas clinicos"><?=$Nota['nota_diagnostico']?></textarea> -->
                                  <div class="seccion_diagnosticos">

                                    <nav class=" back-imss">
                                        <ul class="nav navbar-nav" >
                                          <li>
                                            <a id="consulta_diagnosticos" style="font-size:16px;">
                                                Diagnósticos Encontrados (<?= count($Diagnosticos); ?>)
                                            </a>
                                          </li>
                                        </ul>
                                        <ul class="nav navbar-nav" style="float:right" >
                                          <li>
                                            <div style="padding-right:10px;">
                                              <button  type="button" class="btn btn-success btn_agregarDiagnostico"
                                                title="Agregar Diagnostico Secundario" name="button">
                                                <span class="glyphicon glyphicon-plus "></span>
                                              </button>
                                            </div>
                                          </li>
                                        </ul>
                                    </nav>
                                    <div class="">
                                      <table class="width100">
                                        <thead class="table_diagnosticos" hidden data-value="0">
                                          <tr>
                                            <th>CLAVE</th>
                                            <th>DIAGNÓSTICO CIE10</th>
                                            <th>TIPO</th>
                                          </tr>
                                        </thead>
                                        <tbody class="historial_diagnosticos">

                                        </tbody>
                                      </table>
                                    </div>
                                      <div class="diagnosticos_principales row">
                                      <?php
                                      $label_instruccion_diagnostico = "(Edite el campo si el diagnóstico de ingreso no es el principal)";
                                      $cie10_nombre = $Diagnosticos[0]['cie10_nombre'];
                                      $cie10_clave = $Diagnosticos[0]['cie10_clave'];
                                      $cie10_id = $Diagnosticos[0]['cie10_id1'];
                                      $edit = "hidden";
                                      $edit2 = "";
                                      $principal_edit = "";

                                      if(COUNT($DiagnosticoPaciente) > 0){
                                        $label_instruccion_diagnostico = "";
                                        $cie10_nombre = $DiagnosticoPaciente[0]['cie10_nombre'];
                                        $cie10_clave = $DiagnosticoPaciente[0]['cie10_clave'];
                                        $cie10_id = $DiagnosticoPaciente[0]['cie10_id1'];
                                        $edit = "";
                                        $edit2 = "hidden";
                                        $principal_edit = "disabled";
                                      }
                                      ?>
                                        <div class="col-sm-9">
                                          <div class="form-group">
                                            <label>Diagnóstico Principal <?=$label_instruccion_diagnostico?> </label>
                                            <input type="text" class="form-control" id="text_diagnostico_1" onkeydown="BuscarDiagnostico(1)" value="<?=$cie10_nombre?>" <?=$principal_edit?>>
                                            <ul class="contenedor_consulta_diagnosticos" id="lista_resultado_diagnosticos_1"></ul>
                                          </div>
                                        </div>

                                        <div class="col-sm-2">
                                          <label>Código</label>
                                          <input type="text" class="form-control" id="text_codigo_diagnostico_1" value="<?=$cie10_clave?>" disabled>
                                          <input type="hidden" name="cie10_id_principal" id="text_id_diagnostico_1" value="<?=$cie10_id?>">
                                          <input type="hidden" name="accion_diagnostico_principal" value="add">
                                        </div>
                                        <div class="col-sm-1" style="padding-top:22px;" <?=$edit?>>
                                          <a href="#" class="btn btn-default width100 btn-edit-diagnostico-principal" title="Editar diagnóstico principal" >
                                          <span class="glyphicon glyphicon-pencil"></span>
                                          </a>
                                        </div>
                                        <div class="col-sm-1" style="padding-top:22px;" <?=$edit2?>>
                                          <a href="#" class="btn btn-default width100 btn-diagnostico-principal" title="Editar diagnóstico principal" >
                                          <span class="glyphicon glyphicon-pencil"></span>
                                          </a>
                                        </div>
                                      </div>
                                    <div class="diagnosticos_secundarios_dinamico">

                                    </div>
                                  </div>

                                </div>
                                <div class="form-group">
                                 <h4><span class = "label back-imss border-back-imss">ESTADO DE SALUD</span></h4>
                                    <label class="md-check">
                                        <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Delicado"><i class="red"></i>Delicado
                                    </label>&nbsp;&nbsp;&nbsp;
                                    <label class="md-check">
                                        <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Muy Delicado"><i class="red"></i>Muy Delicado
                                    </label>&nbsp;&nbsp;&nbsp;
                                    <label class="md-check">
                                        <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Grave"><i class="red"></i>Grave
                                    </label>&nbsp;&nbsp;&nbsp;
                                    <label class="md-check">
                                        <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Muy Grave"><i class="red"></i>Muy Grave
                                    </label>&nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="form-group">
                                  <h4><span class = "label back-imss border-back-imss">PRONÓSTICO(S)</span></h4>
                                  <textarea class="form-control" name="nota_pronosticos" rows="2" placeholder="Anote diagnóstico y problemas clinicos"><?=$Nota['nota_pronosticos']?></textarea>
                                </div>
                                <div class="row">
                                  <div class="col-sm-2">
                                    <h4>
                                      <span class = "label back-imss border-back-imss">PLAN Y ORDENES MÉDICAS</span>
                                    </h4>
                                  </div>
                                  <div class="col-sm-2" style="margin-left:20px;">
                                    <div class="form-group radio">
                                      <label class="md-check">
                                        <input type="radio" class="has-value" value="0" id='play_ordenes_nuevo' name="play_ordenes" checked ><i class="red"></i>Nuevo
                                      </label>
                                      <label class="md-check">
                                        <input type="radio" class="has-value" value="1" id='play_ordenes_continuar' name="play_ordenes"  ><i class="red"></i>Continuar con la anterior
                                      </label>
                                    </div>
                                  </div>
                                  <label class="lbl_mensaje"></label>


                                </div>

                                <!-- Inicio seccion play y ordenes médicas -->
                                <div class="seccion-plan-ordenes">

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
                                      <input type="text" id="otras-indicaciones-signos" name="otrasIndicacionesSignos" class="form-control" placeholder="Otras indicaciones" value="<?=$Nota['nota_svycuidados']?>">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-sm-12" style="padding:0">
                                    <div class="col-sm-12" style="padding:0" id="divCuidadosGenerales">
                                      <div class="form-group ">
                                        <label><b>c) Cuidados generales de enfermeria:</b>
                                            <?php
                                            // Declara el estado original checkbox de cuidados generales de enfermeria
                                            $labelCheck = 'SI';
                                            $hiddenCheck = 'hidden';
                                            // Al editar, modifica el estado del checkbox
                                            if($Nota['nota_cgenfermeria'] == 1){
                                              $check_generales = 'checked';
                                              $labelCheck = '';
                                              $hiddenCheck = '';
                                            }
                                            ?>
                                          <input type="checkbox" id="checkCuidadosGenerales" name="nota_cgenfermeria" value="1" <?= $check_generales ?> > -
                                          <label id="labelCheckCuidadosGenerales"><?= $labelCheck ?></label>
                                        </label>
                                        <ul id="listCuidadosGenerales" <?= $hiddenCheck ?> >
                                          <li>a. Estado neurológico</li>
                                          <li>b. Cama con barandales</li>
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

                                  <div class="col-sm-12"  style="padding:0">
                                    <div class="col-sm-12" style="padding:0">
                                      <div class="form-group">
                                        <label><b>d) Cuidados especiales de enfermeria</b></label>
                                        <textarea class="form-control nota_cuidadosenfermeria" name="nota_cuidadosenfermeria" rows="5" placeholder="Cuidados especiales de enfermeria"><?=$Nota['nota_cuidadosenfermeria']?></textarea>
                                      </div>
                                    </div>
                                  </div>


                                  <div class="col-sm-12" id="divCuidadosGenerales" style="padding:0">
                                    <div class="col-sm-12" style="padding:0">
                                      <div class="form-group">
                                        <label><b>e) Soluciones parenterales</b></label>
                                        <textarea class="form-control nota_solucionesp" name="nota_solucionesp" rows="5" placeholder="Soluciones Parenterales"><?=$Nota['nota_solucionesp']?></textarea>
                                      </div>
                                    </div>
                                  </div>

                                </div>
                                <!-- Fin seccion play y ordenes médicas -->


                                            <div>

                                            <label><b>f) Prescripción: </b> &nbsp; </label><input type="checkbox" id="check_form_prescripcion">&nbsp;<label id="label_check_prescripcion">- SI</label>
                                            <!-- Panel con el historial de prescripciones -->
                                            <nav class=" back-imss">

                                                <ul class="nav navbar-nav" >
                                                  <li>
                                                    <a id="acordeon_prescripciones_activas">
                                                        Prescripciones activas:
                                                        <label id="label_total_activas"><?= $Prescripciones_activas[0]['activas'] ?></label>
                                                    </a>
                                                  </li>
                                                  <li>
                                                    <a id="acordeon_prescripciones_canceladas">
                                                        Canceladas o Actualizadas:
                                                        <label id="label_total_canceladas"><?= count($Prescripciones_canceladas) ?></label>
                                                    </a>
                                                  </li>
                                                  <li>
                                                    <a id="acordeon_reacciones">
                                                        Reacciones Adversas:
                                                        <label id="label_total_reacciones"><?= count($ReaccionesAdversas) ?></label>
                                                    </a>
                                                  </li>
                                                  <!--
                                                  <li>
                                                    <a id="acordeon_notificaciones">
                                                        Notificaciones Farmacovigilancia:
                                                        <label id="label_total_notificaciones">0</label>
                                                    </a>
                                                  </li>
                                                   -->
                                                </ul>
                                                <label id="estado_panel" hidden>0</label>

                                            </nav>
                                            <div>
                                              <table id="historial_medicamentos_activos" style="width:100%;" hidden>
                                                <thead id="historial_prescripcion" >
                                                  <tr>
                                                    <th>Medicamento</th>
                                                    <th>Categoria Farmacologica</th>
                                                    <th>Fecha prescripción</th>
                                                    <th>Dosis</th>
                                                    <th>Vía</th>
                                                    <th>Frecuencia</th>
                                                    <th>Aplicación</th>
                                                    <th>Fecha Inicio</th>
                                                    <th colspan="2">Tiempo</th>
                                                    <th>Fecha Fin</th>
                                                    <th id="col_dias">Días Transcurridos</th>
                                                    <th id="col_fechaFin" >Acciones</th>
                                                    <th id="col_acciones" >Acciones</th>
                                                    <th id="col_movimiento" >Movimiento</th>
                                                    <th id="col_fecha_movimiento" >Fecha Movimiento</th>
                                                  </tr>
                                                </thead>
                                                <tbody id="table_prescripcion_historial">

                                                </tbody>
                                              </table>
                                            </div>
                                            <div>
                                              <div class="panel-group" id='historial_movimientos' hidden>

                                              </div>
                                            </div>
                                            <div id='historial_reacciones' hidden>
                                              <table style="width:100%;">
                                                <thead>
                                                  <th>Medicamento</th>
                                                  <th>Observacion</th>
                                                </thead>
                                                <tbody id="table_historial_reacciones">

                                                </tbody>
                                              </table>

                                            </div>
                                            <div id='historial_notificaciones'>

                                            </div>



                                            <!-- Inicio formulario prescripcion -->
                                            <div class="formulario_prescripcion" style="padding-top: 10px;" hidden>
                                              <br>
                                              <div class="row" >
                                                  <div class="col-md-12" style="margin-top: -15px">
                                                      <div class="form-group">
                                                          <div class="input-group m-b">
                                                              <span class="input-group-addon back-imss border-back-imss" >
                                                                RECETA MÉDICA
                                                              </span>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-sm-12" style="padding:0">

                                                <div class="col-sm-5" style="padding: 0;">
                                                  <div class="form-group">
                                                  <label><b>Medicamento / Forma farmaceutica</b></label>
                                                  <div id="borderMedicamento">
                                                    <select id="select_medicamento" onchange="indicarInteraccion()" class="form control select2 selectpicker" style="width: 100%">
                                                        <option value="0">-Seleccionar-</option>
                                                        <?php foreach ($Medicamentos as $value) {?>
                                                        <option value="<?=$value['medicamento_id']?>" ><?=$value['medicamento']?></option>
                                                        <?php } ?>
                                                    </select>
                                                  </div>

                                                  </div>

                                                  <!-- Formulario para antibiotico NTP
                                                  *El formulrio es desplegado en una ventana modal* -->
                                                  <div class="form-group form-antibiotico-npt" hidden>
                                                     <input class="form-control" id="categoria_safe"/>
                                                     <input class="form-control aminoacido" />
                                                     <input class="form-control dextrosa" />
                                                     <input class="form-control lipidos-intravenosos" />
                                                     <input class="form-control agua-inyectable" />
                                                     <input class="form-control cloruro-sodio" />
                                                     <input class="form-control sulfato-magnesio" />
                                                     <input class="form-control cloruro-potasio" />
                                                     <input class="form-control fosfato-potasio" />
                                                     <input class="form-control gluconato-calcio" />
                                                     <input class="form-control albumina" />
                                                     <input class="form-control heparina" />
                                                     <input class="form-control insulina-humana" />
                                                     <input class="form-control zinc" />
                                                     <input class="form-control mvi-adulto" />
                                                     <input class="form-control oligoelementos" />
                                                     <input class="form-control vitamina" />
                                                     <input class="form-control total-npt" />
                                                     <!-- Campos antimicrobianos y oncologicos -->
                                                     <input class="form-control diluyente" />
                                                     <input class="form-control vol_diluyente" />
                                                  </div>
                                                  <!-- Fin formulario para antibiotico NTP -->
                                                </div>



                                                <div class="col-sm-3">
                                                  <label><b>Via de administración</b></label>
                                                  <div class="input-group" id="borderVia">
                                                    <div id="opcion_vias_administracion">
                                                      <select class="form control select2 width100" id="via">
                                                        <option value="0">-Seleccionar-</option>
                                                      </select>
                                                    </div>
                                                    <span class="input-group-btn">
                                                      <button class="btn btn-default btn_otra_via" type="button" value="0" title="Indicar otra via de administración">Otra</button>
                                                    </span>
                                                  </div>
                                                </div>
                                                <div class="col-sm-1" style="padding-right: 0;">
                                                  <div class="form-group" >
                                                    <label ><b>Dosis</b></label>
                                                    <div id="borderDosis">
                                                    <input type="number" min='0' id="input_dosis" class="form-control">
                                                    <label id="dosis_max" hidden></label>
                                                    <label id="gramaje_dosis_max" hidden></label>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-sm-1" style="padding-left: 0; padding-right: 0;">
                                                  <div class="form-group" >
                                                    <label ><b>Unidad</b></label>
                                                    <div id="borderUnidad">
                                                    <select name="" id="select_unidad" class="form-control">
                                                      <option value="0">-Unidad-</option>
                                                      <option value="g">g</option>
                                                      <option value="mg">mg</option>
                                                      <option value="mcg">mcg</option>
                                                      <option value="mL">mL</option>
                                                      <option value="UI">UI</option>
                                                    </select>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="col-sm-2" style="padding-right: 0;">
                                                  <label><b>Frecuencia</b></label>
                                                  <div id="borderFrecuencia">
                                                  <select class="form-control" id="frecuencia" onchange="asignarHorarioAplicacion()" >
                                                    <option value="0">- Frecuencia -</option>
                                                    <option value="4 hrs">4 hrs</option>
                                                    <option value="6 hrs">6 hrs</option>
                                                    <option value="8 hrs">8 hrs</option>
                                                    <option value="12 hrs">12 hrs</option>
                                                    <option value="24 hrs">24 hrs</option>
                                                    <option value="48 hrs">48 hrs</option>
                                                    <option value="72 hrs">72 hrs</option>
                                                    <option value="Dosis unica">Dosis unica</option>
                                                  </select>
                                                  </div>
                                                </div>

                                                <!-- identificador de los medicamentos con interaccion interaccion_amarilla,
                                                     el select se llena al seleccionar un medicamento -->
                                                <div hidden class="col-sm-2">
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

                                                <div class="col-sm-3" style="padding-left: 0;">
                                                  <label><b>Aplicación</b></label>
                                                  <div class="input-group" id="borderAplicacion">
                                                    <input type="text" class="form-control" id="aplicacion" disabled='disabled' >
                                                    <span class="input-group-btn">
                                                      <button class="btn btn-default edit-aplicacion" type="button" value="0" title="Cambiar el horario de aplicación">Cambiar</button>
                                                    </span>
                                                  </div>
                                                </div>

                                                <div class="col-sm-2" style="padding-left: 0;">
                                                  <label><b>Fecha inicio</b></label>
                                                  <div id="borderFechaInicio">
                                                  <input id="fechaInicio" onchange="mostrarFechaFin()" class="form-control dd-mm-yyyy"  name="" placeholder="06/10/2016">
                                                  </div>
                                                </div>
                                                <!-- El div cambia dependiendo el medicamento que sea prescrito -->
                                                <div class="tiempo_tipo_medicamento">


                                                </div>





            <!-- <div class="col-lg-6">
            <div class="input-group">
            <input type="text" id="contador" class="form-control" placeholder="1" value="1">
            <span class="input-group-btn">
            <button class="btn btn-default" id="carga" onClick="sube()" type="button">Carga</button>
            </span>
            <span class="input-group-btn">
            <button class="btn btn-default" id="descarga" onClick="baja()" type="button">Descarga</button>
            </span>
            </div>
            </div> -->

                                              </div>

                                              <div class="col-sm-8" style="padding: 0;" >
                                                <label><b>Observaciones para la prescripción</b></label>
                                                <div id="borderFechaFin">
                                                <input name="observacion_prescripcion" class="form-control" id="observacion"   name="" >
                                                </div>
                                              </div>
                                              <div class="col-sm-2">
                                                <div class="form-group" style="padding-top:23px;" >
                                                  <div hidden id="div_btnActualizarPrescripcion">
                                                      <button type="button"  id="btnActualizarPrescripcion" class="btn back-imss btn-block" onclick="actualizarPrescripcion()"> MODIFICAR </button>
                                                  </div>
                                                  <div id="btn-form-npt" hidden>
                                                    <button type="button" class="btn back-imss btn-block edit-form-npt">MODIFICAR NPT </button>
                                                  </div>
                                                  <div id="btn-form-onco-anti" hidden>
                                                    <button type="button" class="btn back-imss btn-block edit-form-onco-anti">DILUYENTE</button>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-sm-2" style="padding-right: 0">
                                                <div class="form-group" style="padding-top:23px;">
                                                  <div class="btn_agregarPrescripcion">
                                                      <button type="button" class="btn back-imss btn-block"  onclick="agregarPrescripcion()"> AGREGAR </button>
                                                  </div>
                                                  <div class="btn_modificarPrescripcion" hidden>
                                                      <button type="button" class="btn back-imss btn-block" data-value="" id="btn_modificar_prescripcion"> MODIFICAR </button>
                                                  </div>
                                                </div>
                                              </div>
                                              <table style="width:100%;">
                                                <thead >
                                                  <tr>
                                                    <th colspan='11' class="back-imss">Medicamentos agregados</th>
                                                  </tr>
                                                  <tr>
                                                    <th hidden >ID</th>
                                                    <th>Medicamento</th>
                                                    <th>Cat F.</th>
                                                    <th>Dosis</th>
                                                    <th>Vía</th>
                                                    <th>Frecuencia</th>
                                                    <th>Aplicación</th>
                                                    <th>Inicio</th>
                                                    <th>Duración</th>
                                                    <th>Periodo</th>
                                                    <th>Fin</th>
                                                    <th>Opciones</th>
                                                  </tr>
                                                </thead>
                                                <tbody id="tablaPrescripcion">
                                                </tbody>
                                              </table>
                                            </div>
                                            <!-- Fin formulario prescripcion-->

                                        <br/>
                                        <div class="col-sm-12" id="divCuidadosGenerales" style="padding:0">
                                          <div class="col-sm-12" style="padding:0">
                                            <div class="form-group">
                                              <label><b>g) Solicitud de estudios de laboratorio y rayos x: &nbsp;  </b></label><input type="checkbox" id="check_estudios">&nbsp;<label id="label_check_estudios">- SI</label>
                                              <div class="solicitud_laboratorio" hidden>
                                                  <textarea class="form-control" name="nota_solicitud_laboratorio" rows="4" placeholder="Indicar los estudios a realizar"><?=$Nota['nota_solicitud_laboratorio']?></textarea>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                <div class="form-group">

                                    <h4>
                                      <span class = "label back-imss border-back-imss">SOLICITUD DE INTERCONSULTAS</span>
                                      <input type="checkbox" name="check_solicitud_interconsulta" value="0" >
                                      <label id="lbl_check_interconsulta">- SI</label>
                                    </h4>

                                        <div class="input-group m-b nota_interconsulta" style='display:none' >
                                          <span class="input-group-addon  back-imss border-back-imss"><i class="fa fa-user-plus"></i></span>
                                              <select class="select2" multiple="" name="nota_interconsulta[]" id="nota_interconsulta" data-value="" style="width: 100%">
                                                <?php foreach ($Especialidades as $value) {?>
                                                <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                                                <?php } ?>
                                              </select>
                                        </div>
                                </div>
                                <div class="form-group nota_interconsulta" style='display:none' >
                                  <label for=""><b>MOTIVO</b></label>
                                  <textarea class="form-control" name="motivo_interconsulta" rows="2"><?=$Interconsultas[0]['motivo_interconsulta'] ?></textarea>
                                </div>

                    </div>


                        <div class="col-sm-12">
                            <div class="form-group" >
                              <label class="mayus-bold">¿ES MÉDICO RESIDENTE?</label>&nbsp;&nbsp;&nbsp;
                              <?php
                              foreach ($Usuario as $value) {
                                 $servicio = substr($value['empleado_matricula'],0,8);
                               }
                              $bloquear = "disabled";
                              if(count($Residentes) > 1 || $servicio == 'Servicio'){
                                $checkSi = "checked=''";
                                $residentesForm = "";
                              }else{
                                 $checkNo = "checked=''";
                                 $residentesForm = "hidden";
                              }
                              if($_GET['a']=='add'){
                                $bloquear = "";
                              ?>
                                <?=$usu['usuario'] ?>
                                <label class="md-check">
                                    <input type="radio" name="residente" <?=$checkSi ?> value="Si" data-value="<?=$Nota['notas_esresidente']?>">
                                    <i class="blue"></i>Si
                                </label>&nbsp;&nbsp;&nbsp;
                                <label class="md-check">
                                    <input type="radio" name="residente" <?=$checkNo ?> value="No" >
                                    <i class="blue"></i>No
                                </label>
                              <?php } ?>
                            </div>
                        </div>
                         <div class="col-sm-12 medico_residente <?=$residentesForm ?> ">
                           <div class="form-group">
                            <div class="col-sm-8">
                              <label>Medico de Base:</label>
                              <?php
                              if($_GET['a'] == 'add'){ ?>
                                <select class="select2 width100" name="interConMedicoBase" id="interConMedicoBase">
                                  <option value="" disabled selected>Nombre(s) / Apellido(s)</option>
                                  <?php
                                  foreach ($MedicosBase as $value) { ?>
                                    <option value="<?=$value['empleado_matricula'] ?>"><?=$value['empleado_nombre'] ?> <?=$value['empleado_apellidos'] ?></option>
                                  <?php } ?>
                                </select>
                              <?php }
                              else{

                                foreach ($MedicosBaseNota as $value) { ?>
                                    <input type="text" class="form-control" id="" name="nombre_residente[]" placeholder="Nombre(s)" value="<?= $value['empleado_nombre']?> <?= $value['empleado_apellidos']?>" <?=$bloquear ?> >
                                <?php }
                              } ?>
                            </div>
                            <div class="col-sm-3">
                              <label style="color: white;">C </label>
                              <?php
                              if($_GET['a'] == 'add'){ ?>
                                    <input class="form-control" id="medicoMatricula" type="text" name="medicoMatricula" placeholder="Matrícula Medico" value="" <?=$bloquear ?>>
                              <?php }
                              else{
                                foreach ($MedicosBaseNota as $value) { ?>
                                    <input class="form-control" id="medicoMatricula" type="text" name="medicoMatricula" placeholder="Matrícula Medico" value="<?=$value['empleado_matricula']?>" <?=$bloquear ?>>
                                <?php }
                              } ?>
                            </div>
                            <div class="col-sm-1">
                            <label style="color: white;">B </label>
                            <?php if($_GET['a']=='add'){ ?>
                              <a href='#' class="btn btn-success btn-xs " style="width:100%;height:100%;padding:7px;" id="add_otro_residente"><span class="glyphicon glyphicon-plus "></span></a>
                            <?php } ?>
                            </div>
                           </div>
                            <label></label>
                        </div>
                        <div id="medicoResidente">
                          <?php for($i = 0; $i < count($Residentes); $i++){?>
                             <div class="col-sm-12 form-group">
                               <div class="col-sm-4">
                                 <input type="text" class="form-control" id="medico<?=$i ?>" name="nombre_residente[]" placeholder="Nombre(s)" value="<?=$Residentes[$i]['nombre_residente']?>" <?=$bloquear ?> >
                               </div>
                               <div class="col-sm-4">
                                 <input type="text" class="form-control" id="medico<?=$i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?=$Residentes[$i]['apellido_residente']?>" <?=$bloquear ?> >
                               </div>
                               <div class="col-sm-4">
                                 <input type="text" class="form-control" id="medico<?=$i ?>" name="cedula_residente[]" placeholder="Cédula Profesional" value="<?=$Residentes[$i]['cedulap_residente']?>" <?=$bloquear ?> >
                               </div>
                             </div>
                           <?php } ?>
                        </div>

                            <div class="row">
                            <div class="col-sm-7 <?=$_GET['inputVia']=='Médico Torres Hospitalización' ? '':'hide'?>">

                                <div class="form-group notas_medicotratante hide">
                                    <select class="select2 width100" name="notas_medicotratante" data-value="<?=$Nota['notas_medicotratante']?>">
                                        <option value="">SELECCIONAR MÉDICO TRATANTE</option>
                                        <?php foreach ($Medicos as $value) {?>
                                        <option value="<?=$value['empleado_id']?>"><?=$value['empleado_matricula']?> - <?=$value['empleado_nombre']?> <?=$value['empleado_apellidos']?></option>
                                            <?php }?>
                                    </select>

                                    </div>
                                </div>
                       <div class="<?=$_GET['inputVia']=='Médico Torres Hospitalización' ? 'col-sm-2':'col-sm-offset-10 col-sm-2'?>">

                                    <input type="hidden" name="csrf_token" >
                                    <input type="hidden" name="triage_id" value="<?=$_GET['folio']?>">
                                    <input type="hidden" name="accion" value="<?=$_GET['a']?>">
                                    <input type="hidden" name="notas_id" value="<?=$this->uri->segment(4)?>">
                                    <input type="hidden" name="via" value="<?=$_GET['via']?>">
                                    <input type="hidden" name="inputVia" value="<?=$_GET['inputVia']?>">
                                    <input type="hidden" name="doc_id" value="<?=$_GET['doc_id']?>">
    <!-- BOTON GUARDAR -->          <button class="btn back-imss pull-right btn-block" type="submit" style="margin-bottom: -10px">Guardar</button>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url('assets/js/sections/Documentos.js?'). md5(microtime())?>" type="text/javascript"></script>

<script>
$(document).ready(function() {
    $('.Form-Notas-COC').submit(function (e) {
        e.preventDefault();
        SendAjax($(this).serialize(),'Sections/Documentos/AjaxNotas',function (response) {
            if(response.accion=='1'){
                window.opener.location.reload();
                window.top.close();
                AbrirDocumentoMultiple(base_url+'Inicio/Documentos/GenerarNotas/'+response.notas_id+'?inputVia='+$('input[name=inputVia]').val(),'NOTAS');
            }
        },'','No');
    });
});
</script>
