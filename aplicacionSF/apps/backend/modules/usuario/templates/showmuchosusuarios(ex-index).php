<h1>Lista de Usuarios</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>User</th>
      <th>Rut</th>
      <th>Nombre</th>
      <th>Apellido materno</th>
      <th>Apellido paterno</th>
      <th>Email</th>
      <th>Telefono fijo</th>
      <th>Telefono celular</th>
      <th>Cargo</th>
      <th>Proyecto</th>
      <th>Sexo</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pastoral_usuarios as $pastoral_usuario): ?>
    <tr>
      <td><a href="<?php echo url_for('usuario/show?id='.$pastoral_usuario->getId()) ?>"><?php echo $pastoral_usuario->getId() ?></a></td>
      <td><?php echo $pastoral_usuario->getUserId() ?></td>
      <td><?php echo $pastoral_usuario->getRut() ?></td>
      <td><?php echo $pastoral_usuario->getNombre() ?></td>
      <td><?php echo $pastoral_usuario->getApellidoMaterno() ?></td>
      <td><?php echo $pastoral_usuario->getApellidoPaterno() ?></td>
      <td><?php echo $pastoral_usuario->getEmail() ?></td>
      <td><?php echo $pastoral_usuario->getTelefonoFijo() ?></td>
      <td><?php echo $pastoral_usuario->getTelefonoCelular() ?></td>
      <td><?php echo $pastoral_usuario->getCargoId() ?></td>
      <td><?php echo $pastoral_usuario->getProyectoId() ?></td>
      <td><?php echo $pastoral_usuario->getSexo() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('usuario/new') ?>">New</a>
