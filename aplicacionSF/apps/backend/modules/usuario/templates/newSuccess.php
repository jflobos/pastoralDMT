<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="page-header">
  <h1>¡Regístrate! <small>Pastoral UC</small></h1>
</div>

<div class="hero-unit">
  <input type="hidden" id = "proyecto_id" value="1"/>
  <input type="hidden" id = "registro" value="1"/>
  <form action="<?php echo url_for('usuario/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
    <table class=" table-bordered table-striped table-condensed" class="btn">
      <tfoot>
        <tr>
          <td colspan="2">
            <input type="hidden" name="pid" value="<?php echo $proyecto_id?>"/>
            &nbsp;<a href="<?php echo url_for('/') ?>">Volver</a>
            <input type="button" onclick="validarFormulario();" value="Guardar" />
          </td>
        </tr>
      </tfoot>
      <tbody>
        <?php echo $form ?>        
      </tbody>
    </table>
  </form>
</div>
<a id="modal_launcher" href="#modalError" class="btn" data-toggle="modal" style="display: none"></a> 
<div class="modal" id="modalError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
    <h3 id="myModalLabel">Hay errores en el formulario</h3>
  </div>
  <div id="modal_error_body" class="modal-body">
    <p></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>    
  </div>
</div>