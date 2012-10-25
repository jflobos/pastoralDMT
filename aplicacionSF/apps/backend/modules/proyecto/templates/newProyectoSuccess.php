<!--NAVEGACIÓN-->
<div class="" style="text-align:left" >
  &raquo;
  <?php if($sf_user->getAttribute('usuario_cargo')->getPastoralCargo()->getEsDirector()==1){ ?> 
  <a align="left" href="<?php echo url_for('proyecto/index') ?>">
    <span style='font-size:10px;color:blue'>Proyectos</span>
  </a>
  &raquo;
  <a align="left" href="<?php echo url_for('proyecto/newProyecto') ?>">
    <span style='font-size:10px;color:blue'>Crear Proyecto</span>
  </a>
  <?php } ?>
</div>
<!--/NAVEGACIÓN-->

<!--ENCABEZADO-->
<div class="page-header">
<h1>Crear Proyecto <small>Pastoral UC</small></h1>
</div>
<!--/ENCABEZADO-->

<!--LINKS DERECHOS-->
<!--/LINKS DERECHOS-->

<?php include_partial('form2', array('form' => $form)) ?>
