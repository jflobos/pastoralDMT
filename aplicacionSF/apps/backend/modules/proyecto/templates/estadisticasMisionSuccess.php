<input type="hidden" id="zonaId" value="<?php echo $pastoral_mision->getId() ?>"/>

<div class="page-header">
  <h1><?php echo $pastoral_proyecto->getNombre().' '.$proyecto_version->getAno().' - '.$pastoral_grupo->getNombre()?> <small><?php echo $pastoral_mision->getNombre() ?></small></h1>
</div>

<div class="page-header">
 <?php if($esDirector){ ?> <a href="<?php echo url_for('proyecto/index') ?>"><b>&raquo; Proyecto </b></a> <?php }?>
 <a href="<?php echo url_for('proyecto/menuInstancia?id='.$proyecto_version->getId().'')?>"><b>&raquo; Versión</b></a>
 <a href="<?php echo url_for('proyecto/grupo?id='.$pastoral_grupo->getId()) ?>"><b>&raquo; Grupo</b></a>
 <a href="<?php echo url_for('proyecto/mision?mision_id='.$pastoral_mision->getId()) ?>"><b>&raquo; Zona</b></a>
 <b>&raquo; Estadísticas</b>
</div>
<div class="page-header">
<h3>Estadísticas <?php echo $pastoral_mision->getNombre()?></h3>

</div>

<div class="span9 span-fixed-sidebar tab-content">

<div id="chart1" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart2" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart5" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart6" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart7" style=" height: 250px; position: relative; " class="jqplot-target"></div>
</div>