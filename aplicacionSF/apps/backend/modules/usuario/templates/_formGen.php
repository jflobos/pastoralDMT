<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<div class="hero-unit" >
  <form action="<?php echo url_for('usuario/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
    <table class="table-bordered table-striped table-condensed" class="btn">
      <tfoot>
        <tr>
          <td colspan="2">
            <a href="<?php echo url_for('usuario/informacion') ?>"><button class="btn btn-info">Volver</button></a>
            <input type="button" onclick="validarFormulario();" value="Guardar" class="btn btn-info" />
          </td>
        </tr>
      </tfoot>
      <tbody>
        <?php echo $form ?>
      </tbody>
    </table>
  </form>
</div>
