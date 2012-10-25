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
        
        <!---------- Informacion-------------->
        
        <div id="municipalidad_acordion" class="btn_acordion">>>Municipalidad</div>
        <div id="municipalidad" style="display:none;" class="acordion-content">
          <table class="table table-bordered table-striped no-bottom" id="Municipalidad_table"
          <?php if( $municipalidad == null) echo "style='display:none'";?> >
            <thead>
              <tr>
                <th class="span4">Nombre</th>
                <th class="span5">Direcci&oacute;n</th>
              </tr>
            </thead>
            <tbody>
            <?php if($municipalidad != null):?>
            <tr>
              <td>
                <a  data-toggle="modal" class = "contactos_button"
                  href="#contacto_modal" title="Mostrar contactos">
                  <?php echo $municipalidad->getNombre();?>
                  <input type="hidden" class="lugar_id" value="<?php echo $municipalidad->getId();?>"/>
                </a>
              </td>
              <td><?php echo $municipalidad->getDireccion();?></td>
            </tr>
            <?php endif;?> 
            </tbody>
              <div class="alert alert-info span8 mensaje" id="Municipalidad_error"
              <?php if( $municipalidad != null) echo "style='display:none'";?> >No se ha ingresado una municipalidad.</div>
             
          </table>
          <button class="btn btn-mini" id="agregar_municipalidad_btn" title="Agregar municipalidad">
          <i class="icon-plus"> </i>
          </button>
        </div>
        <br/>
        
        <div id="alojamientos_acordion" class="btn_acordion">>>Alojamientos</div>
          <div id="alojamientos" style="display:none;" class="acordion-content">
          
          <table class="table table-bordered table-striped no-bottom" id="Alojamiento_table"
          <?php if( !(count($alojamientos) > 0) ) echo "style='display:none'";?> >
              <thead>
                <tr>
                  <th class="span4">Nombre</th>
                  <th>Direcci&oacute;n</th>
                </tr>
              </thead>
              <tbody>
              <?php if(count($alojamientos) > 0):?>
              <?php foreach($alojamientos as $alojamiento):?>
              <tr>
                <td>
                  <a  data-toggle="modal" class="contactos_button"
                    href="#contacto_modal" title="Mostrar contactos">
                    <?php echo $alojamiento->getNombre();?>
                    <input type="hidden" class="lugar_id" value="<?php echo $alojamiento->getId();?>"/>
                  </a>
                </td>
                <td><?php echo $alojamiento->getDireccion();?></td>
              </tr>
              <?php endforeach;?> 
              <?php endif;?>
              </tbody>     
              <div class="alert alert-info span8 mensaje" id="Alojamiento_error"
              <?php if( (count($alojamientos) > 0) ) echo "style='display:none'";?>>No se han ingresado alojamientos.</div>  
            </tbody>
          </table>
          <a  data-toggle="modal" 
            href="#nuevo_lugar_modal" title="Agregar alojamiento">
            <button class="btn btn-mini" id="agregar_alojamiento_btn">
            <i class="icon-plus"> </i>
            </button>
          </a>
        </div>
        <br/>
        
        <div id="parroquias_acordion" class="btn_acordion">>>Parroquias</div>
        <div id="parroquias" style="display:none;" class="acordion-content">
          
          <table class="table table-bordered table-striped no-bottom" id="Parroquia_table"
          <?php if( !(count($parroquias) > 0) ) echo "style='display:none'";?> >
              <thead>
                <tr>
                  <th class="span4">Nombre</th>
                  <th class="span5">Direcci&oacute;n</th>
                </tr>
              </thead>
              <tbody>
              <?php if(count($parroquias) > 0):?>
              <?php foreach($parroquias as $parroquia):?>
              <tr>
                <td>
                  
                  <a  data-toggle="modal" class="contactos_button"
                    href="#contacto_modal" title="Mostrar contactos">
                    <?php echo $parroquia->getNombre();?>
                    <input type="hidden" class="lugar_id" value="<?php echo $parroquia->getId();?>"/>
                  </a>
                  
                </td>
                <td><?php echo $parroquia->getDireccion();?></td>
              </tr>
              <?php endforeach;?> 
              <?php endif;?> 
              </tbody>
              <div class="alert alert-info span8 mensaje" id="Parroquia_error"
              <?php if( (count($parroquias) > 0) ) echo "style='display:none'";?>>No se han ingresado parroquias.</div>
            </tbody>
          </table>
          <a  data-toggle="modal" 
            href="#nuevo_lugar_modal" title="Agregar parroquia">
            <button class="btn btn-mini" id="agregar_parroquia_btn">
            <i class="icon-plus"> </i>
            </button>
          </a>
        </div>
        <br/>
        <div id="contactos_acordion" class="btn_acordion">>>Otros Contactos</div>
        <div id="contactos" style="display:none;" class="acordion-content">
          
          <table class="table table-bordered table-striped no-bottom" id="contactos_table"
          <?php if( !(count($contactos) > 0) ) echo "style='display:none'";?> >
              <thead>
                <tr>
                  <th>Tipo</th>
                  <th>Nombre</th>
                  <th>Cargo</th>
                  <th>Tel&eacute;fono</th>
                </tr>
              </thead>
              <tbody>
              <?php if(count($contactos) > 0):?>
              <?php foreach($contactos as $contacto):?>
              <tr>
                <td><?php echo $contacto->getPastoralTipoContacto()->getNombre();?></td>
                <td><?php echo $contacto->getNombre();?></td>
                <td><?php echo $contacto->getCargo();?></td>
                <td><?php echo $contacto->getTelefono();?></td>
              </tr>
              <?php endforeach;?>   
              <?php endif;?> 
              </tbody>
              <div class="alert alert-info span8 mensaje" id="contactos_error"
              <?php if( (count($contactos) > 0) ) echo "style='display:none'";?>>No se han ingresado contactos.</div>
            </tbody>
          </table>
          <a  data-toggle="modal" 
            href="#nuevo_contacto_modal" title="Agregar contactos">
            <button class="btn btn-mini nuevo_contacto_button">
            <i class="icon-plus"></i>
            </button>
          </a>
        </div>
        <input type="hidden" id="localidad_id" value="<?php echo $pastoral_localidad->getId();?>"/>
        <br/>
        <!---------- Termino Informacion -------------->
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
                  <th>Tipo</th>
                  <th class="span3">&Uacute;ltima modificaci&oacute;n</th>
                  <th>Comentario</th>
                  <th>Creador</th>
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
                <td><?php echo $ca->getCreador()->getNombreCompleto();?></td>
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
        <!---------- Inicio Comentarios --------------->
        
        <table class="table table-bordered table-striped no-bottom" id="historial_table" >
              <thead>
                <tr>
                  <th>Tipo</th>
                  <th class="span3">&Uacute;ltima modificaci&oacute;n</th>
                  <th>Comentario</th>
                  <th>Creador</th>
                  <td class="span1"></td>
                </tr>
              </thead>
              <tbody>
              <?php if(count($comentarios_cubiertos) > 0):?>
              <?php foreach($comentarios_cubiertos as $cc):?>
              <tr>
                <td><?php echo $ca->getPastoralTipoNecesidad()->getNombre();?></td>
                <td><?php echo $cc->getUpdatedAt();?></td>
                <td>
                  <span class="comentario_descripcion"><?php echo $cc->getDescripcion();?></span>
                </td>
                <td><?php echo $cc->getCreador()->getNombreCompleto();?></td>
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


