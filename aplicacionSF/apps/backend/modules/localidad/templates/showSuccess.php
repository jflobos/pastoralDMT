<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&v=3&libraries=geometry"></script>

<div class="container">

<div class="row">
  <div class="span10">
    <div class="page-header">
      <h1><?php echo $pastoral_localidad->getNombre()?> 
        <small>Sector: <?php echo $pastoral_localidad->getPastoralLocalidadFantasia()->getNombre()?></small>
      </h1>
    </div>
   
    
    <ul class="nav nav-tabs">
      <li class="active"><a href="#informacion" data-toggle="tab">Informaci&oacute;n</a></li>
      <li id="map_tab"><a href="#comentarios" data-toggle="tab">Comentarios</a></li>
      <li><a href="#historial" data-toggle="tab">Historial</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="informacion">
        <input type="hidden" id="localidad_id" value="<?php echo $pastoral_localidad->getId();?>"/>
        <?php include_component('localidad','contactos', array('localidad_id'=>$pastoral_localidad->getId())); ?>
      </div>
      
      <div class="tab-pane" id="comentarios">
        <!---------- Inicio Comentarios --------------->
        
        <div class="row">
          <div class="span10">
            <div class="span9 well center">
              <div id="map" style="width: 870px; height: 400px;"></div>
              <div style="border-top:solid gray 1px;">|
                <?php foreach($tipos_comentarios as $tipos_comentario):?>
                <?php if($tipos_comentario->getNombre()=="General") continue;?>
                <span class="simbolo_comentario">
                  <img src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|<?php echo  $tipos_comentario->getColor();?>"/> 
                  <span class="nombre_tipo"><?php echo  $tipos_comentario->getNombre();?></span>
                | </span>
                <?php endforeach;?> 
              </div>
            </div>
            <div class="span3 hidden" >
              <table class="table table-bordered table-striped">
                <tr><th class="span2">Latitud:</th><td id="latitud"><?php echo $pastoral_localidad->getLatitud();?></td></tr>
                <tr><th class="span2">Latitud:</th><td id="longitud"><?php echo $pastoral_localidad->getLongitud();?></td></tr>
              </table>
            </div>
          </div>
        </div>
        <br/>
        
        
        <table class="table table-bordered table-striped no-bottom" id="comentarios_table" >
              <thead>
                <tr>
                  <th class="span3">Tipo</th>
                  <th class="span3">&Uacute;ltima modificaci&oacute;n</th>
                  <th>Comentario</th>
                  <td class="span1"></td>
                </tr>
              </thead>
              <tbody>
              <?php if(count($comentarios_activos) > 0):?>
              <?php foreach($comentarios_activos as $ca):?>
              <tr>
                <td><?php echo $ca->getPastoralTipoNecesidad()->getNombre();?></td>
                <td><?php echo $ca->getUpdatedAt();?></td>
                <td>
                  <span class="comentario_descripcion"><?php echo $ca->getDescripcion();?></span>
                  <a  data-toggle="modal" class="btn btn-mini right editar_comentario"
                      href="#nuevo_comentario_modal" title="Editar">
                      <i class="icon-pencil"></i>
                      <input type="hidden" class="comentario_id" value="<?php echo $ca->getId();?>"/>
                  </a>
                </td>
                <td>
                  <ul class="no-mark pull-right">
                    <li><button class="btn btn-mini solucionar_comentario" title="Solucionado"><i class="icon-ok"></i></button></li>
                    <li><button class="btn btn-mini borrar_comentario" title="Borrar"><i class="icon-remove"></i></button></li>
                  </ul>
                </td>
              </tr>
              <?php endforeach;?>   
              <?php endif;?> 
              </tbody>
              
            </tbody>
          </table>
          <a  data-toggle="modal" 
            href="#nuevo_comentario_modal" title="Agregar comentario">
            <button class="btn btn-mini" id="agregar_comentario_btn">
            <i class="icon-plus"> </i>
            </button>
          </a>
         <!---------- Termino Comentarios --------------->
      </div>
      
      <div class="tab-pane" id="historial">
        <!---------- Inicio Historial Comentarios --------------->
        
        <table class="table table-bordered table-striped no-bottom" id="historial_table" >
              <thead>
                <tr>
                  <th class="span3">Tipo</th>
                  <th class="span3">&Uacute;ltima modificaci&oacute;n</th>
                  <th>Comentario</th>
                  <td class="span1"></td>
                </tr>
              </thead>
              <tbody>
              <?php if(count($comentarios_cubiertos) > 0):?>
              <?php foreach($comentarios_cubiertos as $cc):?>
              <tr>
                <td><?php echo $cc->getPastoralTipoNecesidad()->getNombre();?></td>
                <td><?php echo $cc->getUpdatedAt();?></td>
                <td>
                  <span class="comentario_descripcion"><?php echo $cc->getDescripcion();?></span>
                </td>
                <td></td>
              </tr>
              <?php endforeach;?>   
              <?php endif;?> 
              </tbody>
              
            </tbody>
          </table>
         <!---------- Termino Comentarios --------------->
      </div>
      
      
      
    </div>
      

    
    
    
    <br/>
    
  </div>
</div>  
    
</div>


<!------------------ Modals -------------------->

<div id="nuevo_comentario_modal" class="modal hide fade in" style="display: none; ">  
  <div class="modal-header">  
    <span class="close" data-dismiss="modal">x</span>  
    <h3 id="comentario_modal_title"></h3>  
  </div>  
  <div class="modal-body">
    <p id="info_comentario_general">Comentario general (sin coordenadas). Si requiere crear un comentario 
    con ubicaci&oacute;n geogr&aacute;fica, utilice los s&iacute;mbolos del mapa. </p>
    <p><label>Comentario: </label><textarea type="text" id="comentario_text" class="modal_textarea"></textarea></p>
  </div>  
  <div class="modal-footer">  
    <button class="btn close_comentario_modal" data-dismiss="modal">Cerrar</button>  
    <button class="btn btn-success" id="submit_comentario">Guardar</button> 
  </div>  
</div>     

<br/>