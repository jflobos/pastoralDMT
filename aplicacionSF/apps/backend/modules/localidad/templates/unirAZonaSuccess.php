
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&v=3&libraries=geometry"></script>

<div class="page-header">
    <h1>Elecci&oacute;n de localidad para <?php echo $mision->getNombre();?></h1>
</div>





<div class="row">
  <div class="span8">
      <div class="well span8">
        <p><b>Instrucciones:</b></p>
        <p>Selecciona <img src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|75FE69"/> para cargar los datos del lugar que visitarás.</p>
        <p>Selecciona <img src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|FE7569"/> sólo si es necesario crear una localidad, no olvides asignarle un nombre.</p>
        <P>Las localidades <img src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|7569FE"/> no pertenecen a tu sector, son puntos de referencia.</P>
        
        <form action="<?php echo url_for('localidad/crearYUnir') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <?php if (!$form->getObject()->isNew()): ?>
        <input type="hidden" name="sf_method" value="put" />
        <?php endif; ?>
          <table class=" table table-bordered table-striped table-condensed" class="btn">
            <tbody>          
            
              <?php echo $form->renderGlobalErrors() ?>
              <tr>
                <th><?php echo $form['nombre']->renderLabel() ?></th>
                <td class= "span7">
                  <?php echo $form['nombre']->renderError() ?>
                  <?php echo $form['nombre'] ?>
                </td>
                <td rowspan="4">
                  <input type="text" class="search-query span2" placeholder="Buscar" id="buscarText"/>
                  <input type="button" class="btn btn-small" id = "buscarButton" value="Buscar"/>
                  <input type="image" src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|FE7569" class="btn btn-small" id = "centrarButton" title="Crear/centrar nueva localidad"/>
                  <div id="map" style="width: 380px; height: 400px;"></div>
                </td>
              </tr>
              <tr>
                <th><?php echo $form['localidad_fantasia_id']->renderLabel() ?></th>
                <td>
                  <?php echo $form['localidad_fantasia_id']->renderError() ?>
                  <?php echo $form['localidad_fantasia_id'] ?>
                </td>
              </tr>
              <tr>
                <th><?php echo $form['latitud']->renderLabel() ?></th>
                <td>
                  <?php echo $form['latitud']->renderError() ?>
                  <?php echo $form['latitud'] ?>
                </td>
              </tr>
              <tr>
                <th><?php echo $form['longitud']->renderLabel() ?></th>
                <td>
                  <?php echo $form['longitud']->renderError() ?>
                  <?php echo $form['longitud'] ?>
                </td>
              </tr>
              <tr>
                <th></th>
                <td>
                  <p id="info_creacion"></p>
                </td>
              </tr>
              <input type="hidden" name="mision_id" id="mision_id" value="<?php echo $mision->getId();?>" />
              <input type="hidden" name="sector_id" id="sector_id" value="<?php echo $mision->getLocalidadFantasiaId();?>" />
              <input type="hidden" name="localidad_id" id="localidad_id" 
              value="<?php echo $mision->getLocalidadId()?$mision->getLocalidadId():-1;?>" />
              <?php echo $form->renderHiddenFields(false) ?>
            </tbody>
          </table>
          <div>
              <input id="submit_localidad" class="btn btn-inverse btn-small" type="button" value="Seleccionar Localidad"/>
          </div>
        
          
        </form>
