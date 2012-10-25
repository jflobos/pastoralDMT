$(document).ready(function($){
	 $("#jefe").chosen({no_results_text: "No existe nombre"});
	 
	 var a = document.getElementById("pastoral_grupo_proyecto_version_id");
	 if(a == -10)
	 {
		$("#pastoral_grupo_proyecto_version_id").parent().parent().show()
	 }
   
		
		$("#pastoral_grupo_proyecto_version_id").parent().parent().hide();
	 
	 
});
