$(document).ready(function($){  
      
    $("#inscripcion").click(function () {  
      if(document.getElementById("inscripcion").innerHTML == 'Cerrada')
      {
        document.getElementById("inscripcion").style.background='#5BB75B';
        document.getElementById("inscripcion").innerHTML='Abierta';        
      }
      else
      {
        document.getElementById("inscripcion").style.background='#D14741';
        document.getElementById("inscripcion").innerHTML='Cerrada';
      }
      cambioEstadoInscripciones();
    });

});

function cambioEstadoInscripciones()
{    
    var estado_inscripcion;
    var mision = document.getElementById("misionId").value;
    if(document.getElementById("inscripcion").innerHTML == 'Cerrada')
    {
      estado_inscripcion = 0;
    }
    else
    {
      estado_inscripcion = 1;
    }
    $.get(routing.url_for('mision','AjaxEstadoInscripcionCambio'), { inscripcion_abierta: estado_inscripcion, mision_id: mision},
        function(data){
        
        });
}