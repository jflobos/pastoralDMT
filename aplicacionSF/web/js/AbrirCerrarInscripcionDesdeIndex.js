function botonClick(boton, mision)
{  
  var estado_inscripcion; 
  if(boton.innerHTML == 'Cerrada')
  {
    boton.style.background='#5BB75B';
    boton.innerHTML='Abierta'; 
    estado_inscripcion = 1;
  }
  else
  {
    boton.style.background='#D14741';
    boton.innerHTML='Cerrada';
    estado_inscripcion = 0;
  }
   $.get(routing.url_for('mision','AjaxEstadoInscripcionCambio'), { inscripcion_abierta: estado_inscripcion, mision_id: mision},
        function(data){
        
        });
}