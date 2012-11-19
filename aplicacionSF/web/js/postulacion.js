$(document).ready(function($){
	$(function(){
	   hideMision();
	    
	   $("#salidas").change(function () {        
	        
	        $("#zonas_lista").html("");
	        $("#zonas_mini").html("");
	        hideMision();
	        $("#inscripcion_img").show();	        
	        
	        var salida_id = $("#salidas").val();
	        var proyecto_id = $("#proyecto_id").lenght > 0 ? null : $("#proyecto_id").val();
	        
	        $.get(routing.url_for('usuario','AjaxGetGruposPorSalida'), { salida_id: salida_id, proyecto_id: $("#proyecto_id").val()},
	            function(data){
	            $("#grupos").html("");                
	                jQuery.each(data, function(id, val) {
	                  $("#grupos").append(
	                    "<div class='accordion-group'>"+
	                        "<div class='accordion-heading'>"+
	                          "<a class='accordion-toggle' data-toggle='collapse' data-parent='#grupos' href='#grupo"+id+"'>"+
	                            "<h5><i class='icon-chevron-down'></i>"+val+"</h5>"+
	                          "</a>"+
	                        "</div>"+
	                        "<div id='grupo"+id+"' class='accordion-body collapse'>"+
	                          "<div class='accordion-inner' id='zonas_lista"+id+"'>"+
	                                     "Lista zonas"+
	                          "</div>"+
	                       "</div>"+
	                      "</div>");
	
	                  hideMision();
	                  
	                  $.get(routing.url_for('usuario', 'AjaxGetMisionesPorGrupo'), { grupo_id: id},
	                      function(data){
	                        $("#zonas_lista"+id).html("");
	                        $("#zonas_mini"+id).html("");
	                          
	                        jQuery.each(data, function(zona_id, val) {
	                          $("#zonas_lista"+id).append("<li><a id='zona_list_"+zona_id+"' style='cursor:pointer;'>"+val['nombre']+"</a></li>");
	                          $("#zonas_mini"+id).append("<div class='well span2'><a id='zona_mini_"+zona_id
	                          +"'><img style='padding:0; margin:0;' class='span2'src='"+val['foto_url']
	                          +" '/><br/><p>"+val['nombre']+"</p></a></div>");
	                          $("#zona_list_"+zona_id).click(function(){mostrarDetalleZona(zona_id);});
	                          $("#zona_list_"+zona_id).click(function(){$("#inscripcion_img").hide();});
	                          $("#zonas_mini"+id).click(function(){$("#zonas_mini"+id).show();});
	                          
	                        });
	                        
	                        
	                  }, "json");
	
	                });
	        }, "json");
	        hideMision();
	   });
	   
	  $(".submit_postulacion").click(function(e) {
	      e.preventDefault();
	      bootbox.dialog("Una vez que postules a una zona, no podr&aacute;s seleccionar otra, &iquest;deseas continuar?", [{
	          "label" : "An&oacute;tame!",
	          "class" : "btn-success",
	          "callback": function() {
	              submitPostulacion();
	          }
	      }, {
	          "label" : "Cancelar",
	          "class" : "btn-danger",
	          "callback": function() {
	             
	          }
	      }]);
	  });
	   
	}); 
	
	function hideMision(){
	  $("#detalle-mision").hide();
	}
	   
	function showMision(){
	 $("#detalle-mision").show();
	}
	
	function mostrarDetalleZona(id){
	  
	  $("#zonas_mini").hide();
	  hideMision();
	  $.get(routing.url_for('usuario', 'AjaxGetInformacionMision'), { mision_id: id },
	      function(data){
	        var localidad_fantasia = data[0][0];
	        var mision = data[2][0];
	        var jefes = data[1];
	        $("#zona_id").val(mision.id);
	        $("#foto_localidad li").remove();
	        $("#foto_localidad").append($("<li class='span3'><img style='width: 375px' src='"+routing.public_path('uploads/infoZonas/localidadFantasia/'+localidad_fantasia.foto_url)+"' alt='"+localidad_fantasia.nombre+"'></li>"));
	        $("#info_localidad tr").remove();
	        $("#info_localidad").append($("<tr><th> Localidad: </th><td>"+localidad_fantasia.nombre+"</td></tr>"));
	        $("#info_localidad").append($("<tr><th> Descripcion: </th><td>"+localidad_fantasia.descripcion+"</td></tr>"));
	        for(i=0;i<jefes.length;i=i+1) {
	            $("#info_localidad").append($("<tr><th> Jefe: </th><td>"+jefes[i]+"</td></tr>"));
	        }
	        showMision();
	      }, "json");
	
	}
	
	function submitPostulacion(){
	  $(".submit_postulacion").button('loading');
	    var id = $("#zona_id").val();
	   $.get(routing.url_for('usuario','AjaxIngresarPostulante'), { mision_id: id },
	      function(data){
	
	            var exito = data==1?true:false;
	            
	            $("#resultado_postulacion").html("");
	            $("#resultado_postulacion").removeClass("alert alert-success alert alert-error");
	            if(exito){
	                $(".submit_postulacion").addClass("disabled"); 
	                $(".submit_postulacion").attr("disabled", "disabled");
	                $("#resultado_postulacion").addClass("alert alert-success");
	                $("#resultado_postulacion").html("<br/>La inscripci&oacute;n se ha realizado de manera exitosa<br/><br/>");
	
	                location.reload();
	            }else{
	                $("#resultado_postulacion").addClass("alert alert-error");
	                $("#resultado_postulacion").html("<br/>La inscripci&oacute;n no se ha podido realizar<br/><br/>");
	                $("#info_postulacion").hide();  
	            }
	    
	      }, "json");
	        $(".submit_postulacion").button('reset');
	}
});

/*
*/