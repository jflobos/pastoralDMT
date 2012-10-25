$(document).ready(function($){  
  $('#jefe').chosen({no_results_text: "No existe nombre"});
    
	cambioSalida();
	$("#pastoral_mision_salida_id").change(function () {
		
		cambioSalida();	
	 });
	
	cambioLocalidadFantasia();		
	$("#pastoral_mision_localidad_fantasia_id").change(function () {
		
		cambioLocalidadFantasia();
	 });	
	
	$('#filtros').hide();
  $('#jefes').hide();
  
   
	$("#guard").click(function () {
    var data = 	document.getElementById("Edad mínima").checked +";"+ document.getElementById("Edad mínima_valor").value + ";"+
			    document.getElementById("Total de inscritos").checked +";"+ document.getElementById("Total de inscritos_valor").value +";"+                                            
			    document.getElementById("Máximo porcentaje de hombres").checked +";"+ document.getElementById("Máximo porcentaje de hombres_valor").value +";"+
			    document.getElementById("Máximo porcentaje de mujeres").checked +";"+ document.getElementById("Máximo porcentaje de mujeres_valor").value +";"+
			    document.getElementById("Movimiento").checked +";"+ document.getElementById("Movimiento_valor").value +";"+
			    document.getElementById("Universidad").checked +";"+ document.getElementById("universidad").options[document.getElementById("universidad").selectedIndex].value +";"+ document.getElementById("Universidad_valor").value +";" +
			    document.getElementById("Carrera").checked +";"+ document.getElementById("carrera").options[document.getElementById("carrera").selectedIndex].value +";"+ document.getElementById("Carrera_valor").value;
    console.log("Filtro: "+data);
    document.getElementById("info").value = data; 
    });      
  
	
  $("form").bind("keypress", function(e) {

      var c = e.which ? e.which : e.keyCode;
    
      if (c == 13) {
          var $targ = $(e.target);

          if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
              var focusNext = false;
              $(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
                  if (this === e.target) {
                      focusNext = true;
                  }
                  else if (focusNext){
                      $(this).focus();
                      return false;
                  }
              });

              return false;
          }
      }

    });
    
});

function validate(evt) 
{
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

function cambioSalida()
{
	var a = document.getElementById("pastoral_mision_salida_id");
	var text = a.options[a.selectedIndex].text;
	if(text == '- Crear nueva Salida -')
	{
		(($("#pastoral_mision_nueva_salida_nombre").parent()).parent()).parent().parent().parent().parent().show();
	}
	else
	{
		(($("#pastoral_mision_nueva_salida_nombre").parent()).parent()).parent().parent().parent().parent().hide();

		$("#pastoral_mision_nueva_salida_nombre").val("");
		$("#pastoral_mision_nueva_salida_descripcion").val("");
	}
}

function cambioLocalidadFantasia()
{
	var a = document.getElementById("pastoral_mision_localidad_fantasia_id");
		var text = a.options[a.selectedIndex].text;
		if(text == '- Crear nuevo Sector -')
		{
			(($("#pastoral_mision_nuevo_sector_nombre").parent()).parent()).parent().parent().parent().parent().show();
		}
		else
		{
			(($("#pastoral_mision_nuevo_sector_nombre").parent()).parent()).parent().parent().parent().parent().hide();
	  
			$("#pastoral_mision_nuevo_sector_nombre").val("");
			$("#pastoral_mision_nuevo_sector_descripcion").val("");
			$("#pastoral_mision_nuevo_sector_foto_url").val("");
		}
}












