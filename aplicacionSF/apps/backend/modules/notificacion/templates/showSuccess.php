<table class='table table-bordered table-striped'>
  <tbody>
    <tr>
      <th>Envia:</th>
      <td><?php echo $pastoral_notificacion_usuario->getEnvia()->getNombreCompleto() ?></td>
    </tr>
    <tr>
      <th>Asunto:</th>
      <td><?php echo $pastoral_notificacion_usuario->getAsunto() ?></td>
    </tr>
    <tr>
      <th>Mensaje:</th>
      <td><?php echo $pastoral_notificacion_usuario->getMensaje() ?></td>
    </tr>
    <tr>
      <th>Link:</th>
      <td><?php echo $pastoral_notificacion_usuario->getLink() ?></td>
    </tr>
  </tbody>
</table>

<hr />
&nbsp;
<a href="<?php echo url_for('notificacion/index') ?>">Ver Todas</a>
