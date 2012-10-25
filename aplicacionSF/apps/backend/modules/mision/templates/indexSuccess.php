<div class="page-header">
 <h1>Zonas <small>Pastoral UC</small></h1>
</div>

<div >
		<a href="<?php echo url_for('mision/new') ?>"><button class="btn btn-info">Crear nueva Zona</button></a>
</div >
<br/>
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Nombre Zona</th>
      <th>Localidad</th>
      <th>Grupo</th>
      <th>Inscritos&nbsp;/&nbsp;Cupos</th>
      <th>Mujeres</th>
      <th>Inscritos UC</th>
      <th>Lugar de salida</th>
      <th>Estado inscripciones</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($pastoral_misions as $pastoral_mision): 
    	$countHombres = $pastoral_mision->countHombres();
    	$countMujeres = $pastoral_mision->countMujeres();
    	$total = $countHombres+$countMujeres;
    	$universidad = Doctrine_Core::getTable('PastoralUniversidad')->find(15);
    	$totalUc = $universidad->cantidadPorMision($pastoral_mision->getId());    
    	$mision_filtros = Doctrine_Core::getTable('PastoralMisionFiltro')->findByMisionId($pastoral_mision->getId());
    	$cupos = '&infin;';
	    if($mision_filtros!= null)
	    {
	      foreach($mision_filtros as $mf)
	      {
	      if($mf->getPastoralFiltro()->getNombre() == 'Total de inscritos')
	          $cupos = $mf->getParametros();
	      }
	    }
    ?>
    <tr>
        <td><a title='Ver Zona' href="<?php echo url_for('mision/show?mision_id='.$pastoral_mision->getId()) ?>"><?php echo $pastoral_mision->getNombre() ?></a></td>
        <td><a title='Ver Localidad' href="<?php echo url_for("localidad/show?id=".$pastoral_mision->getLocalidadId()); ?>">
          <?php echo $pastoral_mision->getPastoralLocalidad()->getNombre()?></a>
          <a class="btn btn-mini right" title="Elegir Localidad"
          href="<?php echo url_for('localidad/unirAZona').'?mision_id='.$pastoral_mision->getId();?>">
          <i class="icon-pencil"></i></a>
        </td>
        <td><?php echo $pastoral_mision->getPastoralGrupo()->getNombre()?></td>
        <td id="centrar"><?php echo $total.' / '.$cupos?></td>    
        <td id="centrar"><?php if($total!=0) {echo $countMujeres.' ('.round($countMujeres*100/($total)).'&#37;)';}?></td>        
        <td id="centrar"><?php if($total!=0) {echo $totalUc.' ('.round($totalUc*100/($total)).'&#37;)';}?></td>
        <td id="centrar"><?php echo $pastoral_mision->getPastoralSalida()->getNombre() ?></td>
        <?php 
        $able = '';
        $title = 'Cambiar estado de inscripciones';
        if($pastoral_mision->getFechaTermino() < date("Y-m-d")&&$pastoral_mision->getPastoralLocalidad()->getNombre()!='Donde Dios me Quiera')
        {
          $able = 'disabled="disabeled"';
          $title = 'misi&oacute;n ya termino';
        }
        else if($pastoral_mision->estaActiva()&&$pastoral_mision->getPastoralLocalidad()->getNombre()!='Donde Dios me Quiera')
        {
          $able = 'disabled="disabeled"';
          $title = 'misi&oacute;n ya empez&oacute;';
        }
        else if($pastoral_mision->filtroGeneralActivo()&&$pastoral_mision->getPastoralLocalidad()->getNombre()!='Donde Dios me Quiera')
        {
          $able = 'disabled="disabeled"';
          $title = 'Cerrada por filtro activado';
        }
        $inscripcion_abierta = $pastoral_mision->estaInscripcionAbierta();        
        if(!$inscripcion_abierta)
          $inscripcion = 'Cerrada';
        else
          $inscripcion = 'Abierta'; 
        if($inscripcion=='Cerrada'){?>
          <td id="centrar"><button id='inscripcion_.<?php echo $pastoral_mision->getId() ?>' <?php echo$able ?> title= '<?php echo$title ?>' style="width : 80px;" class="btn btn-danger" onclick='botonClick(this,<?php echo $pastoral_mision->getId() ?>)'><?php echo $inscripcion ?></button></td>
        <?php }
        else{?>
          <td id="centrar"><button id='inscripcion_.<?php echo $pastoral_mision->getId() ?>' <?php echo$able ?> title= '<?php echo$title ?>' style="width : 80px;" class="btn btn-success" onclick='botonClick(this,<?php echo $pastoral_mision->getId() ?>)'><?php echo $inscripcion?></button></td>
        <?php }?>
        
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
		<div >
		<a href="<?php echo url_for('mision/new') ?>"><button class="btn btn-info">Crear nueva Zona</button></a>
		</div>     
  

<br></br>
  
  
  