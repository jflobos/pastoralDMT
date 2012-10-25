$(document).ready(function(){

    getEstadisticaProyecto();
    
});

function getEstadisticaProyecto()
{
    pv_id = $("#acumulada1").attr('value');
    $.get('../../AjaxInscritosAcumulados', { pv_id: pv_id },
        function(data){
        
        dias = data[0];
        total = data[1];
        
        var arreglo = [];
        var arreglo2 = [];
        for(i=0;i<dias.length;i++)
          arreglo.push([dias[i],total[i]]);
          
        if(data[2].length>0)
        {
            dias2 = data[2];
            total2 = data[3];
            for(i=0;i<dias2.length;i++)
                arreglo2.push([dias2[i],total2[i]]);
        }
          
         var plot3 = $.jqplot('acumulada1', [arreglo , arreglo2],
            { 
              title:'Evoluci&oacute;n de inscritos', 
              // Series options are specified as an array of objects, one object
              // for each series.
              series:[ 
                  {
                    // Change our line width and use a diamond shaped marker.
                    lineWidth:3, 
                    markerOptions: { size: 2, style:"x" }
                  },
                                    {
                    // Change our line width and use a diamond shaped marker.
                    lineWidth:1, 
                    markerOptions: { size: 2, style:"x" }
                  }

              ],      
              axes: {
                // options for each axis are specified in seperate option objects.
                xaxis: {
                  label: "D&iacute;as desde inicio de inscripciones",
                  // Turn off "padding".  This will allow data point to lie on the
                  // edges of the grid.  Default padding is 1.2 and will keep all
                  // points inside the bounds of the grid.
                  pad: 0
                },
                yaxis: {
                  label: "Inscritos"
                }
              },
              highlighter: {
                show: true,
                sizeAdjust: 7.5
              },
              cursor: {
                show: false
              },
              legend:{
                show:true,
                labels:['Versi&oacute;n Actual', 'Versi&oacute;n Anterior']
              }
           });

    },'JSON');
}