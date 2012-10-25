<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<style type="text/css">
#guardar
{
  color: #FFFFFF;
  font-size:13px;
  width: 70px;
  margin: 25px;
  padding: 3px 7px;
}
</style>

<form action="<?php echo url_for('proyecto/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <a href="<?php echo (url_for('proyecto/menuInstancia').'/id/'.$form->getObject()->getId() ) ?>"><span style='font-size:11px;'>&#9668; </span><span style='font-size:14px;'>Atr&aacute;s</span></a>
          <!--
          ?php if (!$form->getObject()->isNew()): ?>
            &nbsp;
            ?php 
            if($cargo->getCbProyectoversion()==1){
              echo link_to('Eliminar', 'proyecto/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => '¿Est&aacutes seguro?'));
            }
            ?>
          ?php endif; ?>
          -->
          <input class="btn btn-info" id='guardar' type="submit" value="Guardar" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
