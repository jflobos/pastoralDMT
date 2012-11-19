$(document).ready(function($){
	$(function()
	{           
	    $("#masinfo").children().change(cambioRadiosInfoMetricas);	    
	    $(".RadiosProyectos").change(manejarRadios);	    
	    $("#dropdownProyectos").change(verMetricasGlobales);	    
	    $("#dropdownProyectos").change(mostrarInfoProyectosSegunDropdownlist);	    
	    $("#dropdownProyectoVersionGrupos").change(mostrarInfoGrupoVersionSegunDropdownlist);	    
	    $("#dropdownProyectoVersionMisiones").change(mostrarInfoMisionVersionSegunDropdownlist);	    
	    $("#masinfoGrupo").children().change(cambioRadiosGruposInstancias);	    
	    $("#masinfoZonas").children().change(cambioRadiosInfoMetricasMision);	    
	    $('#RadioMetricasGrupo').click(verMetricasVersion);	    
	    $('#ZonaMetricasGrupo').click(function(){ 
	         var id_z = $("#dropdownProyectoVersionMisiones option:selected").val();	         
	         var vacioZona = document.getElementById('Zona_vacio_o_no_'+id_z).value;	         
	         if(vacioZona =='vacio'){
	                       // Se llama al ajax que esta en el action del modulo grupo.  
	           $.get(routing.url_for('proyecto', 'AjaxEstadisticaZona'), {mision_id: id_z},
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
	         }
	    });
	    
	    $('#botonToken').click(function(){
	        var pv_id = document.getElementById('proyecto_version_id').value;
	        var mail_token = document.getElementById('mail_usuario').value;
	        var nombre_token = document.getElementById('nombre_usuario').value;	                
	        //Se llama al ajax que esta en el action del modulo grupo.  
	        $.get(routing.url_for('proyecto', 'AjaxGenerarToken'), {proyecto_version_id: pv_id, mail: mail_token, nombre: nombre_token},
	          function(data){ 
	              data = jQuery.parseJSON(data);
	              if(data[0]!=-1){
	                var t = document.getElementById('valorToken');
	                t.value = data[0];
	                var f = document.getElementById('fechaToken');
	                f.value = data[1]; 
	                var url_token = document.getElementById('url_token').value;
	                url_token = url_token + data[0];
	                $("#info_token").show();	                                
	                $("#linkToken").html('<a href="'+url_token+'") "><b>&raquo; Ir a m&oacute;dulo D&iacute;a de Salida </b></a><br><br><h4>TOKEN GENERADO CON EXITO<h4>');
	              }
	              else{
	                alert('Error! No se ha podido crear el token. Intentelo de nuevo mas tarde');
	              }
	        });	    
	    });
	    
	});
});
	
	function verMetricasVersion(){       
	          
	         var id_g = $("#dropdownProyectoVersionGrupos option:selected").val();
	         
	         var vacioGrupo = document.getElementById('Grupo_vacio_o_no_'+id_g).value;
	         
	         if(vacioGrupo=='vacio'){
	
	           // Se llama al ajax que esta en el action del modulo grupo.  
	           $.get(routing.url_for('proyecto', 'AjaxEstadisticaGrupo'), {grupo_id: id_g},
	              function(data){ 
	                  data = jQuery.parseJSON(data);       
	                  pieChart("chart1_"+data[10],data[0],data[1],"Genero Misioneros");
	                  barGraph("chart5_"+data[10],data[2],data[3],"Edades Misioneros");
	                  barGraph("chart6_"+data[10],data[4],data[5],"Movimiento Misioneros");
	                  barGraph("chart7_"+data[10],data[6],data[7],"Carreras Misioneros");
	                  pieChart("chart2_"+data[10],data[8],data[9],"Necesidades Abarcadas");
	                  
	                  var v = document.getElementById('Grupo_vacio_o_no_'+data[10]);
	                  v.value = 'lleno';
	            });  
	         }
	    }
	
	function verMetricasGlobales(){        
	         var director_o_jefe = document.getElementById('director_o_jefe').value;
	         
	
	         if(director_o_jefe=='director'){
	            var idp = $("#dropdownProyectos option:selected").val();
	         }
	         else if(director_o_jefe=='jefe'){
	            var idp = $("#id_proyecto_jefe").val();        
	         }
	                  
	         var vacio = document.getElementById('vacio_o_no_'+idp).value;
	         
	         if(vacio=='vacio'){
	
	           $.get(routing.url_for('proyecto', 'AjaxEstadisticasGlobales'), { id_proyecto: idp},
	              function(data){
	                  
	                  data = jQuery.parseJSON(data);
	                  
	                  pieChart("chart1_"+data[12],data[0],data[1],"Genero Misioneros");
	                  barGraph("chart5_"+data[12],data[4],data[5],"Edades Misioneros");
	                  barGraph("chart6_"+data[12],data[6],data[7],"Movimiento Misioneros");
	                  barGraph("chart7_"+data[12],data[8],data[9],"Carreras Misioneros");
	                  pieChart("chart2_"+data[12],data[10],data[11],"Necesidades Abarcadas");
	                  
	                  var v = document.getElementById('vacio_o_no_'+data[12]);
	                  v.value = 'lleno';
	            });  
	         }
	 
	    }
	
	function mostrarInfoMisionVersionSegunDropdownlist(){
	      $("#tituloZonas").show();      
	      $("#div_general_zonas").show();
	
	      var idDropElegido = $("#dropdownProyectoVersionMisiones option:selected").val();
	      
	      var largo = $("#dropdownProyectoVersionMisiones option").length;
	      
	      var lista = [];
	      $('#dropdownProyectoVersionMisiones option').each(function() { 
	          lista.push( $(this).attr('value') );
	      });
	      
	      // recorremos todos los radios para "borrar" los no elegidos. 
	      for(var i = 0; i < largo; i++){
	            
	            if(lista[i] != idDropElegido && lista[i]!=-1){
	                var string2 = "#MetricasZona"+lista[i];      
	                var string3 = "#InfoGeneralZona"+lista[i];
	                $(string2).hide();
	                $(string3).hide();
	            }
	      }
	      
	      var stringJQueryMetrica =  "#MetricasZona"+idDropElegido;
	      var stringJQueryGeneral = "#InfoGeneralZona"+idDropElegido;
	      
	      $(stringJQueryMetrica).show();
	      $(stringJQueryGeneral).show(); 
	      
	      //Mostramos la 'seccion' general (en vez de la de metricas). 
	      var radioElements = document.getElementsByName("ZonaRadioInfoGrupo");
	      radioElements[0].checked = true;
	    
	      cambioRadiosInfoMetricasMision();
	}
	
	function cambioRadiosInfoMetricasMision(){
	        var radioElements = document.getElementsByName("ZonaRadioInfoGrupo");
	        
	        for(var i = 0; i < radioElements.length; i++){
	        if(radioElements[0].checked == true){
	             $("#div_general_zonas").show();
	             $("#div_metricas_zonas").hide();
	        }
	        if(radioElements[1].checked == true){
	             $("#div_metricas_zonas").show();
	             $("#div_general_zonas").hide();
	        }  
	    }            
	}
	
	function mostrarInfoProyectosSegunDropdownlist(){
	      $("#tituloInstancias").show();      
	      $("#div_general").show();
	      
	      var idDropElegido = $("#dropdownProyectos option:selected").val();
	      
	      var largo = $("#dropdownProyectos option").length;
	
	      
	      var lista = [];
	      $('#dropdownProyectos option').each(function() { 
	          lista.push( $(this).attr('value') );
	      });
	            
	      // recorremos todos los radios para "borrar" los no elegidos. 
	      for(var i = 0; i < largo; i++){
	            
	            if(lista[i] != idDropElegido && lista[i]!=-1){
	                var string1 = "#Proyecto"+lista[i];
	                var string2 = "#Proyecto"+lista[i]+"_metricas";      
	                var string3 = "#InfoGeneral"+lista[i];
	                var string4 = "#LinkEditar"+lista[i];
	                var string5 = "#LinkNavegacion"+lista[i];
	                $(string1).hide();
	                $(string2).hide();
	                $(string3).hide();
	                $(string4).hide();
	                $(string5).hide();
	            }
	      }
	      
	      var stringJQueryProyecto = "#Proyecto"+idDropElegido;
	      var stringJQueryMetrica =  "#Proyecto"+idDropElegido+"_metricas";
	      var stringJQueryGeneral = "#InfoGeneral"+idDropElegido;
	      var stringJQueryEditar= "#LinkEditar"+idDropElegido;
	      var stringJQueryNavegacion= "#LinkNavegacion"+idDropElegido;
	      
	      $(stringJQueryProyecto).show();
	      $(stringJQueryMetrica).show();
	      $(stringJQueryGeneral).show();
	      $(stringJQueryEditar).show();
	      $(stringJQueryNavegacion).show();
	      
	      // Mostramos la 'seccion' de instancias (en vez de la de metricas). 
	      //var radioElements = document.getElementsByName("GrupoRadioInfo");
	      //radioElements[0].checked = true;
	      //cambioRadiosInfoMetricas();
	      
	      var idp = $("#dropdownProyectos option:selected").val();
	      $.get(routing.url_for('proyecto', 'SetearComoJefeDeProyecto'), { proyecto_id: idp},
	              function(data){  
	                data = jQuery.parseJSON(data);
	                $("#768531").css("display", "block");
	                $("#768532").css("display", "block");
	                document.getElementById('99876').innerHTML = "<span><span style='font-size:20px;'>"+data[0]+"</span></br><span style='font-size:10px;'>"+data[1]+"</span></span>";
	            });  
	    
	}
	
	function cambioRadiosInfoMetricas(){
	        var radioElements = document.getElementsByName("GrupoRadioInfo");
	        for(var i = 0; i < radioElements.length; i++){
	        if(radioElements[0].checked == true){
	             $("#div_general").show();
	             $("#div_instancias").hide();
	             $("#div_metricas").hide();
	        }
	        if(radioElements[1].checked == true){
	             $("#div_instancias").show();
	             $("#div_metricas").hide();
	             $("#div_general").hide();
	        }
	        if(radioElements[2].checked == true){
	             $("#div_instancias").hide();
	             $("#div_metricas").show();
	             $("#div_general").hide();
	        }        
	    }            
	}
	
	function manejarRadios (){
	    
	      $("#tituloInstancias").show();      
	      $("#div_general").show();
	      
	      var idRadioElegido = $("input[name='GrupoRadio']:checked").val();
	      
	      // recorremos todos los radios para 'borrarlos'. 
	      var radioElements = document.getElementsByName("GrupoRadioInfo");
	      for(var i = 0; i < radioElements.length; i++){
	            if(radioElements[i].value != idRadioElegido){
	                var string1 = "#Proyecto"+radioElements[i].value;
	                var string2 = "#Proyecto"+radioElements[i].value+"_metricas";      
	                $(string1).hide();
	                $(string2).hide();
	            }
	      }
	      
	      var stringJQueryProyecto = "#Proyecto"+idRadioElegido;
	      var stringJQueryMetrica =  "#Proyecto"+idRadioElegido+"_metricas";
	      
	      $(stringJQueryProyecto).show();
	      $(stringJQueryMetrica).show();
	      
	      // Mostramos la 'seccion' de instancias (en vez de la de metricas). 
	      var radioElements = document.getElementsByName("GrupoRadioInfo");
	      radioElements[0].checked = true;
	      cambioRadiosInfoMetricas();
	    
	}
	
	function mostrarInfoGrupoVersionSegunDropdownlist () {
	      
	      var idDropElegido = $("#dropdownProyectoVersionGrupos option:selected").val();
	      
	      var largo = $("#dropdownProyectoVersionGrupos option").length;    
	      
	      var lista = [];
	      $('#dropdownProyectoVersionGrupos option').each(function() { 
	          lista.push( $(this).attr('value') );
	      });
	      
	      // recorremos todos los radios para "borrar" los no elegidos. 
	      for(var i = 0; i < largo; i++){
	            
	            if(lista[i] != idDropElegido && lista[i]!=-1){
	                var string3 = "#MetricasGrupo"+lista[i];
	                $(string3).hide();
	            }
	      }
	      
	      var stringJQueryMetricas = "#MetricasGrupo"+idDropElegido;   
	      $(stringJQueryMetricas).show();
	      verMetricasVersion();
	       
	}
	
	function cambioRadiosGruposInstancias(){      
	       var radioElements = document.getElementsByName("GrupoRadioInfoGrupo");
	        for(var i = 0; i < radioElements.length; i++){
	        if(radioElements[0].checked == true){
	              
	             $("#div_general_grupos").show();
	             $("#div_misiones_grupo").hide();
	             $("#div_metricas_grupos").hide();
	        }
	        if(radioElements[1].checked == true){
	             $("#div_misiones_grupo").show();
	             $("#div_general_grupos").hide();
	             $("#div_metricas_grupos").hide();
	        }  
	
	        // Cuando se selecciona ver estadisticas, hay que llamar al ajax:
	        if(radioElements[2].checked == true){
	             $("#div_misiones_grupo").hide();
	             $("#div_general_grupos").hide();
	             $("#div_metricas_grupos").show();
	                           
	        }        
	        
	    }
	}  
	    
	function SetearComoJefeNacional(proyecto_version)
	  {
	      $.get(routing.url_for('proyecto', 'SetearComoJefeDeProyectoVersion'), { proyecto_id: proyecto_version},
                  function(data){  
                    data = jQuery.parseJSON(data);
                    $("#768531").css("display", "block");
                    $("#768532").css("display", "block");
                    document.getElementById('99876').innerHTML = "<span><span style='font-size:20px;'>"+data[0]+"</span></br><span style='font-size:10px;'>"+data[1]+"</span></span>";
                }); 
	  }