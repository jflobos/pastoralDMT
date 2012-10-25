<link rel="stylesheet" type="text/css" href="/css/jquery.jqplot.min.css" />
<script type="text/javascript" src="/js/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="/js/graphFunctions.js"></script>

<div class="page-header">
 <h1><?php echo $pastoral_proyecto->getNombre().' '.$proyecto_version->getAno().' - '.$pastoral_grupo->getNombre().' '?><small>Pastoral UC</small></h1>
 </div>

<div class="page-header">
  <?php if($esDirector){ ?> <a href="<?php echo url_for('proyecto/index') ?>"><b>&raquo; Proyecto </b></a> <?php } ?>
 <a href="<?php echo url_for('proyecto/menuInstancia?id='.$proyecto_version->getId().'')?>"><b>&raquo; Versi&oacute;n</b></a>
 <b>&raquo; Grupo</b>
  <?php if($cargo_actual->getEGrupo()==1 && $esDelProyecto && $proyecto_activo){ ?>
<a href="<?php echo (url_for('grupo/edit').'?id='.$pastoral_grupo->getId()) ?>"><b>(Editar)</b></a>
<?php } ?> 
</div>

<input type="hidden" id="GrupoId" value="<?php echo $pastoral_grupo->getId() ?>"/>

<div class="page-header">
 <a href="<?php echo (url_for('proyecto/estadisticasGrupo').'/id_grupo/'.$pastoral_grupo->getId().'/id_version/'.$proyecto_version->getId().'/id_proyecto/'.$pastoral_proyecto->getId()) ?>"><b>&raquo; Ver estad&iacute;sticas</b></a>
</div>
   
  <div class="accordion" id="infoJefes">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoJefes" href="#jefes">
        <h5><i class="icon-chevron-down"></i> Ver jefes de proyecto </h5>
      </a>
    </div>
    <div id="jefes" class="accordion-body collapse">
      <div class="accordion-inner">
      
<h3><?php echo 'Jefe';if(count($jefes)>1){echo 's';} ;echo ' del Grupo' ?></h3>
<table class="table table-bordered table-striped">
<thead>
    <tr>
      <th>Nombre</th>
      <th>e-mail</th>
      <th>Celular</th> 
      <th>Editar</th>      
    </tr>
  </thead>
  <tbody>
  <?php foreach ($jefes as $jefe): ?>
    <tr>
        <td><?php echo $jefe ?></td>
        <?php 
            $user = Doctrine_Core::getTable('SfGuardUser')->findOneById($jefe->getUserId());
        ?>
        <td><?php echo $user->getEmailAddress() ?></td>
        <td><?php echo $jefe->getTelefonoCelular() ?></td>
        <?php if($cargo_actual->getEGrupo()==1 && $esDelProyecto && $proyecto_activo){ ?> 
        <th><a href="<?php echo url_for('grupo/edit?id='.$pastoral_grupo->getId()) ?>">Editar</a></th>
        <?php } else { ?>
        <th>Editar</a></th>
        <?php }  ?>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

      </div>
    </div>
  </div> <!--End info jefes-->
</div> <!--End acordeon-->

<div class="accordion" id="infoZonas">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoZonas" href="#zonas">
        <h5><i class="icon-chevron-down"></i> Ver informaci&oacute;n de zonas </h5>
      </a>
    </div>
    <div id="zonas" class="accordion-body collapse">
      <div class="accordion-inner">

<div>
<b>Zonas de este grupo: </b>
<select id = "dropdownProyectoVersionMisiones" name="dropdownProyectoVersionMisiones">
 <option value="-1"><i>- Seleccione una zona -</i></option>
<?php foreach ($pastoral_misions as $mision): ?>
  <option id = "<?php echo $mision->getId() ?>" value="<?php echo $mision->getId() ?>"><?php echo $mision->getNombre() ?></option>
<?php endforeach; ?>
</select>
</div>

