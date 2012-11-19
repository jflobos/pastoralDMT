<div class="container-fluid">
  <div class="row-fluid row">
    <div class="span4">
      <div class="well sidebar-nav-fixed">
        <ul class="nav nav-stacked">
          <li class="nav-header">Salida</li> <!-- se pueden poner mas de estos para subcategorias -->
          <li>
            <select id = 'salidas' name ='salidas' class="btn">
              <option value= '-1'>&#8212;&#8212; Salida&#8212;&#8212;</option>
              <?php                  
               foreach($pastoral_misiones as $mision)
               {
                   echo '<option value=\''.$mision->getSalidaId().'\'>';  
                   echo $mision->getPastoralSalida()->getNombre();
                   echo '</option>';
               }                 
              ?>
              </select>
          </li>
          <li class="nav-header">Regi&oacute;n</li>
          <li>
            <div class="accordion" id="grupos" name="grupos">
            </div>
          </li>
        </ul>
      </div>
    </div>    
    <div class="span7 well" id="content_zonas">
      <img src="<?php echo public_path('images/inscripcion.png')?>" id="inscripcion_img" style="max-width: 400px;"/>             
      <div id='detalle-mision'>
        <div class="span5">
          <ul class="thumbnails" id="foto_localidad">
          </ul>
          <table class="table table-bordered table-striped" id="info_localidad"> 
            <tbody>
              <colgroup>
               <col class="span3">
              </colgroup>
            </tbody>
          </table>          
        </div>
      </div > 
    </div>
  </div>   
</div>
<script>    
    var viewZonas = (function(){
        //Variables
        var zonas, grupos, salidaActiva, zonasById;
        //Metodos privados
        //Carga de Info e inicializacion del DOM
        function getInfoZonasPorSalida(proyecto_id){            
            $.ajax({
                url: routing.url_for('zonas','getZonasPorSalidaJSON'), 
                data: {proyecto: proyecto_id} ,
                type: 'post',
                success: function(data){
                    zonas = data;
                    estructurarInfo();
                    fillDOMSalidas();                    
                    initializeListeners();
                }                
            });         
        }
        //Separa las regiones por lugar de salida
        function estructurarInfo(){
            grupos = Array();
            zonasById = Array();
            $.each(zonas, function(i, salida){
                grupos[salida.id] = Array();
                $.each(salida.PastoralMision,function(j, zona){
                    if(grupos[salida.id][zona.PastoralGrupo.id] == undefined){
                        grupos[salida.id][zona.PastoralGrupo.id] = zona.PastoralGrupo;
                        grupos[salida.id][zona.PastoralGrupo.id].zonas = Array();
                    }
                    grupos[salida.id][zona.PastoralGrupo.id].zonas[zona.id] = zona;
                    zonasById[zona.id] = zona;
                });                
            });            
        }        
        //Agrega la informacion de las Variables del DOM
        function fillDOMSalidas(){
            //Llenamos el Select de las salidas:
            $.each(zonas, function(i, salida){
                $('#salidas').append('<option value="'+i+'">'+salida.nombre+'</option>');
            });
        }        
        //Inicializa los listeners en la vista:
        function initializeListeners(){
            $('#salidas').change(function(){
                cargarSalida($('#salidas').val());                
            });
        }
        //Una vez que se elige una salida se cargan los grupos pertencientes a la salida
        var cargarSalida = function cargarSalida(newSalida){
            if(salidaActiva != newSalida){                
                $('#grupos').empty();
                salidaAcriva = newSalida;
                $.each(grupos[zonas[newSalida].id],function(i, grupo){
                    printGrupo($('#grupos'), grupo);
                });
            }
        }
        //Para imprimir el grupo en la salida
        var printGrupo = function printGrupo(container, grupo){            
            if(grupo != undefined){
                container.append('<div class="accordion-groupgrupo-'+grupo.id+' accordion-group"></div>');
                $('.accordion-groupgrupo-'+grupo.id).append('<div class="accordion-heading'+grupo.id+'"></div>');
                $('.accordion-heading'+grupo.id).append('<a class="accordion-toggle" data-toggle="collapse" data-parent="#grupos" href="#grupo'+grupo.id+'"><h5><i class="icon-chevron-down"></i>'+grupo.nombre+'</h5></a>');
                container.append('<div id="grupo'+grupo.id+'" class="accordion-body collapse"></div>');
                $('#grupo'+grupo.id).append('<div class="accordion-inner-'+grupo.id+'" id="zonas_lista'+grupo.id+'"></div>');
                $.each(grupo.zonas, function(i, zona){
                    if(zona != undefined){
                        $('.accordion-inner-'+grupo.id).append('<li><a id="zona_list_'+zona.id+'" style="cursor:pointer;" zona_id="'+zona.id+'">'+zona.PastoralLocalidadFantasia.nombre+'</a></li>');
                        $('#zona_list_'+zona.id).click(function(){
                            var zona_activa = zonasById[$(this).attr('zona_id')].PastoralLocalidadFantasia;                            
                            $('#inscripcion_img').hide();
                            $('#info_localidad tbody').empty();
                            $('#foto_localidad').empty();
                            if(zona_activa.foto_url != '')                            
                                $('#foto_localidad').append('<img style="width: 435px" src="'+routing.public_path('uploads/infoZonas/localidadFantasia/'+zona_activa.foto_url)+'" alt="'+zona_activa.nombre+'">');                                                        
                            //Localidad
                            if(zona_activa.nombre != '')
                                $('#info_localidad tbody').append('<tr><th>Localidad:</th><td>'+zona_activa.nombre+'</td></tr>');
                            //Descripcion                            
                            if(zona_activa.descripcion != '')
                                $('#info_localidad tbody').append('<tr><th>Descripci&oacute;n:</th><td>'+zona_activa.descripcion+'</td></tr>');

                        });
                    }
                });   
            }
        }
       
        //Metodos Publicos
        return {
            init: function init(proyecto_id){                
                getInfoZonasPorSalida(proyecto_id);
            },
            getZonas: function getZonas(){
                return zonas;
            },
            getGrupos: function getGrupos(){
                return grupos;
            }
        }
    })();
    $(document).ready(function(){
        viewZonas.init(<?php echo $proyecto_id ?>);
    });
</script>


    
        
            
        
    
        
            
        </div>
    </div>