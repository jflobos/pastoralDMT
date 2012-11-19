var postulantesManager = (function()
{
    return {
        init: function(){
            $("#cambio_cuota_inmediata").click(function(){
                var id = $("#cuota_modal_instantaneas").attr('value');
                var cuota = $("#cuota_nueva_inmediata").val();
                $.get(routing.url_for('usuario','AjaxSetMueCuota'), { id: id, cuota:cuota},
                    function(data){
                    if(data ==1)
                      $("#"+id+"_cuota_en_tabla span").html(cuota);
                });    
                $("#cuota_modal_instantaneas").modal('hide');
            });    

            $("#cambio_estado_inmediata").click(function(){
                var id = $("#estados_modal_instantaneas").attr('value');
                var estado = $("#estados_instantaneas option:selected").val();
                $.get(routing.url_for('usuario', 'AjaxSetMueEstado'), { id: id, estado:estado},
                    function(data){
                    if(data ==1)
                      $("#"+id+"_estado_en_tabla span").html($("#estados_instantaneas option:selected").html());
                });    
                $("#estados_modal_instantaneas").modal('hide');
            });

            $("#cambio_cargo_inmediata").click(function(){
                var id = $("#cargos_modal_instantaneas").attr('value');
                var cargo = $("#cargos_instantaneas option:selected").val();
                $.get(routing.url_for('usuario', 'AjaxSetMueCargo'), { id: id, cargo:cargo},
                    function(data){
                    if(data ==1)
                      $("#"+id+"_cargo_en_tabla span").html($("#cargos_instantaneas option:selected").html());
                });    
                $("#cargos_modal_instantaneas").modal('hide');
            });

            $("#cambio_zona_inmediata").click(function(){
                var id = $("#misiones_modal_instantaneas").attr('value');
                var zona= $("#misiones_instantaneas option:selected").val();
                $.get(routing.url_for('usuario', 'AjaxSetMueSoloZona'), { id: id, zona:zona},
                    function(data){
                    if(data ==1)
                      $("#"+id+"_zona_en_tabla span").html($("#misiones_instantaneas option:selected").html());
                });    
                $("#misiones_modal_instantaneas").modal('hide');
            });
            $(".cambio_cuota_inmediato").click(function(){
                cuota = this.getAttribute('cuota');
                mue = this.getAttribute('value');
                $("#cuota_modal_instantaneas").attr('value',mue);
                $("#cuota_nueva_inmediata").val(cuota);
                $("#cuota_modal_instantaneas").modal('show');
            });
            $(".cambio_zona_inmediato").click(function(){
                mue = this.getAttribute('value');
                $("#misiones_modal_instantaneas").attr('value',mue);
                $("#misiones_modal_instantaneas").modal('show');
            });
            $(".cambio_cargo_inmediato").click(function(){
                mue = this.getAttribute('value');
                $("#cargos_modal_instantaneas").attr('value',mue);
                $("#cargos_modal_instantaneas").modal('show');
            });
            $(".cambio_estado_inmediato").click(function(){
                mue = this.getAttribute('value');
                $("#estados_modal_instantaneas").attr('value',mue);
                $("#estados_modal_instantaneas").modal('show');
            }); 

            $(".solucionar_solicitud_cuota").click(function(){
                var id = this.getAttribute('value');
                var cuota = $("#"+id+"_cuota_nueva_module").val();
                $.get(routing.url_for('usuario', 'AjaxSetMueCuota'), { id: id, cuota:cuota},
                    function(data){
                    if(data ==1)
                    {
                      $("#"+id+"_cuota_en_tabla span").html(cuota);
                      eliminar_flag_cuota(id);
                    }
                });
            });

            $(".solucionar_solicitud_zona").click(function(){
                var id = this.getAttribute('value');
                var selected = $('#mision_nueva_modal_'+id+' option:selected');
                var zona_id = selected.val();
                $.get(routing.url_for('usuario', 'AjaxSetMueZona'), { id: id, zona_id:zona_id},
                    function(data){
                    if(data ==1)
                    {
                      $("#"+id+"_zona_en_tabla span").html(selected.html());
                      $("#"+id+"_cuota_en_tabla span").html(selected.attr('cuota'));
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

            $(".cerrar_flag_zona").click(function(){
                cerrar_flag_zona(this.getAttribute('value'));
            });

            $(".eliminar_flag_zona").click(function(){
                eliminar_flag_zona(this.getAttribute('value'));
            });

            $(".guardar_cambios_flag_zona").click(function(){
                guardar_cambios_flag_zona(this.getAttribute('value'));
            });

            $(".cerrar_flag_cuota").click(function(){
                cerrar_flag_cuota(this.getAttribute('value'));
            });

            $(".eliminar_flag_cuota").click(function(){
                eliminar_flag_cuota(this.getAttribute('value'));
            });

            $(".guardar_cambios_flag_cuota").click(function(){
                guardar_cambios_flag_cuota(this.getAttribute('value'));
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
                      tr.css("background-color","#f9f9f9");
                      tr.hover(function() {tr.css("background-color","#CCFFCC");},function(){tr.css("background-color","#f9f9f9");});
                   }
                   else
                   {
                      tr.css("background-color","transparent");
                      tr.hover(function() {tr.css("background-color","#CCFFCC");},function(){tr.css("background-color","#f9f9f9");});
                   }
                }
            });

            $(".download_excel").click(function(){
                var mision = $("#misiones_postulantes").val();
                var estado = $("#estados_postulantes").val();
                var flag = $("#flag_postulante").val();
                location.href = 'DownloadExcel?mision_id='+mision+';estado_id='+estado+';flag_id='+flag;
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

            $(".flag_zona").click(function () {
              change_flag_zona(this.getAttribute("value"));
            });

            $(".flag_cuota").click(function () {
              change_flag_cuota(this.getAttribute("value"));
            });
        }
    }
})();

$(window).load(function(){
    postulantesManager.init();
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

function change_flag_zona(id){
    $("#"+id+"_modal_zona").css("visibility","visible");
    $("#"+id+"_modal_zona").modal('show');
}    
    
function change_flag_cuota(id){
    $("#"+id+"_modal_cuota").css("visibility","visible");
    $("#"+id+"_modal_cuota").modal('show');
}