<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="row">
  <div class="span8">
      <div class="well span8">
        <h2>Informaci&oacute;n general</h2>
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
              <?php echo $form->renderHiddenFields(false) ?>
            </tbody>
          </table>
          <div>
              <input class="btn btn-inverse btn-small" type="submit" value="Crear Localidad"/>
          </div>
        
          
        </form>
      </div>
  </div>
</div>
<?php if($canEdit): ?>
<script></script>
<?php ?>
