$(document).ready(function($){
	$(function()
	{ 
	   
	   var comentario_actual_id=-1;  // Variable auxiliar para manejar los comentarios dentro del modal
	   var marker_actual_id = -1;    // Variable auxiliar para manejar los marcadores dentro del infowindow
	   
	    //Marcadores para los comentarios
	    var markers = [];
	
	    //Creamos el google map
	    var map = new google.maps.Map(document.getElementById('map'), {
	      zoom: 13,
	      center: new google.maps.LatLng($("#latitud").text(), $("#longitud").text()),
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    });
	    
	    $("#map_tab").click(function(){
	      setTimeout(function(){
	        google.maps.event.trigger(map, 'resize');
	        map.setCenter(new google.maps.LatLng($("#latitud").text(), $("#longitud").text()));
	      }
	      ,0.5);
	    });
	
	    //Variable de plugin para agrupar marcadores
	    var  markerCluster = new MarkerClusterer(map, null);
	
	    //Cargamos los marcadores pidiendo las localidades a traves de Ajax
	    cargarMarkers();
	    
	  //Infowindow, burbuja de informacion de marcadores
	  var infowindow = new google.maps.InfoWindow({
	      maxWidth: 600,
	      content: "Cargando..."
	  });  
	    
	    
	  //Funcion que trae los comentarios por ajax y los carga al mapa  
	  function cargarMarkers()
	  {
	      
	      $.get("../../AjaxGetComentarios",{id: $("#localidad_id").val()},
	      function(data){
	        jQuery.each(data['comentarios'], function(id, val) {
	          agregarMarcador(val);
	        });
	       
	
	      }, "json");
	  }
	  
	  //Agrega un marcador dado un comentario
	  function agregarMarcador(comentario)
	  {
	    //Tiene que tener latitud y longitud para poder agregar el marcador
	    if(comentario['latitud']== null || comentario['longitud']== null)
	      return;
	      
	    //Imagen del marcador del color correspondiente (dado por la BD) 
	    var image = getPinImage(comentario["PastoralTipoNecesidad"]["color"]);
	    
	    var mark = new google.maps.Marker({
	      position: new google.maps.LatLng(comentario['latitud'], comentario['longitud']),
	      map: map,
	      icon: image[0],
	      shadow: image[1],
	      title:comentario['descripcion'],
	      draggable: false
	    });
	    
	    markers[comentario['id']] = mark;
	    
	    google.maps.event.addListener(mark, 'click', function() {
	      marker_actual_id = $.inArray(mark, markers);
	      comentario_actual_id = comentario['id'];
	      infowindow.setOptions({maxWidth:600, content: "Cargando..."});
	      infowindow.open(map,mark);
	      $.get("../../AjaxGetComentario",{id: comentario['id']},
	        function(data){
	          infowindow.close();
	          var contentString = crearInfoWindowContent(data['comentario']);
	          infowindow.setOptions({maxWidth:600, content: contentString});
	          mark.setTitle(data['comentario']['descripcion']);
	          infowindow.open(map,mark);
	          
	      }, "json");
	      mark.setDraggable(true);
	      mark.setAnimation(google.maps.Animation.BOUNCE);
	    });
	    
	    //Por defecto al finalizar de hacer drag para la animacion, por eso se agrega este evento
	    google.maps.event.addListener(mark, 'dragend', function() {
	      mark.setDraggable(true);
	      mark.setAnimation(google.maps.Animation.BOUNCE);
	    });
	    
	    markerCluster.addMarker(mark);
	  }
	  
	  //Evento para cerrar la infowindow
	  google.maps.event.addListener(infowindow, 'closeclick', function() {
	    markers[marker_actual_id].setDraggable(false);
	    markers[marker_actual_id].setAnimation();
	    cerrarInfowindow();
	            
	  });
	  
	  //Evento cuando uno hace click sobre la simbologia para agregar nuevos comentarios al mapa
	  $(".simbolo_comentario").click(function(){
	    var comentario = {};
	    comentario['descripcion'] = "";
	    comentario['tipo'] = $(this).children(".nombre_tipo").text();
	    comentario['latitud'] = map.getCenter().lat();
	    comentario['longitud'] = map.getCenter().lng();
	    comentario['localidad_id'] = $('#localidad_id').val();
	    submitComentario(comentario);
	  });
	  
	  //iw: infowindow de los marcadores
	  $("#iw_guardar").live('click', function(){
	    
	    var comentario = {};
	    comentario['id'] = comentario_actual_id;
	    comentario['descripcion'] = $('#iw_comentario').val();
	    comentario['latitud'] = markers[marker_actual_id].getPosition().lat();
	    comentario['longitud'] = markers[marker_actual_id].getPosition().lng();
	    submitComentario(comentario);
	    cerrarInfowindow();
	  });
	  
	  $("#iw_borrar").live('click', function(){
	    borrarComentario(comentario_actual_id);
	    cerrarInfowindow();
	  });
	  
	  $("#iw_cerrar").live('click', function(){
	    cerrarInfowindow();
	  });
	  
	  function cerrarInfowindow()
	  {
	    markers[marker_actual_id].setDraggable(false);
	    markers[marker_actual_id].setAnimation();
	    infowindow.close();
	  }
	  
	  
	
	    $("#agregar_comentario_btn").live("click", function(){
	
	      comentario_actual_id = -1;
	      $('#comentario_text').val("");
	      $('#info_comentario_general').show();
	      $('#comentario_modal_title').text('Crear Comentario General');
	      
	    });
	    
	    $(".editar_comentario").live("click", function(){
	      comentario_actual_id = $(this).children(".comentario_id").val();
	      $('#comentario_text').val($(this).prev().text());
	      $('#comentario_modal_title').text('Editar Comentario');
	      $('#info_comentario_general').hide();
	    });
	    
	    $(".solucionar_comentario").live("click", function(){
	      var comentario_id = $(this).closest('tr').find(".comentario_id").val();  
	      solucionarComentario(comentario_id);
	    });
	    
	    $(".borrar_comentario").live("click", function(){
	      var comentario_id = $(this).closest('tr').find(".comentario_id").val();  
	      borrarComentario(comentario_id);
	    });
	    
	    $("#submit_comentario").click(function(){
	      var comentario = {};
	      comentario['id'] = comentario_actual_id;
	      comentario['descripcion'] = $('#comentario_text').val();
	      comentario['localidad_id'] = $('#localidad_id').val();
	      if($('#comentario_modal_title').text() == 'Crear Comentario General')
	        comentario['tipo'] = 'General';
	      submitComentario(comentario);
	    });
	    
	    
	    
	    $(".close_comentario_modal").click(function(){
	      $("#nuevo_comentario_modal").modal("hide");
	    });
	    
	    
	    function submitComentario(comentario)
	    {
	      if(comentario['id'] != -1 && comentario['id'] != null){
	        $.get("../../AjaxUpdateComentario", comentario,
	          function(data){
	            $fila = crearFilaComentario(data["comentario"]);
	            $(".comentario_id[value="+data['comentario']['id']+"]").closest("tr").replaceWith($fila);
	            $("#nuevo_comentario_modal").modal("hide");
	            markers[data['comentario']['id']].setTitle(data['comentario']['descripcion']);
	        }, "json");
	      }
	      else{
	        $.get("../../AjaxCrearComentario", comentario,
	          function(data){
	            $fila = crearFilaComentario(data["comentario"]);
	            $("#comentarios_table").children("tbody").prepend($fila);
	            $("#nuevo_comentario_modal").modal("hide");
	            if(data["comentario"]["latitud"] != null && data["comentario"]["longitud"] != null)
	            {
	              agregarMarcador(data["comentario"]);
	              google.maps.event.trigger(markers[data["comentario"]["id"]], 'click');
	            }
	        }, "json");
	      }
	    }
	    
	    function borrarComentario(id)
	    {
	      $.get("../../AjaxBorrarComentario", {id: id},
	        function(data){
	          $(".comentario_id[value="+data['comentario']['id']+"]").closest("tr").remove();
	          $("#nuevo_comentario_modal").modal("hide");
	          markerCluster.removeMarker(markers[id]);
	      }, "json");
	    }
	    
	    function solucionarComentario(id)
	    {
	      $.get("../../AjaxSolucionarComentario", {id: id},
	        function(data){
	          $fila = crearFilaHistorialComentario(data["comentario"]);
	          $("#historial_table").children("tbody").prepend($fila);
	          $(".comentario_id[value="+data['comentario']['id']+"]").closest("tr").remove();
	          $("#nuevo_comentario_modal").modal("hide");
	      }, "json");
	    }
	  
	  
	    //Marcador para el centro de la localidad
	    var marker = new google.maps.Marker({
	      position: map.getCenter(),
	      map: map,
	      title: 'Centro de la localidad',
	      draggable: false
	    });
	   
	   
	});
	
	
	function resetCrearComentarioForm()
	{
	  $('#comentario_text').val("");
	}
	
	//Recibe un comentario y devuelve una fila html con su contenido para la tabla de comentarios
	function crearFilaComentario(comentario)
	{
	  var $fila = "<tr>"+
	                "<td>"+comentario['PastoralTipoNecesidad']['nombre']+"</td>"+
	                "<td>"+comentario['updated_at']+"</td>"+
	                "<td>"+
	                  "<span class='comentario_descripcion'>"+comentario['descripcion']+"</span>"+
	                  "<a  data-toggle='modal' class='btn btn-mini right editar_comentario'"+
	                      "href='#nuevo_comentario_modal' title='Editar'>"+
	                      "<i class='icon-pencil'></i>"+
	                      "<input type='hidden' class='comentario_id' value='"+comentario['id']+"'/>"+
	                  "</a>"+
	                "</td>"+
	                "<td>"+
	                  "<ul class='no-mark pull-right'>"+
	                    "<li><button class='btn btn-mini solucionar_comentario' title='Solucionado'><i class='icon-ok'></i></button></li>"+
	                    "<li><button class='btn btn-mini borrar_comentario' title='Borrar'><i class='icon-remove'></i></button></li>"+
	                  "</ul>"+
	                "</td>"+
	              "</tr>";
	  return $fila;
	}
	
	
	//Recibe un comentario y devuelve una fila html con su contenido para la tabla de historial
	function crearFilaHistorialComentario(comentario)
	{
	  var $fila =  "<tr>"+
	                  "<td>"+comentario["PastoralTipoNecesidad"]["nombre"]+"</td>"+
	                  "<td>"+comentario['updated_at']+"</td>"+
	                  "<td>"+
	                    "<span class='comentario_descripcion'>"+
	                      comentario['descripcion']+
	                    "</span>"+
	                  "</td>"+
	                  "<td></td>"+
	                "</tr>";
	  return $fila;
	}
	
	//Recibe un comentario y devuelve el form del infowindow del mapa
	function crearInfoWindowContent(comentario)
	{
	  var $content = '<div class="infowindow">'+
	                    '<h3>'+comentario["PastoralTipoNecesidad"]["nombre"]+'</h3>'+  
	                    '<p><label>Comentario: </label></p>'+
	                    '<p><textarea type="text" id="iw_comentario" >'+comentario['descripcion']+'</textarea>'+
	                    '</p>'+ 
	                    '<button class="btn" id="iw_cerrar">Cancelar</button>'+ 
	                    '<button class="btn btn-danger" id="iw_borrar">Borrar</button>'+                      
	                    '<button class="btn btn-success" id="iw_guardar">Guardar</button>'+
	                  '</div>'
	                  ;
	  return $content;
	}
	
	//Funcion que devuelve una imagen y su sombra segun el color (hexagesimal) que uno le pase
	function getPinImage(pinColor)
	{
	
	  var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
	      new google.maps.Size(21, 34),
	      new google.maps.Point(0,0),
	      new google.maps.Point(10, 34));
	  var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
	      new google.maps.Size(40, 37),
	      new google.maps.Point(0, 0),
	      new google.maps.Point(12, 35));
	      
	  var image = [pinImage, pinShadow];
	  return image;
	  
	}
});