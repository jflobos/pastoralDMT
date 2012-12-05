<!--NAVEGACION-->
<div class="" style="text-align:left" >
  &raquo;
  <?php if($esDirector){ ?> 
  <a align="left" href="<?php echo url_for('proyecto/index') ?>">
    <span style='font-size:10px;color:blue'>Proyectos</span>
  </a>
  &raquo;
  <a align="left" href="<?php echo (url_for('proyecto/menuInstancia').'/id/'.$pastoral_proyecto_version->getId()) ?>">
    <span style='font-size:10px;color:blue'><?php echo $pastoral_proyecto_version->getNombre() ?></span>
  </a>
  <?php } ?>
  <?php if($esJefe && !$esDirector){ ?> 
    <?php if($sf_user->getAttribute('usuario_cargo')->getPastoralCargo()->getVProyecto()==1){ ?> 
    <a align="left" href="<?php echo url_for('proyecto/index') ?>">
      <span style='font-size:10px;color:blue'><?php echo $pastoral_proyecto->getNombre() ?></span>
    </a>
    &raquo;
    <?php } ?>
  <a align="left" href="<?php echo (url_for('proyecto/menuInstancia').'/id/'.$pastoral_proyecto_version->getId()) ?>">
    <span style='font-size:10px;color:blue'><?php echo $pastoral_proyecto_version->getNombre() ?></span>
  </a>
  <?php } ?>
</div>
<!--/NAVEGACIONN-->

<!--ENCABEZADO-->
<div class="page-header">
<h1><?php echo $pastoral_proyecto->getNombre()." - ".$pastoral_proyecto_version->getVersion()?> <small>Pastoral UC</small></h1>
</div>
<!--/ENCABEZADO-->

<div>
<?php if ($sf_user->hasFlash('editar_jefe')): ?>
<br>
  <table>
    <tbody>
      <tr>
        <td></td>
        <td>
          <div class="alert alert-info span5"  id="info_tabla_vacia" style="text-align:center">
          <?php echo $sf_user->getFlash('editar_jefe') ?>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
<?php endif ?>
</div>

<!--LINKS DERECHOS-->
<div class="" style="text-align:right">
              <?php if($cargo_actual->getEProyectoversion()==1 && $esDirector && $proyecto_activo){ ?> 
               <a href="<?php echo (url_for('proyecto/edit').'?id='.$pastoral_proyecto_version->getId()) ?>">Editar versi&oacute;n</a> |
              <?php } ?> 

              <?php if($cargo_actual->getVProyecto()==1){ ?>
               <a href="<?php echo url_for('proyecto/index') ?>">Ver otras versiones</a>
              <?php } ?>
</div>
<!--/LINKS DERECHOS-->


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

<div class="accordion" id="infoEstadisticas">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoEstadisticas" href="#estadisticas">
        <h5 style="font-size:16px;"><i class="icon-chevron-down"></i> Estad&iacute;sticas </h5>
      </a>
    </div>
    <div id="estadisticas" class="accordion-body in">
      <div class="accordion-inner">
          <div id="acumulada1" value="<?php echo $pastoral_proyecto_version->getId(); ?>" style="height: 300px; width: 100%; position: relative"></div>
          <div id="acumulada2" value="<?php echo $pastoral_proyecto_version->getId(); ?>" style="height: 300px; width: 100%; position: relative"></div>
          <a href="<?php echo (url_for('proyecto/estadisticasVersion?id=').$pastoral_proyecto_version->getId().'') ?>">&#9658; Ver m&aacute;s estad&iacute;sticas</a><br/>
          <a href="">&#9658; Excel de inscritos</a>
      </div>
    </div>
  </div> <!--End info estadisticas-->
</div> <!--End acordeon-->


