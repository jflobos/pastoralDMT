<input type="hidden" id="proyecto_version_id" value="<?php echo $pastoral_proyecto_version->getId() ?>"/>

<div class="page-header">
  <h1><?php echo $pastoral_proyecto->getNombre()." - ".$pastoral_proyecto_version->getAno()?> <small>Pastoral UC</small></h1>
</div>

<div class="page-header">
 <?php if($cargo_actual->getEProyecto()==1){ ?> <a href="<?php echo url_for('proyecto/index') ?>"><b>&raquo; Proyecto </b></a> <?php } ?>
 <a href="<?php echo url_for('proyecto/menuInstancia?id='.$pastoral_proyecto_version->getId().'')?>"><b>&raquo; Versión</b></a>
 <b>&raquo; Estadísticas</b>
</div>

<div class="span9 span-fixed-sidebar tab-content">


<div id="chart1" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart5" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart6" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart7" style= " height: 250px; position: relative; " class="jqplot-target"></div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
       graficosModule.getEstadisticaProyecto(); 
    });
</script>