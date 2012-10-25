 
$(document).ready(function($){ 
 $(".chzn-results").children().mouseover(function(){
    var chzn_id = $(this).attr("id");
    var id = chzn_id.substring("0","13");
    var position = chzn_id.substring("21"); //el id es del tipo jefe_chzn_o_1 (hay que eliminar los primeros 12 caracteres)
    var nombre = $("#"+id+" option:eq("+position+")").text();
    var id = $("#"+id+" option:eq("+position+")").val();
    var element = $(this);
    $.get('../usuario/AjaxGetUserInformation', {usuario_id : id},
      function(data){
        element.unbind('mouseover');
        element.popover({
          title: data['nombre']+" "+data['apellido_paterno'],
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