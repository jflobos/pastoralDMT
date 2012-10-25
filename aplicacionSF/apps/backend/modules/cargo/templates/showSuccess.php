<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $pastoral_usuario_cargo->getId() ?></td>
    </tr>
    <tr>
      <th>Usuario:</th>
      <td><?php echo $pastoral_usuario_cargo->getUsuarioId() ?></td>
    </tr>
    <tr>
      <th>Cargo:</th>
      <td><?php echo $pastoral_usuario_cargo->getCargoId() ?></td>
    </tr>
    <tr>
      <th>Misi&oacute;n:</th>
      <td><?php echo $pastoral_usuario_cargo->getMisionId() ?></td>
    </tr>
    <tr>
      <th>Proyecto Versi&oacute;n:</th>
      <td><?php echo $pastoral_usuario_cargo->getProyectoVersionId() ?></td>
    </tr>
    <tr>
      <th>Grupo:</th>
      <td><?php echo $pastoral_usuario_cargo->getGrupoId() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $pastoral_usuario_cargo->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $pastoral_usuario_cargo->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('cargo/edit?id='.$pastoral_usuario_cargo->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('cargo/index') ?>">List</a>
