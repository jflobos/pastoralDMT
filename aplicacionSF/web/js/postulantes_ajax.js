var gestorTablaVoluntarios = (function(){
    //Variables privadas
    var cargo_usuario, paginacion, postulantes, zonas;
    var mision, estado, flag, pagina;
    //Metodos privados    
    var vaciarTabla = function vaciarTabla(){
        $("#postulantes_content  tr").remove();
        $("#tabla_input tr").remove();
    }    
    var recargarInformacion = function recargarInformacion(){
        mision = $("#misiones_postulantes").val();
        estado = $("#estados_postulantes").val();
        flag   = $("#flag_postulante").val();        
        pagina = ($('#pagina').val() != undefined) ? $('#pagina').val():1;
    }  
    
    //Imprime cabecera de la tabla
    var imprimirCabeceraDeTabla = function imprimirCabeceraDeTabla(){
        $("#postulantes_content").append('<tr id="cabecera_inscritos" style="background-color: rgb(249, 249, 249);"></tr>');        
        $('#cabecera_inscritos').append('<th colspan="2">Nombre</th><th>Edad</th><th>Estudios</th>');
        $('#cabecera_inscritos').append('<th>Celular</th><th>Movimiento</th><th>Zona</th><th>Cargo</th><th>Estado</th>');
        if(cargo_usuario.cveb_flag_cuota==1)
            $('#cabecera_inscritos').append('<th>Cuota</th>');
        if(cargo_usuario.cveb_flag_zona==1)
            $('#cabecera_inscritos').append('<th>S. Zona</th>');
        if(cargo_usuario.cveb_flag_cuota==1)
            $('#cabecera_inscritos').append('<th>S. Cuota</th>');        
    }
    //Var Elimina los datos de la tabla
    var limpiarTabla = function limpiarTabla(){
        $("#info_usuarios div").hide('slow');
        $("#aciones_y_botones").show();
        $("#info_tabla_vacia").hide();
        $("#flag_zona_information div").remove();
        $("#flag_cuota_information div").remove();
        $("#info_usuarios div").remove();
    }
    //Genera el paginador
    var generarPaginacion = function generarPaginacion(){        
        $("#paginacion").paginate({
            count: paginacion,
            start: pagina,
            display: 12,
            border: true,
            border_color: '#79B5E3',
            text_color: '#79B5E3',
            background_color: 'none',	
            text_hover_color: '#2573AF',
            background_hover_color: 'none', 
            images: false,
            mouse: 'press',
            onChange: function(page){
                $('#pagina').val(page);
                imprimirTabla();
            }
        }); 
    }    
    var generarVoluntario = function generarVoluntario(mue){
        var voluntario = {};
        voluntario.mision = mue['PastoralMision'];
        voluntario.usuario = mue['PastoralUsuario'];
        voluntario.estado = mue['PastoralEstadoPostulacion'];
        voluntario.localidad = voluntario.mision['PastoralLocalidadFantasia'];
        voluntario.usuario_cargo = voluntario.usuario['PastoralUsuarioCargo'];
        voluntario.email = voluntario.usuario['User'].email_address;
        voluntario.universidad = (voluntario.usuario['PastoralUniversidad'] != null) ? voluntario.usuario['PastoralUniversidad'] : {nombre: 'Sin Universidad'} ;
        voluntario.carrera = (voluntario.usuario['PastoralCarrera'] != null) ? voluntario.usuario['PastoralCarrera'] : {nombre: 'Sin Carrera'};
        voluntario.comuna = (voluntario.usuario['PastoralComuna'] != null) ? voluntario.usuario['PastoralComuna']: {nombre: 'No ingresada'};
        voluntario.movimiento = (voluntario.usuario['PastoralMovimiento'] != null) ? voluntario.usuario['PastoralMovimiento'] : 'Ninguno';
         if(voluntario.usuario_cargo != '')
            voluntario.nombre_cargo = voluntario.usuario_cargo[0]['PastoralCargo'].nombre;
        else
            voluntario.nombre_cargo = 'misionero-voluntario';        
        return voluntario;
    }    
    var imprimirFilaVoluntario = function imprimirFilaVoluntario(i, mue, voluntario){
        parity = i%2==0?"even":"odd";            
        flag_zona = mue.flag_zona?"<i id='"+mue.id+"_flag_zona' class='icon-flag flag_zona' value='"+mue.id+"'></i>":"<i id='"+mue.id+"_flag_zona' class='icon-headphones flag_zona'  value='"+mue .id+"'></i>";
        flag_cuota = mue.flag_cuota?"<i id='"+mue.id+"_flag_cuota' class='icon-flag flag_cuota' value='"+mue.id+"'></i>":"<i id='"+mue.id+"_flag_cuota' class='icon-headphones flag_cuota'  value='"+mue .id+"'></i>";            
        icono = 'icon-plus';            
        //Inicio de la impresion del voluntario:
        //Fila que lo contiene:
        $("#postulantes_content").append('<tr id="voluntario_row_'+mue.id+'" class="'+parity+'"></tr>');        
        //Checkbox para marcar su seleccion:
        $('#voluntario_row_'+mue.id).append('<td><input type="checkbox" value="'+mue.id+'"/></td>');        
        //Nombre del voluntario
        nombre_cell = '<span value="'+voluntario.usuario.id+'" mue="'+mue.id+'" class="show_info_usuarios" style="text-decoration:underline;cursor:pointer;color:blue;">'+voluntario.usuario.nombre+' '+voluntario.usuario.apellido_paterno+'</span>';        //TODO: Revisamos si puede editar el voluntario e imprimimos el icono de edicion
        if(cargo_usuario.e_inscritos_mision==1)
            nombre_cell = '<i class="icon-tint editar_voluntario" usuario="'+i+'" style="margin-right: 3px; cursor: pointer;"></i>'.concat(nombre_cell);
        $('#voluntario_row_'+mue.id).append('<td style="position: relative;">'+nombre_cell+'</td>');        
        //Edad
        $('#voluntario_row_'+mue.id).append('<td>'+((voluntario.usuario.fecha_nacimiento != undefined) ? getAge(voluntario.usuario.fecha_nacimiento) : 'Sin datos' )+'</td>');        
        //Estudios
        $('#voluntario_row_'+mue.id).append('<td>'+((voluntario.universidad.nombre != undefined) ? voluntario.universidad.nombre : 'Sin universidad')+'-'+voluntario.carrera.nombre+'</td>');        
        //Celular
        $('#voluntario_row_'+mue.id).append('<td>'+voluntario.usuario.telefono_celular+'</td>');
        //Movimiento
        $('#voluntario_row_'+mue.id).append('<td>'+voluntario.movimiento.nombre+'</td>');
        //Zona
        string_zona =  '<span>'+voluntario.localidad.nombre+'</span>'
        if(cargo_usuario.e_inscritos_mision==1)
            string_zona += '<i class="'+icono+' cambio_zona_inmediato pull-right" value="'+mue.id+'" ></i>';
        $('#voluntario_row_'+mue.id).append('<td id="'+mue.id+'_zona_en_tabla">'+string_zona+'</td>');
        //Cargo
        string_cargo = '<span>'+voluntario.nombre_cargo+'</span>';        
        if(cargo_usuario.e_inscritos_cargo==1)
            string_cargo += '<i class="'+icono+' cambio_cargo_inmediato pull-right" value="'+mue.id+'" ></i>';
        $('#voluntario_row_'+mue.id).append('<td id="'+mue.id+'_cargo_en_tabla">'+string_cargo+'</td>');
        //Estado
        string_estado = '<span>'+voluntario.estado.nombre+'</span>';
        if(cargo_usuario.e_inscritos_estado==1)
            string_estado += '<i class="'+icono+' cambio_estado_inmediato pull-right" value="'+mue.id+'"></i>';
        $('#voluntario_row_'+mue.id).append('<td id="'+mue.id+'_estado_en_tabla">'+string_estado+'</td>');
        //Cuota
        string_cuota = '<span>'+mue.cuota+'</span>';
        if(cargo_usuario.e_inscritos_cuota==1)
            string_cuota += '<i class="'+icono+' cambio_cuota_inmediato pull-right" value="'+mue.id+'" cuota="'+mue.cuota+'" ></i>';
        $('#voluntario_row_'+mue.id).append('<td id="'+mue.id+'_cuota_en_tabla">'+string_cuota+'</td>');
        //Flags
        //Zona
        if(cargo_usuario.cveb_flag_zona == 1)
            $('#voluntario_row_'+mue.id).append("<td >"+toString(flag_zona)+"</td>");        
        //Cuota
        if(cargo_usuario.cveb_flag_cuota == 1)
            $('#voluntario_row_'+mue.id).append("<td >"+toString(flag_cuota)+"</td>"); 
        //Se crean los flags
        if(cargo_usuario.cveb_flag_zona == 1)
            crearFlag('zona', mue, voluntario, flag_zona, cargo_usuario);        
        if(cargo_usuario.cveb_flag_cuota == 1)
            crearFlag('cuota', mue, voluntario, flag_cuota, cargo_usuario);
    }
    //Genera las acciones para escuchar a cada voluntario
    var listenersVoluntario = function listenersVoluntario(){
        $('.editar_voluntario').click(function(){
            var id = $(this).attr('usuario');
            modalEditarVoluntario(postulantes[id]);            
        });
    }
    //Modal que permite editar los cambios del voluntario
    var modalEditarVoluntario = function modalEditarVoluntario(voluntario){
        printFormEditarVoluntario($('#postulantes_content'), voluntario.PastoralUsuario);
    }
    var validarFormularioEditarVoluntario = function validarFormularioEditarVoluntario(){
      //Revisamos campo a campo el formulario
      retorno = true;
      retorno = datosPersonalesNoNulosyValidos();
      retorno = datosEstudiosValidos();
      retorno = datosDatosDeCuentaValidos();
      if($('#pastoral_usuario_User_id').val() != undefined){
        retorno = false;
      }
      if($('#pastoral_usuario_id').val() != undefined){
        retorno = false;
      }
      if(retorno){
        $('#form_editar_voluntario_jefe_'+$('#pastoral_usuario_id').val());
      }      
      return retorno;
    }
    var datosDatosDeCuentaValidos = function datosDatosDeCuentaValidos(){
      retorno = true;
      if($('#pastoral_usuario_User_email_address').val() == undefined){
        retorno = false;
      }
      if($('#pastoral_usuario_User_password').val() != 
        $('#pastoral_usuario_User_password_confirmation').val()){
        retorno = false;
      }      
      return retorno;
    }
    var datosEstudiosValidos = function datosEstudiosValidos(){   
      retorno = true;
      switch($('#pastoral_usuario_tipo_institucion_id').val()){
        //Universidad
        case 1:
          if($('#pastoral_usuario_universidad_id').val() == undefined)
            retorno = false;
          if($('#pastoral_usuario_colegio_id').val() == undefined)
            retorno = false;
          if($('#pastoral_usuario_carrera_id').val() == undefined)
            retorno = false;
          if($('#pastoral_usuario_ano_ingreso').val() != undefined || 
            !(/^\d+$/.test($('#pastoral_usuario_ano_ingreso').val())) ||
            $('#pastoral_usuario_ano_ingreso').lenght == 4 )
            retorno = false;
          break;
        //Colegio
        case 2:
          if($('#pastoral_usuario_colegio_id').val() == undefined)
            retorno = false;
          break;
        //Ninguna
        case 3:          
          break;
      }
      return retorno;
    }
    var datosPersonalesNoNulosyValidos = function datosPersonalesNoNulosyValidos(){
      retorno = true;
      if($('#pastoral_usuario_rut').val().trim() == '' ||  $('#pastoral_usuario_rut').val() == undefined){
        retorno = false;
      }
      if($('#pastoral_usuario_nombre').val().trim() == '' || $('#pastoral_usuario_nombre').val() == undefined){
        retorno = false;
      }
      if($('#pastoral_usuario_apellido_paterno').val().trim() == '' || $('#pastoral_usuario_nombre').val() == undefined){
        retorno = false;
      }
      if($('#pastoral_usuario_apellido_materno').val().trim() == '' || $('#pastoral_usuario_apellido_materno').val() == undefined){
        retorno = false;
      }      
      dia = $('#pastoral_usuario_fecha_nacimiento_day').val();
      mes = $('#pastoral_usuario_fecha_nacimiento_month').val();
      ano = $('#pastoral_usuario_fecha_nacimiento_year').val();
      if(!fechaValida(dia, mes, ano)){
        retorno = false;
      }
      if($('#pastoral_usuario_movimiento_id').val() == undefined){
        retorno = false;
      }      
      if($('input:radio[name=pastoral_usuario[sexo]]:checked').val() == undefined){
        retorno = false;
      }
      if($('#pastoral_usuario_telefono_celular').val() != undefined || 
        !(/^\d+$/.test($('#pastoral_usuario_telefono_celular').val()))){
        retorno = false;
      }
      if($('#pastoral_usuario_telefono_emergencia').val() == undefined || 
        !(/^\d+$/.test($('#pastoral_usuario_telefono_emergencia').val()))){
        retorno = false;
      }
      if($('#pastoral_usuario_region_id').val() == undefined){
        retorno = false;
      }
      if($('#pastoral_usuario_comuna_id').val() == undefined){
        retorno = false;
      }      
      return retorno;
    }
    var cerrarFormularioEditarVoluntario = function cerrarFormularioEditarVoluntario(id){
      $('#form_editar_voluntario_'+id).modal('hide');
      $('#form_editar_voluntario_'+id).remove();
    }
    //Form para el form de editar voluntario
    var printFormEditarVoluntario = function printFormEditarVoluntario(contenedor, usuario){
        $.ajax({
          url: routing.url_for('usuario','editarUsuarioModalAjax'),
          type: "POST",
          data: {usuario_id : usuario.id},
          success: function(data){
              contenedor.append(data);
              $('#form_editar_voluntario_'+usuario.id).modal(); 
              activarListenersEditarVoluntario(usuario);                     
          }
        });
    }
    //Activar Listeners Formulario Editar voluntario
    var activarListenersEditarVoluntario = function activarListenersEditarVoluntario(usuario){      
      $('#pastoral_usuario_rut').Rut({
        on_error: function(){
          if(!$("#rut_error").text())
            $('#pastoral_usuario_rut').parent().append("<span id='rut_error'>Rut invalido.</span>"); 
        },
        on_success: function(){
          $("#rut_error").remove(); 
        }    
      });
      $("#pastoral_usuario_rut").click(function(){
        if($("#pastoral_usuario_es_extranjero").is(':checked')){
          $("#pastoral_usuario_es_extranjero").removeAttr("checked");
        }
      });
      $('#cambiar_voluntario').click(function(){
        console.log(validarFormularioEditarVoluntario());
        console.log(inputAObject($('#form_editar_voluntario_jefe_'+usuario.id+' :input')));
        if(validarFormularioEditarVoluntario()){
          //Mensaje de exito
          cerrarFormularioEditarVoluntario(usuario.id)
        }
      });
      $('#cerrar_modal').click(function(){
          cerrarFormularioEditarVoluntario(usuario.id)
      });
    }
    var inputAObject = function inputAObject(inputArray){
      values = {};
      $.each(inputArray, function(i, input){
        values[input.name] = input.value;
      })
      return values;
    }
    //Imprime una fila con el nuevo voluntario
    var imprimirVoluntario = function imprimirVoluntario(i,mue){
        //Inicio de impresion de postulantes
        var voluntario = generarVoluntario(mue);               
        imprimirFilaVoluntario(i, mue, voluntario);        
    }
    //Crear Flag para pedir Cambio de Zona o Cuota
    var crearFlag = function crearFlag(tipo, mue, voluntario, flag, cargo_usuario){        
        var modal;
        usuario = voluntario.usuario;                   
        switch(tipo){
            case 'zona':                
              if(cargo_usuario.e_inscritos_mision == 1)
                modal = crearFlagResolutivoZona(mue, voluntario);
              else
                modal = crearFlagSolicitudCambioZona(mue);
              break;
            case 'cuota':
              if(cargo_usuario.e_inscritos_mision == 1)
                modal = crearFlagResolutivoCuota(mue);
              else
                modal = crearFlagSolicitudCambioCuota(mue);
              break;             
            }
            $("#flag_cuota_information").append('<div class="modal fade in" id="'+mue.id+'_modal_'+tipo+'" style="visibility:hidden; padding: 0px;"><button type="button" class="close" data-dismiss="modal">x</button></div>');
            //Agregamos la cabecera
            $('#'+mue.id+'_modal_'+tipo).append('<div id="modal_'+tipo+'_header_'+mue.id+'" class="modal-header"><h3>'+flag+' '+usuario.nombre+' '+usuario.apellido_paterno+' '+usuario.apellido_materno+' '+'</h3></div>');
            //Agregamos el cuerpo del modal            
            descripcion = (tipo == 'cuota') ? mue.descripcion_cuota:mue.descripcion_zona;
            data_cells = "";
            if((mue.flag_zona == 1 || mue.flag_cuota == 1) || mue.e_inscritos_mision != 1)
              data_cells += '<td><textarea id="'+mue.id+'_text_'+tipo+'" rows="10" cols="40">'+descripcion+'</textarea></td>';
            data_cells += '<td>'+modal.solicitud+'</td>';            
            $('#'+mue.id+'_modal_'+tipo).append('<div class="modal-body" style="overflow: hidden;"><table>'+data_cells+'</table></div>');
            //Footer del modal
            $('#'+mue.id+'_modal_'+tipo).append('<div class="modal-footer">'+modal.botones+'</div>');            
    }
    var crearFlagSolicitudCambioCuota = function crearFlagSolicitudCambioCuota(mue){
      retorno = {};      
      retorno.solicitud = "";
      retorno.botones = "";
      //Resuelve cambio de zonas
      if(mue.flag_zona == 1)
        retorno.botones = "<span value='"+mue.id+"' class='btn span1 cerrar_flag_cuota'>Cancelar</span>"+
                  "<span id='"+mue.id+"_remove_flag_cuota_button' value='"+mue.id+"' class='btn btn-primary span2 eliminar_flag_cuota'>Remover solicitud</span>"+
                  "<span id='"+mue.id+"_guardar_flag_cuota_button' value='"+mue.id+"' class='btn btn-primary span2 guardar_cambios_flag_cuota'>Guardar solicitud</span>";      
      else
        retorno.botones = "<span value='"+mue.id+"' class='btn span1 cerrar_flag_cuota'>Cerrar</span>"+                  
                  "<span id='"+mue.id+"_guardar_flag_cuota_button' value='"+mue.id+"' class='btn btn-primary span2 guardar_cambios_flag_cuota'>Guardar solicitud</span>";
      return retorno;
    }    
    
    var crearFlagResolutivoCuota = function crearFlagResolutivoCuota(mue){
      retorno = {};      
      retorno.solicitud = "";      
      //Resuelve cambio de zonas
      if(mue.flag_cuota == 1){   
        retorno.botones = "<span value='"+mue.id+"' class='btn span1 cerrar_flag_cuota'>Cancelar</span>"+
                  "<span id='"+mue.id+"_remove_flag_cuota_button' value='"+mue.id+"' class='btn btn-primary span2 eliminar_flag_cuota'>Remover solicitud</span>"+
                  "<span id='"+mue.id+"_guardar_flag_cuota_button' value='"+mue.id+"' class='btn btn-primary span2 guardar_cambios_flag_cuota'>Guardar solicitud</span>";
        retorno.solicitud="<div id='"+mue.id+"_solucionar_solicitud_cuota' class='span4' style='text-align:center;'>"+ 
                            "<input class='span2' value="+mue.cuota+" id='"+mue.id+"_cuota_nueva_module' type='numbers' placeholder='cuota'></input></br>"+
                            "<span value='"+mue.id+"' class='btn btn-success span2 solucionar_solicitud_cuota'>Solucionar Solicitud</span>"+
                          "</div>";
      }
      else{
        retorno.solicitud = "No hay solicitud de cambio de cuota pendiente";
        retorno.botones = "<span value='"+mue.id+"' class='btn span1 cerrar_flag_cuota'>Cerrar</span>"
      }
      return retorno;
    }
    
    var crearFlagSolicitudCambioZona = function crearFlagSolicitudCambioZona(mue){
      retorno = {};      
      retorno.solicitud = "";
      retorno.botones = "";
      //Resuelve cambio de zonas
      if(mue.flag_zona == 1){        
        retorno.botones = "<span value='"+mue.id+"' class='btn span1 cerrar_flag_zona'>Cerrar</span>"+
                  "<span id='"+mue.id+"_remove_flag_zona_button' value='"+mue.id+"' class='btn btn-primary span2 eliminar_flag_zona'>Remover Advertencia</span>"+
                  "<span id='"+mue.id+"_guardar_flag_zona_button' value='"+mue.id+"' class='btn btn-primary span2 guardar_cambios_flag_zona'>Guardar Advertencia</span>";        
      }
      else{
        retorno.botones = "<span value='"+mue.id+"' class='btn span1 cerrar_flag_zona'>Cerrar</span>"+                  
                  "<span id='"+mue.id+"_guardar_flag_zona_button' value='"+mue.id+"' class='btn btn-primary span2 guardar_cambios_flag_zona'>Guardar Advertencia</span>";
      }
      return retorno;
    }
    //Crear un flag para el voluntario que es cambiar el tipo de zona:
    var crearFlagResolutivoZona = function crearFlagResolutivoZona(mue, voluntario){
      retorno = {};      
      retorno.solicitud = "";      
      //Resuelve cambio de zonas
      if(mue.flag_zona == 1){        
        misiones= "<select class='btn fade in' id='mision_nueva_modal_"+mue.id+"' style='padding-bot:5px'>";
        $.each(zonas, function(i, val2) {                    
            i++;
            misiones+="<option cuota="+val2.cuota+" value='"+val2.id+"' ";
            if(val2.id == voluntario.localidad.id){
                misiones+="selectied='selected'";
            }
            misiones+=">"+val2.nombre+"</option>";
        });
        misiones+="</select>";
        textoBoton="Cambiar zona";
        retorno.botones = "<span value='"+mue.id+"' class='btn span1 cerrar_flag_zona'>Cerrar</span>"+
                  "<span id='"+mue.id+"_remove_flag_zona_button' value='"+mue.id+"' class='btn btn-primary span2 eliminar_flag_zona'>Remover solicitud</span>"+
                  "<span id='"+mue.id+"_guardar_flag_zona_button' value='"+mue.id+"' class='btn btn-primary span2 guardar_cambios_flag_zona'>Guardar solicitud</span>";
        retorno.solicitud=""+"<div id='"+mue.id+"_solucionar_solicitud_zona' class='span4' style='text-align:center;'>"+ 
                      misiones+
                      "<span value='"+mue.id+"' class='btn btn-success span2 solucionar_solicitud_zona' style='margin-top:15px;'>"+textoBoton+"</span>"+
                      "</div>";
      }
      else{
        retorno.solicitud = "No hay solicitud de cambio de zona pendiente";
        retorno.botones = "<span value='"+mue.id+"' class='btn span1 cerrar_flag_zona'>Cerrar</span>"
      }
      return retorno;
    }
    //Imprime la tabla en funcion de los datos entregados
    var exitoEnElIf = function exitoEnElIf(data){      
        cargo_usuario = data[0];
        zonas = data[1];
        postulantes = data[2];        
        paginacion = data[3];
        vaciarTabla();
        limpiarTabla();
        imprimirCabeceraDeTabla();
        generarPaginacion();                
        $.each(postulantes, function(i, mue) {            
            imprimirVoluntario(i,mue);            
        });
        listenersVoluntario();        
    }
    var imprimirTabla = function imprimirTabla(){
        recargarInformacion();
        $.get(routing.url_for('usuario', 'AjaxGetMUEdeEstadoYMision'), { mision_id: mision, estado_id:estado, flag_id:flag, pagina:pagina},
        function(data){                
            if(data!='' & data[2]!=''){                
                exitoEnElIf(data);
            }
            else{ 
                $("#paginacion").children().remove();
                $("#aciones_y_botones").hide();
                $("#info_tabla_vacia").show();
                $("#info_tabla_vacia").html("<br/>La tabla no contiene resultados con los filtro actuales<br/><br/>");
            }
            $("head").append("<script type='text/javascript' src='"+routing.public_path('js/postulantes.js')+"'></script>");
        }, "json");
    }
    var initEventos = function initEventos(){
        $("#misiones_postulantes").change(function () {
            $('#pagina').val(1);
            imprimirTabla();
        });   
        $("#estados_postulantes").change(function () {
            $('#pagina').val(1);
            imprimirTabla();
        });    
        $("#flag_postulante").change(function () {
            $('#pagina').val(1);
            imprimirTabla();
        });    
        $("#info_tabla_vacia").hide();    
        $(".guardar_cambios").click(function () {
            guardar_cambios_muec();
        });
    }
    //Metodos publicos
    return{
        init: function init(){
            imprimirTabla();
            initEventos();
        }
    }
})();
        
    $(function(){    
        gestorTablaVoluntarios.init();
        postulantesManager.init();
    });
        
