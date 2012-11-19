$(document).ready(function($) {

    $(".max3f :checkbox").click(function() {
        checkCheckboxes();
    });
    
    $(".max3m :checkbox").click(function() {
        checkCheckboxes();
    });
    
    $(".guardar_comentarios_usuario").click(function() {
      var mue_id = this.getAttribute("value");
      var descripcion = $("#textarea_"+mue_id).val();
      $.get(routing.url_for('usuario', 'AjaxEditarEvalDescripcion'), { mue_id:mue_id,descripcion:descripcion},
        function(data){
        });
    });
    
    $('.con_enviar').click(function() {
        enviarSolicitud();
    });
    
    $("#mensaje_enviado").hide();
    
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

function enviarSolicitud()
{
  var recomendado = $('input:checkbox[name=recomiendo]:checked').map(function () {
  return this.value;
  }).get();
  $.get(routing.url_for('usuario', 'AjaxEditarCoEvaluacion'), {recomendado:recomendado},
  function(data){
          if(data==1){
          $("#mensaje_enviado").html('<br/>Su evaluaci&oacute;n ha sido enviada exitosamente<br/><br/>');
          $("#mensaje_enviado").show();
          $("input[name=recomiendo]").attr('disabled', 'disabled');
          $('.con_enviar').hide();
        }else{
          $("#mensaje_enviado").html('<br/>Su evaluaci&oacute;n no se ha podido mandar<br/><br/>');
          $("#mensaje_enviado").show();
        }
  });
}