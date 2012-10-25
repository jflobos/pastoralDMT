<h1>Comentarios List</h1>

<table>
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Localidad</th>
      <th>Prioridad</th>
      <th>Fecha de término</th>
      <th>Creado por</th>
      <th>Editado por</th>
      <th>Estado</th>
      <th>Tipo</th>
    </tr>
  </thead>
  <tbody>
  <!-- Esto esta sacado de otro archivo. Corregir esto con lo necesario para los comentarios -->
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
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('usuario/new') ?>">Agregar Comentario</a>