<div class="accordion" id="infoJefes">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoJefes" href="#jefes">
        <h5 style="font-size:16px;"><i class="icon-chevron-down"></i> Jefes del Proyecto</h5>
      </a>
    </div>
    <div id="jefes" class="accordion-body collapse">
      <div class="accordion-inner">
      <table class="table table-bordered table-striped" align='center' valign='top' border='1'>
        <thead>
          <tr>
            <th>Cargo</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Editar</th>
          </tr>
        </thead>
        
        <tbody>
          <?php foreach($jefesNacionales as $j_nacional){ ?>
          <tr> 
            <td>Jefe Nacional</td>
            <td><?php echo $j_nacional ?></td>
            <?php 
            $user = Doctrine_Core::getTable('SfGuardUser')->findOneById($j_nacional->getUserId());
            ?>
            <td><?php echo $user->getEmailAddress() ?></td>
            <td><?php echo $j_nacional->getTelefonoCelular() ?></td>
            <?php if($id_jefe_visitando_sitio==$j_nacional->getId() || $cargo_actual->getEProyectoversion()!=1 || !$proyecto_activo){ ?>
            <th>Editar</th>
            <?php } else if($id_jefe_visitando_sitio!=$j_nacional->getId() && $cargo_actual->getEProyectoversion()==1 && $esDelProyecto && $proyecto_activo){ ?>
            <th><a href="<?php echo (url_for('proyecto/editJefe').'?id='.$pastoral_proyecto_version->getId().'&cargo=Nacional&id_usuario='.$j_nacional->getId()) ?>">Editar</th>
            <?php } else if($id_jefe_visitando_sitio!=$j_nacional->getId() && $cargo_actual->getEProyectoversion()==1 && $esDirector && $proyecto_activo){ ?>
            <th><a href="<?php echo (url_for('proyecto/editJefe').'?id='.$pastoral_proyecto_version->getId().'&cargo=Nacional&id_usuario='.$j_nacional->getId()) ?>">Editar</th>
            <?php } ?>
          </tr>
          <?php } ?>
          <?php foreach($jefesFinanzas as $j_finanzas){ ?>
          <tr> 
            <td>Jefe de Finanzas</td>
            <td><?php echo $j_finanzas ?></td>
            <?php 
            $user = Doctrine_Core::getTable('SfGuardUser')->findOneById($j_finanzas->getUserId());
            ?>
            <td><?php echo $user->getEmailAddress() ?></td>
            <td><?php echo $j_finanzas->getTelefonoCelular() ?></td>
            <?php if($cargo_actual->getEProyectoversion()!=1 || !$proyecto_activo){ ?>
            <th>Editar</th>
            <?php } else if($cargo_actual->getEProyectoversion()==1 && $esDelProyecto && $proyecto_activo) {?>
            <th><a href="<?php echo (url_for('proyecto/editJefe').'?id='.$pastoral_proyecto_version->getId().'&cargo=de Finanzas&id_usuario='.$j_finanzas->getId()) ?>">Editar</th>
            <?php } else if($cargo_actual->getEProyectoversion()==1 && $esDirector && $proyecto_activo) {?>
            <th><a href="<?php echo (url_for('proyecto/editJefe').'?id='.$pastoral_proyecto_version->getId().'&cargo=de Finanzas&id_usuario='.$j_finanzas->getId()) ?>">Editar</th>
            <?php } ?>            
          </tr>
          <?php } ?> 
          <?php foreach($jefesInscripciones as $j_inscripciones){ ?>
          <tr> 
            <td>Jefe de Inscripciones</td>
            <td><?php echo $j_inscripciones ?></td>
            <?php 
            $user = Doctrine_Core::getTable('SfGuardUser')->findOneById($j_inscripciones->getUserId());
            ?>
            <td><?php echo $user->getEmailAddress() ?></td>
            <td><?php echo $j_inscripciones->getTelefonoCelular() ?></td>
            <?php if($cargo_actual->getEProyectoversion()!=1 || !$proyecto_activo){ ?>
            <th>Editar</th>
            <?php } else if($cargo_actual->getEProyectoversion()==1 && $esDelProyecto && $proyecto_activo) { ?>
            <th><a href="<?php echo (url_for('proyecto/editJefe').'?id='.$pastoral_proyecto_version->getId().'&cargo=de Inscripciones&id_usuario='.$j_inscripciones->getId()) ?>">Editar</th> 
            <?php } else if($cargo_actual->getEProyectoversion()==1 && $esDirector && $proyecto_activo) { ?>
            <th><a href="<?php echo (url_for('proyecto/editJefe').'?id='.$pastoral_proyecto_version->getId().'&cargo=de Inscripciones&id_usuario='.$j_inscripciones->getId()) ?>">Editar</th>
            <?php } ?>
          </tr>
          <?php } ?>
          <?php foreach($jefesExtranjeros as $j_extranjeros){ ?>
          <tr> 
            <td>Jefe de Extranjeros</td>
            <td><?php echo $j_extranjeros ?></td>
            <?php 
            $user = Doctrine_Core::getTable('SfGuardUser')->findOneById($j_extranjeros->getUserId());
            ?>
            <td><?php echo $user->getEmailAddress() ?></td>
            <td><?php echo $j_extranjeros->getTelefonoCelular() ?></td>
            <?php if($cargo_actual->getEProyectoversion()!=1 || !$proyecto_activo){ ?>
            <th>Editar</th>
            <?php } else if($cargo_actual->getEProyectoversion()==1 && $esDelProyecto && $proyecto_activo) { ?>
            <th><a href="<?php echo (url_for('proyecto/editJefe').'?id='.$pastoral_proyecto_version->getId().'&cargo=de Extranjeros&id_usuario='.$j_extranjeros->getId()) ?>">Editar</th>
            <?php } else if($cargo_actual->getEProyectoversion()==1 && $esDirector && $proyecto_activo) { ?>
            <th><a href="<?php echo (url_for('proyecto/editJefe').'?id='.$pastoral_proyecto_version->getId().'&cargo=de Extranjeros&id_usuario='.$j_extranjeros->getId()) ?>">Editar</th>
            <?php } ?>            
          </tr>
          <?php } ?>    
          
        </tbody>
       </table> 
       <?php if($cargo_actual->getEProyectoversion()==1 && $esDelProyecto && $proyecto_activo){ ?>
       <a href="<?php echo (url_for('proyecto/masJefesInstancia?id=').$pastoral_proyecto_version->getId().'') ?>"><b>&oplus; Agregar jefe</b></a>
       <?php } else if($cargo_actual->getEProyectoversion()==1 && $esDirector && $proyecto_activo){ ?>
       <a href="<?php echo (url_for('proyecto/masJefesInstancia?id=').$pastoral_proyecto_version->getId().'') ?>"><b>&oplus; Agregar jefe</b></a>
       <?php } ?>

      </div>
    </div>
  </div> <!--End info jefes-->
