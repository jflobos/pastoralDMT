$(document).ready(function($){
	$(function(){
		    var lugar_actual_id=-1;       // Variable auxiliar para manejar los contactos dentro del modal
		    var contacto_actual_id = -1;
		    $(".contactos_button").live("click", function(){		      
		      contactosClickHandler($(this).children(".lugar_id").val());
		    });
		    $("#agregar_contacto").click(function(){
		      resetCrearContactoForm();
		      contacto_actual_id = -1;
		      $("#contacto_form_header").text("Nuevo contacto");
		      $("#contacto_modal").modal("hide");
		      $("#nuevo_contacto_modal").modal("show");
		      $("#tipo_contacto").hide();
		    });
	
		    $(".editar_contacto_btn").live("click", function(){
		      resetCrearContactoForm();
		      $("#contacto_form_header").text("Editar contacto");
		      contacto_actual_id = $(this).siblings(".contacto_id").val();
		      $table = $(this).siblings("table");
		      
		      $('#nombre_contacto').val($table.find(".nombre_contacto_row").text());
		      $('#cargo_contacto').val($table.find(".cargo_contacto_row").text());
		      $('#telefono_contacto').val($table.find(".telefono_contacto_row").text());
		      $("#contacto_modal").modal("hide");
		      $("#nuevo_contacto_modal").modal("show");
		      $("#tipo_contacto").hide();
		    });
		    
		    $(".eliminar_contacto_btn").live("click", function(){
		      var $contacto = $(this).closest(".contacto");
		      $.get(routing.url_for('localidad','AjaxEliminarContacto'),{id: $(this).next(".contacto_id").val()},
		        function(){
		          $contacto.hide();
		      });
		    });
		    
		    $(".nuevo_contacto_button").live("click", function(){
		      lugar_actual_id=-1;
		      contacto_actual_id = -1;
		      $("#contacto_form_header").text("Nuevo contacto");
		      $('#tipo_contacto').show();
		    });
		   
		    
		    $('#submit_contacto').click(function(){
		      //TODO: validar.
		      $.get(routing.url_for("localidad","AjaxCrearActualizarContacto"),{tipo_contacto:$('#tipo_contacto_select').val(),nombre:$('#nombre_contacto').val(),
		      cargo:$('#cargo_contacto').val(),telefono:$('#telefono_contacto').val(), localidad_id:$('#localidad_id').val(),
		      lugar_id: lugar_actual_id, id: contacto_actual_id},
		        function(data){
		        if(data['contacto']['lugar_id'] > 0)
		        {
		          $("#nuevo_contacto_modal").modal("hide");
		          $("#contacto_modal").modal("show");
		          contactosClickHandler(lugar_actual_id);
		        }
		        else
		        {
		          $("#contactos_table").show();
		          $("#contactos_table").append(
		          "<tr>"+
		            "<td>"+data['tipo_contacto']+"</td>"+
		            "<td>"+data['contacto']['nombre']+"</td>"+
		            "<td>"+data['contacto']['cargo']+"</td>"+
		            "<td>"+data['contacto']['telefono']+"</td>"+
		          "</tr>"
		          );
		          $("#contactos_table").before(
		                        "<div class='alert alert-success span7'>"+  
		                            "<a class='close' data-dismiss='alert'>x</a>"+  
		                            "<strong>Bien!</strong> Acci&oacute;n realizada exitosamente."+
		                        "</div>"
		                        );
		        }
		        $("#nuevo_contacto_modal").modal("hide");
		        if($("#contactos_error").length>0)
		          $("#contactos_error").hide();
		        resetCrearContactoForm();
		      }, "json");
		    });
		    
		    $("#agregar_municipalidad_btn").click(function(){
		      lugar_actual_id = -1;
		      $("#nuevo_lugar_modal").modal("show");
		      $("#lugar_modal_title").html("Nueva municipalidad");
		      $('#lugar_tipo').hide();
		      $('#nombre_tipo_lugar').val('Municipalidad');
		    });
		    
		    $("#agregar_alojamiento_btn").click(function(){
		      lugar_actual_id = -1;
		      $("#lugar_modal_title").html("Nuevo alojamiento");
		      $('#lugar_tipo').hide();
		      $('#nombre_tipo_lugar').val('Alojamiento');
		    });
		    
		    $("#agregar_parroquia_btn").click(function(){
		      lugar_actual_id = -1;
		      $("#lugar_modal_title").html("Nueva parroquia");
		      $('#lugar_tipo').hide();
		      $('#nombre_tipo_lugar').val('Parroquia');
		    });
		    
		    $("#submit_lugar").click(function(){
		      $.get(routing.url_for("localidad", "AjaxCrearActualizarLugar"), {nombre_tipo_lugar:$('#nombre_tipo_lugar').val(),nombre:$('#nombre_lugar').val(), 
		        direccion:$('#direccion_lugar').val(), comentario:$('#comentario_lugar').val(), localidad_id:$('#localidad_id').val(),
		        lugar_id: lugar_actual_id},
		        function(data){
		        if($(".lugar_id[value="+data['lugar']['id']+"]").length > 0)
		        {
		          var $fila = crearFilaLugar(data['lugar']);
		          $(".lugar_id[value="+data['lugar']['id']+"]").closest("tr").replaceWith($fila);
		          $("#nuevo_lugar_modal").modal("hide");
		          resetCrearLugarForm();
		          lugar_actual_id=-1;
		          return;
		        }
		        
		        if($('#nombre_tipo_lugar').val() == 'Municipalidad'){
		        
		          $("#municipalidad").html('<a  data-toggle="modal" class = "contactos_button"'+
		                                        'href="#contacto_modal" title="Mostrar contactos">'+data["lugar"]["nombre"]+
		                                      '<input type="hidden" class="lugar_id" value="'+data["lugar"]["id"]+'"/>'+
		                                   '</a>. Direcci&oacute;n: '+data["lugar"]["direccion"]);
		                                   
		        }
		        else{
		          var $table = $("#"+$('#nombre_tipo_lugar').val()+"_table");
		          
		          $table.show();
		          $table.children('tbody').append(crearFilaLugar(data['lugar']));
		          $table.before(
		                        "<div class='alert alert-success span7'>"+  
		                            "<a class='close' data-dismiss='alert'>x</a>"+  
		                            "<strong>Bien!</strong> Se ha creado exitosamente."+
		                        "</div>"
		                        );    
		          
		          if($("#"+$('#nombre_tipo_lugar').val()+"_error").length>0)
		            $("#"+$('#nombre_tipo_lugar').val()+"_error").hide();
		        }
		        
		        $("#nuevo_lugar_modal").modal("hide");
		        
		        resetCrearLugarForm();
		      }, "json");
		    });
		    
		    
		    $("#guardar_checklist_btn").click(function(){
		      $.get(routing.url_for("localidad","AjaxActualizarChecklistLugar"), {id:lugar_actual_id, checklist:$('#checklist_form').serialize()},
		        function(data){
		          if(!($("#checklist_tab").find(".alert").length > 0))
		          {
		            $("#checklist_tab").children(".modal-body").prepend(
		                  "<div class='alert alert-success span4'>"+  
		                      "<a class='close' data-dismiss='alert'>x</a>"+  
		                      "Se ha guardado el checklist exitosamente!"+
		                  "</div>");
		          }
		      }, "json");
		    });
		    
		    
		    $("#guardar_comentario_lugar_btn").click(function(){
		      $.get(routing.url_for("localidad", "AjaxActualizarComentarioLugar"), {id:lugar_actual_id, comentario:$('#comentario_lugar_en_tab').val()},
		        function(data){
		          if(!($("#descripcion_tab").find(".alert").length > 0))
		          {
		            $("#descripcion_tab").children(".modal-body").prepend(
		                  "<div class='alert alert-success span4'>"+  
		                      "<a class='close' data-dismiss='alert'>x</a>"+  
		                      "Se ha guardado el comentario exitosamente!"+
		                  "</div>");
		          }
		      }, "json");
		    });
		    
		        
		    function contactosClickHandler(id)
		    {
		      lugar_actual_id = id;
		      $("#contacto_modal").find(".alert").remove();
		      $("#contactos_tab").children(".modal-body").html("Cargando...");
		      $('input:checkbox').attr('checked', false);
		      $("#comentario_lugar_en_tab").val("Cargando...");
		      
		      $.get(routing.url_for('localidad', 'AjaxGetInfoLugar'),{id: lugar_actual_id},
		        function(data){
		          $("#contactos_tab").children(".modal-body").html("");
		          $("#comentario_lugar_en_tab").val("");
		          
		          if(data['PastoralTipoContacto']['nombre']!='Alojamiento')
		            $('#checklist_menu_tab').hide();
		          else
		            $('#checklist_menu_tab').show();
		          
		          $.each(data['PastoralContacto'], function(id, val) {
		            var table = "<div class ='contacto'><span title='Editar' class='btn editar_contacto_btn'><i class='icon-pencil'></i></span>"+
		                        "<span title='Eliminar' class='btn eliminar_contacto_btn'><i class='icon-remove'></i></span>"+
		                        "<input type='hidden' class='contacto_id' value='"+val['id']+"'/>"+
		                        "<table class='table table-bordered table-striped'>"+
		                          "<tbody>"+
		                                "<tr><th class='span2'>Nombre</th><td class='nombre_contacto_row'>"+val['nombre']+"</td></tr>"+
		                                "<tr><th class='span2'>Cargo</th><td class='cargo_contacto_row'>"+val['cargo']+"</td></tr>"+
		                                "<tr><th class='span2'>Telefono</th><td class='telefono_contacto_row'>"+val['telefono']+"</td></tr>"+
		                          "</tbody>"+
		                        "</table></div>";
		            $("#contactos_tab").children(".modal-body").append(table);
		          });
		          
		          if(data['PastoralPerfilAlojamiento'].length > 0)
		          {
		            $.each(data['PastoralPerfilAlojamiento'][0], function(key, val){
		            
		                $('input:checkbox[name="pastoral_perfil_alojamiento['+key+']"]').attr('checked', val);
	
		            });
		          }
		          
		          if(data['comentario'] != null)
		            $("#comentario_lugar_en_tab").val(data['comentario']);
		          
		          
		        }, "json"
		      );
		    }
		    
		    $(".editar_lugar").live("click", function(){
		      var id = $(this).closest("tr").find(".lugar_id").val();
		      $("#lugar_modal_title").html("Editar Lugar");
		      $('#lugar_tipo').hide();
		      lugar_actual_id = id;
		      $.get('../../AjaxGetLugar',{id: id},
		        function(data){
		          $("#nombre_lugar").val(data['nombre']);
		          $("#direccion_lugar").val(data['direccion']);
		          $("#comentario_lugar").val(data['comentario']);
		      }, "json");
		      
		    });
		    
	
		    
	
		});
	
	
	
		function resetCrearContactoForm()
		{
		  $('#nombre_contacto').val("");
		  $('#cargo_contacto').val("");
		  $('#telefono_contacto').val("");
	
		}
	
		function resetCrearLugarForm()
		{
		  $('#nombre_lugar').val("");
		  $('#direccion_lugar').val("");
		  $('#comentario_lugar').val("");
		}
	
	
		//Recibe un lugar y devuelve una fila html con su contenido para las distintas tablas de lugares
		function crearFilaLugar(lugar)
		{
		  var $fila = "<tr>"+
		                "<td>"+
		                  "<a  data-toggle='modal' class='contactos_button'"+
		                    "href='#contacto_modal' title='Mostrar contactos'>"+
		                    lugar['nombre']+
		                    "<input type='hidden' class='lugar_id' value='"+lugar['id']+"'/>"+
		                  "</a>"+
		                "</td>"+
		                "<td>"+lugar['direccion']+"</td>"+
		                "<td>"+
		                  "<a  data-toggle='modal' class='btn btn-mini editar_lugar'"+
		                      "href='#nuevo_lugar_modal' title='Editar'>"+
		                      "<i class='icon-pencil'></i>"+
		                  "</a>"+
		                "</td>"+
		              "</tr>";
		  return $fila;
	
	}
});