<div id="contacto_modal" class="modal hide fade in" style="display: none; ">  
  <span class="close" data-dismiss="modal">x</span>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#contactos_tab" data-toggle="tab">Contactos</a></li>
    <li id="checklist_menu_tab"><a href="#checklist_tab" data-toggle="tab">Checklist</a></li>
    <li><a href="#descripcion_tab" data-toggle="tab">Comentario</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="contactos_tab">
      <div class="modal-body">           
      </div>  
      <div class="modal-footer">  
        <button class="btn" data-dismiss="modal" id="cerrar_contactos">Cerrar</button>  
        <button class="btn btn-success" id="agregar_contacto">Agregar Contacto</button> 
      </div> 
    </div>
    <div class="tab-pane" id="checklist_tab">
      <div class="modal-body">
        <table class="table-bordered table-striped table-condensed">
          <form id="checklist_form" action="#">
          <?php $par = false; 
          foreach ($checklist_form as $widget): ?>
            <?php if(!$par) echo '<tr>' ?>
            <td><div class="span1-5"><?php echo $widget->renderLabel() ?></div> <?php echo $widget->render() ?></td>
            <?php if($par) echo '</tr>' ?>
          <?php $par=!$par; endforeach; ?>
          <?php if(!$par) echo '</tr>' ?>
          </form>
        </table>
      </div>  
      <div class="modal-footer">  
        <button class="btn" data-dismiss="modal" id="cerrar_contactos">Cerrar</button>  
        <button class="btn btn-success" id="guardar_checklist_btn">Guardar</button> 
      </div> 
    </div>
    <div class="tab-pane" id="descripcion_tab">
      <div class="modal-body">
        <textarea type="text" id="comentario_lugar_en_tab" class="modal_textarea"></textarea>
      </div>  
      <div class="modal-footer">  
        <button class="btn" data-dismiss="modal" id="cerrar_contactos">Cerrar</button>  
        <button class="btn btn-success" id="guardar_comentario_lugar_btn">Guardar</button> 
      </div> 
    </div>
  </div>
