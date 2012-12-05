<div class="page-header">
 <h1>Detalle del Grupo <small>Pastoral UC</small></h1>
</div>


<div class="span9 span-fixed-sidebar tab-content">
   <h1><small><?php echo 'Grupo: '.$pastoral_grupo->getNombre() ?></small></h1>
<input type="hidden" id="misionId" value="<?php echo $pastoral_grupo->getId() ?>"/>
<a href="<?php echo url_for('grupo/index') ?>"><button class="btn btn-info">Atras</button></a>
&nbsp;
<a href="<?php echo url_for('grupo/edit?id='.$pastoral_grupo->getId()) ?>"><button class="btn btn-info">Editar Grupo</button></a>
<br/><br/>
<table class="table table-bordered table-striped">
  <tbody>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $pastoral_grupo->getNombre() ?></td>
    </tr>
    <tr>
      <th>Descripcion:</th>
      <td><?php echo $pastoral_grupo->getDescripcion() ?></td>
    </tr>
  </tbody>
</table>

<div class="accordion" id="infoCuadroEstadisticas">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoCuadroEstadisticas" href="#cuadroEstadisticas">
        <h5 style="font-size:16px;"><i class="icon-chevron-down"></i>Cuadro de Estad&iacute;sticas</h5>
      </a>
    </div>
    <div id="cuadroEstadisticas" class="accordion-body in">
      <div class="accordion-inner">
          <table class="table table-bordered table-striped">
              <tr>
                  <th>Estad&iacute;sticas globales</th>
                  <th>Total</th>
                  <th>Hombres</th>
                  <th>Mujeres</th>
              </tr>
              <tr>
                  <th>Inscritos Totales</th>
                  <td><?php echo $estadisticas['totales']['sum']['inscritos'] ?></td>
                  <td><?php echo $estadisticas['totales']['sum']['inscritos'] - $estadisticas['totales']['mujeres']['inscritos'] ?></td>
                  <td><?php echo $estadisticas['totales']['mujeres']['inscritos']?></td>
              </tr>
              <tr>
                  <th>Confirmados</th>
                  <td><?php echo $estadisticas['totales']['sum']['confirmados'] ?></td>
                  <td><?php echo $estadisticas['totales']['sum']['confirmados'] - $estadisticas['totales']['mujeres']['confirmados'] ?></td>
                  <td><?php echo $estadisticas['totales']['mujeres']['confirmados']?></td>
              </tr>
               <tr>
                  <th>Aceptados</th>
                  <td><?php echo $estadisticas['totales']['sum']['aceptados'] ?></td>
                  <td><?php echo $estadisticas['totales']['sum']['aceptados'] - $estadisticas['totales']['mujeres']['aceptados'] ?></td>
                  <td><?php echo $estadisticas['totales']['mujeres']['aceptados']?></td>
              </tr>
              <tr>
                  <th>Pendientes</th>
                  <td><?php echo $estadisticas['totales']['sum']['pendientes'] ?></td>
                  <td><?php echo $estadisticas['totales']['sum']['pendientes'] - $estadisticas['totales']['mujeres']['pendientes'] ?></td>
                  <td><?php echo $estadisticas['totales']['mujeres']['pendientes']?></td>
              </tr>
              <tr>
                  <th>Bajas</th>
                  <td><?php echo $estadisticas['totales']['sum']['bajas'] ?></td>
                  <td><?php echo $estadisticas['totales']['sum']['bajas'] - $estadisticas['totales']['mujeres']['bajas'] ?></td>
                  <td><?php echo $estadisticas['totales']['mujeres']['bajas']?></td>
              </tr>
              
          </table>
      </div>
    </div>
  </div> <!--End info estadisticas-->
</div> <!--End acordeon-->

<div class="accordion" id="infoCuadroEstadisticasUC">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoCuadroEstadisticasUC" href="#cuadroEstadisticasUC">
        <h5 style="font-size:16px;"><i class="icon-chevron-down"></i>Cuadro de Estad&iacute;sticas UC</h5>
      </a>
    </div>
    <div id="cuadroEstadisticasUC" class="accordion-body in">
      <div class="accordion-inner">
          <table class="table table-bordered table-striped">
              <tr>
                  <th>Estad&iacute;sticas globales</th>
                  <th>Total</th>
                  <th>Hombres</th>
                  <th>Mujeres</th>
              </tr>
              <tr>
                  <th>Inscritos Totales</th>
                  <td><?php echo $estadisticas['uc']['sum']['inscritos'] ?></td>
                  <td><?php echo $estadisticas['uc']['sum']['inscritos'] - $estadisticas['uc']['mujeres']['inscritos'] ?></td>
                  <td><?php echo $estadisticas['uc']['mujeres']['inscritos']?></td>
              </tr>
              <tr>
                  <th>Confirmados</th>
                  <td><?php echo $estadisticas['uc']['sum']['confirmados'] ?></td>
                  <td><?php echo $estadisticas['uc']['sum']['confirmados'] - $estadisticas['uc']['mujeres']['confirmados'] ?></td>
                  <td><?php echo $estadisticas['uc']['mujeres']['confirmados']?></td>
              </tr>
               <tr>
                  <th>Aceptados</th>
                  <td><?php echo $estadisticas['uc']['sum']['aceptados'] ?></td>
                  <td><?php echo $estadisticas['uc']['sum']['aceptados'] - $estadisticas['uc']['mujeres']['aceptados'] ?></td>
                  <td><?php echo $estadisticas['uc']['mujeres']['aceptados']?></td>
              </tr>
              <tr>
                  <th>Pendientes</th>
                  <td><?php echo $estadisticas['uc']['sum']['pendientes'] ?></td>
                  <td><?php echo $estadisticas['uc']['sum']['pendientes'] - $estadisticas['uc']['mujeres']['pendientes'] ?></td>
                  <td><?php echo $estadisticas['uc']['mujeres']['pendientes']?></td>
              </tr>
              <tr>
                  <th>Bajas</th>
                  <td><?php echo $estadisticas['uc']['sum']['bajas'] ?></td>
                  <td><?php echo $estadisticas['uc']['sum']['bajas'] - $estadisticas['uc']['mujeres']['bajas'] ?></td>
                  <td><?php echo $estadisticas['uc']['mujeres']['bajas']?></td>
              </tr>              
          </table>
      </div>
    </div>
  </div> <!--End info estadisticas-->
