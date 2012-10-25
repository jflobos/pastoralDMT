$(document).ready(function($){
	$(function(){
	  
	  $("#chart1").hide();
	  var char1 = 0;
	  $("#chart2").hide();
	  var char2=0;
	  $("#chart7").hide();
	  var char7=0;
	  $("#chart4").hide();
	  var char4=0;
	  $("#chart5").hide();
	  var char5=0;
	  $("#chart6").hide();
	  var char6=0;
	  $("#misioneros").hide();
	
	  $("#genero_acordion").click(function () {        
	        $("#chart1").slideToggle();
	        if(char1==0)
	        {
	          var mision = $('#misionId').val();
	          $.get('../../AjaxEstadisticaMisionGenero', { mision_id: mision},
	              function(data){
	                  data = jQuery.parseJSON(data);
	                  pieChart("chart1",data[0],data[1],"Genero Misioneros");                  
	              char1 = 1;
	              });
	        }
	     });
	
	    $("#necesidad_acordion").click(function () {  
	        $("#chart2").slideToggle();
	        if(char2==0)
	        {
	          var mision = $('#misionId').val();
	          $.get('../../AjaxEstadisticaMisionNecesidades', { mision_id: mision},
	              function(data){
	                  data = jQuery.parseJSON(data);
	                  pieChart("chart2",data[0],data[1],"Necesidades Abarcadas");
	                  char2 = 1;  
	              });
	        }
	       });
	       
	    $("#experiencia_acordion").click(function () {  
	        $("#chart4").slideToggle();
	        if(char4==0)
	        {
	          var mision = $('#misionId').val();
	          $.get('../../AjaxEstadisticaMisionExperiencia', { mision_id: mision},
	              function(data){
	                  data = jQuery.parseJSON(data);
	                  barGraph("chart4",data[0],data[1],"Experiencia Misioneros");
	                  char4 = 1;
	              });
	          
	        }
	     });
	     
	    $("#edades_acordion").click(function () {  
	        $("#chart5").slideToggle();
	        if(char5==0)
	        {
	          var mision = $('#misionId').val();
	          $.get('../../AjaxEstadisticaMisionEdades', { mision_id: mision},
	              function(data){
	                  data = jQuery.parseJSON(data);
	                  barGraph("chart5",data[0],data[1],"Edades Misioneros");
	                  char5 = 1;
	              });
	          
	        }
	     });
	     
	     $("#movimientos_religiosos_acordion").click(function () {  
	        $("#chart6").slideToggle();
	        if(char6==0)
	        {
	          var mision = $('#misionId').val();
	          $.get('../../AjaxEstadisticaMisionMovimiento', { mision_id: mision},
	              function(data){  
	                  data = jQuery.parseJSON(data);
	                  barGraph("chart6",data[0],data[1],"Movimiento Misioneros");
	                  char6 = 1;
	              });
	          
	        }
	     });
	     
	    $("#carreras_acordion").click(function () {  
	        $("#chart7").slideToggle();
	        if(char7==0)
	        {
	          var mision = $('#misionId').val();
	          $.get('../../AjaxEstadisticaMisionCarreras', { mision_id: mision},
	              function(data){
	                data = jQuery.parseJSON(data);
	                barGraph("chart7",data[0],data[1],"Carreras Misioneros");
	                char7 = 1;
	              });
	          
	        }
	     });   
	     
	    $("#misioneros_acordion").click(function () {  
	        $("#misioneros").slideToggle();
	     }); 
	
	});
});