<div id = "tituloZonas" class="page-header" style="display:none;">

   <div id= "masinfoZonas" class="menup">
     <ul>
          <input type="radio" name="ZonaRadioInfoGrupo" value="ZonaGeneralGrupo" id="ZonaGeneralGrupo">   Info General   </input>
          <input type="radio" name="ZonaRadioInfoGrupo" value="ZonaMetricasGrupo" checked = "true" id="ZonaMetricasGrupo">   Estad&iacute;sticas Zona   </input>
     </ul>
  </div>

  
</div>

<div id = "div_general_zonas" class="page-header" style="display:none;">
<?php foreach ($pastoral_misions as $zona): ?>
<?php
$salida = Doctrine_Core::getTable('PastoralSalida')->find(array($zona->getSalidaId()));
$localidad = Doctrine_Core::getTable('PastoralLocalidad')->find(array($zona->getLocalidadId()));
$sector = Doctrine_Core::getTable('PastoralLocalidadFantasia')->find(array($zona->getLocalidadFantasiaId()));
?>

<div id="InfoGeneralZona<?php echo $zona->getId() ?>" style="display:none;">
<table class="table table-bordered table-striped">
  <thead>
      <tr>
      <th>Nombre de la misi&oacute;n</th>
      <th>Fecha Inicio</th>
      <th>Fecha Termino</th>
      <th>Lugar de salida</th>
      <th>Sector</th>
      <th>Localidad</th>
      <th>M&aacute;s</th>
      </tr>
  </thead>
  <tbody>
    <tr>
        <th><a href="<?php echo url_for('mision/show?mision_id='.$zona->getId()) ?>"><?php echo $zona->getNombre() ?></a></th>
        <td><?php echo $zona->getFechaInicio() ?></td>
        <td><?php echo $zona->getFechaTermino() ?></td>
        <td><?php echo $salida ?></td>
        <td><?php echo $sector ?></td>
        <td><?php echo $localidad ?></td>
        <th><a href="<?php echo url_for('mision/show?mision_id='.$zona->getId()) ?>">Ver m&aacute;s</a></th>
    </tr>
  </tbody>
</table>
</div>
<?php endforeach ?>
</div>



<div style="display:none;" id = "div_metricas_zonas">

<?php foreach ($pastoral_misions as $zona): ?>
<div id="MetricasZona<?php echo $zona->getId() ?>" style="display:none;">

<input type="hidden" id="Zona_vacio_o_no_<?php echo $zona->getId() ?>" value="vacio">

<div class="span9 span-fixed-sidebar tab-content">

<div id="chart1_<?php echo $zona->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart2_<?php echo $zona->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart5_<?php echo $zona->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart6_<?php echo $zona->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart7_<?php echo $zona->getId() ?>" style=" height: 250px; position: relative; " class="jqplot-target"></div>
</div>

</div>
<?php endforeach; ?>

</div>

      </div>
    </div>
  </div> <!--End info jefes-->
</div> <!--End acordeon-->


<div class="accordion" id="infoZonas">

<h4> &raquo; Esta p&aacute;gina fue creada especialmente para los altos cargos, si desea ver la pagina oficial de este grupo 
<a href="<?php echo url_for('grupo/show?id='.$pastoral_grupo->getId()) ?>">haga click aqui</a>
</h4>

</div>


<style type="text/css">
 	.menup {
 		font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:13px;
 		float:left;	
 		width:100%;
 		border-bottom:2px solid #155523
 	}
 	.menup ul {
 		list-style:none;
 		margin:0px;
 		padding:5px 10px 0
 	}
 	.menup li {
 		display:inline
 	}	
 	.menup a {
 		float:left;
 		margin:0 1px 0 0;
 		padding:0px;
 		text-decoration:none
 	}	
 	.menup a span {
 		display:block;
 		padding:5px 15px
 	}
 	.menup a:hover {
 		background-position:100% -75px
 	}	
 	.menup a:hover span {
 		background-position:0% -75px;
 	}	
 	.menup li.current a {
 		background-position:100% -75px;
 		position:relative;
 		top:2px
 	}	
 	.menup li.current a span {
 		background-position:0% -75px;
 	}
</style>