</div> <!--End acordeon-->


<div class="accordion" id="infoGrupos">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoGrupos" href="#grupos">
        <h5 style="font-size:16px;"><i class="icon-chevron-down"></i> Información de Grupos</h5>
      </a>
    </div>
    <div id="grupos" class="accordion-body collapse">
      <div class="accordion-inner">
<div>
  <div class="accordion" id="gruposVersion">
    <?php foreach ($pastoral_grupos_version as $grupo): ?>
      <div class="accordion-group">
        <div class="">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#gruposVersion" href="#grupo<?php echo $grupo->getId() ?>">
            <h5><i class="icon-chevron-down"></i><?php echo $grupo->getNombre() ?></h5>
          </a>         
        </div>
        <div id="grupo<?php echo $grupo->getId() ?>" class="accordion-body collapse">
          <div class="accordion-inner">
            <p><a href="<?php echo (url_for('proyecto/grupo').'/id/'.$grupo->getId()) ?>"> <b>Ver información del grupo</b></a>
            <?php 
              $pastoral_grupo_misiones = Doctrine_Core::getTable('PastoralMision')->getMisionesPorIdGrupo($grupo->getId());
              foreach ($pastoral_grupo_misiones as $mision): 
    
              $salida = Doctrine_Core::getTable('PastoralSalida')->getSalidaPorId($mision->getSalidaId());
              $localidad = Doctrine_Core::getTable('PastoralLocalidad')->getLocalidadPorIdFetchOne($mision->getLocalidadId());
            ?>           
            <p><a href="<?php echo (url_for('mision/show/mision?mision_id=').$mision->getId()) ?>"><?php echo $mision->getNombre() ?></a> 
      <?php

      if($localidad!=null){
        echo "(<a href='".url_for('localidad/show/?id=').$localidad->getId()."'>".$localidad->getNombre()."</a>)";
      }
      ?></p>
    <?php endforeach; ?>
          </div>
        </div>
      </div>  <!--fin grupo-->
    <?php endforeach; ?>
  </div> <!--fin acordion-->
