$(document).ready(function($){

  cambioIndexDeProyecto();
  
  $("#pastoral_mision_localidad_fantasia_id").change(function () {  
      cambioIndexDeSector();  
    });
    
  $("#pastoral_mision_grupo_id").change(function () {  
      cambioIndexDeGrupo();  
      
    });
    
   $(".chzn-results").children().mouseover(function(){
    var chzn_id = $(this).attr("id");
    var position = chzn_id.substring("12"); //el id es del tipo jefe_chzn_o_1 (hay que eliminar los primeros 12 caracteres)
    var nombre = $("#jefe option:eq("+position+")").text();
    var id = $("#jefe option:eq("+position+")").val();
    var element = $(this);
    $.get(routing.url_for('usuario/AjaxGetUserInformation'), {usuario_id : id},
      function(data){
        element.unbind('mouseover');
        element.popover({
          title: data['nombre']+" "+data['apellido_paterno']+" "+data['apellido_materno'],
          content: "<ul class='no-mark'>"+
                    "<li><strong>Colegio/Universidad:</strong> "+data['colegio_universidad']+"</li>"+
                    "<li><strong>Carrera:</strong> "+data['carrera']+"</li>"+
                    "<li><strong>Edad:</strong> "+data['edad']+"</li>"+
                   "</ul>"
        });
        if( element.hasClass('highlighted') )
          element.popover('show');
      }, "json"
    );
  });

});

function cambioIndexDeSector()
{
    document.getElementById('pastoral_mision_localidad_id').options.length = 0;
    var localidad_fantasia_id = $('#pastoral_mision_localidad_fantasia_id').val();   
   
    $.get(routing.url_for('mision','AjaxSectorCambio'), { sector_id: localidad_fantasia_id},
        function(data){
            data = jQuery.parseJSON(data);
            $("#pastoral_mision_localidad_id").append($("<option value=''>"+data[0]+"</option>"));
            for(var i=1;i<data.length;i++)
            {                
                $("#pastoral_mision_localidad_id").append($("<option value="+data[i+1]+">"+data[i]+"</option>"));
                i++;         
            }
        });
}

function cambioIndexDeProyecto()
{
    
    var proyecto_version = $('#pastoral_mision_proyecto_version_id').val();
    var a = document.getElementById("pastoral_mision_grupo_id");
    var grupo_id = a.options[a.selectedIndex].value;
    document.getElementById('pastoral_mision_grupo_id').options.length = 0;
    $.get(routing.url_for('mision','AjaxProyectoCambio'), { proyecto_version_id: proyecto_version},
        function(data){
            data = jQuery.parseJSON(data);
            for(var i=0;i<data.length;i++)
            {
                var selec = '';
                if(grupo_id == data[i+1])
                  selec = 'selected = selected';
                $("#pastoral_mision_grupo_id").append($("<option "+selec+" value="+data[i+1]+">"+data[i]+"</option>"));
                i++;         
            }
        });
}

function cambioIndexDeGrupo()
{
    var grupo = $('#pastoral_mision_grupo_id').val();
    $.get(routing.url_for('mision','AjaxGrupoCambio'), { grupo_id: grupo},
        function(data){
            data = jQuery.parseJSON(data);            
            document.getElementById("pastoral_mision_cuota").value = data[0];
            if(data[1]==null)
              document.getElementById("pastoral_mision_fecha_inicio").value = '';
            else
              document.getElementById("pastoral_mision_fecha_inicio").value = data[1];
            if(data[2]==null)
              document.getElementById("pastoral_mision_fecha_termino").value = '';
            else
              document.getElementById("pastoral_mision_fecha_termino").value = data[2];           
        });
}

