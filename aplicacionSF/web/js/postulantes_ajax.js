$(function(){
    
    change_tables();

    $("#misiones_postulantes").change(function () {
        $('#pagina').val(1);
        change_tables();
    });
   
    $("#estados_postulantes").change(function () {
        $('#pagina').val(1);
        change_tables();
    });
    
    $("#flag_postulante").change(function () {
        $('#pagina').val(1);
        change_tables();
    });
    
    $("#info_tabla_vacia").hide();
    
    $(".guardar_cambios").click(function () {
        guardar_cambios_muec();
    });
  
});
  
  function guardar_cambios_muec()
  {
    var selected = new Array();
    var mision_nueva = $("#mision_nueva").val();
    var cargo_nuevo  = $("#cargo_nuevo").val();
    var estado_nuevo = $("#estado_nuevo").val();
    var cuota_nueva  = $("#cuota_nueva").val();
    
    $("input:checkbox:checked").each(function() {
         selected.push($(this).val());
         id = $(this).val();
         if(cargo_nuevo>0)
            $('#'+id+'_cargo_en_tabla span').html($("#cargo_nuevo option:selected").text());
         if(mision_nueva>0)
         {
            $('#'+id+'_zona_en_tabla span').html($("#mision_nueva option:selected").attr('zona')); 
            $('#'+id+'_estado_en_tabla span').html('pendiente');
            $('#'+id+'_cuota_en_tabla span').html($("#mision_nueva option:selected").attr('cuota'));
         }
         if(estado_nuevo>0)
            $('#'+id+'_estado_en_tabla span').html($("#estado_nuevo option:selected").text());
         if(cuota_nueva>0)
            $('#'+id+'_cuota_en_tabla span').html($("#cuota_nueva").val());
    }); 
    $.get('AjaxEditarInscritos', { selected:selected, mision_nueva:mision_nueva,cargo_nuevo:cargo_nuevo,estado_nuevo:estado_nuevo,cuota_nueva:cuota_nueva},
    function(data){
        if(data==1)
        {
        }
        else if(data==0){}
    });
  }

  function guardar_cambios_flag_zona(id)
  {
          $("#"+id+"_remove_flag_zona_button").show();
          $("#"+id+"_solucionar_solicitud_zona").show();
          $("#"+id+"_guardar_flag_zona_button").html('Guardar Cambios');
          var text =$("#"+id+"_text_zona").val();
          $.get('AjaxEditarFlagZona', { uem_id:id,descripcion:text},
          function(data){
              if(data==1){}
              else if(data==0){}
          });
          $("#"+id+"_flag_zona").removeClass("icon-headphones");
          $("#"+id+"_flag_zona").addClass("icon-flag");
          
          $("#"+id+"_modal_zona").css("visibility","hidden");
          $("#"+id+"_modal_zona").modal('hide');
  }
  function guardar_cambios_flag_cuota(id)
  {
          $("#"+id+"_remove_flag_cuota_button").show();
          $("#"+id+"_solucionar_solicitud_cuota").show();
          $("#"+id+"_guardar_flag_cuota_button").html('Guardar Cambios');
          var text =$("#"+id+"_text_cuota").val();
          $.get('AjaxEditarFlagCuota', { uem_id:id,descripcion:text},
          function(data){
              if(data==1){}
              else if(data==0){}
          });
          $("#"+id+"_flag_cuota").removeClass("icon-headphones");
          $("#"+id+"_flag_cuota").addClass("icon-flag");
          
          $("#"+id+"_modal_cuota").css("visibility","hidden");
          $("#"+id+"_modal_cuota").modal('hide');
  }
  function eliminar_flag_zona(id)
  { 
          $("#"+id+"_remove_flag_zona_button").hide();
          $("#"+id+"_solucionar_solicitud_zona").hide();
          $("#"+id+"_guardar_flag_zona_button").html('Crear Flag');
          $("#"+id+"_text_zona").val('Ingresa aquí tus comentarios');
          $.get('AjaxEliminarFlagZona', { uem_id:id},
          function(data){
              if(data==1){}
              else if(data==0){}
          });
          
          $("#"+id+"_flag_zona").removeClass("icon-flag");
          $("#"+id+"_flag_zona").addClass("icon-headphones");
          
          $("#"+id+"_modal_zona").css("visibility","hidden");
          $("#"+id+"_modal_zona").modal('hide');
  }
  function eliminar_flag_cuota(id)
  { 
          $("#"+id+"_remove_flag_cuota_button").hide();
          $("#"+id+"_text_cuota").val('Ingresa aquí tus comentarios');
          $("#"+id+"_solucionar_solicitud_cuota").hide();
          $("#"+id+"_guardar_flag_cuota_button").html('Crear Flag');
          $.get('AjaxEliminarFlagCuota', { uem_id:id},
          function(data){
              if(data==1){}
              else if(data==0){}
          });
          
          $("#"+id+"_flag_cuota").removeClass("icon-flag");
          $("#"+id+"_flag_cuota").addClass("icon-headphones");
          
          $("#"+id+"_modal_cuota").css("visibility","hidden");
          $("#"+id+"_modal_cuota").modal('hide');
  }

  function cerrar_flag_zona(id)
  {
          $("#"+id+"_modal_zona").css("visibility","hidden");
          $("#"+id+"_modal_zona").modal('hide');
  }
  
  function cerrar_flag_cuota(id)
  {
          $("#"+id+"_modal_cuota").css("visibility","hidden");
          $("#"+id+"_modal_cuota").modal('hide');
  }
  
  function cerrar_info_usuario(id)
  {
          $("#"+id+"_modal_usuario").css("visibility","hidden");
          $("#"+id+"_modal_usuario").modal('hide');
  }

  function change_tables(){
    var mision = $("#misiones_postulantes").val();
    var estado = $("#estados_postulantes").val();
    var flag   = $("#flag_postulante").val();
    var pagina = $('#pagina').val();
    
    $.get('AjaxGetMUEdeEstadoYMision', { mision_id: mision, estado_id:estado, flag_id:flag, pagina:pagina},
        function(data){
            $("#postulantes_content  tr").remove();
            $("#tabla_input tr").remove();
          if(data!='' & data[2]!='')
          {
            cargo_usuario = data[0];
            $("#info_usuarios div").hide('slow');
            $("#aciones_y_botones").show();
            $("#info_tabla_vacia").hide();
            $("#flag_zona_information div").remove();
            $("#flag_cuota_information div").remove();
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
                  "<th>Cargo</th>"+
                  "<th>Estado</th>";
                  if(cargo_usuario.e_inscritos_cuota==1)
                      string += "<th>Cuota</th>";
            if(cargo_usuario.cveb_flag_zona==1)
            {
                string +="<th>S. Zona</th>";
            }
            if(cargo_usuario.cveb_flag_cuota==1)
            {
                 string+="<th>S. Cuota</th>";
            }
            string += "</tr>";
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
            jQuery.each(data[2], function(i, mue) {
              i = i+1;              
              mision =            mue['PastoralMision'];
              usuario =           mue['PastoralUsuario'];
              estado =            mue['PastoralEstadoPostulacion'];
              localidad =         mision['PastoralLocalidadFantasia'];
              usuario_cargo =     usuario['PastoralUsuarioCargo'];
              email =             usuario['User'].email_address;
              universidad =       (usuario['PastoralUniversidad'] != null) ? usuario['PastoralUniversidad'] : {nombre: 'Sin Universidad'} ;
              carrera =           (usuario['PastoralCarrera'] != null) ? usuario['PastoralCarrera'] : {nombre: 'Sin Carrera'};
              comuna =            (usuario['PastoralComuna'] != null) ? usuario['PastoralComuna']: {nombre: 'No ingresada'};
              movimiento =        (usuario['PastoralMovimiento'] != null) ? usuario['PastoralMovimiento'] : 'Ninguno';
              nombre_cargo =      'misionero-voluntario';
              if(usuario_cargo != '')
                  nombre_cargo = usuario_cargo[0]['PastoralCargo'].nombre;
              parity = i%2==0?"even":"odd";
              
              flag_zona = mue.flag_zona?"<i id='"+mue.id+"_flag_zona' class='icon-flag flag_zona' value='"+mue.id+"'></i>":"<i id='"+mue.id+"_flag_zona' class='icon-headphones flag_zona'  value='"+mue .id+"'></i>";
              flag_cuota = mue.flag_cuota?"<i id='"+mue.id+"_flag_cuota' class='icon-flag flag_cuota' value='"+mue.id+"'></i>":"<i id='"+mue.id+"_flag_cuota' class='icon-headphones flag_cuota'  value='"+mue .id+"'></i>";
              
              icono = 'icon-plus';
              
              string_zona =  string_cargo = string_estado = string_cuota = "";
              
              if(cargo_usuario.e_inscritos_cuota==1)
                  string_cuota = '<i class="'+icono+' cambio_cuota_inmediato pull-right" value="'+mue.id+'" cuota="'+mue.cuota+'" ></i>';
              if(cargo_usuario.e_inscritos_mision==1)
                  string_zona = '<i class="'+icono+' cambio_zona_inmediato pull-right" value="'+mue.id+'" ></i>';
              if(cargo_usuario.e_inscritos_cargo==1)
                  string_cargo = '<i class="'+icono+' cambio_cargo_inmediato pull-right" value="'+mue.id+'" ></i>';
              if(cargo_usuario.e_inscritos_estado==1)
                  string_estado = '<i class="'+icono+' cambio_estado_inmediato pull-right" value="'+mue.id+'" ></i>';

              string_zona   = "<td id='"+mue.id+"_zona_en_tabla'  ><span>" +localidad.nombre+"</span>"+string_zona   +"</td>";
              string_cargo  = "<td id='"+mue.id+"_cargo_en_tabla' ><span>" +nombre_cargo    +"</span>"+string_cargo  +"</td>";
              string_estado = "<td id='"+mue.id+"_estado_en_tabla'><span>" +estado.nombre   +"</span>"+string_estado +"</td>";
              string_cuota  = "<td id='"+mue.id+"_cuota_en_tabla' ><span>"  +mue.cuota      +"</span>"+string_cuota  +"</td>";
              
              
              string = "<tr class='"+parity+"'>"+
              "<td><input type='checkbox' value='"+mue.id+"'/></td>"+
              "<td><span value='"+usuario.id+"' mue='"+mue.id+"' class='show_info_usuarios' style='text-decoration:underline;cursor:pointer;color:blue;'>"+usuario.nombre+" "+usuario.apellido_paterno+"</span></td>"+
              "<td>"+((usuario.fecha_nacimiento != undefined) ? getAge(usuario.fecha_nacimiento) : 'Sin datos' )+"</td>"+
              "<td>"+((universidad.nombre != undefined) ? universidad.nombre : 'Sin universidad')+"-"+carrera.nombre+"</td>"+
              "<td>"+usuario.telefono_celular+"</td>"+
              "<td>"+movimiento.nombre+"</td>"+
              string_zona   +
              string_cargo  +
              string_estado +
              string_cuota  ;
              if(cargo_usuario.cveb_flag_zona == 1)
              {
                string += "<td >"+toString(flag_zona)+"</td>";
              }
              if(cargo_usuario.cveb_flag_cuota == 1)
              {
                string += "<td >"+toString(flag_cuota)+"</td>";
              }
              string += "</tr>";
              $("#postulantes_content").append(string);
              var buttons = '';
              var solicitud = '';
              if(cargo_usuario.cveb_flag_zona == 1){
              
                  var visibilidad = mue.flag_zona==0? "display: none;":"";
                  var crear_string = mue.flag_zona==0? "Crear Advertencia":"Guardar Cambios";
                  
                  buttons = "<span value='"+mue.id+"' class='btn span1 cerrar_flag_zona'>Cancelar</span>"+
                  "<span id='"+mue.id+"_remove_flag_zona_button' value='"+mue.id+"' class='btn btn-primary span2 eliminar_flag_zona' style='"+visibilidad+"'>Remover Advertencia</span>"+
                  "<span id='"+mue.id+"_guardar_flag_zona_button' value='"+mue.id+"' class='btn btn-primary span2 guardar_cambios_flag_zona'>"+crear_string+"</span>";
                  if(cargo_usuario.e_inscritos_mision == 1)
                  {
                    var misiones = "<select class='btn fade in' id='mision_nueva_modal_"+mue.id+"' style='padding-bot:5px'>";
                        jQuery.each(data[1], function(i, val2) {
                            misiones = misiones+"<option cuota="+val2.cuota+" value='"+val2.id+"' ";
                            if(val2.id == localidad.id){
                              misiones = misiones+"selectied='selected'";
                            }
                            misiones=misiones+">"+val2.nombre+"</option>";
                        });
                        misiones = misiones+"</select>";
                      solicitud=""+
                      "<div id='"+mue.id+"_solucionar_solicitud_zona' class='span4' style='text-align:center;"+visibilidad+"'>"+ 
                        misiones+
                        "<span value='"+mue.id+"' class='btn btn-success span2 solucionar_solicitud_zona' style='margin-top:15px;'>Cambiar Zona</span>"+
                      "</div>";
                  }
              
                  $("#flag_zona_information").append(""+
                  "<div class='modal fade in' id='"+mue.id+"_modal_zona' style='visibility:hidden;'>"+
                  '<button type="button" class="close" data-dismiss="modal">x</button>                                    '+
                    "<div class='modal-header'>"+
                      "<h3>"+flag_zona+" "+usuario.nombre+" "+usuario.apellido_paterno+" "+usuario.apellido_materno+" "+"</h3>"+
                    "</div>"+
                    "<div class='modal-body'>"+
                      "<table>"+
                        "<td>"+
                          "<textarea id='"+mue.id+"_text_zona' rows='10' cols='40'>"+mue.descripcion_zona+"</textarea>"+
                        "</td><td style='text-align:center;margin:0 auto;'>"+
                          solicitud+
                        "</td>"+
                      "</table>"+
                    "</div>"+
                    "<div class='modal-footer row'>"+
                        buttons+
                    "</div>"+
                  "</div>");
              }
              if(cargo_usuario.cveb_flag_cuota == 1){
                  var visibilidad = mue.flag_cuota==0? "display: none;":"";
                  var crear_string = mue.flag_cuota==0? "Crear Advertencia":"Guardar Cambios";
                  
                  buttons = "<span value='"+mue.id+"' class='btn span1 cerrar_flag_cuota'>Cancelar</span>"+
                  "<span id='"+mue.id+"_remove_flag_cuota_button' value='"+mue.id+"' class='btn btn-primary span2 eliminar_flag_cuota' style='"+visibilidad+"'>Remover Advertencia</span>"+
                  "<span id='"+mue.id+"_guardar_flag_cuota_button' value='"+mue.id+"' class='btn btn-primary span2 guardar_cambios_flag_cuota'>"+crear_string+"</span>";
              
                  if(cargo_usuario.e_inscritos_cuota==1)
                  {
                      solicitud=""+
                      "<div id='"+mue.id+"_solucionar_solicitud_cuota' class='span4' style='text-align:center;"+visibilidad+"'>"+ 
                        "<input class='span2' value="+mue.cuota+" id='"+mue.id+"_cuota_nueva_module' type='numbers' placeholder='cuota'></input></br>"+
                        "<span value='"+mue.id+"' class='btn btn-success span2 solucionar_solicitud_cuota'>Solucionar Solicitud</span>"+
                      "</div>";
                  }
                 
                  $("#flag_cuota_information").append(""+
                  "<div class='modal fade in' id='"+mue.id+"_modal_cuota' style='visibility:hidden;'>"+
                  '<button type="button" class="close" data-dismiss="modal">x</button>                                    '+
                    "<div class='modal-header'>"+
                      "<h3>"+flag_cuota+" "+usuario.nombre+" "+usuario.apellido_paterno+" "+usuario.apellido_materno+" "+"</h3>"+
                    "</div>"+
                    "<div class='modal-body'>"+
                    "<table>"+
                        "<td>"+
                          "<textarea id='"+mue.id+"_text_cuota' rows='10' cols='40'>"+mue.descripcion_cuota+"</textarea>"+
                        "</td><td>"+
                          solicitud+
                        "</td>"+
                      "</table>"+
                    "</div>"+
                    "<div class='modal-footer'>"+
                    buttons+
                    "</div>"+
                  "</div>");
              }
          });
        }
        else
        { 
            $("#paginacion").children().remove();
            $("#aciones_y_botones").hide();
            $("#info_tabla_vacia").show();
            $("#info_tabla_vacia").html("<br/>La tabla no contiene resultados con los filtro actuales<br/><br/>");
        }
        $("head").append("<script type='text/javascript' src='http://www.pastoraluc.cl/dm/gestorProyectos/web/js/postulantes.js'></script>");
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
