<div class="page-header">
 <h1>Grupos <small>Pastoral UC</small></h1>
</div>

<h1><small> <?php echo 'Proyecto: '.$proyecto->getNombre() ?></small></h1>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Descripcion</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pastoral_grupos as $pastoral_grupo): ?>
    <tr>
      <td><a href="<?php echo url_for('grupo/show?id='.$pastoral_grupo->getId()) ?>"><?php echo $pastoral_grupo->getNombre() ?></a></td>
      <td><?php echo $pastoral_grupo->getDescripcion() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

   <div class = "span7">
    <a href="<?php echo url_for('grupo/new') ?>"><button class="btn btn-info">Crear nuevo Grupo</button></a>
    </div>  
  

<br></br>
