<div class="page-header">
 <h1>Localidades <small>Pastoral UC</small></h1>
</div>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Nombre</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pastoral_localidads as $pastoral_localidad): ?>
    <tr>
      <td><a href="<?php echo url_for('localidad/show?id='.$pastoral_localidad->getId()) ?>"><?php echo $pastoral_localidad->getNombre() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('localidad/new') ?>"><button class="btn btn-info">Crear nueva localidad</button></a>
