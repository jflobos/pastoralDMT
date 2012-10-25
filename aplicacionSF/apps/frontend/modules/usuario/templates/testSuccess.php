<h3> cantidad de Mision-Usuario-Cargo : <?php echo $pastoral_misions0->count(); ?></h3>
<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Salida</th>
      <th>Proyecto version</th>
      <th>Localidad</th>
      <th>Id</th>
      <th>Nombre</th>
      <th>Email</th>
      <th>Cargo</th>
      <th>Proyecto</th>
      <th>Sexo</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pastoral_misions0 as $muc): 
    $pastoral_mision = $muc->getPastoralMision();
    $pastoral_usuario = $muc ->getPastoralUsuario();
    $pastoral_cargo = $muc ->getPastoralCargo();
    ?>
    <tr>
      <td><a href="<?php echo url_for('mision/show?id='.$pastoral_mision->getId()) ?>"><?php echo $pastoral_mision->getId() ?></a></td>
      <td><?php echo $pastoral_mision->getPastoralSalida()->getNombre() ?></td>
      <td><?php echo $pastoral_mision->getProyectoVersionId() ?></td>
      <td><?php echo $pastoral_mision->getPastoralLocalidad()->getNombre() ?></td>
      <td><a href="<?php echo url_for('usuario/show?id='.$pastoral_usuario->getId()) ?>"><?php echo $pastoral_usuario->getId() ?></a></td>
      <td><?php echo $pastoral_usuario->getNombre() ?></td>
      <td><?php echo $pastoral_usuario->getEmail() ?></td>
      <td><?php echo $pastoral_cargo->getNombre() ?></td>
      <td><?php echo $pastoral_usuario->getProyectoId() ?></td>
      <td><?php echo $pastoral_usuario->getSexo() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