</div> <!--fin grupos-->
  
<?php if($cargo_actual->getEProyectoversion()==1 && $esDelProyecto){ ?>
<div class="page-header">
 <a href="<?php echo url_for('grupo/new') ?>">&oplus; Agregar grupo</a>
</div>
<?php } ?>
  
<div>
<b>Ver estad&iacute;sticas de un grupo: </b>
<select id = "dropdownProyectoVersionGrupos" name="dropdownProyectoVersionGrupos">
 <option value="-1"><i>Seleccione un Grupo</i></option>
<?php foreach ($pastoral_grupos_version as $grupo): ?>
  <option id = "<?php echo $grupo->getId() ?>" value="<?php echo $grupo->getId() ?>"><?php echo $grupo->getNombre() ?></option>
<?php endforeach; ?>
</select>
</div>

<div id = "tituloGrupos" class="page-header" style="display:none;">
   <div id= "masinfoGrupo" class="menup">
     <ul>
          <input type="radio" name="GrupoRadioInfoGrupo" value="RadioGeneralGrupo" id="RadioGeneralGrupo">   General   </input>
          <input type="radio" name="GrupoRadioInfoGrupo" value="RadioInstanciasGrupo" checked = "true" id="RadioInstanciasGrupo">   Zonas   </input>
          <input type="radio" name="GrupoRadioInfoGrupo" value="RadioMetricasGrupo" checked = "true" id="RadioMetricasGrupo">   Estad&iacute;sticas   </input>
     </ul>
  </div>
</div>

<div style="display:none;" id = "div_general_grupos">

<?php foreach ($pastoral_grupos_version as $grupo): ?>
<div id="InfoGeneralGrupo<?php echo $grupo->getId() ?>" style="display:none;">
 <table class="table table-bordered table-striped" align='center' valign='top' border='1'>
  <thead>
    <tr>
      <th valign="top">Nombre </th>
      <th>Descripci&oacute;n</th>
      <th>M&aacute;s</th> 
    </tr>
  </thead>
  
  <tbody>
    <tr>  
      <th><a href="<?php echo (url_for('proyecto/grupo').'/id/'.$grupo->getId()) ?>"><?php echo $grupo->getNombre() ?></th>
      <td><?php echo $grupo->getDescripcion() ?></td>
      <th><a href="<?php echo (url_for('proyecto/grupo').'/id/'.$grupo->getId()) ?>">Ver m&aacute;s</th>
    </tr>
  </tbody>
 </table>
</div>
<?php endforeach; ?>
</div>

<div style="display:none;" id = "div_misiones_grupo"> 

<?php foreach ($pastoral_grupos_version as $grupo): ?>

<div id="MisionesGrupo<?php echo $grupo->getId() ?>" style="display:none;">
 
  <table class="table table-bordered table-striped" align='center' valign='top' border='1'>
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Fecha Inicio</th>
        <th>Fecha Término</th>
        <th>Salida</th>
        <th>Localidad</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $pastoral_grupo_misiones = Doctrine_Core::getTable('PastoralMision')->getMisionesPorIdGrupo($grupo->getId());
      foreach ($pastoral_grupo_misiones as $mision): 
      $salida = Doctrine_Core::getTable('PastoralSalida')->getSalidaPorId($mision->getSalidaId());
      $localidad = Doctrine_Core::getTable('PastoralLocalidad')->getLocalidadPorIdFetchOne($mision->getLocalidadId());
      ?>   
      <tr>
        <th><a href="<?php echo (url_for('proyecto/mision?mision_id=').$mision->getId()) ?>"><?php echo $mision->getNombre() ?></a></th>
        <td><?php echo $mision->getFechaInicio() ?></td>
        <td><?php echo $mision->getFechaTermino()?></td>
        <td>
        <?php 
        if($salida!=null){
          echo $salida->getNombre(); 
        }
        ?>
        </td>    
        <td>
        <?php 
        if($localidad!=null){ 
            echo $localidad; 
        }
        else{
            echo "-";
        }
        ?>
        </td> 
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
  <?php endforeach; ?>
