$(document).ready(function($){
	$(function(){
	    
	    $('.typeahead').typeahead();
	    
	    busqueda_string = $("#busqueda_string").val();
	    change_table(busqueda_string);
	    
	    $("#info_tabla_vacia").hide();
	    
	    $('.change_filter').change(function () {
	        $('#pagina').val(1);
	        change_table();
	    });
	    
	    $('#grupo').change(function () {
	        $('#mision').val(-1);
	        change_agrupacion();
	    });
	    
	    $('#proyecto_version').change(function () {
	        $('#grupo').val(-1);
	        $('#mision').val(-1);
	        change_agrupacion();
	    });
	    
	    $('#proyecto').change(function () {
	        $('#proyecto_version').val(-1);
	        $('#grupo').val(-1);
	        $('#mision').val(-1);
	        change_agrupacion();
	    });
	    
	    $('#busqueda').click(function () {
	        busqueda();
	    });
	    
	});
	
	
	function busqueda()
	{
	    busqueda_string = $("#busqueda_string").val();
	    change_table();
	}
	
	
	function change_agrupacion(proyecto, proyecto_version, grupo, mision)
	{
	    grupo            = $("#grupo").val();
	    proyecto_version = $("#proyecto_version").val();
	    proyecto         = $("#proyecto").val();
	    
	    $.get(routing.url_for('usuario','AjaxCambioFiltros'), { grupo:grupo, proyecto_version:proyecto_version, proyecto:proyecto},
	    function(data){
	         misiones             =  data[2];
	         grupos               =  data[1];
	         proyecto_version     =  data[0];
	         load = 0;
	         if(proyecto_version.length>0){
	            load=1;
	            $('#proyecto_version option').remove();
	            $('#proyecto_version').append('<option value="-1">-- proyecto version --</option>');
	            for (var i = 0; i < proyecto_version.length; i++) {
	                $('#proyecto_version').append($("<option/>", {
	                    value: proyecto_version[i].id,
	                    text: proyecto_version[i]["PastoralProyecto"].nombre+" - "+proyecto_version[i].version
	                }));
	            }
	         }
	         if(grupos.length>0 || load==1){
	            load=1;
	            $('#grupo option').remove();
	            $('#grupo').append('<option value="-1">-- grupo --</option>');
	            for (var i = 0; i < grupos.length; i++) {
	                $('#grupo').append($("<option/>", {
	                    value: grupos[i].id,
	                    text: grupos[i].nombre
	                }));
	            }
	         }
	         if(misiones.length>0 || load==1){
	            $('#mision option').remove();
	            $('#mision').append('<option value="-1">-- zona --</option>');
	            for (var i = 0; i < misiones.length; i++) {
	                $('#mision').append($("<option/>", {
	                    value: misiones[i].id,
	                    text: misiones[i]["PastoralLocalidadFantasia"].nombre
	                }));
	            }
	         }
	    }, "json");
	}
	
	function change_table(){      
	
	    var pagina           = $('#pagina'           ).val();
	    var mision           = $('#mision'           ).val();
	    var grupo            = $('#grupo'            ).val();
	    var proyecto_version = $('#proyecto_version' ).val();
	    var proyecto         = $('#proyecto'         ).val();
	    var universidad      = $('#universidad'      ).val();
	    var movimiento       = $('#movimiento'       ).val();
	    var carrera          = $('#carrera'          ).val();
	    var cargo            = $('#cargo'            ).val();
	    var sexo             = $('#sexo'             ).val();
	    var rj               = $('#rj').is(':checked')?1:0;
	    var rc               = $('#rc').is(':checked')?1:0;
	    var busqueda_string  = $('#busqueda_string'  ).val();
	    
	    $('#tabla_usuarios tr').remove();
	    
	    $.get(routing.url_for('usuario','AjaxBusqueda'), { pagina:pagina, rj:rj, rc:rc, mision: mision, grupo:grupo, proyecto_version:proyecto_version, proyecto:proyecto, carrera:carrera, universidad:universidad, movimiento:movimiento, sexo:sexo, busqueda_string:busqueda_string, cargo:cargo},
	       function(data){
	       if(data[0]!='')
	       {
	           $("#info_tabla_vacia").hide();
	           cantidadDePaginas = data[1];
	           cargo_usuario = data[2];
	           
	           $("#paginacion").paginate({
	                count 		: cantidadDePaginas,
	                start 		: pagina,
	                display     : 12,
	                border					: true,
	                border_color			: '#79B5E3',
	                text_color  			: '#79B5E3',
	                background_color    	: 'none',	
	                text_hover_color  		: '#2573AF',
	                background_hover_color	: 'none', 
	                images		: false,
	                mouse		: 'press',
	                onChange     			: function(page){
	                    $('#pagina').val(page);
	                    change_table();
	                }
	           }); 
	            
	           string = '<tr>'+
	              '<th fontsize="10" nowrap="nowrap">Nombre</th>'+
	              '<th fontsize="10" nowrap="nowrap">Edad</th>'+
	              '<th fontsize="10" nowrap="nowrap">Estudios</th>'+
	              '<th fontsize="10" nowrap="nowrap">Movimiento</th>'+
	              '<th fontsize="10" nowrap="nowrap">Celular</th>'+
	              '<th fontsize="10" nowrap="nowrap">RJ</th>'+
	              '<th fontsize="10" nowrap="nowrap">RC</th> '+     
	            '</tr>';
	            $('#tabla_usuarios').append(string);
	           jQuery.each(data[0], function(i, usuario) {    
	              educacion = '';
	              if(usuario.tipo_institucion_id == 1){	            	  
	            	  if(usuario['PastoralCarrera'] != undefined)
	            		  educacion = usuario['PastoralCarrera'].nombre;
	            	  else
	            		  educacion = 'Sin datos';
	              }
	              else if(usuario.tipo_institucion_id == 2){
	                  educacion = usuario['PastoralColegio'] ? usuario['PastoralColegio'].nombre : 'Sin datos del colegio';
	              }
	              else
	            	  educacion = 'No estudia';
	              movimiento = (usuario['PastoralMovimiento']) ? usuario['PastoralMovimiento'].nombre : 'Sin Movimiento';  
	              recomendaciones_jefe = usuario.sumJefes? usuario.sumJefes:"-";
	              recomendaciones_copares = usuario.sumCopares? usuario.sumCopares:"-";
	              string = '<tr>'+	              
	              "<td><span value='"+usuario.id+"' class='show_info_usuarios' style='text-decoration:underline;cursor:pointer;color:blue;'>"+usuario.nombre+" "+usuario.apellido_paterno+' '+usuario.apellido_materno+"</span></td>"+
	              '<td>'+getAge(usuario.fecha_nacimiento)+'</td>'+
	              '<td>'+educacion+'</td>'+
	              '<td>'+ movimiento +'</td>'+
	              '<td>'+usuario.telefono_celular+'</td>'+
	              '<td>'+recomendaciones_jefe+'</td>'+
	              '<td>'+recomendaciones_copares+'</td>'+     
	            '</tr>';
	            $('#tabla_usuarios').append(string);
	           });
	       }
	       else
	       { 
	           $("#paginacion").children().remove();
	           $("#info_tabla_vacia").show();
	           $("#info_tabla_vacia").html("<br/>La tabla no contiene resultados con los filtro actuales<br/><br/>");
	       }
	       $("head").append("<script type='text/javascript' src='"+routing.public_path('js/usuario_detalle_modal.js')+"'></script>");
	    }, "json"); 
	}
	
	function getAge(dateString) {
	    var today = new Date();
	    var birthDate = new Date(dateString);
	    var age = today.getFullYear() - birthDate.getFullYear();
	    var m = today.getMonth() - birthDate.getMonth();
	    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
	        age--;
	    }
	    return age;
	}
});