function guardar_cambios_muec(){
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
    $.get(routing.url_for('usuario', 'AjaxEditarInscritos'), { selected:selected, mision_nueva:mision_nueva,cargo_nuevo:cargo_nuevo,estado_nuevo:estado_nuevo,cuota_nueva:cuota_nueva},
    function(data){
        if(data==1){}
        else if(data==0){}
    });
}

function guardar_cambios_flag_zona(id){
    $("#"+id+"_remove_flag_zona_button").show();
    $("#"+id+"_solucionar_solicitud_zona").show();
    $("#"+id+"_guardar_flag_zona_button").html('Guardar Cambios');
    var text =$("#"+id+"_text_zona").val();
    $.get(routing.url_for('usuario','AjaxEditarFlagZona'), { uem_id:id,descripcion:text},
    function(data){
        if(data==1){}
        else if(data==0){}
    });
    $("#"+id+"_flag_zona").removeClass("icon-headphones");
    $("#"+id+"_flag_zona").addClass("icon-flag");

    $("#"+id+"_modal_zona").css("visibility","hidden");
    $("#"+id+"_modal_zona").modal('hide');
}
function guardar_cambios_flag_cuota(id){
    $("#"+id+"_remove_flag_cuota_button").show();
    $("#"+id+"_solucionar_solicitud_cuota").show();
    $("#"+id+"_guardar_flag_cuota_button").html('Guardar Cambios');
    var text =$("#"+id+"_text_cuota").val();
    $.get(routing.url_for('usuario', 'AjaxEditarFlagCuota'), { uem_id:id,descripcion:text},
    function(data){
        if(data==1){}
        else if(data==0){}
    });
    $("#"+id+"_flag_cuota").removeClass("icon-headphones");
    $("#"+id+"_flag_cuota").addClass("icon-flag");

    $("#"+id+"_modal_cuota").css("visibility","hidden");
    $("#"+id+"_modal_cuota").modal('hide');
}
function eliminar_flag_zona(id){ 
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
function eliminar_flag_cuota(id){ 
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
function cerrar_flag_zona(id){
    $("#"+id+"_modal_zona").css("visibility","hidden");
    $("#"+id+"_modal_zona").modal('hide');
}

function cerrar_flag_cuota(id){
    $("#"+id+"_modal_cuota").css("visibility","hidden");
    $("#"+id+"_modal_cuota").modal('hide');
}

function cerrar_info_usuario(id){
    $("#"+id+"_modal_usuario").css("visibility","hidden");
    $("#"+id+"_modal_usuario").modal('hide');
}

function toString(data){
    var valor = "";
    if(data != null && data != "undefined"){
        valor = data;
    }
    return valor;
}
function getAge(dateString){
    var today = new Date();
    var birthDate = new Date(dateString.substr(0,dateString.indexOf(' ')));
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}
function fechaValida(dia, mes, ano) {
	var estado = true;	 	
	switch (parseInt(mes)) { 
		case 1:dmax = 31;break; 
		case 2: 
			if (ano % 4 == 0) dmax = 29; 
			else dmax = 28; 
			break; 
		case 3:dmax = 31;break; 
		case 4:dmax = 30;break; 
		case 5:dmax = 31;break; 
		case 6:dmax = 30;break; 
		case 7:dmax = 31;break; 
		case 8:dmax = 31;break; 
		case 9:dmax = 30;break; 
		case 10:dmax = 31;break; 
		case 11:dmax = 30;break; 
		case 12:dmax = 31;break; 
	} 
	if(dia > dmax){
		estado = false;
	}
	return estado;
}