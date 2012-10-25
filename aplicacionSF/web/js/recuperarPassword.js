$(document).ready(function($){
	$(function(){
	
	  $('#rut').Rut({
	    on_error: function(){
	      if(!$("#rut_error").text())
	        $('#rut').parent().before("<span id='rut_error'>Rut invalido.</span>"); 
	    },
	    on_success: function(){
	        $("#rut_error").remove(); 
	    }
	    
	  });
	  
	  $("#enviar_password").click(function(){
	  
	    if($('#rut').val()!="" && !$.Rut.validar($('#rut').val()))
	      return;
	  
	    $("#enviar_password").attr('disabled', 'disabled');
	    $("#enviar_password").text('Enviando...');
	    $.get("AjaxPasswordReset",{ rut: $('#rut').val(), email: $('#email').val()},
	      function(data){
	        $("#enviar_password").text('Enviar contrase\u00f1a');
	        $("#enviar_password").removeAttr('disabled');
	        if(data['status'] == 'success')
	        {
	            $("#contenido").prepend("<div class='alert alert-success span5'>"+  
	                                      "<a class='close' data-dismiss='alert'>x</a>"+  
	                                      "Te hemos enviado un email con tu nueva contrase&ntilde;a."+
	                                  "</div>");
	        }
	        else
	        {
	             $("#contenido").prepend("<div class='alert alert-danger span5'>"+  
	                                      "<a class='close' data-dismiss='alert'>x</a>"+  
	                                      "No aparecen tus datos en nuestros registros."+
	                                  "</div>");
	        }
	    }, "json");
	    
	  });   
	}); 
});
