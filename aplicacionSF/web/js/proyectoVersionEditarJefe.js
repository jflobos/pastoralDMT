$(document).ready(function($){
	$(document).ready(function(){
	
	    $('#jefe_editar').chosen({no_results_text: "Error, no existe el campo indicado"});
	
	    $("#submit_editar_jefe").click(function (){    
	        var id_jefe_nuevo = $("#jefe_editar option:selected").val();
	        var id_jefe_viejo = document.getElementById('id_jefe_viejo').value;
	        var id_cargo = document.getElementById('id_cargo').value;
	        var id_proyecto = document.getElementById('id_proyecto').value;
	
	        $.get('AjaxEditarJefeInstancia', { id_nuevo: id_jefe_nuevo, id_viejo: id_jefe_viejo, cargo: id_cargo, proyecto: id_proyecto },
	        function(data){     
	            
	            window.location = "menuInstancia/id/"+id_proyecto;
	        
	        }, "json"); 
	    
	    });
	    
	    
	    $("#submit_eliminar_jefe").click(function (){    
	        var id_jefe = document.getElementById('id_jefe_viejo').value;
	        var id_cargo = document.getElementById('id_cargo').value;
	        var id_proyecto = document.getElementById('id_proyecto').value;
	
	        var seguro = confirmSubmit();
	        
	        if(seguro){
	            $.get('AjaxEliminarJefeInstancia', { id_j: id_jefe, cargo: id_cargo, proyecto: id_proyecto },
	            function(data){     
	            
	                window.location = "menuInstancia/id/"+id_proyecto;
	        
	            }, "json");
	        }  
	    
	    });
	    
	    // $('#jefe_editar option').mouseover(function(){
	          // alert('s');
	          //$('#selectedValue').val($('#jefe_editar option:selected').val());
	    // });
	    
	    // $("#jefe_editar").hover(function (e){
	       // var $target = $(e.target); 
	       // if($target.is('option')){
	           //$('#selectedValue').val($target.val());
	           // alert('si');
	       // }
	    // });
	    
	    $(".chzn-results").children().mouseover(function(){
	    var chzn_id = $(this).attr("id");
	    var position = chzn_id.substring("19"); //el id es del tipo jefe_chzn_o_1 (hay que eliminar los primeros 12 caracteres)
	    var nombre = $("#jefe_editar option:eq("+position+")").text();
	    var id = $("#jefe_editar option:eq("+position+")").val();
	    var element = $(this);
	    $.get('../usuario/AjaxGetUserInformation', {usuario_id : id},
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
	
	function confirmSubmit()
	{
	var agree=confirm("¿Seguro que desea eliminar a este usuario como jefe del proyecto?");
	if (agree)
		return true;
	else
		return false;
	}
});