<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<div class="modal" id="form_editar_voluntario_<?php echo $pastoral_usuario->getId()?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><?php echo $pastoral_usuario->getNombre().' '.$pastoral_usuario->getApellidoPaterno().' '.$pastoral_usuario->getApellidoMaterno()?></h3>
  </div>
  <div id="modal_error_body" class="modal-body">
        <table class="table-compact table-bordered">
            <?php echo $form?>
        </table>
  </div>
  <div class="modal-footer">
    <button id="cambiar_voluntario" class="btn" data-dismiss="modal" aria-hidden="true">Cambiar</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
