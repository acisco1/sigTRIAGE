$(document).ready(function () {

  $('.btn_estado_prescripcion').click(function(){
    var estado = $(this).attr('data-value');
    ConsultarEstadoPrescripcionesPaciente('estado',estado);
  });

  $('.fila_paciente').click(function(){
    var fila = $(this).attr('data-value'),
        folio = $('#id_'+fila).text(),
        paciente = $('#paciente_'+fila).text(),
        cama = $('#cama_'+fila).text(),
        area = $('#area_'+fila).text(),
        medico = $('#medico_'+fila).text()
        dataArray = [fila,folio,paciente,cama,area,medico];

    ModalPacientePrescripciones(dataArray);

  });

  $('.op_filtro').click(function(){
    var op_filtro = $(this).text();
    $('#filtro_busqueda').text(op_filtro);
  });

});

function SolicitudInfoPaciente(){

}

function ModalPacientePrescripciones(dataArray){
  var paciente = dataArray[2],
      cama = dataArray[3],
      area = dataArray[4],
      medico = dataArray[5];
  $.ajax({
      url: base_url+"Farmacovigilancia/AjaxPrescripcionesPaciente",
      type: 'GET',
      dataType: 'json',
      data:{
          folio:dataArray[1]
      },success: function (data, textStatus, jqXHR) {
        var filaDatos = "";
        var nueva_fila = "";
        for(var x = 0; x < data.length; x++){
          nueva_fila = ""+
          "<tr>"+
            "<td>"+data[x].prescripcion_id+"</td>"+
            "<td>"+data[x].medicamento+"</td>"+
            "<td>"+data[x].dosis+"</td>"+
            "<td>"+data[x].pr_via+"</td>"+
            "<td>"+data[x].frecuencia+"</td>"+
            "<td>"+
              "<label class='md-check'><input type='checkbox'/><i class='blue'></i></label>"+
              "<button class='btn btn-xs btn-warning btn_msj_prescripcion' onClick=FormMensajePrescripcion(); >Mensaje</button>"+
            "</td>"+
          "</tr>"+
          "";
          filaDatos = filaDatos + nueva_fila;
        }

        bootbox.confirm({
          size: 'large',
          title:'Paciente '+paciente+' Cama: '+cama+' Area: '+area+' Médico: '+medico,
          message: ''+
          '<div class="table-responsive">'+
            '<table class="table table-hover table-responsive center">'+
              '<thead>'+
                '<tr>'+
                  '<th>Folio</th>'+
                  '<th>Prescripción</th>'+
                  '<th>Dosis</th>'+
                  '<th>Via</th>'+
                  '<th>Frecuencia</th>'+
                  '<th>Acciones</th>'+
                '</tr>'+
              '</thead>'+
              '<tbody>'+
                filaDatos+
              '</tbody>'+
            '</table>'+
          '</div>'+
          '',
          buttons: {
            confirm: {
                label: 'Aceptar',
                className: 'back-imss'
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn-basic'
            }
          },
          callback: function(result){

          }
        });


      },error: function (jqXHR, textStatus, errorThrown) {
          bootbox.hideAll();
          MsjError();
      }
  });


}
function BusquedaPorFiltroPacientePrescripcion(filtro, consulta){
  $.ajax({
      url: base_url+"Farmacovigilancia/AjaxBusquedaPorFiltroPacientePrescripcion",
      type: 'GET',
      dataType: 'json',
      data:{
          filtro:filtro,
          consulta: consulta
      },success: function (data, textStatus, jqXHR) {
        $('#tbl_paciente_prescripcion').empty(fila);
        var fila = '',
            color_estado;
        for(var x = 0; x < data.length; x++){
          color_estado = AsignarColorEstadoPrescripcion(data[x].estado);
          fila = "" +
          "<tr>"+
            "<td style='background-color: "+color_estado+";' >"+data[x].triage_id+"</td>"+
            "<td>"+data[x].triage_nombre+" "+data[x].triage_nombre_ap+"</td>"+
            "<td>"+data[x].cama_nombre+"</td>"+
            "<td>"+data[x].area_nombre+"</td>"+
            "<td>"+data[x].empleado_nombre+" "+data[x].empleado_apellidos+"</td>"+
            "<td>"+data[x].medicamento+"</td>"+
          "</tr>"+
          "";
          $('#tbl_paciente_prescripcion').append(fila);
        }

      },error: function (jqXHR, textStatus, errorThrown) {
          bootbox.hideAll();
          MsjError();
      }
  });
}

function ConsultarEstadoPrescripcionesPaciente(filtro,estado){

  $.ajax({
      url: base_url+"Farmacovigilancia/AjaxPacientePrescripcion",
      type: 'GET',
      dataType: 'json',
      data:{
          estado:estado,
          filtro:filtro
      },success: function (data, textStatus, jqXHR) {
        $('#tbl_paciente_prescripcion').empty(fila);
        var fila = '',
            color_estado;
        for(var x = 0; x < data.length; x++){
          color_estado = AsignarColorEstadoPrescripcion(data[x].estado);
          fila = "" +
          "<tr>"+
            "<td style='background-color: "+color_estado+";' >"+data[x].triage_id+"</td>"+
            "<td>"+data[x].triage_nombre+" "+data[x].triage_nombre_ap+"</td>"+
            "<td>"+data[x].cama_nombre+"</td>"+
            "<td>"+data[x].area_nombre+"</td>"+
            "<td>"+data[x].empleado_nombre+" "+data[x].empleado_apellidos+"</td>"+
            "<td>"+data[x].medicamento+"</td>"+
          "</tr>"+
          "";
          $('#tbl_paciente_prescripcion').append(fila);
        }

      },error: function (jqXHR, textStatus, errorThrown) {
          bootbox.hideAll();
          MsjError();
      }
  });
}

function AsignarColorEstadoPrescripcion(estado){

  switch (estado) {
    case '0':
      return 'rgb(242, 222, 222)';
    case '1':
      return 'rgb(252, 248, 227)';
    case '2':
      return 'rgb(223, 240, 216)';
  }

}

function FormMensajePrescripcion(){

  bootbox.confirm({
    size: 'large',
    title:'Notificacion',
    message: ''+
    '<div class="form-group">'+
    '<label>Mensaje</label>'+
    '<textarea class="form-control"></textarea>'+
    '</div>'+
    '',
    buttons: {
      confirm: {
          label: 'Aceptar',
          className: 'back-imss'
      },
      cancel: {
          label: 'Cancelar',
          className: 'btn-basic'
      }
    },
    callback: function(result){

    }
  });

}
