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
    $("#visibilidad").click(function () {  
      if(document.getElementById("visibilidad").innerHTML == 'Cerrada')
      {
        document.getElementById("visibilidad").style.background='#5BB75B';
        document.getElementById("visibilidad").innerHTML='Visible';        
      }
      else
      {
        document.getElementById("visibilidad").style.background='#D14741';
        document.getElementById("visibilidad").innerHTML='Oculta';
      }
      cambioEstadoVisibilidad();
    });
});

function cambioEstadoInscripciones()
{    
    var estado_inscripcion;
    var mision = document.getElementById("misionId").value;
    if(document.getElementById("inscripcion").innerHTML == 'Oculta')
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
function cambioEstadoVisibilidad()
{    
    var visibilidad;
    var mision = document.getElementById("misionId").value;
    if(document.getElementById("visibilidad").innerHTML == 'Oculta')
    {
      visibilidad = 0;
    }
    else
    {
      visibilidad = 1;
    }
    $.get(routing.url_for('mision','AjaxEstadoVisibilidad'), { zona_visible: visibilidad, mision_id: mision},
        function(data){        
    });
}