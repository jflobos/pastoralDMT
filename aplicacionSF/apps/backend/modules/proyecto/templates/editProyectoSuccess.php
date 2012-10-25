<!--NAVEGACIÓN-->
<div class="" style="text-align:left" >
  &raquo;
  <?php if($sf_user->getAttribute('usuario_cargo')->getPastoralCargo()->getEsDirector()==1){ ?> 
  <a align="left" href="<?php echo url_for('proyecto/index') ?>">
    <span style='font-size:10px;color:blue'>Proyectos</span>
  </a>
  &raquo;

  <a align="left" href="<?php echo (url_for('proyecto/editProyecto').'?id='.$form->getObject()->getId() ) ?>"">
    <span style='font-size:10px;color:blue'>Editar <?php echo $form->getObject()->getNombre()?></span>
  </a>
  <?php } ?>
</div>
<!--/NAVEGACIÓN-->

<!--ENCABEZADO-->
<div class="page-header">
<h1>Editar Proyecto <small><?php echo $form->getObject()->getNombre()?></small></h1>
</div>
<!--/ENCABEZADO-->

<?php include_partial('form2', array('form' => $form, 'cargo' => $cargo_actual)) ?>