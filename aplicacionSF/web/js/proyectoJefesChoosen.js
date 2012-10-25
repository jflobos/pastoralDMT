$(document).ready(function($){
	$(document).ready(function(){
	    $('#jefe_nacional').chosen({no_results_text: "No existe "});
	    $('#jefe_finanzas').chosen({no_results_text: "No existe "});
	    $('#jefe_inscripc').chosen({no_results_text: "No existe "});
	    $('#jefe_extranje').chosen({no_results_text: "No existe "});
	});
	
	
	$(function()
	{ 
	    $("#pastoral_proyecto_version_ano").parent().change(autocompletarVersionConAno);
	    
	    $("#guardar").click(function(){
	
	        
	        var nacional = $("#jefe_nacional option:selected").val();
	        var finanzas = $("#jefe_finanzas option:selected").val();
	        var inscripciones = $("#jefe_inscripc option:selected").val();
	        var extranjeros = $("#jefe_extranje option:selected").val();
	        
	        
	        if(nacional==undefined){
	          alert('Debe seleccionar un Jefe Nacional para crear una version del proyecto.');
	          return false;
	        }
	        
	        if(nacional==finanzas || nacional==inscripciones || nacional==extranjeros){
	          alert('Error! No puede haber una misma persona que tenga dos cargos de jefatura dentro del mismo proyecto.');
	          return false;
	        }
	        
	        if(finanzas!=undefined && finanzas==inscripciones){
	          alert('Error! No puede haber una misma persona que tenga dos cargos de jefatura dentro del mismo proyecto.');
	          return false;      
	        }
	        
	        if(inscripciones!=undefined && extranjeros==inscripciones){
	          alert('Error! No puede haber una misma persona que tenga dos cargos de jefatura dentro del mismo proyecto.');
	          return false;      
	        }
	        
	        if(extranjeros!=undefined && finanzas==extranjeros){
	          alert('Error! No puede haber una misma persona que tenga dos cargos de jefatura dentro del mismo proyecto.');
	          return false;      
	        }
	    
	    });
	
	});
	
	function autocompletarVersionConAno() {
	      
	      var a = document.getElementById("pastoral_proyecto_version_ano");
	      
	      var b = document.getElementById("pastoral_proyecto_version_version");
	      
	      b.value = a.value;
	
	}
});
 