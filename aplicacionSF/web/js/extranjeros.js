$(document).ready(function($){
	$(function(){
	
	    $("tr:even").addClass('even');
	    $("tr:odd").addClass('odd');
	    
	
	    $(".solucionar_solicitud_cuota").click(function(){
	        var id = this.getAttribute('value');
	        var cuota = $("#"+id+"_cuota_nueva_module").val();
	        $.get('AjaxSetMueCuota', { id: id, cuota:cuota},
	            function(data){
	            if(data ==1)
	            {
	              $("#"+id+"_cuota_en_tabla").html(cuota);
	              eliminar_flag_cuota(id);
	            }
	        });
	    });
	    
	    $(".solucionar_solicitud_zona").click(function(){
	        var id = this.getAttribute('value');
	        var selected = $('#mision_nueva_modal_'+id+' option:selected');
	        var zona_id = selected.val();
	        $.get('AjaxSetMueZona', { id: id, zona_id:zona_id},
	            function(data){
	            if(data ==1)
	            {
	              $("#"+id+"_zona_en_tabla").html(selected.html());
	              eliminar_flag_zona(id);
	            }
	        });
	    });
	    
	    $(".show_info_usuarios").click(function(){
	        crear_modal(this.getAttribute('value'),$("#info_usuarios"),this.getAttribute('mue'));
	        show_info_usuarios(this.getAttribute('value'));
	    });
	    
	    $(".cerrar_info_usuario").click(function(){
	        cerrar_info_usuario(this.getAttribute('value'));
	    });
	    
	    $(".even").css("background-color","#f9f9f9");
	    $(".even").hover(function() {$(this).css("background-color","#CCFFCC");},function(){$(this).css("background-color","#f9f9f9");});
	    $(".odd ").hover(function() {$(this).css("background-color","#CCFFCC");},function(){$(this).css("background-color","transparent");});
	
	    hide_div($(".acciones_seleccionados"));
	   
	    $("td :checkbox").change(function check_change() {
	        if($(":checkbox:checked").length > 0){
	           show_div($(".acciones_seleccionados"));
	        }else{
	           hide_div($(".acciones_seleccionados"));
	        }
	        var tr =  $(this).parent().parent();
	        if($(this).is(':checked'))
	        {
	           tr.css("background-color","#ffcc99");
	           tr.unbind('mouseenter mouseleave');  
	        }
	        else
	        {
	          if(tr.hasClass("even"))
	           {
	              tr.hover(function() {tr.css("background-color","#CCFFCC");},function(){tr.css("background-color","#f9f9f9");});
	           }
	           else
	           {
	              tr.hover(function() {tr.css("background-color","#CCFFCC");},function(){tr.css("background-color","#ffffff");});
	           }
	        }
	    });
	    
	    $(".select_all").click(function() {
	        $("td :checkbox").prop("checked", true);
	        $("td :checkbox").parent().parent().css("background-color","#ffcc99");
	        $(".even").unbind('mouseenter mouseleave');  
	        $(".odd").unbind('mouseenter mouseleave');  
	        show_div($(".acciones_seleccionados"));
	    });
	
	    $(".select_none").click(function() {
	        $("td :checkbox").prop("checked", false);
	        $(".even").css("background-color","#f9f9f9");
	        $(".odd").css("background-color","transparent");
	        $(".even").hover(function() {$(this).css("background-color","#CCFFCC");},function(){$(this).css("background-color","#f9f9f9");});
	        $(".odd ").hover(function() {$(this).css("background-color","#CCFFCC");},function(){$(this).css("background-color","transparent");});
	        hide_div($(".acciones_seleccionados"));
	    });
	});
	
	function show_div(element)
	{
	    element.css('visibility','visible')
	    element.animate({opacity:1});
	}
	
	function hide_div(element)
	{
	    element.animate({opacity:0});
	    element.css('visibility','hidden')
	}
});