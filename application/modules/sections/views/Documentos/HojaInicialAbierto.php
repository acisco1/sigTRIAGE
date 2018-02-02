<?= modules::run('Sections/Menu/index'); ?> 
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-11 col-centered" style="margin-top: 10px ">
            <div class="box-inner ">
                <?php if($SignosVitales['sv_ta']==''){?>
                <div class="row " style="margin-top: -10px;padding: 16px;">
                    <div class="col-md-12 col-centered back-imss" style="padding:10px;margin-bottom: -7px;">
                        <h6 style="font-size: 20px;text-align: center">
                            <b>EN ESPERA DE CAPTURA DE SIGNOS VITALES</b>
                        </h6>
                    </div>
                </div>
                <?php }else{ ?>
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
                    <div class="col-md-3 text-center back-imss" style="padding-left: 0px;padding: 20px;">
                        <h5 class=""><b>PRESIÓN ARTERIAL</b></h5>
                        <h3 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_ta']?></h3>
                    </div>
                    <div class="col-md-3  text-center back-imss" style="border-left: 1px solid white;padding: 20px;">
                        <h5><b>TEMPERATURA</b></h5>
                        <h3 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_temp']?> °C</h3>
                    </div>
                    <div class="col-md-3  text-center back-imss" style="border-left: 1px solid white;padding: 20px;">
                        <h5><b>FRECUENCIA CARDÍACA </b></h5>
                        <h3 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_fc']?> (lpm)</h3>
                    </div>
                    <div class="col-md-3  text-center back-imss" style="border-left: 1px solid white;padding: 20px;">
                        <h5><b>FRECUENCIA RESPIRATORIA</b></h5>
                        <h3 style="margin-top: -8px;font-weight: bold"> <?=$SignosVitales['sv_fr']?> (rpm)</h3>
                    </div>
                </div>
                <?php }?>
                <div class="panel panel-default " style="margin-top: -8px">
                    
                    <div class="panel-heading p teal-900 back-imss" style="padding-bottom: 0px;">
                        <span style="font-size: 18px;font-weight: 500;text-transform: uppercase">  
                            <div class="row" style="margin-top: -20px;">
                                <div style="position: relative">
                                    <div style="top: 4px;margin-left: -1px;position: absolute;height: 105px;width: 35px;" class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>"></div>
                                </div>
                                <div class="col-md-10" style="padding-left: 40px">
                                    <h3>
                                        
                                        <b>PACIENTE:  <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?></b>
                                    </h3>
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
                                <div class="col-md-2 text-right">
                                    <h3>
                                        <b>EDAD</b>
                                    </h3>
                                    <h2 style="margin-top: -10px">
                                        <?php 
                                        if($info['triage_fecha_nac']!=''){
                                            $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                                            echo $fecha->y.' <span style="font-size:25px"><b>Años</b></span>';
                                        }else{
                                            echo 'S/E';
                                        }
                                        ?>
                                    </h2>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="panel-body b-b b-light">
                        <div class="card-body" style="padding: 20px 0px;">     
                            <form class="guardar-solicitud-hi-abierto" style="margin-top: 0px" oninput="x.value=parseInt(hf_eva.value)">
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
                                            <label><b>MOTIVO DE CONSULTA</b></label>
                                            <textarea class="form-control hf_motivo_abierto" rows="5" name="hf_motivo" placeholder="Escriba aquí el Motivo de la consulta"><?=$hojafrontal[0]['hf_motivo']?>
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label><b>ANTECEDENTES</b></label>
                                            <textarea class="form-control" rows="6" name="hf_antecedentes" placeholder="Escriba aquí los antecedentes"><?=$hojafrontal[0]['hf_antecedentes']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label><b>PADECIMIENTO ACTUAL</b></label>
                                            <textarea class="form-control" rows="5" name="hf_padecimientoa" placeholder="Escriba aquí el/los pacedimiento actual"><?=$hojafrontal[0]['hf_padecimientoa']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label><b>EXPLORACION FISICA</b></label>
                                            <textarea class="form-control" rows="8" name="hf_exploracionfisica"><?=$hojafrontal[0]['hf_exploracionfisica']?></textarea>
                                        </div>
                                         
                                        <label><b>ESCALA DE GLASGOW</b></label><br>

                                        APERTURA OCULAR:
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
                                      
                                            RESPUESTA MOTORA:
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
                                        
                                            REPUESTA VERBAL:
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
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <b>RIESGO DE CAÍDA</b><br>
                                            <label class="md-check">
                                            <input type="radio" name="hf_riesgocaida" data-value="<?=$hojafrontal[0]['hf_riesgocaida']?>" value="Alta" class="has-value"><i class="red"></i>Alta
                                            </label>&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">    
                                            <input type="radio" name="hf_riesgocaida" data-value="<?=$hojafrontal[0]['hf_riesgocaida']?>" value="Media" class="has-value"><i class="red"></i>Media
                                            </label>&nbsp;&nbsp;&nbsp;
                                            <label class="md-check">
                                            <input type="radio" name="hf_riesgocaida" data-value="<?=$hojafrontal[0]['hf_riesgocaida']?>" value="Baja" class="has-value"><i class="red"></i>Baja
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><b>ESCALA DE DOLOR (EVA)</b></label><br>
                                            <input type="range" name="hf_eva" min="0" max="10" value="0"><output name="x" for="hf_eva">=</output>
                                        </div>
                                   </div>
