var cont = 0;
$(document).ready(function () {


    $('.select2').select2();
    //$('textarea[name=cpr_nota]').wysihtml5();
    $('.hf_motivo_abierto').wysihtml5();
    $('.hf_antecedentes').wysihtml5();
    //$('.hf_padecimientoa_abierto').wysihtml5();
    $('.hf_exploracionf_abierto').wysihtml5();
    $('.hf_textarea').wysihtml5();
    $('.hf_ayuno').wysihtml5();
    $('.hf_signosycuidados').wysihtml5();
    $('.hf_cuidadosenfermeria').wysihtml5();
    $('.hf_solucionesp').wysihtml5();
    $('.hf_medicamentos').wysihtml5();
    $('.hf_diagnosticos').wysihtml5();
    $('textarea[name=nota_interrogatorio]').wysihtml5();
    $('textarea[name=nota_problema]').wysihtml5();
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

    /*if($('input[name=accion]').val()!=undefined){
        $('#nota_interconsulta').val($('#nota_interconsulta').attr('data-value').split(',')).select2(); //divide cada seleccinado
    }*/
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

    // Toma el valor del 'data-value' y lo asigna en el select
    $('select[name=tomaSignos]').val($('select[name=tomaSignos]').attr('data-value'));
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

    $('body').on('click','.desactivar-prescripcion',function(){

      if(confirm('¿QIERES RETIRAR ESTE MEDICAMENTO?')){
        var prescripcion_id = $(this).attr('data-value');
        var estado = 0;
        var motivo = prompt('Motivo por el que se cancela el medicamento');
        var paciente = $('input[name=triage_id]').val();

        if(motivo!=null && motivo!=''){
          $.ajax({
            url: base_url+"Sections/Documentos/AjaxCambiarEstadoPrescripcion",
            type: 'GET',
            dataType:'json',
            data: {
              estado: estado,
              prescripcion_id: prescripcion_id,
              paciente: paciente
            },success: function (data, textStatus, jqXHR) {
                msj_success_noti(data.mensaje);
                ActualizarHistorialPrescripcion(paciente,"1");
                RegistrarAccionBitacoraPrescripcion(prescripcion_id,'Cancelar',motivo);
                ConteoEstadoPrescripcion(paciente);

            },error: function (e) {
                msj_error_serve(e)
                bootbox.hideAll();
            }
          });
        }
      }
    });

    $('#acordeon_prescripciones_activas').click(function(){
      var paciente = $('input[name=triage_id]').val();
      $('#historial_prescripcion').removeAttr('hidden');
      ActualizarHistorialPrescripcion(paciente,"1");
    });
    $('#acordeon_prescripciones_canceladas').click(function(){
      var paciente = $('input[name=triage_id]').val();
      $('#historial_prescripcion').removeAttr('hidden');
      ActualizarHistorialPrescripcion(paciente,"0");
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

    $('#check_form_prescripcion').change(function(){

      if($(this).is(':checked')){
        $('.formulario_prescripcion').removeAttr('hidden');
        $('#label_check_prescripcion').text('');
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
function mostrarFechaFin(){

  var fechaInicio = $('#fechaInicio').val();
  var duracion = $('#duracion').val();
  var fechaFin = sumarfecha(duracion,fechaInicio);
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
}

// Se almacenan los datos de la prescripcion en un arreglo
function agregarPrescripcion(){
  var validar = revisarCamposVaciosPrescripcion();
  if (validar === true){
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
    var observacion = $('#observacion').val();;
    if(observacion === ''){
      observacion = "Sin observaciones";
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
            alert(arrayPrescripcion[x]['medicamento']+" puede generar efectos adversos al aplicarse con el medicamento seleccionado. Favor de notificar a la Gefatura de Consulta Externa");

            //break;
          }
        }
        for (var y = 0; y < longitudInteracciones; y++){
          interaccionA = arrayInteracciones[x]['arrayInteraccionRoja'][y];
          if(arrayInteracciones[x]['arrayInteraccionRoja'][y] == idMedicamento ){
            $('#fila'+x).css("background-color","rgb(255, 170, 170)");//color rojo para efectos muy grabes
            alert(arrayPrescripcion[x]['medicamento']+" puede generar efectos"+
            "adversos muy graves al aplicarse con el medicamento seleccionado. "+
            "Favor de notificar a la Gefatura de Consulta Externa");
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
          dosis:dosis,
          unidad:unidad,
          via:via,
          frecuencia:frecuencia,
          horaAplicacion:horaAplicacion,
          fechaInicio:fechaInicio,
          duracion:duracion,
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
        dosis:dosis,
        unidad:unidad,
        via:via,
        frecuencia:frecuencia,
        horaAplicacion:horaAplicacion,
        fechaInicio:fechaInicio,
        duracion:duracion,
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
  "<td><input readonly type='text' name='dosis[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["dosis"]+" "+arrayPrescripcion[arrayLongitud]["unidad"]+"' /></td>"+
  "<td><input readonly type='text' name='via_administracion[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["via"]+"' /></td>"+
  "<td><input readonly type='text' name='frecuencia[]' size='4' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["frecuencia"]+"' /></td>"+
  "<td><input readonly type='text' name='horaAplicacion[]' size='22' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["horaAplicacion"]+"' /></td>"+
  "<td><input readonly type='text' name='fechaInicio[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["fechaInicio"]+"' /></td>"+
  "<td><input readonly type='text' name='duracion[]' size='1' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["duracion"]+"' /></td>"+
  "<td><input readonly type='text' name='fechaFin[]' size='8' class='label-input' value='"+arrayPrescripcion[arrayLongitud]["fechaFin"]+"' /></td>"+
  "<td><a href='#'><i class='fa fa-pencil icono-accion' onclick=TomarDatosTablaPrescripcion("+arrayLongitud+") ></i></a>"+
  "<a href='#'> <i class='glyphicon glyphicon-remove icono-accion' onclick=EliminarFilaPrescripcion("+arrayLongitud+") ></i> </a>"+
  "<a href='#'> <i class='glyphicon glyphicon-eye-open icono-accion' onclick=MostrarOcularObservacion("+arrayLongitud+") ></i> </a></td>"+
  "</tr>"+
  "<tr hidden style='background-color:rgb(228, 228, 228); ' class='fila"+arrayLongitud+"Observacion'>"+
  "<td style='text-align: right;'><strong>Observación del medicamento:  </strong></td>"+
  "<td colspan='8' ><input hidden style='text-align: left;' class='fila"+arrayLongitud+"Val' value='0' />"+
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
        var accion_observaciones = "";
        var total_dias = RestarFechas(data[x].fecha_inicio,fechaActual);
        var tiempo_transcurrido = "";

        if(total_dias < 0){
          tiempo_transcurrido = "Sin iniciar";
        }else if (total_dias >= 0) {
          tiempo_transcurrido = total_dias+" dias";
        }
        if(data[x].estado == 1){
          color_estado = "162, 255, 156";//verde
          accion_cancelar = "class='glyphicon glyphicon-remove pointer desactivar-prescripcion'";
          accion_observaciones = "class='glyphicon glyphicon-eye-open pointer observaciones-prescripcion '";
          //accion_editar = "class='fa fa-pencil pointer editar-prescripcion'";
        }
        var prescripciones = "<tr style='background:rgb("+color_estado+")' >"+
          "<td>"+data[x].medicamento+"</td>"+
          "<td>"+data[x].fecha_prescripcion+"</td>"+
          "<td>"+data[x].dosis+"</td>"+
          "<td>"+data[x].via_administracion+"</td>"+
          "<td>"+data[x].frecuencia+"</td>"+
          "<td>"+data[x].aplicacion+"</td>"+
          "<td>"+data[x].fecha_inicio+"</td>"+
          "<td>"+tiempo_transcurrido+"</td>"+
          "<td>"+
            "<i "+accion_cancelar+" title='Canselar Prescripción' data-value='"+data[x].prescripcion_id+"' ></i>"+
            "<i style='padding-left: 5px;' "+accion_editar+" title='Editar Prescripcion' data-value='"+data[x].prescripcion_id+"' ></i>"+
            "<i "+accion_observaciones+" title='Observaciones' data-value='"+data[x].prescripcion_id+"' ></i>"+
          "</td>"+
        "</tr>"+
        "<tr id='historial_prescripcion_observacion"+data[x].prescripcion_id+"' hidden value='0'>"+
          "<td>Observaciones: </td>"+
          "<td colspan='8' style='text-align:left;' >"+data[x].observacion+"</td>"+
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
    "<td><input readonly type='text' name='dosis[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["dosis"]+" "+arrayPrescripcion[x]["unidad"]+"' /></td>"+
    "<td><input readonly type='text' name='via_administracion[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["via"]+"' /></td>"+
    "<td><input readonly type='text' name='frecuencia[]' size='4' class='label-input' value='"+arrayPrescripcion[x]["frecuencia"]+"' /></td>"+
    "<td><input readonly type='text' name='horaAplicacion[]' size='22' class='label-input' value='"+arrayPrescripcion[x]["horaAplicacion"]+"' /></td>"+
    "<td><input readonly type='text' name='fechaInicio[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["fechaInicio"]+"' /></td>"+
    "<td><input readonly type='text' name='duracion[]' size='1' class='label-input' value='"+arrayPrescripcion[x]["duracion"]+"' /></td>"+
    "<td><input readonly type='text' name='fechaFin[]' size='8' class='label-input' value='"+arrayPrescripcion[x]["fechaFin"]+"' /></td>"+
    "<td><a href='#'><i class='fa fa-pencil icono-accion' onclick=TomarDatosTablaPrescripcion("+x+") ></i></a>"+
    "<a href='#'> <i class='glyphicon glyphicon-remove icono-accion' onclick=EliminarFilaPrescripcion("+x+") ></i> </a>"+
    "<a href='#'> <i class='glyphicon glyphicon-eye-open icono-accion' onclick=MostrarOcularObservacion("+x+") ></i> </a></td>"+
    "</tr>"+
    "<tr hidden style='background-color:rgb(228, 228, 228);' class='fila"+x+"Observacion'>"+
    "<td style='text-align: right;'><strong>Observación del medicamento:</strong>  </td>"+
    "<td colspan='8' ><input hidden  class='fila"+x+"Val' value='0' />"+
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
      $('#label_total_canceladas').text(data.Prescripciones_canceladas[0].canceladas);
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
