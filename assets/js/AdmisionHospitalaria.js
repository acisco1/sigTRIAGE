$(document).ready(function () {
    if($('input[name=AdmisionHospitalaria]').val()!=undefined){
        AjaxCamas();
    }
    $('.ajax-load-camas').click(function (e) {
        e.preventDefault();
        AjaxCamas();
    })
    function AjaxCamas() {
        $.ajax({
            url: base_url+"AdmisionHospitalaria/AjaxVisorCamas",
            dataType: 'json',
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
                bootbox.hideAll();
                $('.visor-camas').html(data.Col);
            },error: function (e) {
                msj_error_serve();
                bootbox.hideAll();
                console.log(e)
            }
        })
    }

    $('input[name=directorio_cp]').blur(function (e){
        if($(this).val()!=''){
            BuscarCodigoPostal({
                'cp':$(this).val(),
                'input1':'directorio_municipio',
                'input2':'directorio_estado',
                'input3':'directorio_colonia'
            })
        }
    })
    $('body').on('click','.btn-paciente-agregar',function () {
        var cama_id=$(this).attr('data-cama');
        var cama_estatus=$(this).attr('data-accion');
        if(confirm('¿DESEA REALIZAR UNA SOLICITUD DE ASIGNACIÓN DE CAMA A ESTE PACIENTE?')){
            var triage_id=prompt('ESCANEAR N° DE FOLIO','');
            if(triage_id!=null && triage_id!=''){
                $.ajax({
                    url: base_url+"AdmisionHospitalaria/AjaxBuscarPaciente",
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        cama_id:cama_id,
                        triage_id:triage_id,
                        csrf_token:csrf_token
                    },beforeSend: function (xhr) {
                        msj_loading();
                    },success: function (data, textStatus, jqXHR) {
                        bootbox.hideAll();
                        if(data.accion=='1'){
                            msj_error_noti('EL PACIENTE ACTUALMENTE TIENE UNA SOLICITUD DE ASIGNACIÓN DE CAMA');

                        }if(data.accion=='2'){
                            var empleado_matricula=prompt('CONFIRMAR MATRICULA','');
                            if(empleado_matricula!=null && empleado_matricula!=''){
                                AbrirVista(base_url+'AdmisionHospitalaria/AsignarCama?cama='+cama_id+'&triage_id='+triage_id+'&empleado_matricula='+empleado_matricula+'&cama_estatus='+cama_estatus,800,500)
                            }else{
                                msj_error_noti('CONFIRMACIÓN DE MATRICULA REQUERIDA');
                            }

                        }
                    },error: function (e) {
                        bootbox.hideAll();
                        MsjError();
                        console.log(e);
                    }
                })
            }else{
                msj_error_noti('ESPECIFICAR N° DE FOLIO')
            }
        }
    });
    $('.form-asignacion-cama').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: base_url+"AdmisionHospitalaria/AjaxAsignarCama_v2",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading('','No');
            },success: function (data, textStatus, jqXHR) {
                console.log(data);
                bootbox.hideAll();
                if(data.accion=='1'){
                    AbrirDocumentoMultiple(base_url+'Inicio/Documentos/DOC43051/'+$('input[name=triage_id]').val(),'DOC43051');
                    ActionCloseWindowsReload();

                }if(data.accion=='2'){
                    ActionCloseWindows();
                    msj_error_noti('LA MATRICULA ESPECIFICADA NO EXISTE')
                }
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e)
            }
        })
    });
    $('body input[name=ac_ingreso_matricula]').blur(function () {
        if($(this).val()!=''){
            AjaxBuscarEmpleado(function (response) {
                $('input[name=ac_ingreso_medico]').val(response.empleado_nombre+' '+response.empleado_apellidos)
            },$(this).val())
        }

    })
    $('body input[name=ac_salida_matricula]').blur(function () {
        if($(this).val()!=''){
            AjaxBuscarEmpleado(function (response) {
                $('input[name=ac_salida_medico]').val(response.empleado_nombre+' '+response.empleado_apellidos)
            },$(this).val())
        }
    });
    $('body').on('click','.eliminar43051',function () {
        var cama_id=$(this).attr('data-cama');
        var triage_id=$(this).attr('data-triage');
        bootbox.confirm({
            title:'<h5>ELIMINAR SOLICITUD</h5>',
            message:'<div class="row">'+
                        '</div class="col-md-12"><h5>¿ELIMINAR SOLICITUD 43051?</h5></div>'+
                    '</div>',
            size:'small',
            buttons:{
                confirm:{
                    label:'Eliminar',
                    className:'btn-imss-cancel'
                },cancel:{
                    label:'Cancelar',
                    className:'back-imss'
                }
            },callback:function (res) {
                if(res==true){
                    SendAjax({
                        cama_id:cama_id,
                        triage_id:triage_id,
                        csrf_token:csrf_token
                    },'AdmisionHospitalaria/AjaxEliminar43051',function (response) {
                        AjaxCamas();
                        msj_success_noti('SOLICITUD ELIMINADA');
                    },'');
                }
            }
        })
    })
    $('body').on('click','.liberar43051',function () {
        var cama_id=$(this).attr('data-cama');
        var triage_id=$(this).attr('data-triage');
        bootbox.confirm({
            title:'<h5>LIBERAR CAMA DE SOLICITUD</h5>',
            message:'<div class="row">'+
                        '</div class="col-md-12"><h5>¿LIBERAR CAMA SOLICITUD 43051?</h5></div>'+
                    '</div>',
            size:'small',
            buttons:{
                confirm:{
                    label:'Liberar',
                    className:'btn-imss-cancel'
                },cancel:{
                    label:'Cancelar',
                    className:'back-imss'
                }
            },callback:function (res) {
                if(res==true){
                    SendAjax({
                        cama_id:cama_id,
                        triage_id:triage_id,
                        csrf_token:csrf_token
                    },'AdmisionHospitalaria/AjaxLiberarCama43051',function (response) {
                        AjaxCamas();
                        msj_success_noti('CAMA LIBERADA');
                    },'');
                }
            }
        })
    })
    $('body').on('click','.generar43051',function (e) {
        e.preventDefault();
        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/DOC43051/'+$(this).attr('data-triage'),'DOC43051');
    });
    $('.PaseDeVisitaFamiliar').submit(function (e) {
        e.preventDefault();
        SendAjaxPost($(this).serialize(),'AdmisionHospitalaria/AjaxAgregarFamiliar',function (response) {
            window.top.close();
            window.opener.location.reload();
        },'No')
    });
    $('body').on('click','.pases-eliminar-familiar',function (e) {
        SendAjaxPost({
            familiar_id:$(this).attr('data-id'),
            csrf_token:csrf_token
        },'AdmisionHospitalaria/AjaxEliminarFamiliar',function (response) {
            location.reload();
        })
    })
    if($('input[name=inputPerfilFamiliar]').val()!=undefined){
        Webcam.set({
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach( '#my_camera' );
        $('.btn-tomar-foto').click(function (e) {
            // TOMAR UNA FOTO INSTANTANEA Y MOSTRARLO EN UNA IMAGEN RETORNANDO EN base64
            Webcam.snap( function(src) {
                    // display results in page
                    $('input[name=familiar_perfil]').val(src);
                    $('.image_profile').attr('src',src).css({
                        width:'100%'
                    });
            } );
        })
        $('.btn-save-img').click(function(e) {
           SendAjaxPost({
               familiar_perfil:$('input[name=familiar_perfil]').val(),
               familiar_id:$('input[name=familiar_id]').val(),
               triage_id:$('input[name=triage_id]').val(),
               csrf_token:csrf_token
           },'AdmisionHospitalaria/AjaxGuardarPerfilFamiliar',function(response) {
               window.close();
               window.opener.location.reload();
            },'Si','No')
        })
    }
})
function DireccionResponsable(folio) {
    $.ajax({
            url: base_url+"AdmisionHospitalaria/AjaxDireccionPaciente",
            type: 'GET',
            dataType: 'json',
            data:{
                'triage_id':folio
            },success: function (data, textStatus, jqXHR) {
                $('input[name=directorio_cp]').val(data.Direccion.directorio_cp);
                $('input[name=directorio_cn]').val(data.Direccion.directorio_cn);
                $('input[name=directorio_colonia]').val(data.Direccion.directorio_colonia);
                $('input[name=directorio_municipio]').val(data.Direccion.directorio_municipio);
                $('input[name=directorio_estado]').val(data.Direccion.directorio_estado);
            },error: function (e) {
              alert("holad"+ e);
                console.log(e);
            }
        })
}
function ActualizarConteoCamas(idPiso){

//  $('input[name=conteo]').val(idPiso);
  $.ajax({
    url: base_url+"AdmisionHospitalaria/AjaxActualizarConteoCamas",
    type: 'GET',
    dataType: 'json',
    success:function(data, textStatus, jqXHR){
      var conteo = data.Disponibles;
      $('input[name=conteo]').val(data.Dat1.Disponibles);
    }
  });
}
