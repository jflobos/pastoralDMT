<link rel="stylesheet" type="text/css" href="/css/jquery.jqplot.min.css" />
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="/js/jqplot/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="/js/graphFunctions.js"></script>
<script type="text/javascript" src="/js/graphProyecto.js"></script>


<input type="hidden" id="proyectoVersionId" value="<?php echo $pastoral_proyecto_version->getId() ?>"/>

<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $pastoral_proyecto_version->getId() ?></td>
    </tr>
    <tr>
      <th>Proyecto:</th>
      <td><?php echo $pastoral_proyecto_version->getProyectoId() ?></td>
    </tr>
    <tr>
      <th>Version:</th>
      <td><?php echo $pastoral_proyecto_version->getVersion() ?></td>
    </tr>
    <tr>
      <th>Ano:</th>
      <td><?php echo $pastoral_proyecto_version->getAno() ?></td>
    </tr>
  </tbody>
</table>
<hr />
<div class="span9 span-fixed-sidebar tab-content">


<h1><small>Estadística - Sexo</small></h1>
<div id="chart1" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<h1><small>Estadística - Edades</small></h1>
<div id="chart5" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<h1><small>Estadística - Movimientos Religiosos</small></h1>
<div id="chart6" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<h1><small>Estadística - Carreras</small></h1>
<div id="chart7" style=" height: 250px; position: relative; " class="jqplot-target"></div>

   <h1><small>Misiones</small></h1>
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Salida</th>             
      <th>Localidad</th>                
      <th>Fecha inicio</th>             
      <th>Fecha término</th>            
      <th>Fecha inicio inscripción</th> 
      <th>Fecha término inscripción</th>
      <th>Localidad Fantasía</th>       
    </tr>
  </thead>
  <tbody>
<?php foreach($misiones as $pastoral_mision):?>
    <tr>
        <td><?php echo $pastoral_mision->getPastoralSalida()->getNombre() ?></td>                 
        <td><?php echo $pastoral_mision->getPastoralLocalidad()->getNombre() ?></td>                 
        <td><?php echo Pastoral::formatDate($pastoral_mision->getFechaInicio()) ?></td>                                 
        <td><?php echo Pastoral::formatDate($pastoral_mision->getFechaTermino()) ?></td>                               
        <td><?php echo Pastoral::formatDate($pastoral_mision->getFechaInicioInscripcion()) ?></td>          
        <td><?php echo Pastoral::formatDate($pastoral_mision->getFechaTerminoInscripcion()) ?></td>        
        <td><?php echo $pastoral_mision->getPastoralLocalidadFantasia()->getNombre() ?></td>
    </tr>
<?php endforeach;?>
  </tbody>
</table>
</div>

<a href="<?php echo url_for('proyecto/edit?id='.$pastoral_proyecto_version->getId()) ?>">Editar</a>
&nbsp;
<a href="<?php echo url_for('proyecto/index') ?>">List</a>
