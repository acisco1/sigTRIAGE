$(document).ready(function () {
    $('#input_search').focus()
    $('#input_search').keyup(function (e){
        var input=$(this);
        var triage_id=$(this).val();
        if(triage_id.length==11 && triage_id!=''){
            SendAjaxGet("Triage/EtapaPaciente/"+triage_id,function (response) {
                if(response.accion=='1'){
                    window.open(base_url+'Triage/Paciente/'+triage_id,'_blank');
                }if(response.accion=='2'){
                    msj_error_noti('EL N° de paciente no existe');
                }
            });
            input.val('');
        }
    });
    $('input[name=pia_procedencia_espontanea]').click(function (e){
        if($(this).val()=='Si'){
            $('input[name=pia_procedencia_espontanea_lugar]').prop('type','text').attr('required',true);
            $('.col-no-espontaneo').addClass('hidden');
            $('select[name=pia_procedencia_hospital]').val("");
            $('input[name=pia_procedencia_hospital_num]').removeAttr('required').val('');
        }else{
            $('input[name=pia_procedencia_espontanea_lugar]').prop('type','hidden').removeAttr('required').val('');
            $('.col-no-espontaneo').removeClass('hidden');
            $('input[name=pia_procedencia_hospital_num]').attr('required',true);
        }
    })
    if($('input[name=pia_procedencia_espontanea]').attr('data-value')=='No'){
        $('.col-no-espontaneo').removeClass('hidden');
        $('input[name=pia_procedencia_espontanea][value="No"]').prop("checked",true);
        $('input[name=pia_procedencia_espontanea_lugar]').prop('type','hidden').removeAttr('required');

        $("select[name=pia_procedencia_hospital]").val($('select[name=pia_procedencia_hospital]').attr('data-value'));
        $('input[name=pia_procedencia_hospital_num]').attr('required',true);
    }
    $('.guardar-triage-enfermeria').submit(function (e) {
        e.preventDefault();
        SendAjaxPost($(this).serialize(),"Triage/EnfemeriatriageGuardar",function (response) {
            msj_success_noti('DATOS GUARDADOS')
            if($('input[name=via]').val()!=''){
                AbrirDocumento(base_url+'Horacero/GenerarTicket/'+$('input[name=triage_id]').val());
                history.go(-1);
            }else{
                ActionCloseWindowsReload();
            }
        });
    });
    /*Indicador*/
    $('select[name=TipoBusqueda]').change(function () {
        if($(this).val()=='POR_FECHA'){
            $('.row-por-fecha').removeClass('hide');
            $('.row-por-hora').addClass('hide');
        }if($(this).val()=='POR_HORA'){
            $('.row-por-hora').removeClass('hide');
            $('.row-por-fecha').addClass('hide');
        }if($(this).val()==''){
            $('.row-por-hora').addClass('hide');
            $('.row-por-fecha').addClass('hide');
        }
    })
    $('select[name=triage_paciente_sexo]').change(function (e) {
        if($(this).val()=='MUJER'){
            $('.triage_paciente_sexo').removeClass('hide');
            $('.paciente-sexo-mujer').removeClass('hide');
            $('input[name=pic_indicio_embarazo][value=No]').attr('checked',true);
            $('.paciente-sexo').html('<i class="fa fa-female " style="color: pink"></i>').removeClass('hide');
        }else if($(this).val()=='HOMBRE'){
            $('.paciente-sexo-mujer').addClass('hide');
            $('.paciente-embarazo').html('').removeClass('hide');
            $('.triage_paciente_sexo').addClass('hide');
            $('input[name=pic_indicio_embarazo][value=No]').attr('checked',true);
            $('.paciente-sexo').html('<i class="fa fa-male " style="color: blue"></i>').removeClass('hide');
            $('#lbl_cod_mater').empty();
        }else{
            $('.paciente-sexo-mujer').addClass('hide');
            $('.paciente-sexo').html('');
            $('.triage_paciente_sexo').removeClass('hide');
            $('input[name=pic_indicio_embarazo][value=No]').attr('checked',true);
            $('.paciente-embarazo').html('').removeClass('hide');
        }
    })
    $('input[name=pic_indicio_embarazo]').click(function () {
        if($(this).val()=='Si'){
            $('.paciente-embarazo').html('EMBARAZO').removeClass('hide');
            $('#lbl_cod_mater').html('<input type="radio" name="triage_codigo_atencion" value="4"><i class="green"></i>Mater');
        }else{
            $('.paciente-embarazo').html('EMBARAZO').addClass('hide');
            $('#lbl_cod_mater').empty();
        }
    });
    $('input[name=triage_fecha_nac]').mask('99/99/9999');
    $('input[name=triage_fecha_nac]').change(function (e) {
        var triage_fecha_nac=$(this).val();
        if($(this).val()!=''){
            var CheckDate=/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/;
            if(CheckDate.test(triage_fecha_nac)){
                SendAjaxPost({
                    fechaNac:triage_fecha_nac,
                    csrf_token:csrf_token
                },'Triage/AjaxObtenerEdad',function (response) {
                    console.log(response)
                    $('.Error-Formato-Fecha').addClass('hide');
                    $('.paciente-edad').html(response.Anios+' Años').removeClass('hide');
                    if(response.Anios<15){
                        $('.paciente-tipo').html('PEDIATRICO').removeClass('hide');
                    }else if(response.Anios>15 && response.Anios<60){
                        $('.paciente-tipo').html('ADULTO').removeClass('hide');
                    }else if(response.Anios>60){
                        $('.paciente-tipo').html('GERIATRICO').removeClass('hide');
                    }
                },'No')


            }else{
                $('.Error-Formato-Fecha').removeClass('hide').find('h2').html('FORMATO DE FECHA NO VÁLIDO ESPECIFIQUE UN FORMATO DE FECHA VÁLIDO (EJEMPLO: 05/02/1993)')
            }
        }
    });
    $('select[name=triage_paciente_sexo]').val($('select[name=triage_paciente_sexo]').attr('data-value'));
    /*SI EL MODULO ENFERMERIA TRIAGE HORA CERO ESTA HABILITADO*/
    $('.btn-horacero-enfermeria').click(function (e) {
        e.preventDefault();
        SendAjaxGet("Horacero/GenerarFolio",function (response) {
            if(response.accion=='1'){
                location.href=base_url+'Triage/Paciente/'+response.max_id+'/?via=EnfermeriaHoraCero'
            }
        })
    })
});
