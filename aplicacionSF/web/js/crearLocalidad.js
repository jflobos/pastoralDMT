$(document).ready(function($){
	$(function()
	{  
	
	    //Marcadores para las localidades
	    var markers = [];
	
	    //Creamos el google map
	    var map = new google.maps.Map(document.getElementById('map'), {
	      zoom: 4,
	      center: new google.maps.LatLng(-33.52307916495625, -70.59814414062498),
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    });
	
	    //Plugin para agrupar marcadores
	    var markerCluster;
	    
	    //Cargamos los marcadores pidiendo las localidades a traves de Ajax
	    cargarMarkers();
	    
	    
	    //Marcador para crear una nueva localidad
	    var marker = new google.maps.Marker({
	      position: map.getCenter(),
	      map: map,
	      title: 'Nueva Localidad',
	      draggable: true
	    });
	    
	    //Cada vez que muevan el marcador de nueva localidad 
	    google.maps.event.addListener(marker, 'position_changed', function() {
	      actualizarCoords();
	    });
	    
	    //Creamos un geocoder para realizar busquedas
	    var geocoder = new google.maps.Geocoder();
	    
	    //Evitamos que al apretar enter en el field de busqueda se haga submit del form
	    $("form").bind("keypress", function(e) {
	
	      var c = e.which ? e.which : e.keyCode;
	    
	      if (c == 13) {
	          var $targ = $(e.target);
	
	          if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
	              var focusNext = false;
	              $(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
	                  if (this === e.target) {
	                      focusNext = true;
	                  }
	                  else if (focusNext){
	                      $(this).focus();
	                      return false;
	                  }
	              });
	
	              return false;
	          }
	      }
	
	    });
	    
	    //Realizamos la busqueda si es que apreto "enter" dentro del field para buscar
	    $("#buscarText").keypress(function(e){
	      var c = e.which ? e.which : e.keyCode;
	      if(c == 13){
	          buscar();
	      }
	    });
	    
	
	    
	    //O si apreto el boton "buscar"
	    $("#buscarButton").click(function(){
	        buscar();
	    });
	    
	    function buscar()
	    {
	      geocoder.geocode(
	            {'address': $("#buscarText").val()+", Chile"}, 
	            function(results, status) { 
	                if (status == google.maps.GeocoderStatus.OK) { 
	                    var loc = results[0].geometry.location;
	                    map.setCenter(loc);
	                    map.setZoom(13);
	                    marker.setPosition(loc);
	                    actualizarCoords();
	                } 
	                else {
	                    alert("No encontrado: " + status); 
	                } 
	            }
	       );
	    }
	    
	    //Ponemos placeholder al field del nombre
	    $("#pastoral_localidad_nombre").attr("placeholder", "Escriba el nombre de la localidad");
	    
	    //Funcion que actualiza los fields de coordenadas segun la posicion del marcador. Esta adentro de este scope para
	    //no tener que pasar marker como referencia
	    function actualizarCoords()
	    {
	      $('#pastoral_localidad_latitud').val(marker.getPosition().lat());
	      $('#pastoral_localidad_longitud').val(marker.getPosition().lng());
	    }
	
	    //Hanfler de cuando hacen click en el boton para centrar el marcador. Este habilita los campos si es que estan
	    //deshabilitados y hace visible el marcador en el centro.
	    $("#centrarButton").click(function(e){
	        e.preventDefault();
	        
	        moverMarkerAlCentro();
	        marker.setVisible(true);
	        resetCampos();
	        
	    });
	    
	    function moverMarkerAlCentro()
	    {
	      marker.setPosition(map.getCenter());
	      actualizarCoords();
	      
	    }
	    
	  // -------------- Nueva Localidad de Fantasia --------------------  
	    
	
	  init();
	  
	  $('#agregar_sector').click(function(){
	    showSector(); 
	  });
	  
	  $('#cerrar_sector').click(function(){
	    hideSector();
	  });
	  
	  
	  //Retorna true si hay localidades a menos de 5 km del marcador de "nueva localidad", false en caso contrario
	  function comprobarLocalidadesCercanas()
	  {
	    var hayCercanas = false;
	    $.each(markers, function(key, value) {
	      var distance = google.maps.geometry.spherical.computeDistanceBetween (value.getPosition(), marker.getPosition());
	      if(distance < 5000)
	      {
	        hayCercanas = true;
	      }
	    });
	    
	    return hayCercanas;
	  }
	  
	  //Al hacer submit, muestra un mensaje de confirmacion si es que hay localidades cercanas a la creada.
	  $("#submit_localidad").click(function(e)
	  {
	    if(marker.getVisible() && comprobarLocalidadesCercanas())
	    {
	      e.preventDefault();
	      bootbox.dialog("Al parecer hay localidades creadas a menos de 5km, &iquest;deseas de todas maneras crear una nueva?", [{
	          "label" : "S&iacute! Es necesario",
	          "class" : "btn-success",
	          "callback": function() {
	              $("form").submit();
	          }
	      }, {
	          "label" : "Cancelar",
	          "class" : "btn-danger",
	          "callback": function() {
	             
	          }
	      }]);
	    }
	    else
	    {
	      $("form").submit();
	    }
	    
	  });
	  
	  
	  //Carga los marcadores de las localidades, poniendole handlers a los del sector de la mision para poder clickiarlos.
	  function cargarMarkers()
	  {
	     $.get('AjaxGetLocalidades',{},
	      function(data){
	        var image = getPinImage("7569FE");
	        var maxLoc = [-1000, -1000];
	        var minLoc = [1000, 1000];
	        jQuery.each(data, function(id, val) {
	          var mark = new google.maps.Marker({
	            position: new google.maps.LatLng(val['latitud'], val['longitud']),
	            map: map,
	            icon: image[0],
	            shadow: image[1],
	            title: val['nombre']
	          });
	          
	          
	          if(val['localidad_fantasia_id']==$("#sector_id").val())
	          {
	            //Usamos marcadores verdes para localidades del mismo sector de la zona
	            var imageGreen = getPinImage("75FE69");
	            mark.setIcon(imageGreen[0]);
	            mark.setShadow(imageGreen[1]);
	            
	            google.maps.event.addListener(mark, 'click', function() {
	              rellenarCampos(val);
	              marker.setVisible(false);
	              map.panTo(mark.getPosition());
	            });
	            
	            //Si es que ya había elegido una localidad, parte seleccionada.
	            if($("#localidad_id").val() == val['id'])
	            {
	              rellenarCampos(val);
	              marker.setVisible(false);
	              map.setCenter(mark.getPosition());
	              map.setZoom(13);
	            }
	            
	            //Queremos determinar el centro de los marcadores del sector
	            if(mark.getPosition().lat() > maxLoc[0])
	              maxLoc[0] = mark.getPosition().lat();
	            if(mark.getPosition().lat() < minLoc[0])
	              minLoc[0] = mark.getPosition().lat();
	            if(mark.getPosition().lng() > maxLoc[1])
	              maxLoc[1] = mark.getPosition().lng();
	            if(mark.getPosition().lng() < minLoc[1])
	              minLoc[1] = mark.getPosition().lng();
	          }
	          
	          
	          markers.push(mark);
	        });
	        
	        //Centramos el mapa al centro de las localidades del sector al que pertenece la zona
	        if(maxLoc[0]!=-1000 && $("#localidad_id").val() == -1)
	        {
	          var lat = (maxLoc[0]+minLoc[0])/2;
	          var lng = (maxLoc[1]+minLoc[1])/2;
	          
	          map.setCenter(new google.maps.LatLng(lat, lng));
	          map.setZoom(13);
	        }
	        
	        markerCluster = new MarkerClusterer(map, markers);
	
	      }, "json");
	  }
	  
	
	  
	  
	
	
	
	});
	
	//--------Funciones fuera del scope---------------
	
	
	function hideSector()
	{
	  $('#pastoral_localidad_localidad_fantasia_nombre').closest('.embedded').parent().parent().hide();
	  $('#pastoral_localidad_localidad_fantasia_esta_embebida').val('0');
	  $('#agregar_sector').removeAttr('disabled');
	  $('#pastoral_localidad_localidad_fantasia_id').removeAttr('disabled');
	}
	
	function showSector()
	{
	  $('#pastoral_localidad_localidad_fantasia_nombre').closest('.embedded').parent().parent().show();
	  $('#pastoral_localidad_localidad_fantasia_id').val('');
	  $('#pastoral_localidad_localidad_fantasia_esta_embebida').val('1');
	  $('#agregar_sector').attr('disabled', 'disabled');
	  $('#pastoral_localidad_localidad_fantasia_id').attr('disabled', 'disabled');
	}
	
	function init()
	{
	  $('#pastoral_localidad_localidad_fantasia_id').val($('#sector_id').val());
	  $('#pastoral_localidad_localidad_fantasia_id').attr('disabled', 'disabled');
	}
	
	//Funcion que devuelve una imagen y su sombra segun el color que uno le pase
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
	
	//Rellena los campos del formulario segun la localidad
	function rellenarCampos(localidad)
	{
	  $("#pastoral_localidad_nombre").val(localidad['nombre']);
	  $("#pastoral_localidad_localidad_fantasia_id").val(localidad['localidad_fantasia_id']);
	  $("#pastoral_localidad_latitud").val(localidad['latitud']);
	  $("#pastoral_localidad_longitud").val(localidad['longitud']);
	  $("#agregar_sector").attr("disabled", "disabled");
	  $("#localidad_id").val(localidad['id']);
	  
	  deshabilitarCampos();
	}
	
	function deshabilitarCampos()
	{
	  $("#pastoral_localidad_nombre").attr("disabled", "disabled");
	  $("#pastoral_localidad_localidad_fantasia_id").attr("disabled", "disabled");
	  $("#pastoral_localidad_latitud").attr("disabled", "disabled");
	  $("#pastoral_localidad_longitud").attr("disabled", "disabled");
	}
	
	//Vuelve a habilitar los campos para modificarlos.
	function resetCampos()
	{
	  $("#pastoral_localidad_nombre").val("");
	  $("#pastoral_localidad_nombre").removeAttr("disabled");
	  $("#pastoral_localidad_latitud").removeAttr("disabled");
	  $("#pastoral_localidad_longitud").removeAttr("disabled");
	  $("#localidad_id").val("-1");
	  
	}
});