</div> <!--End acordeon-->

<h1><small><?php echo 'Jefe';if(count($jefes)>1){echo 's';} ;echo ' del Grupo' ?></small></h1>
<table class="table table-bordered table-striped">
<thead>
    <tr>
      <th>Nombre</th>
      <th>Rut</th>
      <th>Celular</th>  
    </tr>
  </thead>
  <tbody>
  <?php foreach ($jefes as $jefe): ?>
    <tr>
        <td><?php echo $jefe ?></td>
        <td><?php echo $jefe->getRut() ?></td>
        <td><?php echo $jefe->getTelefonoCelular() ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<h1><small><?php echo 'Zona';if(count($zonas)>1){echo 's';} ;echo ' del Grupo' ?></small></h1>
<table class="table table-bordered table-striped">
<thead>
    <tr>
		<th>Nombre</th>
		<th>Fecha Inicio</th>
		<th>Fecha Termino</th>
		<th>Lugar de salida</th>
		<th>Sector</th>
		<th>Localidad</th>
    </tr>
  </thead>
  <tbody>
  <?php $contador = 0; ?>
  <?php foreach ($pastoral_misions as $zona): ?>
    <tr>
        <td><a href="<?php echo url_for('mision/show?mision_id='.$zona->getId()) ?>"><?php echo $zona->getNombre() ?></a></td>
        <td><?php echo $fechas_inicio[$contador] ?></td>
        <td><?php echo $fechas_termino[$contador] ?></td>
        <td><?php echo $salidas[$contador] ?></td>
        <td><?php echo $sectores[$contador] ?></td>
        <td><?php echo $localidades[$contador] ?></td>
		<?php $contador++; ?>
    </tr>
  <?php endforeach; ?>
  <tr>
    <td COLSPAN = 6>
      <a href="<?php echo url_for('mision/new') ?>">Crear nueva Zona</a>
    </td>
  </tr>
  </tbody>
  <input type="hidden" id="grupoId" value="<?php echo $pastoral_grupo->getId() ?>"/>
</table>

<div id="genero_acordion" class="btn_acordion">>>Estad&iacute;stica - Genero</div>
<div id="chart1" style= " height: 300px; position: relative; " class="jqplot-target"></div>

<div id="experiencia_acordion" class="btn_acordion">>>Estad&iacute;stica - Experiencia</div>
<div id="chart4" style= " height: 300px; position: relative; " class="jqplot-target"></div>

<div id="edades_acordion" class="btn_acordion">>>Estad&iacute;stica - Edades</div>
<div id="chart5" style= " height: 300px; position: relative; " class="jqplot-target"></div>

<div id="movimientos_religiosos_acordion" class="btn_acordion">>>Estad&iacute;stica - Movimientos Religiosos</div>
<div id="chart6" style= " height: 300px; position: relative; " class="jqplot-target"></div>


<div id="carreras_acordion" class="btn_acordion">>>Estad&iacute;stica - Carreras</div>
<div id="chart7" style=" height: 300px; position: relative; " class="jqplot-target"></div>

<div id="necesidad_acordion" class="btn_acordion">>>Estad&iacute;stica - Necesidades Abarcadas</div>
  <div id="chart2" style= " height: 300px; position: relative; " class="jqplot-target"></div>

<hr />

<a href="<?php echo url_for('grupo/index') ?>"><button class="btn btn-info">Atras</button></a>
&nbsp;
<a href="<?php echo url_for('grupo/edit?id='.$pastoral_grupo->getId()) ?>"><button class="btn btn-info">Editar Grupo</button></a>


<input type ='hidden' id='grupoId' value = "<?php echo $pastoral_grupo->getId()  ?>"/>
 <br></br>
 <script type="text/javascript">
     $(document).ready(function(){
         graficosModule.initGraficosGrupo();
     });
 </script>