$(document).ready(function($){ 
 $(".chzn-results").children().mouseover(function(){
    var chzn_id = $(this).attr("id");
    var position = chzn_id.substring("12"); //el id es del tipo jefe_chzn_o_1 (hay que eliminar los primeros 12 caracteres)
    var nombre = $("#jefe option:eq("+position+")").text();
    var id = $("#jefe option:eq("+position+")").val();
    var element = $(this);
    $.get('../../../usuario/AjaxGetUserInformation', {usuario_id : id},
      function(data){
        element.unbind('mouseover');
        element.popover({
          title: data['nombre']+" "+data['apellido_paterno']+" "+data['apellido_materno'],
          content: "<ul class='no-mark'>"+
                    "<li><strong>Colegio/Universidad:</strong> "+data['colegio_universidad']+"</li>"+
                    "<li><strong>Carrera:</strong> "+data['carrera']+"</li>"+
                    "<li><strong>Edad:</strong> "+data['edad']+"</li>"+
                   "</ul>"
        });
        if( element.hasClass('highlighted') )
          element.popover('show');
      }, "json"
    );
  });
});