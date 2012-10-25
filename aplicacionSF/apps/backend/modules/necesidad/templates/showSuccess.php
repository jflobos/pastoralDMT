<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $pastoral_necesidad->getId() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $pastoral_necesidad->getNombre() ?></td>
    </tr>
    <tr>
      <th>Localidad:</th>
      <td><?php echo $pastoral_necesidad->getLocalidad() ?></td>
    </tr>
    <tr>
      <th>Descripcion:</th>
      <td><?php echo $pastoral_necesidad->getDescripcion() ?></td>
    </tr>
    <tr>
      <th>Prioridad:</th>
      <td><?php echo $pastoral_necesidad->getPrioridad() ?></td>
    </tr>
    <tr>
      <th>Fecha termino:</th>
      <td><?php echo $pastoral_necesidad->getFechaTermino() ?></td>
    </tr>
    <tr>
      <th>Usuario creado:</th>
      <td><?php echo $pastoral_necesidad->getUsuarioCreadoId() ?></td>
    </tr>
    <tr>
      <th>Usuario editado:</th>
      <td><?php echo $pastoral_necesidad->getUsuarioEditadoId() ?></td>
    </tr>
    <tr>
      <th>Estado necesidad:</th>
      <td><?php echo $pastoral_necesidad->getEstadoNecesidadId() ?></td>
    </tr>
    <tr>
      <th>Tipo necesidad:</th>
      <td><?php echo $pastoral_necesidad->getTipoNecesidadId() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $pastoral_necesidad->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $pastoral_necesidad->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('necesidad/edit?id='.$pastoral_necesidad->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('necesidad/index') ?>">List</a>
