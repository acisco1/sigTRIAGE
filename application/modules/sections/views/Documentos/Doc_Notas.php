<?= modules::run('Sections/Menu/HeaderBasico'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-11 col-centered" style="margin-top: 10px">
        <div class="box-inner">
            <style>
            hr.style-eight{
              border: 0;
              border-top: 4px double #8c8c8c;
              text-align: center;
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
              border-bottom: 1px solid #ddd;
            }
            </style>
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss text-center scroll-box" style="">
                    <div class="row" style="margin-top: -15px!important;">
                        <div style="position: relative;">
                            <div style="top: -1px;margin-left: -1px;position: absolute;height: 112px;width: 35px;" class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>"></div>
                        </div>
                        <div class="col-sm-9 text-left" style="padding-left: 40px">
                            <h4>
                                <b>PACIENTE</b>: <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
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
                        <div class="col-sm-3 text-right">
                            <h3><b>EDAD</b></h3>
                            <h1 style="margin-top: -10px">
                                <?php
                                if($info['triage_fecha_nac']!=''){
                                    $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                    echo $fecha->y.' <span style="font-size:25px"><b>Años</b></span>';
                                }else{
                                    echo 'S/E';
                                }
                                ?>
                            </h1>
                        </div>
                    </div>
                </div>
                <style> .wysiwyg-text-align-center {text-align: center;}</style>
                <div class="panel-body b-b b-light scrollspy-body">
                    <div class="card-body" style="padding: 20px 0px;">
                        <form class="Form-Notas-COC" oninput="x.value=parseInt(nota_eva.value)">
                            <div class="row" >
                                <div class="col-md-7" style="margin-top: -10px">
                                    <div class="form-group">
                                        <div class="input-group m-b">
                                            <span class="input-group-addon back-imss border-back-imss">SELECCIONAR TIPO DE NOTA</span>
                                            <select name="notas_tipo" class="form-control" data-value="<?=$Nota['notas_tipo']?>" required>
                                                <option value="" selected hidden>NOTAS</option>
                                                <?php foreach ($Documentos as $value) {?>
                                                <option value="<?=$value['doc_nombre']?>"><?=$value['doc_nombre']?></option>
                                                <?php }?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><b>PRESION ARTERIAL (mmHg)</b></label>
                                        <input class="form-control"  name="sv_ta" value="<?=$SignosVitales['sv_ta']?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><b>TEMPERATURA (°C)</b></label>
                                        <input class="form-control" name="sv_temp"  value="<?=$SignosVitales['sv_temp']?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><b>FRECUENCIA CARDIACA (lpm)</b></label>
                                        <input class="form-control" name="sv_fc"  value="<?=$SignosVitales['sv_fc']?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><b>FREC. RESPIRATORIA (rpm)</b></label>
                                        <input class="form-control" name="sv_fr"  value="<?=$SignosVitales['sv_fr']?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><b>SP02 (%)</b></label>
                                        <input class="form-control" name="sv_oximetria"  value="<?=$SignosVitales['sv_oximetria']?>">
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="control-group">
                                        <label><b>GLUCOSA (mg/dl)</b></label>
                                        <input class="form-control" name="sv_dextrostix"  value="<?=$SignosVitales['sv_dextrostix']?>">
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="control-group">
                                        <label><b>PESO (kg)</b></label>
                                        <input class="form-control" name="sv_peso"  value="<?=$SignosVitales['sv_peso']?>">
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="control-group">
                                        <label><b>TALLA (cm)</b></label>
                                        <input class="form-control" name="sv_talla"  value="<?=$SignosVitales['sv_talla']?>">
                                    </div>

                                </div>
       <!-- COMIENZA LOS CAMPOS DEL FORMULARIO PARA LA NOTA MEDICA -->
                <?php
                $visibleInterconsulta = "hidden";
                if($Nota['notas_tipo']=='NOTA DE INTERCONSULTA'){
                  $visibleInterconsulta = "";
                } ?>
                <div class="col-sm-12 nota_motivoInterconsulta <?=$visibleInterconsulta ?>">
                    <h4><span class = "label back-imss border-back-imss">MOTIVO DE INTERCONSULTA</span></h4>
                    <textarea class="form-control" name="nota_motivoInterconsulta" rows="2" placeholder="Anote el motivo de la interconsulta"><?=$Nota['nota_motivoInterconsulta']?></textarea>
                </div>
                    <div class="col-sm-12" >
                                <h4><span class = "label back-imss border-back-imss">EVOLUCION Y/O ACTUALIZACION DEL CUADRO CLINICO</span></h4>

                                    <div class="form-group">
                                        <label><b>INTERROGATORIO</b></label>
                                        <textarea class="form-control" name="nota_interrogatorio" rows="10" placeholder="Interrogatorio directo o indirecto"><?=$Nota['nota_interrogatorio']?></textarea>
                                    </div>
                                <div class="form-group">
                                        <label><b>EXPLORACION FISICA</b></label>
                                        <textarea class="form-control" name="nota_exploracionf" rows="10" placeholder=""><?=$Nota['nota_exploracionf']?></textarea>
                                </div>
                    </div>
                    <div class="col-md-3">
                        <label><b>ESCALA DE GLASGOW</b></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-toggle="modal" data-target='#myModal1' placeholder="Clic para colocar valor" name="hf_escala_glasgow" value="<?=$Nota['nota_escala_glasgow']?>">
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
                                            <input type="radio" name="hf_riesgo_caida" data-value="<?=$Nota['hf_riesgo_caida']?>" value="Alta" class="has-value"><i class="red"></i>Alta
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
                                                 <input type="range" name="nota_eva" value="<?=$Nota['nota_eva']?>" min="0" max="10" value="0">
                                                </div>
                                                <div class="col-sm-6" style="width:10px;height:30px;border:1px solid blue;">
                                                    <output name="x" for="nota_eva"><?=$Nota['nota_eva']?></output>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                        <div class="col-md-3">
                        <label><b>RIESGO DE TROMBOSIS</b></label>
                            <div class="input-group">
                                <input type="text" class="form-control" data-toggle="modal" data-target='#myModal2' placeholder="Clic para colocar valor" name="nota_riesgotrombosis" id="puntos_rt" value='<?=$Nota['nota_riesgotrombosis']?>'>
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
                                    <h4><span class = "label back-imss border-back-imss">RESULTADOS DE SERVICIO AUXILIARES DE DIAGNOSTICO</span></h4>
                                        <textarea class="form-control" name="nota_auxiliaresd" rows="5" placeholder=""><?=$Nota['nota_auxiliaresd']?></textarea>
                                    </div>
                                <div class="form-group">
                                    <h4><span class = "label back-imss border-back-imss">PROCEDIMIENTOS REALIZADOS</span></h4>
                                        <textarea class="form-control textWysihtml5" name="nota_procedimientos" rows="5" placeholder="Incluye intervencionismo en servicios auxiliares de diágnóstico"><?=$Nota['nota_procedimientos']?></textarea>
                                </div>
                                <div class="form-group">
                                        <h4><span class = "label back-imss border-back-imss">ACTUALIZACION DE DIAGNÓSTICO(S)</span></h4>
                                        <textarea class="form-control" name="nota_diagnostico" rows="5" placeholder="Anote diagnóstico y problemas clinicos"><?=$Nota['nota_diagnostico']?></textarea>
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
                                    <div class="form-group">
                                        <h4><span class = "label back-imss border-back-imss">PLAN Y ORDENES MÉDICAS</span></h4>
                                            <div>
                                                <label><b>a) Ayuno:</b></label>
                                                <input class="form-control" type="text" name="nota_ayuno" placeholder="Instrucciones de ayuno" value="<?=$Nota['nota_ayuno']?>"></div><br>
                                            <div>
                                                <label><b>b) Signos vitales y cuidados de enfermeria</b></label>
                                                <input class="form-control" type="text" name="nota_svycuidados" placeholder="Instrucciones de signos vitales y cuidados de enfermeria" value="<?=$Nota['nota_svycuidados']?>">
                                                </div>
                                                <br>
                                            <div>
                                                <label><b>c) Indicaciones y cuidados de enfermeria</b></label>
                                                <textarea class="form-control" name="nota_cuidadosenfermeria" placeholder="Cuidados especificos de enfermeria"><?=$Nota['nota_cuidadosenfermeria']?></textarea>
                                            </div><br>
                                            <div>
                                            <label><b>d) Soluciones Parenterales</b></label>
                                                <textarea class="form-control" name="nota_solucionesp" placeholder="Soluciones Parenterales"><?=$Nota['nota_solucionesp']?></textarea>
                                            </div><br>
                                            <div>
                                            <label><b>e) Prescripcion: </b></label>

                                                <button type="button" class="btn back-imss" onclick="agregarPrescripcion()"> Nueva </button>

                                                <!-- <textarea class="form-control" name="nota_medicamentos" placeholder="Anote aquí los Medicamentos"><?=$Nota['nota_medicamentos']?></textarea> -->


                                                <div class="row" id="contenedorFormularios">

                                        <div class="col-sm-12">
                                            <label><b>Medicamento</b></label>
                                            <div id="borderMedicamento">
                                              <select id="select_medicamento" class="form control select2 selectpicker" style="width: 100%" required>
                                                  <option value="0">-Seleccionar-</option>
                                                  <?php foreach ($Medicamentos as $value) {?>
                                                  <option ><?=$value['medicamento']?></option>
                                                  <?php } ?>
                                              </select>
                                            </div>

                                        </div>
                                        <div class="col-sm-2">
                                            <label><b>Via Administración</b></label>
                                            <div id="borderVia">
                                            <select class="select2 selectpicker" id="via_administracion" style="width: 100%" required>
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
                                          <select class="form-control" id="frecuencia" onchange="asignarHorarioAplicacion()" required>
                                            <option value="0">- Frecuencia -</option>
                                            <option value="6">6 hrs</option>
                                            <option value="8">8 hrs</option>
                                            <option value="12">12 hrs</option>
                                            <option value="24">24 hrs</option>
                                            <option value="48">48 hrs</option>
                                            <option value="72">72 hrs</option>
                                          </select>
                                          </div>
                                        </div>
                                        <div class="col-sm-3">
                                          <label><b>Aplicacion</b></label>
                                          <div id="borderAplicacion">
                                          <input id="aplicacion" class="form-control" type="text" name="" value="12:00 / 18:00 / 24:00 / 6:00">
                                          </div>
                                        </div>
                                        <div class="col-sm-2">
                                          <label><b>Fecha Inicio</b></label>
                                          <div id="borderFechaInicio">
                                          <input id="fechaInicio" onchange="mostrarFechaFin()" class="form-control dd-mm-yyyy" required name="" placeholder="06/10/2016">
                                          </div>
                                        </div>
                                        <div class="col-sm-1">
                                          <label><b>No. Dias</b></label>
                                          <div id="borderDuracion">
                                          <select id="duracion" onchange="mostrarFechaFin()" class="form-control">
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
                                        <div class="col-sm-2">
                                          <label><b>Fecha Fin</b></label>
                                          <div id="borderFechaFin">
                                          <input id="fechaFin"  required name="" >
                                          </div>
                                        </div>







                                    </div>
                                        </div>
                                        <table style="width:100%;">
                                          <thead >
                                            <tr>
                                              <th>Fecha</th>
                                              <th>Servicio</th>
                                              <th>Medico</th>
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
                                                <!-- Modal prescripcion -->
                                                <div class="modal fade" id="myModal3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" id="modalTamanioT">
                                                        <div class="modal-content">
                                                            <div class="modal-header container-fluid">
                                                                <div class="navbar-header">
                                                                    <a class="navbar-brand modal-title" href="#">Prescripcion Medica</a>
                                                                </div>
                                                                <ul class="nav navbar-nav navbar-right">
                                                                    <li>
                                                                        <a class="btn btn-default btn-md" id="agregarFormulario">Agregar Prescripcion</a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="close" data-dismiss="modal">&times;</a>
                                                                    </li>
                                                                </ul>

                                                            </div>

                                                            <div class="modal-body" data-spy="scroll" data-target="#myScrollspy" data-offset="20">

                                                            </div> <!-- modal-body  de riesgo de trombosis-->
                                                            <!-- Contenedor paral ingresar los nuevos formularios-->

                                                                <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="obtenerDatosPrescripcion()">Aceptar</button>
                                                                </div>

                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                    </div>
                                <div class="form-group">
                                    <h4><span class = "label back-imss border-back-imss">SOLICITUD DE INTERCONSULTAS</span></h4>
                                    <?php echo $nota_interconsulta; ?>
                                        <div class="input-group m-b">
                                             <span class="input-group-addon back-imss border-back-imss"><i class="fa fa-user-plus"></i></span>
                                              <select class="select2" multiple="" name="nota_interconsulta[]" id="nota_interconsulta" data-value="<?=$Nota['nota_interconsulta']?>" style="width: 100%">
                                                <?php foreach ($Especialidades as $value) {?>
                                                <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                                                <?php }?>
                                        </select>
                                    </div>
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
