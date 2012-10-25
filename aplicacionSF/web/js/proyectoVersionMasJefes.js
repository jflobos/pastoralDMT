$(document).ready(function($){

    $('#jefe_nuevo').chosen({no_results_text: "Error, no existe el campo indicado"});
    $('#cargo_nuevo').chosen({no_results_text: "Error, no existe el campo indicado"});

    $("#submit_mas_jefes").click(function (){    
        var id_cargo_nuevo = $("#cargo_nuevo option:selected").val();
        var id_jefe_nuevo = $("#jefe_nuevo option:selected").val();
        var id_proyecto = document.getElementById('id_proyecto').value;
        
        
        $.get('../../AjaxMasJefeInstancia', { id_jefe: id_jefe_nuevo, id_cargo: id_cargo_nuevo, proyecto: id_proyecto },
        function(data){     
            
            if(data==1){
              window.location = "../../menuInstancia/id/"+id_proyecto;
            }
            else{
              alert("Error! No se ha podido agregar el nuevo jefe. Intentelo de nuevo mas tarde");
              window.location = "../../menuInstancia/id/"+id_proyecto; 
            }
            
        }, "json"); 
    
    });
    
    $(".chzn-results").children().mouseover(function(){
    var chzn_id = $(this).attr("id");
    var position = chzn_id.substring("18"); //el id es del tipo jefe_chzn_o_1 (hay que eliminar los primeros 12 caracteres)
    var nombre = $("#jefe_nuevo option:eq("+position+")").text();
    var id = $("#jefe_nuevo option:eq("+position+")").val();
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