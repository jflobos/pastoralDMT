<div class="page-header">
  <h1>Bienvenido <small>Pastoral UC</small></h1>
</div>

<h1><small>Filtros</small></h1>

      <select id ='misiones_postulantes' class="btn" ><option value= '-1' selected='selected'>---- Filtro Mision ----</option>
      <?php 
          foreach($misiones as $uem)
          {
              $mision = $uem->getPastoralMision()->getPastoralLocalidadFantasia();
              echo '<option value="'.$mision->getId().'">';  
              echo $mision->getNombre();
              echo '</option>';
          }
      ?>
      </select>   
      <select id ='estados_postulantes' class="btn" ><option value= '-1' selected='selected'>---- Filtro Estados ----</option>
      <?php      
          foreach($estados as $uem)
          {
              $estado = $uem->getPastoralEstadoPostulacion();
              echo '<option value="'.$estado->getId().'">';  
              echo $estado->getNombre();
              echo '</option>';
          }
      ?>
      </select>
<br/>
<br/>
<table class="table table-bordered" id="postulantes_content">
  <thead>
    <tr>
      <th></th>
      <th>Email</th>
      <th>Estado</th>
      <th>Mision</th>
      <th>Nombre</th>
      <th>Cargo</th>
      <th>Sexo</th>
    </tr>
  </thead>
  <tbody>
    <label class="checkbox">
    <?php 
    foreach ($usuario_estado_mision as $uem): 
	    $pastoral_usuario = $uem->getPastoralUsuario();
	    $pastoral_mision = $uem->getPastoralMision()->getPastoralLocalidadFantasia();
	    $pastoral_estado_mision = $uem->getPastoralEstadoPostulacion();
    ?>
    <tr >
      <td><input type="checkbox"val="<?php echo $uem->getId() ?>"/></td>
      <td><?php echo $pastoral_usuario->getEmail() ?></td>
      <td><?php echo $pastoral_estado_mision->getNombre() ?></td>
      <td><?php echo $pastoral_mision->getNombre()?></td>
      <td><?php echo $pastoral_usuario->getNombre() ?></td>
      <td><?php echo $pastoral_usuario->getPastoralCargo()->getNombre() ?></td>
      <td><?php echo $pastoral_usuario->getSexo() ?></td>
    </tr>
    <?php endforeach; ?>
  </label>
  </tbody>
</table>

  <a href="<?php echo url_for('usuario/new') ?>">New</a>
