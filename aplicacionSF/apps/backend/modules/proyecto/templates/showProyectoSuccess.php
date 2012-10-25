<link rel="stylesheet" type="text/css" href="/css/jquery.jqplot.min.css" />
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="/js/graphFunctions.js"></script>
<script type="text/javascript" src="/js/graphProyecto.js"></script>


<input type="hidden" id="proyectoId" value="<?php echo $pastoral_proyecto->getId() ?>"/>

<div class="page-header">
  <h1>Información Proyecto <small>Pastoral UC</small></h1>
</div>

<table>
  <tbody>
    <tr>
      <th>Nombre:</th>
      <td><?php //echo $pastoral_proyecto->getNombre() ?></td>
    </tr>
    <tr>
      <th>Descripción:</th>
      <td><?php //echo $pastoral_proyecto->getDescripcion() ?></td>
    </tr>
  </tbody>
</table>

<a href="<?php echo url_for('proyecto/edit?id='.$pastoral_proyecto_version->getId()) ?>">Editar</a>
&nbsp;
<a href="<?php echo url_for('proyecto/index') ?>">Volver atrás</a>
