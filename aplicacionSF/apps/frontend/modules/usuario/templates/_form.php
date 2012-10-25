<div class="span5 span-fixed-sidebar">
  <div class="hero-unit">
      <form action="<?php echo url_for('usuario/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
        <?php if (!$form->getObject()->isNew()): ?>
        <input type="hidden" name="sf_method" value="put" />
        <?php endif; ?>
        <table class=" table-bordered table-striped table-condensed" class="btn">
          <colgroup>
                  <col class="span2">
                  <col class="span3">
          </colgroup>
          <tbody>
            <?php echo $form->renderGlobalErrors() ?>
            <tr>
              <th><?php echo $form['rut']->renderLabel() ?></th>
              <td>
                <?php echo $form['rut']->renderError() ?>
                <?php echo $form['rut'] ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $form['nombre']->renderLabel() ?></th>
              <td>
                <?php echo $form['nombre']->renderError() ?>
                <?php echo $form['nombre'] ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $form['apellido_materno']->renderLabel() ?></th>
              <td>
                <?php echo $form['apellido_materno']->renderError() ?>
                <?php echo $form['apellido_materno'] ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $form['apellido_paterno']->renderLabel() ?></th>
              <td>
                <?php echo $form['apellido_paterno']->renderError() ?>
                <?php echo $form['apellido_paterno'] ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $form['email']->renderLabel() ?></th>
              <td>
                <?php echo $form['email']->renderError() ?>
                <?php echo $form['email'] ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $form['telefono_fijo']->renderLabel() ?></th>
              <td>
                <?php echo $form['telefono_fijo']->renderError() ?>
                <?php echo $form['telefono_fijo'] ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $form['telefono_celular']->renderLabel()?>Forma 12345678</th>
              <td>
                <?php echo $form['telefono_celular']->renderError() ?>
                <?php echo $form['telefono_celular'] ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $form['sexo']->renderLabel() ?></th>
              <td>
                <?php echo $form['sexo']->renderError() ?>
                <?php echo $form['sexo'] ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $form['universidad_id']->renderLabel() ?></th>
              <td>
                <?php echo $form['universidad_id']->renderError() ?>
                <?php echo $form['universidad_id'] ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $form['carrera_id']->renderLabel() ?></th>
              <td>
                <?php echo $form['carrera_id']->renderError() ?>
                <?php echo $form['carrera_id'] ?>
              </td>
            </tr>
            <tr>
              <th><?php echo $form['movimiento_id']->renderLabel() ?></th>
              <td>
                <?php echo $form['movimiento_id']->renderError() ?>
                <?php echo $form['movimiento_id'] ?>
              </td>
            </tr>
          </tbody>
        </table>
        &nbsp;
        <div>
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('./usuario/show') ?>"><button class="btn btn-inverse">Volver</button></a>
          <input class="btn btn-primary" type="submit" value="Guardar"/>
        </div>
      </form>
  </div>
</div>

