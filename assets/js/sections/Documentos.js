var cont = 0;
$(document).ready(function () {
    $('.select2').select2();
    $('.hf_motivo_abierto').wysihtml5();
    $('.hf_antecedentes').wysihtml5();
    $('.hf_padecimientoa').wysihtml5();
    $('.hf_exploracionfisica').wysihtml5();
    $('.hf_textarea').wysihtml5();
    $('.hf_ayuno').wysihtml5();
    $('.hf_signosycuidados').wysihtml5();
    $('.hf_cuidadosenfermeria').wysihtml5();
    $('.hf_solucionesp').wysihtml5();
    $('.hf_medicamentos').wysihtml5();
    $('.hf_diagnosticos').wysihtml5();
    $('textarea[name=nota_interrogatorio]').wysihtml5();
    $('textarea[name=nota_exploracionf]').wysihtml5();
    $('textarea[name=nota_analisis]').wysihtml5();
    $('textarea[name=nota_motivoInterconsulta]').wysihtml5();
    $('textarea[name=nota_auxiliaresd]').wysihtml5();
    $('textarea[name=nota_procedimientos]').wysihtml5();
    $('textarea[name=nota_diagnostico]').wysihtml5();
    $('textarea[name=nota_pronosticos]').wysihtml5();
    $('textarea[name=nota_cuidadosenfermeria]').wysihtml5();
    $('textarea[name=nota_solucionesp]').wysihtml5();
    $('.nota_pronosticos').wysihtml5();
    //$('#nota_interconsulta').val($('#nota_interconsulta').attr('data-value').split(',')).select2();

    if($('input[name=accion]').val()!=undefined){
        $('#nota_interconsulta').val($('#nota_interconsulta').attr('data-value').split(',')).select2(); //divide cada seleccinado
    }
    var triage_paciente_accidente_lugar=$('input[name=pia_lugar_accidente]').val();
    if(triage_paciente_accidente_lugar=='TRABAJO'){
        $('.col-hojafrontal-info').removeClass('hide');
        $('textarea[name=hf_motivo]').keyup(function (e){
            $('textarea[name=asistentesmedicas_da]').val($(this).val());
        })
        $('textarea[name=hf_exploracionfisica]').keyup(function (e){
            $('textarea[name=asistentesmedicas_dl]').val($(this).val());
        })
        $('textarea[name=hf_diagnosticos]').keyup(function (e){
            $('textarea[name=asistentesmedicas_ip]').val($(this).val());
        })
        $('textarea[name=hf_indicaciones]').keyup(function (e){
            $('textarea[name=asistentesmedicas_tratamientos]').val($(this).val());
        })
    }else{
        $('body .hojafrontal-info').removeAttr('required');
    }
    $('select[name=hf_especialidad]').val($('select[name=hf_especialidad]').attr('data-value'))
    $('input[name=po_donador]').click(function (e) {
        if($(this).val()=='Si'){
            $('.po_donador').removeClass('hide');
        }else{
            $('select[name=po_criterio]').val('');
            $('.po_donador').addClass('hide');
        }
    })
    if($('input[name=po_donador]').attr('data-value')!='' && $('input[name=po_donador]').attr('data-value')=='Si'){
        $('input[name=po_donador][value="Si"]').attr('checked',true);
        $('.po_donador').removeClass('hide');
        $('select[name=po_criterio]').val($('select[name=po_criterio]').attr('data-value'))
    }
    $('input[name=hf_intoxitacion]').click(function (e) {
        if($(this).val()=='No'){
            $('.hf_intoxitacion').addClass('hide');
            $('input[name=hf_intoxitacion_descrip]').val('');
        }else{
            $('.hf_intoxitacion').removeClass('hide');
        }
    })
    if($('input[name=hf_intoxitacion]').attr('data-value')!='' && $('input[name=hf_intoxitacion]').attr('data-value')=='Si'){
        $('input[name=hf_intoxitacion]').attr('checked',true);
        $('.hf_intoxitacion').removeClass('hide');
    }
    $('.guardar-solicitud-hf').submit(function (e){
        e.preventDefault();
        $.ajax({
            url: base_url+"Sections/Documentos/GuardarHojaFrontal",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if($('input[name=tipo]').val()=='Consultorios'){
                    if($('input[name=ce_status]').val()!='Salida'){
                        GuardarDarAlta($('input[name=triage_id]').val());
                    }else{
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaFrontalCE/'+$('input[name=triage_id]').val(),'Hola Frontal',100);
                        if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',500);
                        }if($('input[name=hf_ministeriopublico]:checked').val()=='Si'){
                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/'+$('input[name=triage_id]').val(),'NMP',800);
                        }
                    }

                }else{
                    bootbox.hideAll();
                    AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaFrontalCE/'+$('input[name=triage_id]').val(),'Hola Frontal',100);
                    if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',500);
                    }if($('input[name=hf_ministeriopublico]:checked').val()=='Si'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/'+$('input[name=triage_id]').val(),'NMP',800);
                    }
                    ActionCloseWindowsReload();
                }
            },error: function (e) {
                bootbox.hideAll();
                msj_error_serve()
                ReportarError(window.location.pathname,e.responseText);
            }
        })
    })
    $('#radioAyuno').click(function(){
      $('#divSelectDietas').attr('hidden','true');
      $('#divOtraDieta').attr('hidden','true');
      $('#selectDietas').val('0');
      $('#inputOtraDieta').val('');
    });
    $('#radioDieta').click(function(){
      $('#divSelectDietas').removeAttr("hidden");
    });
    $('#selectDietas').change(function(){
      if($('#selectDietas').val() == 13){
        $('#divOtraDieta').removeAttr("hidden");
      }else{
        $('#divOtraDieta').attr("hidden",'true');
      }
    });
    $('#selectTomaSignos').change(function(){
      if( $(this).val() == '3' ){
        $('#divOtrasInidcacionesSignos').removeAttr('hidden');
      }else{
        $('#divOtrasInidcacionesSignos').attr('hidden','true');
      }
    });
    $('#checkCuidadosGenerales').change(function(){
      if($(this).is(':checked')){
        $('#listCuidadosGenerales').removeAttr('hidden');
        $('#labelCheckCuidadosGenerales').text('');
      }else{
        $('#listCuidadosGenerales').attr('hidden', 'true');
        $('#labelCheckCuidadosGenerales').text('SI');
      }
    });
    $('input[name=asistentesmedicas_incapacidad_am]').click(function (e){
        if($(this).val()=='Si'){
            $('input[name=asistentesmedicas_incapacidad_ga]').removeAttr('disabled');
        }else{
            $('input[name=asistentesmedicas_incapacidad_ga]').attr('disabled',true);
            $('input[name=asistentesmedicas_incapacidad_ga][value=No]').prop("checked",true).click();
        }
    })
    $('input[name=asistentesmedicas_incapacidad_ga]').click(function (e){
        if($(this).val()=='Si'){
            $('select[name=asistentesmedicas_incapacidad_tipo]').removeAttr('disabled').click();
            $('input[name=asistentesmedicas_incapacidad_folio]').removeAttr('readonly');
            $('input[name=asistentesmedicas_incapacidad_fi]').removeAttr('readonly');
            $('input[name=asistentesmedicas_incapacidad_da]').removeAttr('readonly');
        }else{
            $('input[name=asistentesmedicas_incapacidad_folio]').attr('readonly',true).val('');
            $('input[name=asistentesmedicas_incapacidad_fi]').attr('readonly',true).val('');
            $('input[name=asistentesmedicas_incapacidad_da]').attr('readonly',true).val('');
            $('select[name=asistentesmedicas_incapacidad_tipo]').attr('disabled',true).val('');
            $('input[name=asistentesmedicas_incapacidad_dias_a]').attr('type','hidden').val('');

        }
    })
    if($('input[name=asistentesmedicas_incapacidad_am]').attr('data-value')=='Si'){
        $('input[name=asistentesmedicas_incapacidad_ga]').removeAttr('disabled');
        $('input[name=asistentesmedicas_incapacidad_ga][value="'+$('input[name=asistentesmedicas_incapacidad_ga]').data('value')+'"]').prop("checked",true).click();
        $('select[name=asistentesmedicas_incapacidad_tipo]').val($('select[name=asistentesmedicas_incapacidad_tipo]').attr('data-value'));

    }
    if($('input[name=asistentesmedicas_incapacidad_ga]').attr('data-value')=='Si' && $('select[name=asistentesmedicas_incapacidad_tipo]').attr('data-value')=='Subsecuente'){
        $('input[name=asistentesmedicas_incapacidad_dias_a]').attr('type','text');
    }
    $('select[name=asistentesmedicas_incapacidad_tipo]').click(function () {
        if($(this).val()=='Subsecuente'){
            $('input[name=asistentesmedicas_incapacidad_dias_a]').attr('type','text');
        }else{
            $('input[name=asistentesmedicas_incapacidad_dias_a]').attr('type','hidden');
        }
    })
    /**/
    $('input[name=hf_intoxitacion][value="'+$('input[name=hf_intoxitacion]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_urgencia][value="'+$('input[name=hf_urgencia]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_atencion][value="'+$('input[name=hf_atencion]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_especialidad][value="'+$('input[name=hf_especialidad]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_mecanismolesion_ab][value="'+$('input[name=hf_mecanismolesion_ab]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_mecanismolesion_td][value="'+$('input[name=hf_mecanismolesion_td]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_mecanismolesion_av][value="'+$('input[name=hf_mecanismolesion_av]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_mecanismolesion_maquinaria][value="'+$('input[name=hf_mecanismolesion_maquinaria]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_mecanismolesion_mordedura][value="'+$('input[name=hf_mecanismolesion_mordedura]').data('value')+'"]').prop("checked",true);

    $('input[name=hf_quemadura_fd][value="'+$('input[name=hf_quemadura_fd]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_quemadura_ce][value="'+$('input[name=hf_quemadura_ce]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_quemadura_e][value="'+$('input[name=hf_quemadura_e]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_quemadura_q][value="'+$('input[name=hf_quemadura_q]').data('value')+'"]').prop("checked",true);

    $('input[name=hf_trataminentos_curacion][value="'+$('input[name=hf_trataminentos_curacion]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_trataminentos_curacion][value="'+$('input[name=hf_trataminentos_curacion]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_trataminentos_sutura][value="'+$('input[name=hf_trataminentos_sutura]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_trataminentos_vendaje][value="'+$('input[name=hf_trataminentos_vendaje]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_trataminentos_ferula][value="'+$('input[name=hf_trataminentos_ferula]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_trataminentos_vacunas][value="'+$('input[name=hf_trataminentos_vacunas]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_ministeriopublico][value="'+$('input[name=hf_ministeriopublico]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_expontanea][value="'+$('input[name=hf_glasgow_expontanea]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_hablar][value="'+$('input[name=hf_glasgow_hablar]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_dolor][value="'+$('input[name=hf_glasgow_dolor]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_ausente][value="'+$('input[name=hf_glasgow_ausente]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_localiza][value="'+$('input[name=hf_glasgow_localiza]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_retira][value="'+$('input[name=hf_glasgow_retira]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_flexion][value="'+$('input[name=hf_glasgow_flexion]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_extension][value="'+$('input[name=hf_glasgow_extension]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_ausencia][value="'+$('input[name=hf_glasgow_ausencia]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_orientado][value="'+$('input[name=hf_glasgow_orientado]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_confuso][value="'+$('input[name=hf_glasgow_confuso]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_incoherente][value="'+$('input[name=hf_glasgow_incoherente]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_sonidos][value="'+$('input[name=hf_glasgow_sonidos]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_arespuesta][value="'+$('input[name=hf_glasgow_arespuesta]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_glasgow_obedece][value="'+$('input[name=hf_glasgow_obedece]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_riesgocaida][value="'+$('input[name=hf_riesgocaida]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_eva][value="'+$('input[name=hf_eva]').data('value')+'"]').prop("checked",true);
    $('input[name=hf_estadosalud][value="'+$('input[name=hf_estadosalud]').data('value')+'"]').prop("checked",true);

    // Toma el valor del 'data-value' y lo asigna en el select
    $('select[name=tomaSignos]').val($('select[name=tomaSignos]').attr('data-value'));
    $('select[name=select_alergias]').val($('select[name=select_alergias]').attr('data-value'));
    $('select[name=tipoDieta]').val($('select[name=tipoDieta]').attr('data-value'));
    $('select[name=hf_alta]').val($('select[name=hf_alta]').attr('data-value'));
    $('select[name=hf_alta]').click(function (e) {
        if($(this).val()=='Otros'){
            $('.hf_alta_otros').removeClass('hide');
        }else{
            $('.hf_alta_otros').addClass('hide');
        }
    });
    if($('select[name=hf_alta]').attr('data-value')=='Otros'){
        $('.hf_alta_otros').removeClass('hide');
    }
    $('input[name=asistentesmedicas_ss_in][value="'+$('input[name=asistentesmedicas_ss_in]').data('value')+'"]').prop("checked",true);
    $('input[name=asistentesmedicas_ss_ie][value="'+$('input[name=asistentesmedicas_ss_ie]').data('value')+'"]').prop("checked",true);
    $('input[name=asistentesmedicas_ss_in][value="'+$('input[name=asistentesmedicas_oc_hr]').data('value')+'"]').prop("checked",true);
    $('input[name=asistentesmedicas_oc_hr][value="'+$('input[name=asistentesmedicas_ss_in]').data('value')+'"]').prop("checked",true);
    $('input[name=asistentesmedicas_incapacidad_am][value="'+$('input[name=asistentesmedicas_incapacidad_am]').data('value')+'"]').prop("checked",true);
    $('input[name=asistentesmedicas_omitir]').click(function (e){
        if($(this).val()=='Si'){
            $('.asistentesmedicas_omitir').addClass('hide').find('.hojafrontal-info').removeAttr('required');
        }else{
            $('.asistentesmedicas_omitir').removeClass('hide').find('.hojafrontal-info').attr('required',true);
        }
    })
    if($('input[name=asistentesmedicas_omitir]').data('value')!='' && triage_paciente_accidente_lugar=='TRABAJO'){
        $('input[name=asistentesmedicas_omitir][value="'+$('input[name=asistentesmedicas_omitir]').data('value')+'"]').prop("checked",true);
        if($('input[name=asistentesmedicas_omitir]').data('value')=='Si'){
            $('.asistentesmedicas_omitir').addClass('hide').find('.hojafrontal-info').removeAttr('required');
        }if($('input[name=asistentesmedicas_omitir]').data('value')=='No'){
            $('.asistentesmedicas_omitir').removeClass('hide').find('.hojafrontal-info').attr('required',true);
        }
    }
    $('input[name=hf_alta][type=radio]').click(function (e){
        $('input[name=hf_alta][type=text]').val('');
    })
    function GuardarDarAlta(Folio) {
        bootbox.confirm({
            title:'<h5>GUARDAR Y DAR DE ALTA</h5>',
            message:'<div class="row">'+
                        '<div class="col-md-12">'+
                            '<h5>¿GUARDAR DATOS DATOS DEL PACIENTE Y DAR DE ALTA DE CONSULTORIO?</h5>'+
                        '</div>'+
                    '</div>',
            buttons:{
                cancel:{
                    label:'Espera Paciente'
                },confirm:{
                    label:'Egresar Paciente'
                }
            },callback:function (res) {
                if(res==true){
                    $.ajax({
                        url: base_url+"Consultorios/AjaxReportarSalida",
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            'csrf_token':csrf_token,
                            'triage_id':Folio,
                        },beforeSend: function (xhr) {
                            msj_loading();
                        },success: function (data, textStatus, jqXHR) {
                            bootbox.hideAll();
                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaFrontalCE/'+Folio,'Hola Frontal',100);
                            if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                                AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+Folio,'ST7',500);
                            }if($('input[name=hf_ministeriopublico]:checked').val()=='Si'){
                                AbrirDocumentoMultiple(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/'+Folio,'NMP',800);
                            }
                            ActionCloseWindowsReload()
                        },error: function (e) {
                            msj_error_serve();
                            bootbox.hideAll();
                            ReportarError(window.location.pathname,e.responseText);
                        }
                    })
                }else{
                    bootbox.hideAll();
                    ActionCloseWindowsReload();
                    AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaFrontalCE/'+Folio,'Hola Frontal',100);
                    if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+Folio,'ST7',500);
                    }if($('input[name=hf_ministeriopublico]:checked').val()=='Si'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/'+Folio,'NMP',800);
                    }
                }
            }
        })
    }
    // Hoja de Notas parte de riesgo de caida
    $('input[name=hf_riesgo_caida][value="'+$('input[name=hf_riesgo_caida]').data('value')+'"]').prop("checked",true);
    $('input[name=nota_estadosalud][value="'+$('input[name=nota_estadosalud]').data('value')+'"]').prop("checked",true);

    $('.Form-Notas-HojaFrontal').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"Sections/Documentos/AjaxHfCE",
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading()
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if(data.accion=='1'){
                    msj_success_noti('Registro Guardado');
                    AbrirDocumento(base_url+'Inicio/Documentos/NotaConsultoriosEspecialidad/'+data.notas_id);
                    ActionCloseWindowsReload();
                }
            },error: function (e) {
                bootbox.hideAll();
                msj_error_serve(e);
                ReportarError(window.location.pathname,e.responseText);
            }
        })
    })
    /*Uso de generacion de documento dinamicos*/
    if($('select[name=notas_tipo]').attr('data-value')!=''){
        $('select[name=notas_tipo]').val($('select[name=notas_tipo]').attr('data-value'));
    }
    /***/
    $('#hf_mecanismolesion').change(function () {
        if($(this).val().indexOf('Caida')!=-1){
            $('.mecanismo-lesion-caida').removeClass('hide');
        }else{
            $('input[name=hf_mecanismolesion_mtrs]').val('');
            $('.mecanismo-lesion-caida').addClass('hide');
        }
        if($(this).val().indexOf('Otros')!=-1){
            $('.mecanismo-lesion-otros').removeClass('hide');
        }else{
            $('input[name=hf_mecanismolesion_otros]').val('');
            $('.mecanismo-lesion-otros').addClass('hide');
        }
    })
    $('#hf_quemadura').change(function () {
        if($(this).val().indexOf('Otros')!=-1){
            $('.quemadura-otros').removeClass('hide');
        }else{
            $('input[name=hf_quemadura_otros]').val('');
            $('.quemadura-otros').addClass('hide');
        }
    })
    if($("input[name=hf_mecanismolesion_mtrs]").val()!=undefined){
        $("#hf_quemadura").val($('#hf_quemadura').attr('data-value').split(',')).select2();
        $("#hf_mecanismolesion").val($('#hf_mecanismolesion').attr('data-value').split(',')).select2();
        $("#hf_trataminentos").val($('#hf_trataminentos').attr('data-value').split(',')).select2();
    }

    if($('input[name=hf_mecanismolesion_mtrs]').val()!=''){
        $('.mecanismo-lesion-caida').removeClass('hide');
    }
    if($('input[name=hf_mecanismolesion_otros]').val()!=''){
        $('.mecanismo-lesion-otros').removeClass('hide');
    }
    if($('input[name=hf_quemadura_otros]').val()!=''){
        $('.quemadura-otros').removeClass('hide');
    }
    $('#hf_trataminentos').change(function () {
        if($(this).val().indexOf('Otros')!=-1){
            $('.hf_trataminentos_otros').removeClass('hide');
        }else{
            $('input[name=hf_trataminentos_otros]').val('');
            $('.hf_trataminentos_otros').addClass('hide');
        }
    });
    if($('input[name=hf_trataminentos_otros]').val()!=''){
        $('.hf_trataminentos_otros').removeClass('hide');
    }

    /*Diagnosticos*/
    if($('input[name=cie10_nombre').val()!=undefined){
       $('input[name=cie10_nombre').shieldAutoComplete({
            dataSource: {
                data: CIE10,
            },minLength: 5
        });
    }

    $('body').on('click','.observaciones-prescripcion',function(){
        var prescripcion_id = $(this).attr('data-value');
        if($('#historial_prescripcion_observacion'+prescripcion_id).val() == 0){
            $('#historial_prescripcion_observacion'+prescripcion_id).removeAttr("hidden");
            $('#historial_prescripcion_observacion'+prescripcion_id).val("1");
        }else{
            $('#historial_prescripcion_observacion'+prescripcion_id).attr("hidden","true");
            $('#historial_prescripcion_observacion'+prescripcion_id).val("0");
        }
    });
    $('body').on('click','.movimientos_prescripcion',function(){

      var medicamento = $(this).attr('data-value');
      if($('#mostrar_ocultar'+medicamento).text() == 0){
        $('#mostrar_ocultar'+medicamento).text('1')
        $('#historial_'+medicamento).removeAttr('hidden');
      }else{
        $('#mostrar_ocultar'+medicamento).text('0')
        $('#historial_'+medicamento).attr('hidden','true');
      }

    });

    $('body').on('click','.editar-prescripcion',function(){
      var prescripcion_id = $(this).attr('data-value');
      var medicamento = $('#fila_medicamento'+prescripcion_id).text();

      if(confirm('¿QUIERES MODIFICAR ESTA PRESCRIPCIÓN? '+medicamento)){

          var medicamento_id = $('#fila_idmedicamento'+prescripcion_id).text();
          var categoria_farmacologica = $('#fila_categoria_farmacologica'+prescripcion_id).text();
          var fecha_prescripcion = $('#fila_fecha_prescripcion'+prescripcion_id).text();
          var dosis = $('#fila_dosis'+prescripcion_id).text();
          var via_administracion = $('#fila_via_administracion'+prescripcion_id).text();
          var frecuencia = $('#fila_frecuencia'+prescripcion_id).text();
          var aplicacion = $('#fila_aplicacion'+prescripcion_id).text();
          var fecha_inicio = $('#fila_fecha_inicio'+prescripcion_id).text();
          var tiempo = $('#fila_tiempo'+prescripcion_id).text();
          var periodo = $('#fila_periodo'+prescripcion_id).text();
          var fecha_fin = $('#fila_fecha_'+prescripcion_id).text();
          var observacion = $('#fila_observacion'+prescripcion_id).text();
          //Fragmento para dividir la dosis en dos, cantidad y unidad
          var arregloDosis = dosis.split(" ");

          $('.formulario_prescripcion').removeAttr('hidden');
          $('.tiempo_tipo_medicamento').empty();
          $('#label_check_prescripcion').text('');
          $('#select_medicamento').select2('val',medicamento_id).select2();
          $('#select_medicamento').select2('enable',false);
          $('#input_dosis').val(arregloDosis[0]);
          $('#select_unidad').val(arregloDosis[1]).trigger('change.select2');

          $('#via_administracion').val(via_administracion).trigger('change.select2');
          $('#frecuencia').val(frecuencia);
          $('#aplicacion').val(aplicacion);
          $('#fechaInicio').val(fecha_inicio);
          //$('#duracion').val();

          $('#observacion').val(observacion);
          $('#btn_modificar_prescripcion').attr('data-value',prescripcion_id);
          $('.btn_agregarPrescripcion').attr('hidden','true');
          $('.btn_modificarPrescripcion').removeAttr('hidden');

          var motivo =
          "<div class='col-sm-3'>"+
            "<label><b>Motivo de actualización</b></label>"+
            "<input type='text' class='form-control' id='motivo_actualizar' />"+
          "</div>";

          if(categoria_farmacologica.toLowerCase() == 'antibiotico'){
            formulario =
            "<div class='col-sm-1' style='padding: 0;' >"+
              "<label id='categoria_farmacologica' hidden>"+categoria_farmacologica+"</label>"+
              "<label><b>Dias</b></label>"+
              "<div id='borderDuracion'>"+
              "<select id='duracion' onchange='mostrarFechaFin()' class='form-control' >"+
                "<option value='0'>0</option>"+
                "<option value='1'>1</option>"+
                "<option value='2'>2</option>"+
                "<option value='3'>3</option>"+
                "<option value='4'>4</option>"+
                "<option value='5'>5</option>"+
                "<option value='6'>6</option>"+
                "<option value='7'>7</option>"+
                "<option value='8'>8</option>"+
                "<option value='9'>9</option>"+
                "<option value='10'>10</option>"+
              "</select>"+
              "</div>"+
            "</div>"+
            "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
              "<label><b>Fecha Fin</b></label>"+
              "<div id='borderFechaFin'>"+
              "<input class='form-control' id='fechaFin'  >"+
              "</div>"+
            "</div>";
          }else{
            formulario =
            "<div class='col-sm-1' style='padding-right: 0; padding-left: 0;' >"+
              "<label id='categoria_farmacologica' hidden>"+categoria_farmacologica+"</label>"+
              "<label><b>Tiempo</b></label>"+
              "<div class='input-group' >"+
                "<input type='text' class='form-control' id='duracion' onchange='mostrarFechaFin()' >"+
                "<span class='input-group-btn'>"+
                  "<div class='col-sm-12' style=''>"+
                  "<a class='btn' title='Aumentar' onClick=AumentarNum() style='padding=0;margin-left:-28px; margin-top:-8px;' ><span style='border:1px solid #000; width:20px; height:17px;' class='glyphicon glyphicon-menu-up'></span></a>"+
                  "</div>"+
                  "<div class='col-sm-12' style=''>"+
                  "<a class='btn' title='Reducir' onClick=ReducirNum() style='padding=0;margin-left:-28px; margin-top:-17px;' ><span style='border:1px solid #000; width:20px; height:17px;' class='glyphicon glyphicon-menu-down'></span></a>"+
                  "</div>"+
                "</span>"+
              "</div>"+
            "</div>"+
            "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
              "<label><b>Periodo</b></label>"+
              "<select class='form-control' id='periodo' onchange='mostrarFechaFin()'>"+
                "<option value='Dias'>Dias</option>"+
                "<option value='Semanas'>Semanas</option>"+
              "</select>"+
            "</div>"+
            "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
              "<label><b>Fecha Fin</b></label>"+
              "<div id='borderFechaFin'>"+
              "<input class='form-control' id='fechaFin' >"+
              "</div>"+
            "</div>";
          }
          $('.tiempo_tipo_medicamento').append(formulario);
          $('.tiempo_tipo_medicamento').append(motivo);
          $('#fechaFin').val(fecha_fin);
          $('#duracion').val(tiempo);

          if(categoria_farmacologica.toLowerCase() != 'antibiotico'){
            $('#periodo').val(periodo);
          }

      }

    });



    $('body').on('click','.desactivar-prescripcion',function(){



        var reaccion = false;
        var motivo = "";
        var prescripcion_id = $(this).attr('data-value');
        var dias = $('#fila_historial_prescripcion'+prescripcion_id).text();
        var estado = 0;
        var paciente = $('input[name=triage_id]').val();

        bootbox.confirm({
          message: '<h5>¿QIERES RETIRAR ESTE MEDICAMENTO?</h5>',
          buttons: {
            cancel:{
              label: 'NO',
              className: 'btn-imss-cancel'
            },confirm: {
              label: 'SI',
              className: 'back-imss'
            }
          },callback: function(response){
            if(response){
              bootbox.confirm({
                message: '<h5>¿Se presento una reaccion adversa?</h5>',
                buttons: {
                  cancel:{
                    label: 'NO',
                    className: 'btn-imss-cancel'
                  },confirm: {
                    label: 'SI',
                    className: 'back-imss'
                  }
                },callback: function(response){
                  if(response){
                    reaccion = true;
                  }
                  bootbox.prompt({
                    title: "<h5>Motivo por el que se cancela el medicamento</h5>",
                    inputType: 'text',
                    buttons: {
                      cancel:{
                        label: 'Cancelar',
                        className: 'btn-imss-cancel'
                      },confirm: {
                        label: 'Acepar',
                        className: 'back-imss'
                      }
                    },callback: function(result){
                      motivo = result;
                      if(motivo!=null && motivo!=''){
                        $.ajax({
                          url: base_url+"Sections/Documentos/AjaxCambiarEstadoPrescripcion",
                          type: 'GET',
                          dataType:'json',
                          data: {
                            estado: estado,
                            prescripcion_id: prescripcion_id,
                            paciente: paciente,
                            dias: dias
                          },success: function (data, textStatus, jqXHR) {
                              msj_success_noti(data.mensaje);
                              ActualizarHistorialPrescripcion(paciente,"1");
                              RegistrarAccionBitacoraPrescripcion(prescripcion_id,'Cancelar',motivo);
                              ConteoEstadoPrescripcion(paciente);
                              if(reaccion){
                                RegistrarEfectoAdverso(prescripcion_id,paciente,motivo);
                              }


                          },error: function (e) {
                              msj_error_serve(e)
                              bootbox.hideAll();
                          }
                        });
                      }
                    }
                  });
                }
              });
            }


          }
        });




    });

    $('body').on('click','.prescripcion_historial',function(){
      var prescripcion_id = $(this).attr('data-value');
      var paciente = $('input[name=triage_id]').val();
      BitacoraHistorialMedicamentos(prescripcion_id,paciente);
    });

    $('.btn-edit-diagnostico-principal').click(function(){
      $('input[name=accion_diagnostico_principal]').val("edit");
      $('#text_diagnostico_1').removeAttr('disabled');
    });

    $('.btn-diagnostico-principal').click(function(){
      $('#text_diagnostico_1').val('');
      $('#text_codigo_diagnostico_1').val('');
    });

    $('#consulta_diagnosticos').click(function(){
      var folio = $('input[name=triage_id]').val();
      var value_table = $('.table_diagnosticos').attr('data-value');

      if(value_table == 0){
        $('.table_diagnosticos').attr('data-value',"1");
        $('.table_diagnosticos').removeAttr('hidden');
        HistorialDiagnosticos(folio);
      }else if(value_table == 1){
        $('.table_diagnosticos').attr('data-value',"0");
        $('.table_diagnosticos').attr('hidden',true);
        $('.historial_diagnosticos').empty();
      }

    });



    $('#play_ordenes_nuevo').click(function(){
      //Limpiar campos de dieta
      $('#radioAyuno').removeAttr('checked');
      $('#radioDieta').removeAttr('checked');
      $('#divSelectDietas').attr('hidden',true);
      $('#selectDietas').val(0);
      $('#divOtraDieta').attr('hidden',true);
      $('#inputOtraDieta').val('');
      //Limpiar campos de toma de signos
      $('#selectTomaSignos').val(0);
      $('#divOtrasInidcacionesSignos').attr('hidden',true);
      $('#otras-indicaciones-signos').val('');
      //Limpiar campos cuidados generales de enfermeria
      $('#checkCuidadosGenerales').attr('checked',true);
      $('#labelCheckCuidadosGenerales').text(" SI");
      $('#listCuidadosGenerales').attr('hidden',true);
      //Limpiar campo cuidados especiales de enfermeria
      $('textarea[name=nota_cuidadosenfermeria]').data("wysihtml5").editor.setValue('');
      //Limpiar campo soluciones parenterales
      $('textarea[name=nota_solucionesp]').data("wysihtml5").editor.setValue('');

    });

    $('#play_ordenes_continuar').click(function(){
      var folio = $('input[name=triage_id]').val();
      ConsultarUltimasOrdenes(folio);
    });

    $('#acordeon_prescripciones_activas').click(function(){
      var paciente = $('input[name=triage_id]').val();
      var val_accion = 1;
      AccionPanelPrescripcion(val_accion, paciente);
    });

    $('#acordeon_prescripciones_canceladas').click(function(){
      var paciente = $('input[name=triage_id]').val();
      var val_accion = 2;
      AccionPanelPrescripcion(val_accion, paciente);

    });

    //Ejecuta las funciones para mostrar el historial de reacciones adversas
    $('#acordeon_reacciones').click(function(){
      var paciente = $('input[name=triage_id]').val();
      var val_accion = 3;
      AccionPanelPrescripcion(val_accion, paciente);
    });



    $('input[name=cie10_nombre]').removeClass('sui-input');
    $('body').on('click','.add-cie10',function() {
        if($('input[name=cie10_nombre]').val()!=''){
            SendAjax({csrf_token:csrf_token,cie10_nombre:$('input[name=cie10_nombre]').val()},'Sections/Documentos/AjaxCheckCIE10',function (response) {
                if(response.accion=='1'){
                    AjaxGuardarDiagnostico({
                        cie10_nombre:$('input[name=cie10_nombre]').val(),
                        cie10hf_obs:'',
                        cie10hf_id:0,
                        accion:'add'
                    })
                    $('input[name=cie10_nombre]').val('');
                }else{
                    msj_error_noti('EL DIAGNOSTICO CIE10 NO EXISTE POR FAVOR SELECCIONE UNO DE LA LISTA')
                }
            },'');

        }

    })
    $('body').on('click','.sui-listbox-item',function() {
        var diagnostico=$(this).text();
        AjaxGuardarDiagnostico({
            cie10_nombre:diagnostico,
            cie10hf_obs:'',
            cie10hf_id:0,
            accion:'add'
        })
        $('input[name=cie10_nombre]').val('');
    })
    $('body').on('click','.editar-diagnostico-cie10',function() {
        AjaxGuardarDiagnostico({
            cie10_nombre:$(this).attr('data-nombre'),
            cie10hf_obs:$(this).attr('data-obs'),
            cie10hf_id:$(this).attr('data-id'),
            accion:'edit',
        })
    })
    function AjaxGuardarDiagnostico(info){
        bootbox.confirm({
            title:"<h5>AGREGAR DIAGNOSTICO</h5>",
            message:'<div class="row">'+
                        '<div class="col-md-12">'+
                            '<div class="form-group">'+
                                '<label class="mayus-bold">'+info.cie10_nombre+'</label><br>'+
                                '<label class="md-check">'+
                                    '<input type="radio" name="cie10hf_tipo" value="Primario" checked="">'+
                                    '<i class="blue"></i>Primario'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="md-check">'+
                                    '<input type="radio" name="cie10hf_tipo" value="Secundario">'+
                                    '<i class="blue"></i>Secundario'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="md-check">'+
                                    '<input type="radio" name="cie10hf_estado" value="Presuntivo" checked="">'+
                                    '<i class="blue"></i>Presuntivo'+
                                '</label>&nbsp;&nbsp;&nbsp;&nbsp;'+
                                '<label class="md-check">'+
                                    '<input type="radio" name="cie10hf_estado" value="Definitivo">'+
                                    '<i class="blue"></i>Definitivo'+
                                '</label>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<textarea class="form-control" name="cie10hf_obs" placeholcer="Observaciones...">'+info.cie10hf_obs+'</textarea>'+
                            '</div>'+
                        '</div>'+
                    '</div>',
            buttons:{
                cancel:{
                    label:'Cancelar',
                    className:'btn-imss-cancel'
                },confirm:{
                    label:'Acepar',
                    className:'back-imss'
                }
            },callback:function(response){
                if(response==true){
                    var cie10hf_obs=$('body textarea[name=cie10hf_obs]').val();
                    var triage_id=$('body input[name=triage_id]').val();
                    var cie10hf_tipo=$('body input[name=cie10hf_tipo]:checked').val();
                    var cie10hf_estado=$('body input[name=cie10hf_estado]:checked').val()
                    SendAjax({
                        accion:info.accion,
                        cie10_nombre:info.cie10_nombre,
                        triage_id:triage_id,
                        cie10hf_obs:cie10hf_obs,
                        cie10hf_tipo:cie10hf_tipo,
                        cie10hf_estado:cie10hf_estado,
                        cie10hf_id:info.cie10hf_id,
                        csrf_token:csrf_token
                    },'Sections/Documentos/AjaxGuardarDiagnosticos',function(response) {
                        console.log(response)
                        if(response.accion=='1'){
                            AjaxObtenerDiagnosticos();
                        }else{
                            msj_error_noti('EL DIAGNOSTICO NO EXISTE');
                        }
                    },'');
                }
            }

        })
    }
    function AjaxObtenerDiagnosticos() {
        SendAjax({
            triage_id:$('input[name=triage_id]').val(),
            csrf_token:csrf_token
        },'Sections/Documentos/AjaxObtenerDiagnosticos',function(response) {
            $('.row-diagnosticos').html(response.row)
        },'');
    }
    if($('input[name=cie10_nombre]').val()!=undefined){
        AjaxObtenerDiagnosticos();
    }
    $('body').on('click','.eliminar-diagnostico-cie10',function(e) {
        var cie10hf_id=$(this).attr('data-id');
        $.ajax({
            url:base_url+'Sections/Documentos/AjaxEliminarDiagnostico',
            type: 'POST',
            dataType: 'json',
            data:{
                csrf_token:csrf_token,
                cie10hf_id:cie10hf_id
            },beforeSend: function (xhr) {

            },success: function (data, textStatus, jqXHR) {
                AjaxObtenerDiagnosticos()
            },error: function (jqXHR, textStatus, errorThrown) {
                bootbox.hideAll();
                MsjError();
            }
        })
    })



    var indice_diagnosticos_secundarios = 2;

    $('.btn_agregarDiagnostico').click(function(){

      var form_diagnosticos_secundarios = "";
      form_diagnosticos_secundarios =
      "<div class='row'  id='form_diagnosticos_secundarios_"+indice_diagnosticos_secundarios+"'>"+
      /*
        "<div class='col-sm-2'>"+
          "<label class='md-check' style='padding-top:6px;'>"+
            "<input type='radio' class='has-value' value='0' id='diagnostico_frecuente_"+indice_diagnosticos_secundarios+"' name='tipo_diagnostico_"+indice_diagnosticos_secundarios+"' />"+
            "<i class='red'></i>"+
            "Frecuentes"+
          "</label>"+

          "<label class='md-check' style='padding-top:6px;'>"+
            "<input type='radio' class='has-value' value='1' id='diagnostico_cie_"+indice_diagnosticos_secundarios+"' name='tipo_diagnostico_"+indice_diagnosticos_secundarios+"' />"+
            "<i class='red'></i>"+
            "CIE-10"+
          "</label>"+
        "</div>"+
        */

        "<div class='col-sm-9'>"+
          "<div class='form-group'>"+
            "<label>Diagnóstico secundario</label>"+
            "<input type='text' class='form-control' id='text_diagnostico_"+indice_diagnosticos_secundarios+"' onkeydown=BuscarDiagnostico("+indice_diagnosticos_secundarios+") />"+

              "<ul class='contenedor_consulta_diagnosticos' id='lista_resultado_diagnosticos_"+indice_diagnosticos_secundarios+"' ></ul>"+

          "</div>"+
        "</div>"+

        "<div class='col-sm-2'>"+
          "<label>Código</label>"+
          "<input type='text' class='form-control' id='text_codigo_diagnostico_"+indice_diagnosticos_secundarios+"' disabled/>"+
          "<input type='hidden' class='form-control' name='cie10_id[]' id='text_id_diagnostico_"+indice_diagnosticos_secundarios+"' >"+
          "<input type='hidden' name='tipo_diagnostico[]' value='2' >"+
        "</div>"+

        "<div class='col-sm-1' style='padding-top:25px;'>"+
          "<a class='btn btn-imms-cancel width100 delete-diagnostico-secundario' title='Borrar diagnostico secundario' onclick=BorrarDiagnosticoDinamico("+indice_diagnosticos_secundarios+")> "+
            "<span class='glyphicon glyphicon-remove'></span>"+
          "</a>"+
        "</div>"+

      "</div>";
      $('.diagnosticos_secundarios_dinamico').append(form_diagnosticos_secundarios);
      indice_diagnosticos_secundarios = indice_diagnosticos_secundarios + 1;

    });

    $('.check_diagnosticos_secundarios').click(function(){

      if($(this).val() == 0){
        $(this).val('1');
        $('.diagnosticos_secundarios').removeAttr('hidden');
        $('.label_check_secundarios').text('');
      }else if($(this).val() == 1){
        $(this).val('0');
        $('.diagnosticos_secundarios').attr('hidden',true);
        $('.label_check_secundarios').text('SI');
      }
      tipo_diagnostico = 2;
    });




    $('input[name=check_solicitud_interconsulta]').click(function(){

      if($(this).val() == 0){
        $(this).val('1');
        $('#lbl_check_interconsulta').text('');
        $('.nota_interconsulta').removeAttr('style');
      }else if ($(this).val() == 1) {
        $(this).val('0');
        $('#lbl_check_interconsulta').text('- SI');
        $('.nota_interconsulta').css('display','none');
      }
    });
    /*Documento de Hoja Frontal Formato Abierto*/
    $('.guardar-solicitud-hi-abierto').submit(function (e){
        e.preventDefault();
        $.ajax({
            url: base_url+"Sections/Documentos/AjaxHojaInicialAbierto",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                if($('input[name=tipo]').val()=='Consultorios'){
                    if($('input[name=ce_status]').val()!='Salida'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaInicialAbierto/'+$('input[name=triage_id]').val(),'Hola Inicial',100);
                        ActionCloseWindowsReload();
                    }else{
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaInicialAbierto/'+$('input[name=triage_id]').val(),'Hola Inicial',100);
                        if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',500);
                        }
//                        if($('input[name=hf_ministeriopublico]:checked').val()=='Si'){
//                            AbrirDocumentoMultiple(base_url+'Inicio/Documentos/AvisarAlMinisterioPublico/'+$('input[name=triage_id]').val(),'NMP',800);
//                        }
                    }

                }else{
                    bootbox.hideAll();
                    AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HojaInicialAbierto/'+$('input[name=triage_id]').val(),'Hola Inicial',100);
                    if($('input[name=pia_lugar_accidente]').val()=='TRABAJO'){
                        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/ST7/'+$('input[name=triage_id]').val(),'ST7',500);
                    }
                    ActionCloseWindowsReload();
                }
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e);
            }
        });
    });

    $('.opcion_alergias').change(function(){
      if($(this).val() == 1){
        $('.alergias').val('');
        $('.alergias').show();
      }else {
        $('.alergias').hide();
      }
    });

    $('input[name=es_residente]').click(function () {
        if($(this).val()=='Si'){
            $('.notas_medicotratante').removeClass('hide');
        }else{
            $('.notas_medicotratante').addClass('hide');
            $('select[name=notas_medicotratante]').select2('val','').select2();
        }
    })

    if($('input[name=es_residente]').attr('data-value')!='0' && $('input[name=es_residente]').attr('data-value')!=''){
        $('input[name=es_residente][value=Si]').prop('checked',true);
        $('.notas_medicotratante').removeClass('hide');
        $('select[name=notas_medicotratante]').select2('val',$('select[name=notas_medicotratante]').attr('data-value')).select2();
    }
    // OCULTA CAMPOS EN EL MODAL DE RIESGO DE TROMBOSIS
    $('input[name=rt_sexo]').click(function (e){
        if($(this).val()=='f'){
            $('.col-mujer').removeClass('hidden');
            }else {
                if($('input[name=rt_sexo]').attr('value')=='m'){
                    $('.col-mujer').addClass('hidden');
            }
        }

    });

    $('select[name=notas_tipo]').click(function (e) {
        if($(this).val()=='NOTA DE INTERCONSULTA'){
            $('.nota_motivoInterconsulta').removeClass('hidden');
            $('.evolucion-psoap').addClass('hidden');
            $('#psoap_subjetivo').text('INTERROGATORIO:');
            $('#psoap_objetivo').text('EXPLORACION FISICA:');
        }else{
            //if($('select[name=notas_tipo').attr('value')=='NOTA DE EVOLUCIÓN'){
                $('.nota_motivoInterconsulta').addClass('hidden');
                $('.evolucion-psoap').removeClass('hidden');
                $('textarea[name=nota_motivoInterconsulta]').val('');
                $('#psoap_subjetivo').text('SUBJETIVO (Interrogatorio):');
                $('#psoap_objetivo').text('OBJETIVO (Exploracion fisica):');
          //  }

        }
    });

    $('select[name=interConMedicoBase]').change(function(){
      var matricula = $('select[name=interConMedicoBase]').val();
      $('#medicoMatricula').val(matricula);
    });

    $("input[name=residente]").click(function(e) {
        if($(this).val()=='Si'){
            $('.medico_residente').removeClass('hidden');
            $('#nombre_residente').attr('required','true');
            $('#apellido_residente').attr('required','true');
            $('#cedula').attr('required','true');
        } else {
          $('#nombre_residente').removeAttr('required');
          $('#apellido_residente').removeAttr('required');
          $('#cedula').removeAttr('required');
          $('.medico_residente').addClass('hidden');
      }
    });

    $('#btn_modificar_prescripcion').click(function(){
      var prescripcion_id = $(this).attr('data-value');
      var dosis_cantidad = $('#input_dosis').val();
      var unidad = $('#select_unidad').val();
      var dosis = (dosis_cantidad+' '+unidad);
      var via_administracion = $('#via_administracion').val();
      var frecuencia = $('#frecuencia').val();
      var aplicacion = $('#aplicacion').val();
      var fecha_inicio = $('#fechaInicio').val();
      var observacion = $('#observacion').val();
      var motivo_actualizar = $('#motivo_actualizar').val();

      var datos_viejos = DatosTabplaPrescripcionActivas(prescripcion_id);
      var motivo_datos_viejos =
      datos_viejos['via_administracion']+","+
      datos_viejos['frecuencia']+","+
      datos_viejos['aplicacion']+","+
      datos_viejos['fecha_inicio']+","+
      datos_viejos['observacion']+","+
      datos_viejos['dosis']+","+
      motivo_actualizar;

      $.ajax({
        url: base_url+"Sections/Documentos/AjaxModificarPrescripcion",
        type: 'GET',
        dataType: 'json',
        data:{
          via_administracion : via_administracion,
          frecuencia : frecuencia,
          aplicacion : aplicacion,
          fecha_inicio : fecha_inicio,
          observacion : observacion,
          dosis : dosis,
          prescripcion_id : prescripcion_id
        },
        success: function(data, textStatus, jqXHR){
          msj_success_noti("Modificacion correcta");
          limpiarFormularioPrescripcion();
          RegistrarAccionBitacoraPrescripcion(prescripcion_id,'Actualizar',motivo_datos_viejos);
          var paciente = $('input[name=triage_id]').val();
          $('#historial_prescripcion').removeAttr('hidden');
          ActualizarHistorialPrescripcion(paciente,"1");
          $('#select_medicamento').select2('enable',true);
        },error: function (e) {
            bootbox.hideAll();
            msj_error_serve();
        }
      });

    });

    $('#check_estudios').change(function(){
        if($(this).is(':checked')){
          $('.solicitud_laboratorio').removeAttr('hidden');
          $('#label_check_estudios').text('');
        }else {
          $('.solicitud_laboratorio').attr('hidden',true);
          $('#label_check_estudios').text('- SI');
        }
    });


    $('#check_form_alergia_medicamento').change(function(){
      if($(this).is(':checked')){

        $('#label_check_alergia_medicamentos').text("");
        $('#alergia_medicamentos').removeAttr('hidden');

        var formulario =
        "<div class='col-sm-11' style='padding-left:0px;'>"+
          "<label>Medicamento</label>"+
          "<select id='medicamento_select' name='alergias_medicamento[]' class='width100'>"+
          "</select>"+
        "</div>"+
        "<div class='col-sm-1' style='padding-top:25px; padding-right:0px;' >"+
          "<button type='button' class='btn btn-success width100' onClick=AgregaFormularioAlergiaMedicamento(); title='Agregar alergia a medicamentos' name='button'>"+
            "<span class='glyphicon glyphicon-plus'></span>"+
          "</button>"+
        "</div>";

        $('#alergia_medicamentos').append(formulario);
        $('#medicamento_select').select2();

        $.ajax({
          url: base_url+"Sections/Documentos/ObtenerMedicamentos",
          type: 'GET',
          dataType:'json',
          data: {
          },success: function (data, textStatus, jqXHR) {
            for(var x = 0; x < data.medicamentos.length; x++){
            $('#medicamento_select').append("<option value='"+data.medicamentos[x].medicamento_id+"'>"+data.medicamentos[x].medicamento+"</option>");
            }
          },error: function (e) {
              msj_error_serve(e)
              bootbox.hideAll();
          }
        });


      }else {
        $('#label_check_alergia_medicamentos').text("- NO DETECTADAS");
        $('#alergia_medicamentos').attr('hidden',true);
        $('#alergia_medicamentos').empty();
      }
    });

    $('#check_form_prescripcion').change(function(){
      $('.btn_modificarPrescripcion').attr('hidden','true');
      $('.btn_agregarPrescripcion').removeAttr('hidden');

      if($(this).is(':checked')){
        $('.formulario_prescripcion').removeAttr('hidden');
        $('#label_check_prescripcion').text('');
        $('#select_medicamento').select2('enable',true);
      }else{
        $('.formulario_prescripcion').attr('hidden','true');
        $('#label_check_prescripcion').text('- SI');
        limpiarFormularioPrescripcion();
      }

    });

    $('input[name=residente][value="'+$('input[name=residente]').data('value')+'"]').prop("checked",true);

    /*Evento para agregar dinamicamento nuevos médicos residentes*/

    $("#add_otro_residente").click (function(e) {
        /*la varivable cont incrementa cada ves que se genera un nuevo médico residente
        la variable se concatena al identificador del campo con el proposito de tener distinguir cada uno
        en el momento de ser eliminados*/

        if(cont >= 3){
          alert('La nota medica solo acepta maximo 3 medicos residentes');
        }
        else{
          cont += 1;
          $("#medicoResidente").append('<div id=areaResidentes'+ cont +' class="col-sm-12 form-group">'+
          '<div class=col-sm-4 >'+
          '<input id="medico'+ cont +'" class="form-control"  type="text" required name="nombre_residente[]" placeholder="Nombre Residente">'+
          '</div>'+
          '<div class=col-sm-4 >'+
          '<input id="medico'+ cont +'" class=form-control type="text" required name="apellido_residente[]" placeholder="Apellidos Residente">'+
          '</div>'+
          '<div class=col-sm-3 >'+
          '<input id="medico'+ cont +'" class=form-control type="text" required name="cedula_residente[]" placeholder="Cédula Profesional">'+
          '</div>'+
          '<div class=col-sm-1 >'+
          '<a href="#" onclick=quitarResidenteFormulario('+cont+') class="btn btn-danger delete btn-xs" style="width:100%;height:100%;padding:7px;" id="quitar_residente"><span class="glyphicon glyphicon-remove"></span></a>'+
          '</div>'+
          '</div>');
        }

    });

    var Total=0;
    $('.sum').click(function (e) {
        var valor=parseInt($(this).val());
        if($(this).is(':checked')){
            Total=valor+Total;
        }else{
            Total=Total-valor;
        }
        $('input[name=hf_escala_glasgow]').val(Total);

    });

    $(document).on('click keyup','.suma_rt',function() {
    calcular();
    });

});
function quitarResidenteFormulario(residente){
  $('#areaResidentes'+residente).remove();
  cont -= 1;
}
function calcular() {
  var tot = $('#puntos_rt');
  tot.val(0);
  $('.suma_rt').each(function() {
    if($(this).hasClass('suma_rt')) {
      tot.val(($(this).is(':checked') ? parseInt($(this).attr('value')) : 0) + parseInt(tot.val()) );
    }
    else {

     tot.val(parseInt(suma.val()) + (isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val())));
    }

  });
  //var totalParts = parseInt(tot.val()).toFixed(2).split('.');
  //tot.val('$' + totalParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' +  (totalParts.length > 1 ? totalParts[1] : '0'));
    if(tot.val() <= 2)  {
        $("#puntos_rt").val(tot.val() + ' ptos: ' + 'Riesgo Bajo');
    } else if(tot.val() >= 3 && tot.val() <= 4) {
        $("#puntos_rt").val(tot.val() + ' ptos: ' + 'Riesgo Moderado');
    } else if(tot.val() >= 5 && tot.val() <= 8) {
        $("#puntos_rt").val(tot.val() + ' ptos: ' + 'Riesgo Alto');
    } else if(tot.val() > 8) {
        $("#puntos_rt").val(tot.val() + ' ptos: ' + 'Riesgo Muy Alto');
    }
}

function asignarHorarioAplicacion(){
  var frecuencia = $('#frecuencia').val();
  var horaAplicacion = "8:00";
  if(frecuencia == "6 hrs"){
    horaAplicacion = "6:00 / 12:00 / 18:00 / 24:00";
  }else if(frecuencia == "8 hrs"){
    horaAplicacion = "8:00 / 16:00 / 24:00";
  }else if(frecuencia == "12 hrs"){
    horaAplicacion = "8:00 / 20:00";
  }else if( frecuencia == 0){
    horaAplicacion = "Falta asignar frecuencia"
  }
  $('#aplicacion').val(horaAplicacion);
}

function sumDias(fecha, numDias){

  fecha.setDate(fecha.getDate() + numDias);
  return fecha;
}
// Obtine la fecha en que terminara la prescripciones,
// cuenta con una condicion para hacer una convercion en dias
function mostrarFechaFin(){
  var categoria_farmacologica = $('#categoria_farmacologica').text();
  var fechaInicio = $('#fechaInicio').val();
  var duracion = $('#duracion').val();
  var periodo = "";
  var dias = 0;
  var fechaFin = "";

  if(categoria_farmacologica.toLowerCase() == 'antibiotico'){
    fechaFin = sumarfecha(duracion, fechaInicio);
  }else{
    periodo = $('#periodo').val();
    dias = ConvercionDias(duracion, periodo);
    fechaFin = sumarfecha(dias, fechaInicio);
  }

  if(duracion === ''){
    $('#fechaFin').val(fechaInicio);
  }else{
    $('#fechaFin').val(fechaFin);
  }
}
// Valida el llenado del formulario, indicando si
// algun campo falta por llenar
function revisarCamposVaciosPrescripcion(){
  var medico = $('#select_medicamento').val();
  var dosis = $('#input_dosis').val();
  var unidad = $('#select_unidad').val();
  var via = $('#via_administracion').val();
  var frecuencia = $('#frecuencia').val();
  var horaAplicacion = $('#aplicacion').val();
  var fechaInicio = $('#fechaInicio').val();
  var duracion = $('#duracion').val();
  var fechaFin = $('#fechaFin').val();
  var validacion = false;
  if(medico === '0'){
    $('#borderMedicamento').css("border","2px solid red");
  }else if(dosis === ''){
    $('#borderDosis').css("border","2px solid red");
  }else if(unidad === '0'){
    $('#borderUnidad').css("border","2px solid red");
  }else if(via === '0'){
    $('#borderVia').css("border","2px solid red");
  }else if(frecuencia === '0'){
    $('#borderFrecuencia').css("border","2px solid red");
  }else if(horaAplicacion === ''){
    $('#borderAplicacion').css("border","2px solid red");
  }else if(fechaInicio === ''){
    $('#borderFechaInicio').css("border","2px solid red");
  }else if(duracion === ''){
    $('#borderDuracion').css("border","2px solid red");
  }else if(fechaFin === ''){
    $('#borderFechaFin').css("border","2px solid red");
  }else{
    $('#borderMedicamento').css("border","2px solid white");
    $('#borderDosis').css("border","2px solid white");
    $('#borderUnidad').css("border","2px solid white");
    $('#borderVia').css("border","2px solid white");
    $('#borderFrecuencia').css("border","2px solid white");
    $('#borderAplicacion').css("border","2px solid white");
    $('#borderFechaInicio').css("border","2px solid white");
    $('#borderDuracion').css("border","2px solid white");
    $('#borderFechaFin').css("border","2px solid white");
    validacion = true;
  }
  return validacion;
}
//Limpia el formulario despues de usarse
function limpiarFormularioPrescripcion(){
  $('#select_medicamento').val("0").trigger('change.select2');
  $('#via_administracion').val("0").trigger('change.select2');
  $('#input_dosis').val("");
  $('#select_unidad').val("0").trigger('change.select2');
  $('#frecuencia').val("0");
  $('#aplicacion').val("");
  $('#fechaInicio').val("");
  $('#duracion').val("0");
  $('#fechaFin').val("");
  $('#observacion').val("");
}
// Arreglo donde se almacenara los datos de cada prescripcion
var arrayPrescripcion = [];
/* Almacena el Id del medicamento y las interacciones con las que se
se relaciona*/
var arrayInteracciones = [];

function indicarInteraccion(){
  var idMedicamento = $('#select_medicamento').val();
  $('#interaccion_amarilla').val(idMedicamento).trigger('change');
  $('#interaccion_roja').val(idMedicamento).trigger('change');
  TipoMedicamento(idMedicamento);
}

// Se almacenan los datos de la prescripcion en un arreglo
function agregarPrescripcion(){
  //var validar = revisarCamposVaciosPrescripcion();
  var validar = true;
  if (validar === true){
    var categoria_farmacologica = $("#categoria_farmacologica").text();
    var periodo = "";


    // tomar valor del formulario y asignar variable
    var idMedicamento = $('#select_medicamento').val();
    var medicamento = $('#select_medicamento option:selected').text();
    var interaccion_amarilla = $('#interaccion_amarilla option:selected').text();
    var dosis = $('#input_dosis').val();
    var unidad = $('#select_unidad').val();
    var interaccion_roja = $('#interaccion_roja option:selected').text();
    var arrayInteraccionAmarilla = interaccion_amarilla.split(',');
    var arrayInteraccionRoja = interaccion_roja.split(',');
    var via = $('#via_administracion').val();
    var frecuencia = $('#frecuencia').val();
    var horaAplicacion = $('#aplicacion').val();
    var fechaInicio = $('#fechaInicio').val();
    var duracion = $('#duracion').val();
    var fechaFin = $('#fechaFin').val();
    var observacion = $('#observacion').val();
    var periodo = "Dias";
    if(observacion === ''){
      observacion = "Sin observaciones";
    }
    if(categoria_farmacologica.toLowerCase() != 'antibiotico'){
      periodo = $("#periodo").val();

    }
    var arrayLongitud = arrayPrescripcion.length;
    // verifica si el arreglo esta vacio y determinar si el registro es directo o inicia la comparacion
    if(arrayLongitud > 0){
      var interaccionA;
      var interaccionB;
      var comparaMedicamento;
      var resultadoComparacion;
      var x;
      var longitudInteracciones;
      for(x = 0; x < arrayLongitud; x++){
        comparaMedicamento = arrayPrescripcion[x]['medicamento'];
        longitudInteracciones = arrayInteracciones[x]['arrayInteraccionAmarilla'].length;
        for (var y = 0; y < longitudInteracciones; y++){
          interaccionA = arrayInteracciones[x]['arrayInteraccionAmarilla'][y];
          if(arrayInteracciones[x]['arrayInteraccionAmarilla'][y] == idMedicamento ){
            $('#fila'+x).css("background-color","rgb(252, 255, 124)");// Amarillo para efectos grabes, solo requiere observación
            alert(arrayPrescripcion[x]['medicamento']+" y "+medicamento+" pueden generar efectos adversos. Favor de modificar la prescripción o notificar al área de Farmacovigilancia");

            //break;
          }
        }
        for (var y = 0; y < longitudInteracciones; y++){
          interaccionA = arrayInteracciones[x]['arrayInteraccionRoja'][y];
          if(arrayInteracciones[x]['arrayInteraccionRoja'][y] == idMedicamento ){
            $('#fila'+x).css("background-color","rgb(255, 170, 170)");//color rojo para efectos muy grabes
            alert(arrayPrescripcion[x]['medicamento']+" y "+medicamento+" son medicamentos contraindicados"+
            ". "+
            "Favor de modificar la prescripción o notificar al área de Farmacovigilancia");
            //break;
          }
        }
        if(comparaMedicamento == medicamento){
          alert("El medicamento ya fue ingresado, indique uno nuevo, modifque el existente o eliminelo");
          resultadoComparacion = 1;
          $('#fila'+x).css("border-bottom","2px solid rgb(42, 70, 255)");
          break;
        }else{
          resultadoComparacion = 0;
        }
      }
      if(resultadoComparacion == 0){
        for(x = 0; x < arrayLongitud; x++){
            $('#fila'+x).css("border-bottom","1px solid #ddd");
        }
        arrayInteracciones[arrayLongitud] = {
          idMedicamento: idMedicamento,
          arrayInteraccionAmarilla: arrayInteraccionAmarilla,
          arrayInteraccionRoja: arrayInteraccionRoja
        }
        arrayPrescripcion[arrayLongitud] = {
          idMedicamento:idMedicamento,
          medicamento:medicamento,
          categoria_farmacologica:categoria_farmacologica,
          dosis:dosis,
          unidad:unidad,
          via:via,
          frecuencia:frecuencia,
          horaAplicacion:horaAplicacion,
          fechaInicio:fechaInicio,
          duracion:duracion,
          periodo:periodo,
          fechaFin:fechaFin,
          observacion:observacion
        }
        agregarFilaPrescripcion(arrayPrescripcion);
      }
    }else{
      arrayInteracciones[arrayLongitud] = {
        idMedicamento: idMedicamento,
        arrayInteraccionAmarilla: arrayInteraccionAmarilla,
        arrayInteraccionRoja: arrayInteraccionRoja
      }
      arrayPrescripcion[arrayLongitud] = {
        idMedicamento:idMedicamento,
        medicamento:medicamento,
        categoria_farmacologica:categoria_farmacologica,
        dosis:dosis,
        unidad:unidad,
        via:via,
        frecuencia:frecuencia,
        horaAplicacion:horaAplicacion,
        fechaInicio:fechaInicio,
        duracion:duracion,
        periodo:periodo,
        fechaFin:fechaFin,
        observacion:observacion
      }
      agregarFilaPrescripcion(arrayPrescripcion);
    }
  }

}
//pinta la fila con los datos del arraglo 'arrayPrescripcion'
function agregarFilaPrescripcion(arrayPrescripcion){
  var arrayLongitud = arrayPrescripcion.length - 1;
  var fila ="<tr id='fila"+arrayLongitud+"' >"+
  "<td hidden ><input type='text' name=idMedicamento[] size='1' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["idMedicamento"]+"' /></td>"+
  "<td>"+arrayPrescripcion[arrayLongitud]["medicamento"]+"</td>"+
  "<td>"+arrayPrescripcion[arrayLongitud]["categoria_farmacologica"]+"</td>"+
  "<td><input readonly type='text' name='dosis[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["dosis"]+" "+arrayPrescripcion[arrayLongitud]["unidad"]+"' /></td>"+
  "<td><input readonly type='text' name='via_administracion[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["via"]+"' /></td>"+
  "<td><input readonly type='text' name='frecuencia[]' size='4' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["frecuencia"]+"' /></td>"+
  "<td><input readonly type='text' name='horaAplicacion[]' size='22' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["horaAplicacion"]+"' /></td>"+
  "<td><input readonly type='text' name='fechaInicio[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["fechaInicio"]+"' /></td>"+
  "<td><input readonly type='text' name='duracion[]' size='1' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["duracion"]+"' /></td>"+
  "<td><input readonly type='text' name='periodo[]' size='1' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["periodo"]+"' /></td>"+
  "<td><input readonly type='text' name='fechaFin[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["fechaFin"]+"' /></td>"+
  "<td>"+
    //"<a href='#'><i class='fa fa-pencil icono-accion' onclick=TomarDatosTablaPrescripcion("+arrayLongitud+") ></i></a>"+
    "<a href='#'> <i class='glyphicon glyphicon-remove icono-accion' onclick=EliminarFilaPrescripcion("+arrayLongitud+") ></i> </a>"+
    "<a href='#'> <i class='glyphicon glyphicon-eye-open icono-accion' onclick=MostrarOcularObservacion("+arrayLongitud+") ></i> </a>"+
  "</td>"+
  "</tr>"+
  "<tr hidden style='background-color:rgb(228, 228, 228); ' class='fila"+arrayLongitud+"Observacion'>"+
  "<td style='text-align: right;'><strong>Observación:  </strong></td>"+
  "<td colspan='10' ><input hidden style='text-align: left;' class='fila"+arrayLongitud+"Val' value='0' />"+
  "<input readonly type='text' id='' name='observacion[]' style='text-align: left;' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["observacion"]+"' />"+
  "</td>"+
  "</tr>";
  $('#tablaPrescripcion').append(fila);
  limpiarFormularioPrescripcion();
}

function MostrarOcularObservacion(fila){
  var observacionOculto = $('.fila'+fila+"Val").val();
  if(observacionOculto == 0){
    $('.fila'+fila+"Observacion").removeAttr("hidden");
    $('.fila'+fila+"Val").val("1");
  }else{
    $('.fila'+fila+"Observacion").attr("hidden","true");
    $('.fila'+fila+"Val").val("0");
  }

}

// elimina la fila de la prescripcion con el indice enviado
function EliminarFilaPrescripcion(fila){

  $('#fila'+fila).remove();
  $('.fila'+fila+"Observacion").remove();
  arrayPrescripcion.splice(fila,1);
}
function RestarFechas(fecha1, fecha2){
  var fechaRegistrada = fecha1.split('/');
  var fechaActual = fecha2.split('/');
  var fecha_pasada = Date.UTC(fechaRegistrada[2],fechaRegistrada[1]-1,fechaRegistrada[0]);
  var fecha_actual = Date.UTC(fechaActual[2],fechaActual[1]-1,fechaActual[0]);
  var dif = fecha_actual - fecha_pasada;
  var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
  return dias;
}

function HistorialDiagnosticos(folio){
  $.ajax({
    url: base_url+"Sections/Documentos/AjaxConsultarDiagnosticos",
    type:"GET",
    dataType:"json",
    data:{
      folio: folio
    },success: function(data, textStatus, jqXHR){
      var tipo,tabla;
      $('.historial_diagnosticos').empty();

      for(var x = 0; x < data.length; x++){

        if(data[x].tipo_diagnostico == 0){
          tipo = "INGRESO";
        }else if(data[x].tipo_diagnostico == 1){
          tipo = "PRIMARIO";
        }else if(data[x].tipo_diagnostico == 2){
          tipo = "SECUNDARIO";
        }else if(data[x].tipo_diagnostico == 3){
          tipo = "EGRESO";
        }else {
          tipo = "Sin asignar";
        }

        tabla = "<tr>"+
                  "<td>"+data[x].cie10_clave+"</td>"+
                  "<td>"+data[x].cie10_nombre+"</td>"+
                  "<td>"+tipo+"</td>"+
                "</tr>";

        $('.historial_diagnosticos').append(tabla);
      }


    },error: function (e) {
        msj_error_serve(e)
        bootbox.hideAll();
    }
  });
}

function BitacoraPrescripcionMedicamento(folio){

  $.ajax({
    url: base_url+"Sections/Documentos/AjaxBitacoraPrescripciones",
    type:"GET",
    dataType:"json",
    data:{
      folio: folio
    },success: function(data, textStatus, jqXHR){
      $("#historial_movimientos").empty();
      var paneles = "";
      for(var x = 0; x < data.length; x++){
        paneles =
        "<div class='panel-container'>"+
          "<div class='panel-heading' >"+
              "<a data-toggle='collapse' class='accordion-toggle prescripcion_historial' "+
              "style='font-size: 15px;' data-parent='#accordion' "+
              "href='#collapse"+x+"' data-value='"+data[x].prescripcion_id+"'>"+
              data[x].medicamento + " / Fecha Prescripción: "+data[x].fecha_prescripcion+
              "</a>"+
          "</div>"+
          "<div id='collapse"+x+"' class='panel-collapse collapse'>"+
            "<div class='panel-body panel_contenido_historial"+data[x].prescripcion_id+"'>"+
              "<table width='100%'>"+
                "<thead>"+
                "<tr>"+
                  "<th>Via</th>"+
                  "<th>Dosis</th>"+
                  "<th>Frecuencia</th>"+
                  "<th>Aplicacion</th>"+
                  "<th>Fecha Inicio</th>"+
                  "<th>Movimiento</th>"+
                  "<th>Fecha Movimiento</th>"+
                  "<th>Acciones</th>"+
                "</tr>"+
                "</thead>"+
                "<tbody id='contenido_tabla_bitacora_prescripcion"+data[x].prescripcion_id+"'>"+
                "</tbody>"+
              "</table>"+
            "</div>"+
          "</div>"+
        "</div>";
        $("#historial_movimientos").append(paneles);
      }

    },error: function (e) {
        msj_error_serve(e)
        bootbox.hideAll();
    }
  });
}


function BitacoraHistorialMedicamentos(prescripcion_id,folio){

  $.ajax({
    url: base_url+"Sections/Documentos/AjaxBitacoraHistorialMedicamentos",
    type:"GET",
    dataType:"json",
    data:{
      prescripcion_id: prescripcion_id,
      folio: folio
    },success: function(data, textStatus, jqXHR){
      $('#contenido_tabla_bitacora_prescripcion'+prescripcion_id).empty();
      var via,
          dosis,
          frecuencia,
          aplicacion,
          fecha_inicio,
          fecha,
          movimiento,
          motivo,
          datos_actualizar,
          filas,
          filas_motivo_observacion,
          motivo_actualizar;

      for(var x = 0; x < data.length; x++){
        movimiento = data[x].tipo_accion;
        motivo = data[x].motivo;
        if(movimiento == "Actualizar"){
          datos_actualizar = motivo.split(',');
          via_administracion = datos_actualizar[0];
          dosis = datos_actualizar[5];
          frecuencia = datos_actualizar[1];
          aplicacion = datos_actualizar[2];
          fecha_inicio = datos_actualizar[3]
          motivo_actualizar = datos_actualizar[6];
          filas_motivo_observacion =
          "<th>Observaciones:</th>"+
          "<td colspan = 3 style='text-align:left;'>"+
          data[x].observacion+
          "</td>"+
          "<th>Motivo:</th>"+
          "<td colspan = 3 style='text-align:left;'>"+
          motivo_actualizar+
          "</td>";
        }else{
          via_administracion = data[x].via_administracion;
          dosis = data[x].dosis;
          frecuencia = data[x].frecuencia;
          aplicacion = data[x].aplicacion;
          fecha_inicio = data[x].fecha_inicio;
          filas_motivo_observacion =
          "<th>Observaciones:</th>"+
          "<td colspan = 3 style='text-align:left;'>"+
          data[x].observacion+
          "</td>"+
          "<th>Motivo:</th>"+
          "<td colspan = 3 style='text-align:left;'>"+
          data[x].motivo+
          "</td>";
        }
        filas =
        "<tr>"+
          "<td width='120px'>"+via_administracion+"</td>"+
          "<td>"+dosis+"</td>"+
          "<td>"+frecuencia+"</td>"+
          "<td>"+aplicacion+"</td>"+
          "<td>"+fecha_inicio+"</td>"+
          "<td>"+data[x].tipo_accion+"</td>"+
          "<td>"+data[x].fecha+"</td>"+
          "<td><i style='padding-left: 5px;' class='glyphicon glyphicon-eye-open pointer observaciones-prescripcion' data-value='"+x+prescripcion_id+"' title='Observaciones o Motivo de  cancelacion' ></i></td>"+
        "</tr >"+
        "<tr style='background-color:#ededed;' id='historial_prescripcion_observacion"+x+prescripcion_id+"' value='0' hidden>"+
          filas_motivo_observacion+
        "</tr>";
        $('#contenido_tabla_bitacora_prescripcion'+prescripcion_id).append(filas);
      }
    },error: function (e) {
        msj_error_serve(e)
        bootbox.hideAll();
    }
  });



}


function ActualizarHistorialPrescripcion(folio,estado){

  $.ajax({
    url: base_url+"Sections/Documentos/AjaxPrescripciones",
    type:"GET",
    dataType:"json",
    data:{
      folio: folio,
      estado: estado
    },success: function(data, textStatus, jqXHR){
      $("#table_prescripcion_historial").empty();
      var d = new Date();
      var fechaActual = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();

      for(var x = 0; x < data.length; x++){
        var color_estado = "255, 195, 195";//rojo
        var accion_cancelar = "";
        var accion_editar = "";
        var accion_observaciones = "class='glyphicon glyphicon-eye-open pointer observaciones-prescripcion '";
        var total_dias = RestarFechas(data[x].fecha_inicio,fechaActual);
        var tiempo_transcurrido = "";
        var filas_dias_fechafin = "";
        var filas_diasTranscurridos_acciones = "";
        if(total_dias < 0){
          tiempo_transcurrido = "Sin iniciar";
        }else if (total_dias >= 0) {
          tiempo_transcurrido = total_dias+" dias";
        }
        if(data[x].estado == 1){
          color_estado = "";//verde
          accion_cancelar = "class='glyphicon glyphicon-remove pointer desactivar-prescripcion'";

          accion_editar = "class='fa fa-pencil pointer editar-prescripcion'";
          filas_diasTranscurridos_acciones = "<td id='fila_historial_prescripcion"+data[x].prescripcion_id+"' >"+tiempo_transcurrido+"</td>"+
          "<td>"+
            "<i "+accion_cancelar+" title='Cancelar Prescripción' data-value='"+data[x].prescripcion_id+"' ></i>"+
            "<i style='padding-left: 5px;' "+accion_editar+" title='Editar Prescripcion' data-value='"+data[x].prescripcion_id+"' ></i>"+
            "<i style='padding-left: 5px;' "+accion_observaciones+" title='Observaciones' data-value='"+data[x].prescripcion_id+"' ></i>"+
          "</td>";
          $('#col_dias').text('Días Transcurridos');
          $('#col_fechaFin').text('Acciones');
          $('#col_acciones').attr('hidden','true');
          $('#col_movimiento').attr('hidden','true');
          $('#col_fecha_movimiento').attr('hidden','true');
        }else{
          filas_dias_fechafin = "<td>"+data[x].dias+"</td>"+
          "<td>"+data[x].fecha_fin+"</td>"+
          "<td>"+
            "<i style='padding-left: 5px;' "+accion_observaciones+" title='Observaciones' data-value='"+data[x].prescripcion_id+"' ></i>"+
          "</td>";
          $('#col_dias').text('Total días');
          $('#col_fechaFin').text('Fecha Fin');
          $('#col_acciones').removeAttr('hidden');
        }
        var prescripciones = "<tr style='background:rgb("+color_estado+")' >"+
          "<td hidden id='fila_idmedicamento"+data[x].prescripcion_id+"'  >"+data[x].medicamento_id+"</td>"+
          "<td id='fila_medicamento"+data[x].prescripcion_id+"'  >"+data[x].medicamento+"</td>"+
          "<td id='fila_categoria_farmacologica"+data[x].prescripcion_id+"'  >"+data[x].categoria_farmacologica.toUpperCase()+"</td>"+
          "<td id='fila_fecha_prescripcion"+data[x].prescripcion_id+"'  >"+data[x].fecha_prescripcion+"</td>"+
          "<td id='fila_dosis"+data[x].prescripcion_id+"'  >"+data[x].dosis+"</td>"+
          "<td id='fila_via_administracion"+data[x].prescripcion_id+"'  >"+data[x].via_administracion+"</td>"+
          "<td id='fila_frecuencia"+data[x].prescripcion_id+"'  >"+data[x].frecuencia+"</td>"+
          "<td id='fila_aplicacion"+data[x].prescripcion_id+"' style='padding: 5px;' >"+data[x].aplicacion+"</td>"+
          "<td id='fila_fecha_inicio"+data[x].prescripcion_id+"'  >"+data[x].fecha_inicio+"</td>"+
          "<td id='fila_tiempo"+data[x].prescripcion_id+"'  >"+data[x].tiempo+"</td>"+
          "<td id='fila_periodo"+data[x].prescripcion_id+"' style='padding: 5px;' >"+data[x].periodo+"</td>"+
          "<td id='fila_fecha_"+data[x].prescripcion_id+"'  >"+data[x].fecha_fin+"</td>"+
          filas_dias_fechafin+
          filas_diasTranscurridos_acciones+
        "</tr>"+
        "<tr id='historial_prescripcion_observacion"+data[x].prescripcion_id+"' hidden value='0'>"+
          "<th style='background-color:rgb(210, 210, 210);'>Observaciones: </th>"+
          "<td id='fila_observacion"+data[x].prescripcion_id+"' colspan='12' style='text-align:left; background-color:rgb(235, 235, 235);' >"+
            data[x].observacion+
          "</td>"+
        "</tr>";
        $("#table_prescripcion_historial").append(prescripciones);
      }
    },error: function (e) {
        msj_error_serve(e)
        bootbox.hideAll();
    }
  });
}


function actualizarPrescripcion(){
  var indice = $('#indiceArrayPrescripcion').val();
  EliminarFilaPrescripcion(indice);
  agregarPrescripcion();
  $('#tablaPrescripcion').empty();
  var longitud = arrayPrescripcion.length

  for(var x = 0; x < longitud; x++){
    var fila ="<tr id='fila"+x+"' >"+
    "<td hidden ><input type='text' name=idMedicamento[] size='1' class='label-input' value='"+arrayPrescripcion[x]["idMedicamento"]+"' /></td>"+
    "<td>"+arrayPrescripcion[x]["medicamento"]+"</td>"+
    "<td>"+arrayPrescripcion[arrayLongitud]["categoria_farmacologica"]+"</td>"+
    "<td><input readonly type='text' name='dosis[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["dosis"]+" "+arrayPrescripcion[x]["unidad"]+"' /></td>"+
    "<td><input readonly type='text' name='via_administracion[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["via"]+"' /></td>"+
    "<td><input readonly type='text' name='frecuencia[]' size='4' class='label-input' value='"+arrayPrescripcion[x]["frecuencia"]+"' /></td>"+
    "<td><input readonly type='text' name='horaAplicacion[]' size='22' class='label-input' value='"+arrayPrescripcion[x]["horaAplicacion"]+"' /></td>"+
    "<td><input readonly type='text' name='fechaInicio[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["fechaInicio"]+"' /></td>"+
    "<td><input readonly type='text' name='duracion[]' size='1' class='label-input' value='"+arrayPrescripcion[x]["duracion"]+"' /></td>"+
    "<td><input readonly type='text' name='periodo[]' size='1' class='label-input' value='"+arrayPrescripcion[x]["periodo"]+"' /></td>"+
    "<td><input readonly type='text' name='fechaFin[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["fechaFin"]+"' /></td>"+
    "<td>"+
      //"<a href='#'><i class='fa fa-pencil icono-accion' onclick=TomarDatosTablaPrescripcion("+x+") ></i></a>"+
      "<a href='#'> <i class='glyphicon glyphicon-remove icono-accion' onclick=EliminarFilaPrescripcion("+x+") ></i> </a>"+
      "<a href='#'> <i class='glyphicon glyphicon-eye-open icono-accion' onclick=MostrarOcularObservacion("+x+") ></i> </a>"+
    "</td>"+
    "</tr>"+
    "<tr hidden style='background-color:rgb(228, 228, 228);' class='fila"+x+"Observacion'>"+
    "<td style='text-align: right;'><strong>Observación:</strong>  </td>"+
    "<td colspan='10' ><input hidden  class='fila"+x+"Val' value='0' />"+
    "<input readonly type='text' id='' name='observacion[]' style='text-align: left;' class='label-input' value='"+arrayPrescripcion[x]["observacion"]+"' />"+
    "</td>"+
    "</tr>";
    $('#tablaPrescripcion').append(fila);
    $('#div_btnActualizarPrescripcion').attr("hidden","true");
  }
}
function TomarDatosTablaPrescripcion(fila){
  $('#div_btnActualizarPrescripcion').removeAttr("hidden");
  $('#indiceArrayPrescripcion').val(fila);
  $('#select_medicamento').select2('val',arrayPrescripcion[fila]["idMedicamento"]).select2();
  $('#input_dosis').val(arrayPrescripcion[fila]["dosis"]);
  $('#select_unidad').val(arrayPrescripcion[fila]["unidad"]);
  $('#via_administracion').select2('val',arrayPrescripcion[fila]["via"]).select2();
  $('#frecuencia').val(arrayPrescripcion[fila]["frecuencia"]);
  $('#aplicacion').val(arrayPrescripcion[fila]["horaAplicacion"]);
  $('#fechaInicio').val(arrayPrescripcion[fila]["fechaInicio"]);
  $('#duracion').val(arrayPrescripcion[fila]["duracion"]);
  $('#fechaFin').val(arrayPrescripcion[fila]["fechaFin"]);
  $('#observacion').val(arrayPrescripcion[fila]["observacion"]);
  revisarCamposVaciosPrescripcion();
}

function sumarfecha(d, fecha)
{
 var Fecha = new Date();
 var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
 var sep = sFecha.indexOf('/') != -1 ? '/' : '-';
 var aFecha = sFecha.split(sep);
 var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
 fecha= new Date(fecha);
 fecha.setDate(fecha.getDate()+parseInt(d));
 var anno=fecha.getFullYear();
 var mes= fecha.getMonth()+1;
 var dia= fecha.getDate();
 mes = (mes < 10) ? ("0" + mes) : mes;
 dia = (dia < 10) ? ("0" + dia) : dia;
 var fechaFinal = dia+sep+mes+sep+anno;
 return (fechaFinal);
 }

function ConteoEstadoPrescripcion(folio){
  $.ajax({
    url: base_url+"Sections/Documentos/AjaxConteoEstadoPrescripciones",
    type: 'GET',
    dataType: 'json',
    data:{
      folio:folio
    },
    success: function(data, textStatus, jqXHR){
      $('#label_total_activas').text(data.Prescripciones_activas[0].activas);
      $('#label_total_canceladas').text(data.Prescripciones_canceladas.length);
    },error: function (e) {
        bootbox.hideAll();
        msj_error_serve();
    }
  });
}


function RegistrarAccionBitacoraPrescripcion(prescripcion_id,tipo_accion,motivo){
 $.ajax({
   url: base_url+"Sections/Documentos/AjaxRegistrarBitacoraPrescripcion",
   type: 'GET',
   dataType: 'json',
   data:{
     prescripcion_id : prescripcion_id,
     tipo_accion : tipo_accion,
     motivo : motivo
   },
   success: function(data, textStatus, jqXHR){

   },error: function (e) {
       bootbox.hideAll();
       msj_error_serve();
   }
 });
}

function DatosTabplaPrescripcionActivas(prescripcion_id){

  var datos = {
    prescripcion_id : prescripcion_id,
    medicamento_id : $('#fila_idmedicamento'+prescripcion_id).text(),
    medicamento : $('#fila_medicamento'+prescripcion_id).text(),
    fecha_prescripcion : $('#fila_fecha_prescripcion'+prescripcion_id).text(),
    via_administracion : $('#fila_via_administracion'+prescripcion_id).text(),
    frecuencia : $('#fila_frecuencia'+prescripcion_id).text(),
    aplicacion : $('#fila_aplicacion'+prescripcion_id).text(),
    fecha_inicio : $('#fila_fecha_inicio'+prescripcion_id).text(),
    observacion : $('#fila_observacion'+prescripcion_id).text(),
    dosis: $('#fila_dosis'+prescripcion_id).text()
  }
  return datos;
}

function TipoMedicamento(medicamento_id){
  $.ajax({
    url: base_url+"Sections/Documentos/AjaxTipoMedicamento",
    type: 'GET',
    dataType: 'json',
    data:{
      medicamento_id:medicamento_id
    },
    success: function(data, textStatus, jqXHR){
      $('.tiempo_tipo_medicamento').empty();
      var formulario = "";
      var farmacologica = "null";
      if(data.length > 0){
          farmacologica = data[0].categoria_farmacologica;
      }

      if(farmacologica.toLowerCase() == 'antibiotico'){
        formulario =
        "<div class='col-sm-1' style='padding: 0;' >"+
          "<label id='categoria_farmacologica' hidden>"+farmacologica+"</label>"+
          "<label><b>Dias</b></label>"+
          "<div id='borderDuracion'>"+
          "<select id='duracion' onchange='mostrarFechaFin()' class='form-control' >"+
            "<option value='0'>0</option>"+
            "<option value='1'>1</option>"+
            "<option value='2'>2</option>"+
            "<option value='3'>3</option>"+
            "<option value='4'>4</option>"+
            "<option value='5'>5</option>"+
            "<option value='6'>6</option>"+
            "<option value='7'>7</option>"+
            "<option value='8'>8</option>"+
            "<option value='9'>9</option>"+
            "<option value='10'>10</option>"+
          "</select>"+
          "</div>"+
        "</div>"+
        "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
          "<label><b>Fecha Fin</b></label>"+
          "<div id='borderFechaFin'>"+
          "<input class='form-control' id='fechaFin'  >"+
          "</div>"+
        "</div>";
      }else{
        formulario =
        "<div class='col-sm-1' style='padding-right: 0; padding-left: 0;' >"+
          "<label id='categoria_farmacologica' hidden>"+farmacologica+"</label>"+
          "<label><b>Tiempo</b></label>"+
          "<div class='input-group' >"+
            "<input type='text' class='form-control' id='duracion' onchange='mostrarFechaFin()' >"+
            "<span class='input-group-btn'>"+
              "<div class='col-sm-12' style=''>"+
              "<a class='btn' title='Aumentar' onClick=AumentarNum() style='padding=0;margin-left:-28px; margin-top:-8px;' ><span style='border:1px solid #000; width:20px; height:17px;' class='glyphicon glyphicon-menu-up'></span></a>"+
              "</div>"+
              "<div class='col-sm-12' style=''>"+
              "<a class='btn' title='Reducir' onClick=ReducirNum() style='padding=0;margin-left:-28px; margin-top:-17px;' ><span style='border:1px solid #000; width:20px; height:17px;' class='glyphicon glyphicon-menu-down'></span></a>"+
              "</div>"+
            "</span>"+
          "</div>"+
        "</div>"+
        "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
          "<label><b>Periodo</b></label>"+
          "<select class='form-control' id='periodo' name='periodo' onchange='mostrarFechaFin()'>"+
            "<option value='Dias'>Dias</option>"+
            "<option value='Semanas'>Semanas</option>"+
          "</select>"+
        "</div>"+
        "<div class='col-sm-2' style='padding-right: 0; padding-left: 1;' >"+
          "<label><b>Fecha Fin</b></label>"+
          "<div id='borderFechaFin'>"+
          "<input class='form-control' id='fechaFin' >"+
          "</div>"+
        "</div>";
      }
      $('.tiempo_tipo_medicamento').append(formulario);
    },error: function (e) {
        bootbox.hideAll();
        msj_error_serve();
    }
  });
}

function AumentarNum(){
  var numero = $('#duracion').val();
  if(numero != ''){
    $('#duracion').val(Number(numero) + 1);
  }else{
    $('#duracion').val('0');
  }
  mostrarFechaFin();
}

function ReducirNum(){
  var numero = $('#duracion').val();
  if(numero == 0 || numero < 0){
    $('#duracion').val('0');
  }else{
    $('#duracion').val(Number(numero) - 1);
  }
  mostrarFechaFin();
}
function ConvercionDias(tiempo, periodo){

  var dias = 0;
  if(periodo == 'Dias'){
    dias = tiempo;
  }else if(periodo == 'Semanas'){
      dias = tiempo * 7;
  }
  return dias;

}

function multiplo(valor, multiplo){

    var resto = valor % multiplo;
    if(resto==0){
      return true;
    }else{
      return false;
    }

}

function ConsultarUltimasOrdenes(folio){

  $.ajax({
      url:base_url+'Sections/Documentos/AjaxUltimasOrdenes',
      type: 'get',
      dataType: 'json',
      data:{
          folio:folio
      },success: function (data, textStatus, jqXHR) {

        var nutricion = data[0].nota_nutricion,
            signoscuidados = data[0].nota_svycuidados,
            cgenfermeria = data[0].nota_cgenfermeria,
            cuidadosenfermeria = data[0].nota_cuidadosenfermeria,
            solucionesp = data[0].nota_solucionesp;

        // si la variable es indefinida, significa que no hay nota de evolucion
        // por lo que tomara los datos de la hoja frontal
        if(nutricion == undefined){
          nutricion = data[0].hf_nutricion,
          signoscuidados = data[0].hf_signosycuidados,
          cgenfermeria = data[0].hf_cgenfermeria,
          cuidadosenfermeria = data[0].hf_cuidadosenfermeria,
          solucionesp = data[0].hf_solucionesp;
        }

        //asignacion nuticion
        if(nutricion == 0){
          $('#radioAyuno').attr('checked',true);
        }else if(nutricion >= 1 || nutricion <= 12){
          $('#radioDieta').attr('checked',true);
          $('#divSelectDietas').removeAttr('hidden');
          $('#selectDietas').val(nutricion);
        }else{
          $('#radioDieta').attr('checked',true);
          $('#divSelectDietas').removeAttr('hidden');
          $('#selectDietas').val(13);
          $('#divOtraDieta').removeAttr('hidden');
          $('#inputOtraDieta').val(nutricion);
        }
        //asignacion toma de signoscuidados
        if(signoscuidados <=3){
          $('#selectTomaSignos').val(signoscuidados);
        }else{
          $('#selectTomaSignos').val(3);
          $('#divOtrasInidcacionesSignos').removeAttr('hidden');
          $('#otras-indicaciones-signos').val(signoscuidados);
        }
        //asignacion cuidados generales de enfermeria
        if(cgenfermeria == 1){
          $('#checkCuidadosGenerales').attr('checked',true);
          $('#labelCheckCuidadosGenerales').text("");
          $('#listCuidadosGenerales').removeAttr('hidden');
        }

        $('textarea[name=nota_cuidadosenfermeria]').data("wysihtml5").editor.setValue(cuidadosenfermeria);
        $('textarea[name=nota_solucionesp]').data("wysihtml5").editor.setValue(solucionesp);


      },error: function (jqXHR, textStatus, errorThrown) {
          bootbox.hideAll();
          MsjError();
      }
  });

}

function ConsultarClaveCIE10(valor_clave,lista,indice,id_cie10){

  var diagnostico = $('.btn_diagnostico_cie10_'+lista).text();
  $('#text_diagnostico_'+indice).val(diagnostico);
  $('#text_codigo_diagnostico_'+indice).val(valor_clave);
  $('#text_id_diagnostico_'+indice).val(id_cie10);
  $('#lista_resultado_diagnosticos_'+indice).empty();
}
function BorrarDiagnosticoDinamico(indice){
  $('#form_diagnosticos_secundarios_'+indice).remove();
}

var contador_alergia_medicamentos = 0;
function AgregaFormularioAlergiaMedicamento(){
  contador_alergia_medicamentos = contador_alergia_medicamentos + 1;
  var formulario =
  "<div id='input_medicamento_alergia_"+contador_alergia_medicamentos+"'>"+
    "<div class='col-sm-11' style='padding-left:0px;'>"+
      "<label>Medicamento</label>"+
      "<select id='medicamento_select_"+contador_alergia_medicamentos+"' name='alergias_medicamento[]' class='width100'>"+
      "</select>"+
    "</div>"+
    "<div class='col-sm-1' style='padding-top:25px; padding-right:0px;' >"+
      "<button type='button' class='btn btn-imms-cancel width100' "+
      " onClick=BorrarFormularioAlergiaMedicamento("+contador_alergia_medicamentos+"); title='Agregar alergia a medicamentos' name='button'>"+
        "<span class='glyphicon glyphicon-remove'></span>"+
      "</button>"+
    "</div>"+
  "</div>";

  $('#alergia_medicamentos').append(formulario);
  $('#medicamento_select_'+contador_alergia_medicamentos).select2();

  $.ajax({
    url: base_url+"Sections/Documentos/ObtenerMedicamentos",
    type: 'GET',
    dataType:'json',
    data: {
    },success: function (data, textStatus, jqXHR) {
      for(var x = 0; x < data.medicamentos.length; x++){
      $('#medicamento_select_'+contador_alergia_medicamentos).append("<option value='"+data.medicamentos[x].medicamento_id+"'>"+data.medicamentos[x].medicamento+"</option>");
      }
    },error: function (e) {
        msj_error_serve(e)
        bootbox.hideAll();
    }
  });
}

function BorrarFormularioAlergiaMedicamento(indice){
  $('#input_medicamento_alergia_'+indice).remove();
}

function BuscarDiagnostico(indice){

  $('#lista_resultado_diagnosticos_'+indice).empty();
  var diagnostico_solicitado = $('#text_diagnostico_'+indice).val();

  var lista_opciones = "";
  var tipo_diagnostico = $('input:radio[name=tipo_diagnostico_'+indice+']:checked').val();
  var ruta_tipo_diagnostico = "";
  //condicion para validar que un input sea seleccionado y filtrar la busqueda
  //if(diagnostico_solicitado.length >= 3 && tipo_diagnostico != null){
  if(diagnostico_solicitado.length >= 3){
    /*
    if(tipo_diagnostico == 0){
      ruta_tipo_diagnostico = "AjaxDiagnosticosFrecuentes";
    }else if(tipo_diagnostico == 1){
      ruta_tipo_diagnostico = "AjaxDiagnosticos";
    }
    */

    $.ajax({
        url:base_url+'Sections/Documentos/AjaxDiagnosticos',
        type: 'get',
        dataType: 'json',
        data:{
            diagnostico_solicitado:diagnostico_solicitado
        },success: function (data, textStatus, jqXHR) {
          $('#lista_resultado_diagnosticos_'+indice).empty();
            for(var x = 0; x < data.length; x++){
              lista_opciones =
              "<li class='lista_diagnosticos' id='lista_diagnosticos_"+indice+"' >"+
                "<a onclick=ConsultarClaveCIE10('"+data[x].cie10_clave+"',"+x+","+indice+","+data[x].cie10_id+") class='btn_diagnostico_cie10_"+x+"' id='btn_diagnostico_cie10'>"+data[x].cie10_nombre+"</a>"+
              "</li>";

              $('#lista_resultado_diagnosticos_'+indice).append(lista_opciones);
            }
        },error: function (jqXHR, textStatus, errorThrown) {
            bootbox.hideAll();
            MsjError();
        }
    });
  }
  /*
  else if(tipo_diagnostico == null){
    alert("Indicar CIE-10 o Frecuentes");
  }
  */
}

function RegistrarEfectoAdverso(prescripcion_id, paciente, motivo){
  $.ajax({
      url:base_url+'Sections/Documentos/AjaxRegistrarEfectoAdverso',
      type: 'get',
      dataType: 'json',
      data:{
          prescripcion_id : prescripcion_id,
          paciente : paciente,
          motivo : motivo
      },success: function (data, textStatus, jqXHR) {
        $('#label_total_reacciones').text(data.length);
      },error: function (jqXHR, textStatus, errorThrown) {
          bootbox.hideAll();
          MsjError();
      }
  });
}
function HitorialReaccionesAdversas(paciente){
  $.ajax({
      url:base_url+'Sections/Documentos/AjaxHistorialReaccionesAdversas',
      type: 'get',
      dataType: 'json',
      data:{
          paciente:paciente
      },success: function (data, textStatus, jqXHR) {
        $('#table_historial_reacciones').empty();
        var fila = "";

        data.forEach(function(val){
          fila = "<tr>"+
                 "<td>"+val.medicamento+"</td>"+
                 "<td>"+val.efecto+"</td>"+
                 "</tr>";
          $('#table_historial_reacciones').append(fila);
        });


      },error: function (jqXHR, textStatus, errorThrown) {
          bootbox.hideAll();
          MsjError();
      }
  });
}
function AccionPanelPrescripcion(tipo_accion , paciente){

  $("#historial_medicamentos_activos").attr('hidden',true);
  $("#historial_movimientos").attr('hidden',true);
  $("#historial_reacciones").attr('hidden',true);
  $("#historial_notificaciones").attr('hidden',true);

  switch (tipo_accion) {
    case 1:
        $("#historial_medicamentos_activos").removeAttr('hidden');
        ActualizarHistorialPrescripcion(paciente,"1");
      break;
    case 2:
        $("#historial_movimientos").removeAttr('hidden');
        BitacoraPrescripcionMedicamento(paciente);
      break;
    case 3:
        $("#historial_reacciones").removeAttr('hidden');
        HitorialReaccionesAdversas(paciente);
      break;
    case 4:
        $("#historial_notificaciones").removeAttr('hidden');
      break;
  }
}
