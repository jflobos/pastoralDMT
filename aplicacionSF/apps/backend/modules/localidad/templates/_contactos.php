<!----------------- Municipalidad------------------>
        
<?php if( $municipalidad == null):?>
  <p id="municipalidad">No se ha agregado la municipalidad. <button class="btn btn-mini" id="agregar_municipalidad_btn" title="Agregar municipalidad">
    <i class="icon-plus"> </i>Agregar una.</button></p>
<?php else:?>
  <p id="municipalidad"><a  data-toggle="modal" class = "contactos_button"
        href="#contacto_modal" title="Mostrar contactos">
        <?php echo $municipalidad->getNombre();?>
        <input type="hidden" class="lugar_id" value="<?php echo $municipalidad->getId();?>"/>
  </a>. Direcci&oacute;n: <?php echo $municipalidad->getDireccion();?></p>
<?php endif;?> 


<div class="accordion-group">
<!----------------- Alojamientos------------------>
  <div class="accordion-heading">
    <a class="accordion-toggle" data-toggle="collapse"  href="#alojamientos">
      <h5><i class="icon-chevron-down"></i> Alojamientos</h5>
    </a>
  </div>
  <div id="alojamientos" class="accordion-body collapse">
      <div class="accordion-inner">
        <table class="table table-bordered table-striped no-bottom" id="Alojamiento_table"
        <?php if( !(count($alojamientos) > 0) ) echo "style='display:none'";?> >
            <thead>
              <tr>
                <th class="span5">Nombre</th>
                <th>Direcci&oacute;n</th>
                <th class="span1"></th>
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
              <td>
                <a  data-toggle="modal" class="btn btn-mini editar_lugar"
                    href="#nuevo_lugar_modal" title="Editar">
                    <i class="icon-pencil"></i>
                </a>
              </td>
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
  </div>
<!----------------- Parroquias------------------>
  <div class="accordion-heading">
    <a class="accordion-toggle" data-toggle="collapse"  href="#parroquias">
      <h5><i class="icon-chevron-down"></i> Parroquias</h5>
    </a>
  </div>
  <div id="parroquias" class="accordion-body collapse">
      <div class="accordion-inner">
        <table class="table table-bordered table-striped no-bottom" id="Parroquia_table"
          <?php if( !(count($parroquias) > 0) ) echo "style='display:none'";?> >
            <thead>
              <tr>
                <th class="span5">Nombre</th>
                <th>Direcci&oacute;n</th>
                <th class="span1"></th>
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
              <td>
                <a  data-toggle="modal" class="btn btn-mini editar_lugar"
                    href="#nuevo_lugar_modal" title="Editar">
                    <i class="icon-pencil"></i>
                </a>
              </td>
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
  </div>
<!----------------- Contactos------------------>
  <div class="accordion-heading">
    <a class="accordion-toggle" data-toggle="collapse"  href="#contactos">
      <h5><i class="icon-chevron-down"></i> Otros Contactos</h5>
    </a>
  </div>
  <div id="contactos" class="accordion-body collapse">
      <div class="accordion-inner">
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
  

<br/>