$(document).ready(function($) {

    $("#mensaje_enviado").hide();
    
    $(".max3f :checkbox").click(function() {
        checkCheckboxes();
    });
    
    $(".max3m :checkbox").click(function() {
        checkCheckboxes();
    });
    
    $(".select_all").click(function() {
      $("input[name=asistio]").attr('checked', true);
    });
    
    $(".select_none").click(function() {
      $("input[name=asistio]").attr('checked', false);
    });
    
    $(".guardar_comentarios_usuario").click(function() {
      var mue_id = this.getAttribute("value");
      var descripcion = $("#textarea_"+mue_id).val();
      $.get(routing.url_for('usuario', 'AjaxEditarEvalDescripcion'), { mue_id:mue_id,descripcion:descripcion},
        function(data){
        });
    });
    
    $('.sin_enviar').click(function() {
        guardarCambios("0");
    });
    
    $('.con_enviar').click(function() {
        guardarCambios("1");
    });
    
    checkCheckboxes();
    
});

function checkCheckboxes()
{
  if($(".max3f :checkbox:checked").length >= 3) {
      $(".max3f :checkbox:not(:checked)").attr("disabled", "disabled");
  } else {
      $(".max3f :checkbox").removeAttr("disabled");
  }
  
  if($(".max3m :checkbox:checked").length >= 3) {
      $(".max3m :checkbox:not(:checked)").attr("disabled", "disabled");
  } else {
      $(".max3m :checkbox").removeAttr("disabled");
  }
}

function guardarCambios(enviar)
{
  var asistio = $('input:checkbox[name=asistio]:checked').map(function () {
  return([this.value]);
  }).get();
  
  var recomendado = $('input:checkbox[name=recomiendo]:checked').map(function () {
  return this.value;
  }).get();
  
  var no_asistio = $('input:checkbox[name=asistio]:not(:checked)').map(function () {
  return this.value;
  }).get();
  
  var no_recomendado = $('input:checkbox[name=recomiendo]:not(:checked)').map(function () {
  return this.value;
  }).get();
  $.get(routing.url_for('usuario', 'AjaxEditarEvaluacion'), { asistio:asistio, recomendado:recomendado ,no_asistio:no_asistio, no_recomendado:no_recomendado, enviar:enviar},
  function(data){
        if(data==1){
          $("#mensaje_enviado").show();
          if(enviar == "1")
          {
              $("#mensaje_enviado").html('<br/>Su evaluaci&oacute;n ha sido enviada exitosamente<br/><br/>');
              $("input[name=asistio]").attr('disabled', 'disabled');
              $("input[name=recomiendo]").attr('disabled', 'disabled');
              $('.sin_enviar').hide();
              $('.con_enviar').hide();
          }
          else{
              $("#mensaje_enviado").html('<br/>Su evaluaci&oacute;n ha sido guardada exitosamente<br/><br/>');
          }
        }else{
          $("#mensaje_enviado").html('<br/>Su evaluaci&oacute;n no se ha podido mandar<br/><br/>');
          $("#mensaje_enviado").show();
        }
  });

}