</div>

<div id = "div_metricas_grupos">

<?php foreach ($pastoral_grupos_version as $grupo): ?>
<div id="MetricasGrupo<?php echo $grupo->getId() ?>" style="display:none;">

<input type="hidden" id="Grupo_vacio_o_no_<?php echo $grupo->getId() ?>" value="vacio">

<div class="page-header">
<h2><small>Estad&iacute;sticas del Grupo</small></h2>
</div>

<div class="span9 span-fixed-sidebar tab-content">

<div id="chart1_<?php echo $grupo->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart2_<?php echo $grupo->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart5_<?php echo $grupo->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart6_<?php echo $grupo->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="chart7_<?php echo $grupo->getId() ?>" style=" height: 250px; position: relative; " class="jqplot-target"></div>
</div>

</div>
<?php endforeach; ?>

</div>

      </div>
    </div>
  </div> <!--End info jefes--> 
</div> <!--End acordeon-->

<input type="hidden" id="url_token" value="<?php echo url_for('diadesalida/index?token=') ?>">
<input type="hidden" id="proyecto_version_id" value="<?php echo $pastoral_proyecto_version->getId()  ?>">
<input type="hidden" id="mail_usuario" value="<?php echo $mail_token  ?>">
<input type="hidden" id="nombre_usuario" value="<?php echo $nombre_token ?>">

<?php if($proyecto_activo){ ?>
<div class="accordion" id="divToken">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoToken" href="#divToken2">
        <h5 style="font-size:16px;"><i class="icon-chevron-down"></i> D&iacute;a de salida</h5>
      </a>
    </div>
    <div id="divToken2" class="accordion-body collapse">
      <div class="accordion-inner">     
         <div>
               <p>
               <input class="btn btn-info" name="botonToken" type="button" id="botonToken" value="Generar Token" />             
               </p>
              <br/>
         </div>
         <?php if($token){ ?>
         <div id="info_token">
         <b>URL: </b>/diadesalida?token=<input type="text" name="valorToken" value="<?php echo $token?>" id="valorToken" READONLY></input>
         <b>Fecha de creaci&oacute;n: </b><input type="text" name="fechaToken" value="<?php echo $fechaToken ?>" id="fechaToken" READONLY></input>
         <div id = "linkToken">
         <a href="<?php echo url_for('diadesalida/index?token='.$token) ?>"><b>&raquo; Ir a m&oacute;dulo D&iacute;a de Salida </b></a>
         </div>
         </div>
         <?php }?>
         
         <?php if(!$token){ ?>
         <div id="info_token" style="display:none;">
         <b>URL: </b>/diadesalida?token=<input type="text" name="valorToken" value="" id="valorToken" READONLY></input>
         <b>Fecha de creaci&oacute;n: </b><input type="text" name="fechaToken" value="" id="fechaToken" READONLY></input>
         </div>
         <div id = "linkToken">
         
         </div>
         <?php }?>
      </div>
    </div>
  </div> <!--End info estadisticas-->
</div> <!--End acordeon-->

<?php }?>

<br>
<br>
<br>

<script type="text/javascript">
    $(document).ready(function(){
        graficosModule.graficoInscritosAcomulados();
    });
</script>

<style type="text/css">
 	.menup {
 		font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:13px;
 		float:left;	
 		width:100%;
 		border-bottom:2px solid #155523
 	}
 	.menup ul {
 		list-style:none;
 		margin:0px;
 		padding:5px 10px 0
 	}
 	.menup li {
 		display:inline 
 	}	
 	.menup a {
 		float:left;
 		margin:0 1px 0 0;
 		padding:0px;
 		text-decoration:none
 	}	
 	.menup a span {
 		display:block;
 		padding:5px 15px
 	}
 	.menup a:hover {
 		background-position:100% -75px
 	}	
 	.menup a:hover span {
 		background-position:0% -75px;
 	}	
 	.menup li.current a {
 		background-position:100% -75px;
 		position:relative;
 		top:2px
 	}	
 	.menup li.current a span {
 		background-position:0% -75px;
 	}
</style>