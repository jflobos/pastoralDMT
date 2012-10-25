<h1>Pastoral necesidads List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Localidad</th>
      <th>Descripcion</th>
      <th>Prioridad</th>
      <th>Fecha termino</th>
      <th>Usuario creado</th>
      <th>Usuario editado</th>
      <th>Estado necesidad</th>
      <th>Tipo necesidad</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pastoral_necesidads as $pastoral_necesidad): ?>
    <tr>
      <td><a href="<?php echo url_for('necesidad/show?id='.$pastoral_necesidad->getId()) ?>"><?php echo $pastoral_necesidad->getId() ?></a></td>
      <td><?php echo $pastoral_necesidad->getNombre() ?></td>
      <td><?php echo $pastoral_necesidad->getLocalidadId() ?></td>
      <td><?php echo $pastoral_necesidad->getDescripcion() ?></td>
      <td><?php echo $pastoral_necesidad->getPrioridad() ?></td>
      <td><?php echo $pastoral_necesidad->getFechaTermino() ?></td>
      <td><?php echo $pastoral_necesidad->getUsuarioCreadoId() ?></td>
      <td><?php echo $pastoral_necesidad->getUsuarioEditadoId() ?></td>
      <td><?php echo $pastoral_necesidad->getEstadoNecesidadId() ?></td>
      <td><?php echo $pastoral_necesidad->getTipoNecesidadId() ?></td>
      <td><?php echo $pastoral_necesidad->getCreatedAt() ?></td>
      <td><?php echo $pastoral_necesidad->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('necesidad/new') ?>">New</a>
