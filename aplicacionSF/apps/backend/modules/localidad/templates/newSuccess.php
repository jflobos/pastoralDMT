
<script src="http://maps.google.com/maps/api/js?sensor=false" 
          type="text/javascript"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&v=3&libraries=geometry"></script>

<div class="page-header">
    <h1>Elecci&oacute;n de localidad para ....</h1>
</div>





<div class="row">
  <div class="span8">
      <div class="well span8">
        <p>Puedes crear una nueva localidad (marcador rojo) o elejir una ya creada en el mapa (marcador verde).</p>
        <form action="<?php echo url_for('localidad/create') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
                  <input type="button" class="btn btn-small" id = "centrarButton" value="Centrar"/>
                  <div id="map" style="width: 380px; height: 400px;"></div>
                </td>
              </tr>
              <tr>
                <th><?php echo $form['localidad_fantasia_id']->renderLabel() ?></th>
                <td>
                  <?php echo $form['localidad_fantasia_id']->renderError() ?>
                  <?php echo $form['localidad_fantasia_id'] ?>
                  <input type="button" id="agregar_sector" value="+" />
                </td>
              </tr>
              <tr>
                <th><?php echo $form['localidad_fantasia']->renderLabel() ?></th>
                <td>
                  <?php //echo $form['salida']->renderError() ?>
                  <input type="button" id="cerrar_sector" value="x" />
                  <?php echo $form['localidad_fantasia'] ?>
                </td>
              </tr>
              <tr>
                <th><?php echo $form['coord_x']->renderLabel() ?></th>
                <td>
                  <?php echo $form['coord_x']->renderError() ?>
                  <?php echo $form['coord_x'] ?>
                </td>
              </tr>
              <tr>
                <th><?php echo $form['coord_y']->renderLabel() ?></th>
                <td>
                  <?php echo $form['coord_y']->renderError() ?>
                  <?php echo $form['coord_y'] ?>
                </td>
              </tr>
              <tr>
                <th></th>
                <td>
                  <p id="info_creacion"></p>
                </td>
              </tr>
              <?php echo $form->renderHiddenFields(false) ?>
            </tbody>
          </table>
          <div>
              <input id="submit_localidad" class="btn btn-inverse btn-small" type="button" value="Crear Localidad"/>
          </div>
        
          
        </form>
