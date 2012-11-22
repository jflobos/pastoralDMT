
function pieChart(divName,rawData1,rawData2,graphTitle){
  var data = new Array();
  for(i =0;i < rawData1.length;i++)
  {
    var aux = new Array();
    aux[0]= rawData1[i];
    aux[1]= rawData2[i];
    data[i] = aux;
  }  
  var plot1 = jQuery.jqplot (divName, [data], 
      { 
        title: graphTitle,
        seriesDefaults: {
          // Make this a pie chart.
          renderer: jQuery.jqplot.PieRenderer, 
          rendererOptions: {
            // Put data labels on the pie slices.
            // By default, labels show the percentage of the slice.
            showDataLabels: true
          }
        }, 
        legend: { show:true, location: 'e' }
      }
    );
}

function barGraph(divName,axisDates,chartData,graphTitle)
{
  $.jqplot.config.enablePlugins = true;
       var plot2 = $.jqplot(divName, [chartData], {
          title: graphTitle,
           seriesDefaults:{
               renderer: $.jqplot.BarRenderer,
               rendererOptions: {
                  barPadding: 1,
                  barMargin: 15,
                  barDirection: 'vertical',
                  barWidth: 50
              }, 
              pointLabels: { show: true }
          },
          axes: {
              xaxis: {                            
                      renderer:  $.jqplot.CategoryAxisRenderer,
                      ticks: axisDates
              },
              yaxis: {
              }
          },
          highlighter: {
              sizeAdjust: 7.5
          },
          cursor: {
              show: true
          }
      });
}