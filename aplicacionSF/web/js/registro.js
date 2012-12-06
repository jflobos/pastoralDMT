$(function(){	
    ocultarInstituciones();
    mostrarInstituciones($("#pastoral_usuario_tipo_institucion_id option:selected").text());
   
    $("#pastoral_usuario_es_extranjero").change(function(){
        if(this.checked){
            $("#pastoral_usuario_rut").val("");
            $("#pastoral_usuario_rut").attr("disabled","disabled");
            $("#pastoral_usuario_region_id").attr("disabled","disabled");
            $("#autocomplete_pastoral_usuario_comuna_id").attr("disabled","disabled");
            $("#pastoral_usuario_direccion").attr("disabled","disabled");
            $("#pastoral_usuario_universidad_id").attr("disabled","disabled");
            $("#autocomplete_pastoral_usuario_colegio_id").attr("disabled","disabled");
            if($("#rut_error").text())
                $("#rut_error").remove();      
        }
        else{
            $("#pastoral_usuario_rut").removeAttr("disabled");
            $("#pastoral_usuario_region_id").removeAttr("disabled");
            $("#autocomplete_pastoral_usuario_comuna_id").removeAttr("disabled");
            $("#pastoral_usuario_direccion").removeAttr("disabled");
            $("#pastoral_usuario_tipo_institucion_id").removeAttr("disabled");
        }
    });
  
    $("#pastoral_usuario_rut").click(function(){
        if($("#pastoral_usuario_es_extranjero").is(':checked')){
            $("#pastoral_usuario_es_extranjero").removeAttr("checked");
        }
    });
    
   
    $("#pastoral_usuario_tipo_institucion_id").change(function () {
        ocultarInstituciones();
        var tipo_institucion = $("#pastoral_usuario_tipo_institucion_id option:selected").text();
        if(tipo_institucion == "Universidad"){
            mostrarInstituciones("Colegio");
        }
        mostrarInstituciones(tipo_institucion);
    });
   
    $('#pastoral_usuario_rut').Rut({
        on_error: function(){
            if(!$("#rut_error").text())
                $('#pastoral_usuario_rut').parent().append("<span id='rut_error'>Rut invalido.</span>"); 
        },
        on_success: function(){
            $("#rut_error").remove(); 
        }    
    });
}); 


function ocultarInstituciones(){
    $('#pastoral_usuario_universidad_id').parent().parent().hide();
    $('#pastoral_usuario_carrera_id').parent().parent().hide();
    $('#pastoral_usuario_ano_ingreso').parent().parent().hide();
    $('#pastoral_usuario_colegio_id').parent().parent().hide();
    $('.aux').remove();
}

function mostrarInstituciones( tipo_institucion ){
    if(tipo_institucion == "Universidad"){
        $('#pastoral_usuario_universidad_id').parent().parent().show();
        $('#pastoral_usuario_carrera_id').parent().parent().show();
        $('#pastoral_usuario_ano_ingreso').parent().parent().show();
        $('#pastoral_usuario_ano_ingreso').parent().parent().after('<tr class ="aux"></tr>');
    }
    else if(tipo_institucion == "Colegio"){
        $('#pastoral_usuario_ano_ingreso').parent().parent().after('<tr class ="aux"></tr>');
        $('#pastoral_usuario_colegio_id').parent().parent().show();
    }
}

function validarFormulario(){
    var error = false;
    if($('#pastoral_usuario_es_extranjero').attr('checked') == undefined){
    $("#modal_error_body").empty();
    if($("#pastoral_usuario_comuna_id").val() == ""){
        error = true;
        $("#autocomplete_pastoral_usuario_comuna_id").parent().parent().addClass('error');
        $("#modal_error_body").append('<p><b>Comuna:</b></p><p>No has seleccionado ninguna comuna, por favor elige una de entre la opciones de la lista desplegable.</p>')
    }
    switch($("#pastoral_usuario_tipo_institucion_id").val()){
        /*Universidad*/
        case "1":
            if($("#pastoral_usuario_colegio_id").val() == ""){
                $("#autocomplete_pastoral_usuario_colegio_id").parent().parent().addClass('error');
                $("#modal_error_body").append('<p><b>Colegio:</b></p><p>No has seleccionado ning&uacute;n colegio, por favor elige alguno de la lista desplegable.</p>')
                error = true;
            }  
            break;
            /*Colegio*/
        case "2":
            if($("#pastoral_usuario_colegio_id").val() == ""){
                $("#autocomplete_pastoral_usuario_colegio_id").parent().parent().addClass('error');
                $("#modal_error_body").append('<p><b>Colegio:</b></p><p>No has seleccionado ning&uacute;n colegio, por favor elige alguno de la lista desplegable.</p>')
                error = true;
            }  
            break;
        /*Otro*/
        case "3":
            break;
            default:
                $("#pastoral_usuario_tipo_institucion_id").parent().parent().addClass('error');
                $("#modal_error_body").append('<p><b>Tipo de Instituci&oacute;n de Estudios:</b></p><p>Debes indicar el tipo de instituci&oacute;n a la que vas.</p>')
                error = true;
                break;
        }

        if($("#pastoral_usuario_comuna_id").val() == ""){
            error = true;
            $("#autocomplete_pastoral_usuario_comuna_id").parent().parent().addClass('error');
        }

        if($("#rut_error").text()){
            error = true;    
        }	  
    }
    if(!error){
        $('form').submit();
    }
    if(error){
        $("#modal_launcher").click();
    }
}