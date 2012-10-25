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

<form action="<?php echo url_for('proyecto/'.($form->getObject()->isNew() ? 'createProyecto' : 'updateProyecto').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <a href="<?php echo url_for('/index.php/proyecto') ?>"><span style='font-size:11px;'>&#9668; </span><span style='font-size:14px;'>Atr&aacute;s</span></a>
          <!--
          ?php if (!$form->getObject()->isNew()): ?>
            &nbsp;
            ?php 
            if($cargo->getCbProyecto()==1){?>
            ?php   echo link_to('Eliminar', 'proyecto/deleteProyecto?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => '¿Est&aacute;s seguro?'));
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
