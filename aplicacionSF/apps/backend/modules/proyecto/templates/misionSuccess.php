
<div class="page-header">
 <h1><?php echo $proyecto->getNombre().' - '.$proyecto_version->getAno() ?><small>Pastoral UC</small></h1>
</div>


<div class="page-header">
 <?php if($esDirector){ ?> <a href="<?php echo url_for('proyecto/index') ?>"><b>&raquo; Proyecto </b></a> <?php } ?>
 <a href="<?php echo url_for('proyecto/menuInstancia?id='.$proyecto_version->getId().'')?>"><b>&raquo; Versión</b></a>
 <a href="<?php echo url_for('proyecto/grupo?id='.$pastoral_mision->getGrupoId().'')?>"><b>&raquo; Grupo</b></a>
 <b>&raquo; Zona</b>
</div>

<div class="span9 span-fixed-sidebar tab-content">
   <h3><?php echo 'Zona: '.$pastoral_mision->getNombre() ?></h3>
<input type="hidden" id="misionId" value="<?php echo $pastoral_mision->getId() ?>"/>
<table class="table table-bordered table-striped">
  <tbody>
        <tr><th>Proyecto - Versión</th><td><?php echo $proyecto_version ?></td>   </tr>
        <tr><th>Descripción</th><td><?php echo $pastoral_mision->getDescripcion() ?></td>                                   </tr>
        <tr><th>Fecha inicio</th><td><?php echo $pastoral_mision->getFechaInicio() ?></td>                                  </tr>
        <tr><th>Fecha término</th><td><?php echo $pastoral_mision->getFechaTermino() ?></td>                                </tr>
        <tr><th>Lugar Salida</th><td><?php echo $pastoral_mision->getPastoralSalida()->getNombre() ?></td>                  </tr>
        <tr><th>Localidad</th><td><?php echo $pastoral_mision->getPastoralLocalidad()->getNombre() ?></td>                  </tr>
        <tr><th>Localidad Fantasía</th><td><?php echo $pastoral_mision->getPastoralLocalidadFantasia()->getNombre() ?></td> </tr>
        <?php if($cargo_actual->getEMisiones()){ ?>      
        <tr><th>Editar</th><td><a href="<?php echo url_for('mision/edit?id='.$pastoral_mision->getId()) ?>"><b>Editar</b></a></td>
        <?php } ?>
  </tbody>
</table>

<div class="page-header">
 <a href="<?php echo (url_for('proyecto/estadisticasMision?id_grupo=').$grupo->getId().'/id_version/'.$proyecto_version->getId().'/id_proyecto/'.$proyecto->getId().'/id_mision/'.$pastoral_mision->getId()) ?>"><b>&raquo; Ver estad&iacute;sticas</b></a>
</div>


<h3><?php echo 'Jefe';if(count($jefes)>1){echo 's';} ;echo ' de la zona' ?></h3>
<table class="table table-bordered table-striped">
<thead>
    <tr>
      <th>Nombre</th>
      <th>Rut</th>
      <th>Celular</th>  
    </tr>
  </thead>
  <tbody>
  <?php foreach ($jefes as $jefe): ?>
    <tr>
        <td><?php echo $jefe ?></td>
        <td><?php echo $jefe->getRut() ?></td>
        <td><?php echo $jefe->getTelefonoCelular() ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<h3>Misioneros</h3>
<table class="table table-bordered table-striped">
<thead>
    <tr>
      <th>Nombre</th>
      <th>Rut</th>
      <th>Celular</th>  
    </tr>
  </thead>
  <tbody>
  <?php foreach ($misioneros as $misionero):if($misionero->fueAMision($pastoral_mision->getId())): ?>
    <tr>
        <td><?php echo $misionero ?></td>
        <td><?php echo $misionero->getRut() ?></td>
        <td><?php echo $misionero->getTelefonoCelular() ?></td>
    </tr>
  <?php endif;endforeach; ?>
  </tbody>
</table>

</div> 