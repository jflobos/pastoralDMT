<div class="page-header">
  <h1>Notificaciones <small>Pastoral UC</small></h1>
</div>

<table class='table table-bordered table-striped'>
  <thead>
    <tr>
      <th>Asunto</th>
      <th>Envia</th>
      <th>Mensaje</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pastoral_notificacion_usuarios as $pastoral_notificacion_usuario): ?>
    <tr>
      <td><a href="<?php echo url_for('notificacion/show)').'?notificacion_id='.$pastoral_notificacion_usuario->getId() ?>"><?php echo $pastoral_notificacion_usuario->getAsunto() ?></a></td>
      <td><?php echo $pastoral_notificacion_usuario->getEnvia()->getNombreCompleto() ?></td>
      <td><?php echo $pastoral_notificacion_usuario->getMensaje() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
