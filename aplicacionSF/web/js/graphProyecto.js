$(document).ready(function($){
  getEstadisticaProyecto();
});

function getEstadisticaProyecto()
{	
    var proyectoVersion = jQuery('#proyecto_version_id').val();    
    jQuery.get('../../AjaxEstadisticaProyecto', { id_version: proyectoVersion},
        function(data){
            data = jQuery.parseJSON(data);
            pieChart("chart1",data[0],data[1],"Genero Misioneros");
            barGraph("chart5",data[4],data[5],"Edades Misioneros");
            barGraph("chart6",data[6],data[7],"Movimiento Misioneros");
            barGraph("chart7",data[8],data[9],"Carreras Misioneros");
            pieChart("chart2",data[10],data[11],"Necesidades Abarcadas");
        });
}