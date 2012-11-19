$(document).ready(function($){
	$(function(){
	  getEstadisticaProyecto();
	});
	
	function getEstadisticaProyecto()
	{
	    var proyectoGrupo = $('#grupoId').val();
	    
	    $.get('../../../../../../AjaxEstadisticaGrupo', { grupo_id: proyectoGrupo},
	        function(data){
	
	            data = jQuery.parseJSON(data);
	            pieChart("chart1",data[0],data[1],"Genero Misioneros");
	            barGraph("chart5",data[2],data[3],"Edades Misioneros");
	            barGraph("chart6",data[4],data[5],"Movimiento Misioneros");
	            barGraph("chart7",data[6],data[7],"Carreras Misioneros");
	            pieChart("chart2",data[8],data[9],"Necesidades Abarcadas");
	        });
	}
});
