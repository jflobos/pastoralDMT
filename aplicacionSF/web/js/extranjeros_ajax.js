
	$(function(){
	    
	    change_tables();
	    
	    $(".guardar_cambios").click(function () {
	        guardar_cambios_muec();
	    });
	    
	    $(".change_table").change(function() {
	         change_tables();
	    });
	  
	});
	  
	  function guardar_cambios_muec()
	  {
	    
	    var selected = new Array();
	    var mision_nueva = $("#mision_nueva").val();
	    
	    $("input:checkbox:checked").each(function() {
	         selected.push($(this).val());
	         id = $(this).val();
	    }); 
	    console.log(selected+" "+mision_nueva);
	    $.get('AjaxEditarExtranjeros', { selected:selected, mision_nueva:mision_nueva,},
	    function(data){
	        if(data==1)
	        {         
	          if(mision_nueva>0)
	          {
	            $('#'+id+'_zona_en_tabla').html($("#mision_nueva option:selected").attr('zona'));
	            $('#'+id+'_estado_en_tabla').html('aceptado');
	            $('#'+id+'_check_box').html('');
	            $("td :checkbox").prop("checked", false);
	            $(".even").css("background-color","#f9f9f9");
	            $(".odd").css("background-color","transparent");
	            $(".even").hover(function() {$(this).css("background-color","#CCFFCC");},function(){$(this).css("background-color","#f9f9f9");});
	            $(".odd ").hover(function() {$(this).css("background-color","#CCFFCC");},function(){$(this).css("background-color","transparent");});
	            hide_div($(".acciones_seleccionados"));
	          }
	        }
	        else if(data==0){}
	    });
	  }
	
	  function change_tables(){
	    var mision = $("#misiones_postulantes").val();
	    var estado = $("#estados_postulantes").val();
	    var flag   = $("#flag_postulante").val();
	    var pagina = $('#pagina').val();
	    
	    $.get('AjaxGetExtranjeros', { mision_id: mision, estado_id:estado, pagina:pagina},
	        function(data){
	            $("#postulantes_content  tr").remove();
	            $("#tabla_input tr").remove();
	          if(data!='' & data[2]!='')
	          {
	            cargo_usuario = data[0];
	            $("#info_usuarios div").hide('slow');
	            $("#aciones_y_botones").show();
	            $("#info_tabla_vacia").hide();
	            $("#info_usuarios div").remove();
	            string = ""+
	               "<tr style='background-color: rgb(249, 249, 249); '>"+
	                  "<th></th>"+
	                  "<th>Nombre</th>"+
	                  "<th>Edad</th>"+
	                  "<th>Estudios</th>"+
	                  "<th>Celular</th>"+
	                  "<th>Movimiento</th>"+
	                  "<th>Zona</th>"+
	                  "<th>Estado</th>"+
	               "</tr>";
	            $("#postulantes_content").append(string);
	            $("#paginacion").paginate({
	                count 		: data[3],
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
	                    change_tables();
	                }
	            }); 
	            var i = 0;
	            jQuery.each(data[2], function(i, ei) {
	                i = i+1;
	                usuario =           ei['PastoralUsuario'];
	                usuario_cargo =     usuario['PastoralUsuarioCargo'];
	                email =             usuario['User'].email_address;
	                universidad =       usuario['PastoralUniversidad']?usuario['PastoralUniversidad']:{sigla:""};
	                carrera =           usuario['PastoralCarrera']?usuario['PastoralCarrera']:{nombre:""};
	                comuna =            usuario['PastoralComuna'];
	                movimiento =        usuario['PastoralMovimiento']?usuario['PastoralMovimiento']:{nombre:""};
	                mue =               usuario['PastoralMisionUsuarioEstado'];
	                row = "                  "+
	                    "<tr>";
	                if(mue == '')    
	                    row +=  "<td id='"+ei.id+"_check_box'><input type='checkbox' value='"+ei.id+"'/></td>";
	                else
	                    row +=  "<td></td>";
	                row +=  "<td><span value='"+usuario.id+"' class='show_info_usuarios' style='text-decoration:underline;cursor:pointer;color:blue;'>"+usuario.nombre+" "+usuario.apellido_paterno+"</span></td>"+
	                        "<td>"+getAge(usuario.fecha_nacimiento)+"</td>"+
	                        "<td>"+universidad.sigla+" - "+carrera.nombre+"</td>"+
	                        "<td>"+usuario.telefono_celular+"</td>"+
	                        "<td>"+movimiento.nombre+"</td>";
	                  if(mue != '') 
	                  {
	                      mue= mue[0];
	                      mision =            mue['PastoralMision'];
	                      estado =            mue['PastoralEstadoPostulacion'];
	                      localidad =         mision['PastoralLocalidadFantasia'];
	                  row +="<td id='"+ei.id+"_zona_en_tabla'>"+localidad.nombre+"</td>"+
	                        "<td id='"+ei.id+"_estado_en_tabla'>"+estado.nombre+"</td>"+
	                      "</tr>";
	                  }else{
	                  row +="<td id='"+ei.id+"_zona_en_tabla'>"+" "+"</td>"+
	                        "<td id='"+ei.id+"_estado_en_tabla'>"+" "+"</td>"+
	                    "</tr>";
	                    }
	                $("#postulantes_content").append(row);
	              
	            });
	        }
	        else
	        { 
	            $("#paginacion").children().remove();
	            $("#aciones_y_botones").hide();
	            $("#info_tabla_vacia").show();
	            $("#info_tabla_vacia").html("<br/>La tabla no contiene resultados con los filtro actuales<br/><br/>");
	        }
	        $("head").append("<script type='text/javascript' src='http://www.pastoraluc.cl/dm/gestorProyectos/web/js/extranjeros.js'></script>");
	    }, "json"); 
	  }
	  
	  function toString(data)
	  {
	    var valor = "";
	    if(data != null && data != "undefined")
	    {
	      valor = data;
	    }
	    
	    return valor;
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
