<table>
  <tbody>
  <?php if ($sf_user->hasFlash('instancia_fallida')): ?>
    <tr>
      <td></td>
      <td>
        <div class="alert alert-info span5"  id="info_tabla_vacia" style="text-align:center">
        <?php echo $sf_user->getFlash('instancia_fallida') ?>
        </div>
      </td>
    </tr>
  <?php endif ?>
  </tbody>
</table>

<!--NAVEGACIÓN-->
<div class="" style="text-align:left" >
  &raquo;
  <?php if($sf_user->getAttribute('usuario_cargo')->getPastoralCargo()->getEsDirector()==1){ ?> 
  <a align="left" href="<?php echo url_for('proyecto/index') ?>">
    <span style='font-size:10px;color:blue'>Proyectos</span>
  </a>
  &raquo;
  <a align="left" href="<?php echo (url_for('proyecto/menuInstancia').'/id/'.$form->getObject()->getId() ) ?>">
    <span style='font-size:10px;color:blue'><?php echo $form->getObject()->getNombre()?></span>
  </a>
  &raquo;
  <a align="left" href="<?php echo (url_for('proyecto/edit').'?id='.$form->getObject()->getId() ) ?>"">
    <span style='font-size:10px;color:blue'>Edici&oacute;n</span>
  </a>
  <?php } ?>
</div>
<!--/NAVEGACIÓN-->

<!--ENCABEZADO-->
<div class="page-header">
<h1>Editar Versi&oacute;n <small><?php echo $form->getObject()->getNombre()?></small></h1>
</div>
<!--/ENCABEZADO-->

<!--LINKS DERECHOS-->
<!--/LINKS DERECHOS-->

<?php include_partial('form', array('form' => $form, 'cargo'=> $cargo_actual)) ?>