</div> 

<div id="nuevo_contacto_modal" class="modal hide fade in" style="display: none; ">  
  <div class="modal-header">  
    <span class="close" data-dismiss="modal">x</span>  
    <h3 id="contacto_form_header">Nuevo contacto</h3>  
  </div>  
  <div class="modal-body">
    <p id="tipo_contacto"><label>Tipo: </label>
      <select id="tipo_contacto_select">
      <?php foreach($tipos_contacto as $tipo_contacto):?>
        <option value="<?php echo  $tipo_contacto->getId();?>"><?php echo  $tipo_contacto->getNombre();?></option>
      <?php endforeach;?> 
      </select>
    <p>
    <p><label>Nombre: </label><input type="text" id="nombre_contacto"/><p>
    <p><label>Cargo: </label><input type="text" id="cargo_contacto"/><p>
    <p><label>Tel&eacute;fono: </label><input type="text" id="telefono_contacto"/><p>
  </div>  
  <div class="modal-footer">  
    <button class="btn" data-dismiss="modal">Cerrar</button>  
    <button class="btn btn-success" id="submit_contacto">Guardar</button> 
  </div>  
</div>

<div id="nuevo_lugar_modal" class="modal hide fade in" style="display: none; ">  
  <div class="modal-header">  
    <span class="close" data-dismiss="modal">x</span>  
    <h3 id="lugar_modal_title"></h3>  
  </div>  
  <div class="modal-body">
    <p id="lugar_tipo"><label>Tipo: </label>
      <select id="lugar_tipo_select">
      <?php foreach($tipos_contacto as $tipo_contacto):?>
        <option value="<?php echo  $tipo_contacto->getId();?>"><?php echo  $tipo_contacto->getNombre();?></option>
      <?php endforeach;?> 
      </select>
    </p>
    <p><label>Nombre: </label><input type="text" id="nombre_lugar"/></p> 
    <p><label>Direcci&oacute;n: </label><input type="text" id="direccion_lugar"/></p>
    <p><label>Comentario: </label><textarea type="text" id="comentario_lugar"></textarea></p>
    <input type="hidden" id="nombre_tipo_lugar" value="-1"/>
  </div>  
  <div class="modal-footer">  
    <button class="btn" data-dismiss="modal">Cerrar</button>  
    <button class="btn btn-success" id="submit_lugar">Guardar</button> 
  </div>  
</div> 


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