<!--
                                <div class="col-md-4">                             
                                    <div class="form-group">
                                        <label><b>RIESGO DE TROMBOSIS</b></label>
                                        <input type="text" value="<?=$hojafrontal[0]['hf_riesgo_trombosis']?>" class="form-control">
                                    </div>
                                </div> -->
    <!--
    <div class="col-md-4">
        <label><b>EDAD</b></label><br>
        <input type="checkbox" name="rt1" value="1">&nbsp;Edad: 40-60 años<br>
        <input type="checkbox" name="rt2" value="2">&nbsp;Edad: 61-74 años<br>
        <input type="checkbox" name="rt3" value="3">&nbsp;Edad: 75 años o más
    </div>
</div>
<div class="form-group"> 
    <div class="col-md-4">
        <b>PARA MUJERES SOLAMENTE</b><br>
        <input type="checkbox" name="rt4" value="1">&nbsp;Uso de terapia de remplazo hormonal<br>
        <input type="checkbox" name="rt5" value="2">&nbsp;Embarazo o parto en el último mes<br>
        <p><input type="checkbox" name="rt6" value="3"><span>&nbsp;Historia de muerte inexplicable de recién nacidos, abortos expontáneos (más de 3), hijos prematuros o con restricción del crecimento</p></span>
    </div>
</div>
    <div class="col-md-4">
        <label><b>CRUGÍA</b></label><br>
        <input type="checkbox" name="rt7" value="1">&nbsp;Cirugía menor prevista (≤ 45 minutos)<br>
        <input type="checkbox" name="rt8" value="2">&nbsp;Antecedentes de cirugía mayor (≥ 45 minutos) en el último mes<br>
        <input type="checkbox" name="rt9" value="3">&nbsp;Cirugía mayor a 45 minutos (incluyendo laparoscopía o artroscopia)<br>
        <input type="checkbox" name="rt10" value="3">&nbsp;Cirugía de remplazo de cadera o rodilla
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-4">
        <label><b>HISTORIA DE...</b></label><br>
        <input type="checkbox" name="rt11" value="1">&nbsp;Historia de trombosis, trombosis venosa profunda (TVP) o tromboembolia pulmonar (TEP)<br>
        <input type="checkbox" name="rt12" value="1">&nbsp;Historia familiar de trombosis<br>
        <input type="checkbox" name="rt13" value="1">&nbsp;Historia familiar o personal de pruebas de sangre positivas que indican incremento en el riesgo de trombosis
    </div>
    <div class="col-md-4">
        <label><b>ANTECEDENTES CON MENOS DE UN MES</b></label><br>
        <input type="checkbox" name="rt14" value="1">&nbsp;Infarto de miocardio ( ≤ 1 mes)<br>
        <input type="checkbox" name="rt15" value="1">&nbsp;Insuficiencia cardiaca congestiva ( ≤ 1 mes)<br>
        <input type="checkbox" name="rt16" value="1">&nbsp;Infección grave (neumonía) ( ≤ 1 mes)<br>
        <input type="checkbox" name="rt17" value="1">&nbsp;Enfermedad pulmonar (Enfisema o EPOC) ( ≤ 1 mes)<br>
        <input type="checkbox" name="rt18" value="1">&nbsp;Transfusión  sanguínea ( ≤ 1 mes)
    </div>
    <div class="col-md-4">
        <label><b>COMORBILIDADES</b></label><br>
        <input type="checkbox" name="rt19" value="1">&nbsp;Historia de enfermedad inflamatoria intestinal (CUCI o Crohn)<br>
        <input type="checkbox" name="rt20" value="1">&nbsp;Antecedente de cáncer (excluyendo cáncer de piel, no melanoma)<br>
        <input type="checkbox" name="rt21" value="1">&nbsp;Obesidad (índice de masa corporal ≥ de 30 y ≤ de 40)<br>
        <input type="checkbox" name="rt22" value="1">&nbsp;Obesidad mórbida (índice de masa corporal mayor a 40)
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label><b>ORTOPEDIA Y TRAUMATISMOS</b></label><br>
        <input type="checkbox" name="rt23" value="1">&nbsp;Fractura de cadera pelvis o pierna<br>
        <input type="checkbox" name="rt24" value="1">&nbsp;Traumatismo grave (accidente automovilístico, fracturas múltiples)<br>
        <input type="checkbox" name="rt25" value="1">&nbsp;Lesión de la médula espinal con parálisis
    </div>
    <div class="col-md-4">
        <label><b>EXPLORACIÓN</b></label><br>
        <input type="checkbox" name="rt26" value="1">&nbsp;Venas varicosas visibles<br>
        <input type="checkbox" name="rt27" value="1">&nbsp;Edema de piernas<br>
        <input type="checkbox" name="rt28" value="1">&nbsp;Inmovilizador o yeso en miembros inferiores que no permite movilización en el último mes<br>
        <input type="checkbox" name="rt29" value="1">&nbsp;Catéter en vasos sanguíneos del cuello o tórax que lleva sangre o medicamentos al corazón en el último mes<br>
        <input type="checkbox" name="rt30" value="1">&nbsp;Confinado en cama por  72 horas o más
    </div>
