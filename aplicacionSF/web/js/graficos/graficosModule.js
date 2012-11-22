/*
 * Modulo de servicio para gestion de graficos:
 *   - Usando Jqplot
 */

var graficosModule = (function(){   
    //Variables privadas
    var char1, char2, char3, char4, char5, char6, char7;
    var tickZona = 10;
    var tickGrupo = 25;
    var tickProyecto = 100;
    
    //Metodos privados
    var pieChart = function pieChart(divName,rawData1,rawData2,graphTitle){
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
    //Dibuja el grafico de tortas en el div correspondiente
    var barGraph = function barGraph(divName,axisDates,chartData,graphTitle, yTickInterval)
    {      
      $.jqplot.config.enablePlugins = true;
           var plot2 = $.jqplot(divName, [chartData], {
              title: graphTitle,
               seriesDefaults:{
                   renderer: $.jqplot.BarRenderer,
                   rendererOptions: {                      
                      barDirection: 'vertical'                      
                  }, 
                  pointLabels: { show: true }
              },              
              axes: {
                  xaxis: {
                          renderer:  $.jqplot.CategoryAxisRenderer,
                          ticks: axisDates,
                          tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                          tickOptions: {
                            angle: -30,
                            fontSize: '10pt'
                          }
                  },
                  yaxis: {
                          tickInterval: yTickInterval,
                          min: 0,
                          pad: 1.2                       
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
    /*
     * seriesGraph: Permite graficar un grafico de series a partir de la informacion extraida
     *  divId         -> Id del elemento en donde se agrega la informacion
     *  data          -> Arreglo de arreglos donde se grafica la informacion en este caso son dos
     *  nombreGrafico -> nombre del grafico que se va a mostrar
     */
    var seriesGraph = function seriesGraph(divId, data1, data2, nombreGrafico, yTickInterval, nombreSerie1, nombreSerie2){
        var plot3 = $.jqplot(divId, [data1 , data2],
        { 
          title: nombreGrafico, 
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
              label: nombreGrafico,
              // Turn off "padding".  This will allow data point to lie on the
              // edges of the grid.  Default padding is 1.2 and will keep all
              // points inside the bounds of the grid.
              pad: 0,
              min: 1,
              tickInterval: 1
            },
            yaxis: {
              label: "Inscritos",
              min: 0,
              tickInterval: yTickInterval
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
            labels:[nombreSerie1, nombreSerie2]
          }
       });
    }
    //Metodos publicos
    return{
        //Carga las estadisticas por Proyecto       
        getEstadisticaProyecto: function getEstadisticaProyecto()
        {	
            var proyectoVersion = jQuery('#proyecto_version_id').val();    
            jQuery.get(routing.url_for('proyecto','AjaxEstadisticaProyecto'), { id_version: proyectoVersion},
                function(data){
                    data = jQuery.parseJSON(data);
                    pieChart("chart1",data[0],data[1],"Genero Misioneros");
                    barGraph("chart5",data[4],data[5],"Edades Misioneros", tickProyecto);
                    barGraph("chart6",data[6],data[7],"Movimiento Misioneros", tickProyecto);
                    barGraph("chart7",data[8],data[9],"Carreras Misioneros", tickProyecto);
                    pieChart("chart2",data[10],data[11],"Necesidades Abarcadas");
                });
        },
        graficoInscritosAcomulados: function graficoInscritosAcomulados()
        {
            pv_id = $("#acumulada1").attr('value');
            $.get(routing.url_for('proyecto', 'ajaxInscritosAcumulados'), { pv_id: pv_id },
                function(data){
                    dias = data[0];
                    total = data[1];
                    var arreglo = [];
                    var arreglo2 = [];
                    for(i=0;i<dias.length;i++)
                      arreglo.push([dias[i],total[i]]);
                    if(data[2].length>0){
                        dias2 = data[2];
                        total2 = data[3];
                        for(i=0;i<dias2.length;i++)
                            arreglo2.push([dias2[i],total2[i]]);
                    }                
                    seriesGraph('acumulada1', arreglo, arreglo2, 'Evoluci&oacute;n de inscritos', tickProyecto, 'Versi&oacute;n Actual', 'Versi&oacute;n Anterior');
            },'JSON');            
            $.get(routing.url_for('proyecto', 'ajaxInscritosVSAceptados'), { pv_id: pv_id },
                function(data){
                    dias = data[0];
                    total = data[1];
                    var arreglo = [];
                    var arreglo2 = [];
                    for(i=0;i<dias.length;i++)
                      arreglo.push([dias[i],total[i]]);
                    if(data[2].length>0){
                        dias2 = data[2];
                        total2 = data[3];
                        for(i=0;i<dias2.length;i++)
                            arreglo2.push([dias2[i],total2[i]]);
                    }                
                    seriesGraph('acumulada2', arreglo, arreglo2, 'Inscritos vs Aceptados', tickProyecto, 'Inscritos', 'Aceptados');
            },'JSON');
        },
        initGraficosGrupo: function initGraficosGrupo(){
            $("#chart1").hide();
            char1 = 0;
            $("#chart2").hide();
            char2=0;
            $("#chart7").hide();
            char7=0;
            $("#chart4").hide();
            char4=0;
            $("#chart5").hide();
            char5=0;
            $("#chart6").hide();
            char6=0;
            $("#misioneros").hide();

            $("#genero_acordion").click(function () {        
                $("#chart1").slideToggle();
                if(char1==0)
                {
                  var grupo = $('#grupoId').val();
                  $.get(routing.url_for('grupo', 'AjaxEstadisticaGrupoGenero'), { grupo_id: grupo},
                      function(data){
                          data = jQuery.parseJSON(data);
                          pieChart("chart1",data[0],data[1],"Genero Misioneros");
                      });
                  char1 = 1;
                }
             });

            $("#necesidad_acordion").click(function () {  
                $("#chart2").slideToggle();
                if(char2==0)
                {
                  var grupo = $('#grupoId').val();
                  $.get(routing.url_for('grupo', 'AjaxEstadisticaGrupoNecesidades'), { grupo_id: grupo},
                      function(data){
                          data = jQuery.parseJSON(data);
                          pieChart("chart2",data[0],data[1],"Necesidades Abarcadas");
                      });
                  char2 = 1;
                }
               });

            $("#experiencia_acordion").click(function () {  
                $("#chart4").slideToggle();
                if(char4==0)
                {
                  var grupo = $('#grupoId').val();
                  $.get(routing.url_for('grupo', 'AjaxEstadisticaGrupoExperiencia'), { grupo_id: grupo},
                      function(data){
                          data = jQuery.parseJSON(data);
                          barGraph("chart4",data[0],data[1],"Experiencia Misioneros", tickGrupo);
                      });
                  char4 = 1;
                }
             });

            $("#edades_acordion").click(function () {  
                $("#chart5").slideToggle();
                if(char5==0)
                {
                  var grupo = $('#grupoId').val();
                  $.get(routing.url_for('grupo', 'AjaxEstadisticaGrupoEdades'), { grupo_id: grupo},
                      function(data){
                          data = jQuery.parseJSON(data);
                          barGraph("chart5",data[0],data[1],"Edades Misioneros", tickGrupo);
                      });
                  char5 = 1;
                }
             });

             $("#movimientos_religiosos_acordion").click(function () {  
                $("#chart6").slideToggle();
                if(char6==0)
                {
                  var grupo = $('#grupoId').val();
                  $.get(routing.url_for('grupo', 'AjaxEstadisticaGrupoMovimiento'), { grupo_id: grupo},
                      function(data){  
                          data = jQuery.parseJSON(data);
                          barGraph("chart6",data[0],data[1],"Movimiento Misioneros", tickGrupo);
                      });
                  char6 = 1;
                }
             });

            $("#carreras_acordion").click(function () {  
                $("#chart7").slideToggle();
                if(char7==0)
                {
                  var grupo = $('#grupoId').val();
                  $.get(routing.url_for('grupo', 'AjaxEstadisticaGrupoCarrera'), { grupo_id: grupo},
                      function(data){
                          data = jQuery.parseJSON(data);
                    barGraph("chart7",data[0],data[1],"Carreras Misioneros", tickGrupo);
                      });
                  char7 = 1;
                }
             });
        },
        // Inicia los graficos para vista de zona por parte del director
        initGraficoVistaDirector: function initGraficoVistaDirector(){
            var proyectoGrupo = $('#grupoId').val();	    
	    $.get(routing.url_for('proyecto', 'AjaxEstadisticaGrupo'), { grupo_id: proyectoGrupo},
	        function(data){	
	            data = $.parseJSON(data);
	            pieChart("chart1",data[0],data[1],"Genero Misioneros");
	            barGraph("chart5",data[2],data[3],"Edades Misioneros", 100);
	            barGraph("chart6",data[4],data[5],"Movimiento Misioneros", 100);
	            barGraph("chart7",data[6],data[7],"Carreras Misioneros", 100);
	            pieChart("chart2",data[8],data[9],"Necesidades Abarcadas");
            });
        },
        //Inicia los graficos para cada Mision
        initGraficoMision: function initGraficoMision(){
            $("#chart1").hide();
            char1 = 0;
            $("#chart2").hide();
            char2=0;
            $("#chart7").hide();
            char7=0;
            $("#chart4").hide();
            char4=0;
            $("#chart5").hide();
            char5=0;
            $("#chart6").hide();
            char6=0;
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
                          barGraph("chart4",data[0],data[1],"Experiencia Misioneros", tickZona);
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
                          barGraph("chart5",data[0],data[1],"Edades Misioneros", tickZona);
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
                          barGraph("chart6",data[0],data[1],"Movimiento Misioneros", tickZona);
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
                        barGraph("chart7",data[0],data[1],"Carreras Misioneros", tickZona);
                        char7 = 1;
                      });

                }
             });   

            $("#misioneros_acordion").click(function () {  
                $("#misioneros").slideToggle();
             }); 
        },
        //Inicializa la vista de graficos de las zonas por parte de cargos mas altos
        initGraficoMisionVistaDirector: function initGraficoMisionVistaDirector(){
            var proyectoGrupoZona = $('#zonaId').val();	    
	    $.get(routing.url_for('proyecto', 'ajaxEstadisticaZona'), { mision_id: proyectoGrupoZona},
	        function(data){
	
	            data = jQuery.parseJSON(data);
	            pieChart("chart1",data[0],data[1],"Genero Misioneros");
	            barGraph("chart5",data[4],data[5],"Edades Misioneros", tickZona);
	            barGraph("chart6",data[6],data[7],"Movimiento Misioneros", tickZona);
	            barGraph("chart7",data[8],data[9],"Carreras Misioneros", tickZona);
	            pieChart("chart2",data[10],data[11],"Necesidades Abarcadas");
            });
        },
        initMetricasGrupo: function initMetricasGrupo(id_z){
           // Se llama al ajax que esta en el action del modulo grupo.  
           $.get(routing.url_for('proyecto', 'ajaxEstadisticaZona'), {mision_id: id_z},
              function(data){ 
                  data = jQuery.parseJSON(data);	                  
                  pieChart("chart1_"+data[12],data[0],data[1],"Genero Misioneros");
                  barGraph("chart5_"+data[12],data[4],data[5],"Edades Misioneros");
                  barGraph("chart6_"+data[12],data[6],data[7],"Movimiento Misioneros");
                  barGraph("chart7_"+data[12],data[8],data[9],"Carreras Misioneros");
                  pieChart("chart2_"+data[12],data[10],data[11],"Necesidades Abarcadas");	                  
                  var v = document.getElementById('Zona_vacio_o_no_'+data[12]);
                  v.value = 'lleno';
            });
        },
        initMetricasVersion: function initMetricasVersion(id_g){           
           // Se llama al ajax que esta en el action del modulo grupo.  
           $.get(routing.url_for('proyecto', 'ajaxEstadisticaGrupo'), {grupo_id: id_g},
              function(data){ 
                  data = jQuery.parseJSON(data);       
                  pieChart("chart1_"+data[10],data[0],data[1],"Genero Misioneros");
                  barGraph("chart5_"+data[10],data[2],data[3],"Edades Misioneros", tickGrupo);
                  barGraph("chart6_"+data[10],data[4],data[5],"Movimiento Misioneros", tickGrupo);
                  barGraph("chart7_"+data[10],data[6],data[7],"Carreras Misioneros", tickGrupo);
                  pieChart("chart2_"+data[10],data[8],data[9],"Necesidades Abarcadas");

                  var v = document.getElementById('Grupo_vacio_o_no_'+data[10]);
                  v.value = 'lleno';
            });
        },
        initMetricasGlobales: function initMetricasGlobales(id_p){
            $.get(routing.url_for('proyecto', 'ajaxEstadisticasGlobales'), { id_proyecto: id_p},
            function(data){
                  data = jQuery.parseJSON(data);
                  pieChart("chart1_"+data[12],data[0],data[1],"Genero Misioneros");
                  barGraph("chart5_"+data[12],data[4],data[5],"Edades Misioneros", tickProyecto);
                  barGraph("chart6_"+data[12],data[6],data[7],"Movimiento Misioneros", tickProyecto);
                  barGraph("chart7_"+data[12],data[8],data[9],"Carreras Misioneros", tickProyecto);
                  pieChart("chart2_"+data[12],data[10],data[11],"Necesidades Abarcadas");

                  var v = document.getElementById('vacio_o_no_'+data[12]);
                  v.value = 'lleno';
            });
        }
    }
})();