</div> -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><b>MÉTODOS AUXILARES DE DIAGNÓSTICO</b></label>
                                            <textarea class="form-control" rows="2" name="hf_auxiliares" placeholder="Anote los análisis clínicos de laboratorio, los estudios de gabinete radiológico y otros"><?=$hojafrontal[0]['hf_auxiliares']?></textarea>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label><b>DIAGNÓSTICO DE INGRESO</b></label>
                                            <textarea class="form-control hf_textarea" rows="3" name="hf_diagnosticos_lechaga" required><?=$hojafrontal[0]['hf_diagnosticos_lechaga']?></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><b>DIAGNÓSTICOS SECUNDARIOS (COMORBILIDADES)</b> 
                                                <i class="fa fa-plus-circle pointer plantilla-add icono-accion" onclick="AbrirDocumento(base_url+'Sections/Plantillas/SeleccionarContenido?plantilla=Diagnosticos&input=hf_diagnosticos&type=textarea')"></i>
                                            </label>
                                            <textarea class="form-control hf_diagnosticos hf_diagnosticos_abierto" rows="10" name="hf_diagnosticos">
                                                <?=$hojafrontal[0]['hf_diagnosticos']?></textarea>
                                        </div>
                                       
                                        <div class="form-group">        
                                           
                                           <label><b>PLAN Y ORDENES MÉDICAS</b></label>
                                                <div>
                                                   <label><b>a) Ayuno:</b></label>
                                                   <input class="form-control" type="text" name="hf_ayuno" placeholder="Instrucciones de ayuno" value="<?=$hojafrontal[0]['hf_ayuno']?>"></div><br>
                                                <div>
                                                <label><b>b) Signos vitales y cuidados de enfermeria</b></label>
                                                <input class="form-control" type="text" name="hf_signosycuidados" placeholder="Instrucciones de signos vitales y cuidados de enfermeria" value="<?=$hojafrontal[0]['hf_signosycuidados']?>">
                                                </div>
                                                <br>
                                            <div>
                                                <label><b>c) Indicaciones y cuidados de enfermeria</b></label>
                                                <textarea class="form-control" name="hf_cuidadosenfermeria" placeholder="Cuidados especificos de enfermeria"><?=$hojafrontal[0]['hf_cuidadosenfermeria']?></textarea>
                                            </div><br>
                                            <div>
                                            <label><b>d) Soluciones Parenterales</b></label>
                                                <textarea class="form-control" name="hf_solucionesp" placeholder="Soluciones Parenterales"><?=$hojafrontal[0]['hf_solucionesp']?></textarea>
                                            </div><br>
                                            <div>
                                            <label><b>e) Medicamentos</b></label>
                                                <textarea class="form-control" name="hf_medicamentos" placeholder="Anote aquí los Medicamentos"><?=$hojafrontal[0]['hf_medicamentos']?></textarea>
                                            </div>
                                        </div>
                                                                               
                                        <div class="form-group">
                                            <label><b>PRONÓSTICOS</b></label> <!-- tabla de hf_indicaciones en --> 
                                            <textarea class="form-control" rows="3" name="hf_indicaciones"><?=$hojafrontal[0]['hf_indicaciones']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label><b>ESTADO DE SALUD</b></label>
                                            <textarea class="form-control" rows="4" name="hf_interpretacion"><?=$hojafrontal[0]['hf_interpretacion']?></textarea>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <?php if( $_GET['tipo']=='Consultorios'){?>
                                        <div class="form-group">
                                            <?php if($ce[0]['ce_status']=='Salida'){?>
                                            <label><b>ALTA A :</b> </label> <?=$ce[0]['ce_hf']?>
                                            <?php }else{?>
                                            <label><b>ACCIÓN: </b></label>
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
                                            <label class="text-color-white">.</label>
                                            <input type="text" name="hf_alta_otros" placeholder="Indique otra acción" value="<?=$hojafrontal[0]['hf_alta_otros']?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><b>VALORACION POR:</b></label>
                                            <input type="text" name="hf_interconsulta" placeholder="Indique si necesita interconsulta" value="<?=$hojafrontal[0]['hf_interconsulta']?>" class="form-control">
                                        </div>
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
<script src="<?= base_url('assets/js/sections/Documentos.js?md5='). md5(microtime())?>" type="text/javascript"></script>
<script type="text/JavaScript">


