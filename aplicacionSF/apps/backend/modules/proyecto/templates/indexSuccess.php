<?php if($esDirector){ ?>

<!--NAVEGACIÓN-->
<div class="" style="text-align:left" >
  &raquo;
  <?php if($esDirector){ ?> 
  <a align="left" href="<?php echo url_for('proyecto/index') ?>">
    <span style='font-size:10px;color:blue'>Proyectos</span>
  </a>
  <?php } ?>
  <?php if($esJefe && !$esDirector){ ?> 
    <?php if($sf_user->getAttribute('usuario_cargo')->getPastoralCargo()->getVProyecto()==1){ ?> 
    <a align="left" href="<?php echo url_for('proyecto/index') ?>">
      <span style='font-size:10px;color:blue'><?php echo $pastoral_proyecto->getNombre() ?></span>
    </a>
    <?php } ?>
  <?php } ?>
</div>
<!--/NAVEGACIÓN-->

<!--ENCABEZADO-->
<div class="page-header">
<h1>Proyectos <small>Pastoral UC</small></h1>
</div>
<!--/ENCABEZADO-->

<!--LINKS DERECHOS-->
<div class="" style="text-align:right">
              <?php 
                     foreach($pastoral_proyecto as $pastoral_p)
                     {?>
                         <span id="LinkEditar<?php echo $pastoral_p->getId() ?>" style="display:none;">
                         <a href="<?php echo (url_for('proyecto/editProyecto').'?id='.$pastoral_p->getId()) ?>">Editar Proyecto</a> |
                         </span>
              <?php  }
              ?>
              <a href="<?php echo url_for('proyecto/new') ?>">Instanciar Proyecto</a> |
              <a href="<?php echo url_for('proyecto/newProyecto') ?>">Crear Proyecto</a>
</div>
<!--/LINKS DERECHOS-->

<input type="hidden" id="director_o_jefe" value="director">

<div class="container-fluid">
  <div class="row-fluid row">
  
    <div class="span5">
      <div class="well sidebar-nav-fixed">
      
        <ul class="nav nav-stacked">
          <li class="nav-header">Proyecto</li> <!-- se pueden poner mas de estos para subcategorias -->
          <li>
            <select id = 'dropdownProyectos' name ='dropdownProyectos' class="btn">
              <option value= '-1'>&#8212; Seleccione un Proyecto &#8212;</option>
              <?php 
                   foreach($pastoral_proyecto as $pastoral_p)
                   {
                       echo '<option id="'.$pastoral_p->getId().'" value="'.$pastoral_p->getId().'">';  
                       echo $pastoral_p->getNombre();
                       echo '</option>';
                   }
              ?>
              </select>
          </li>
          <li>
              <?php 
              foreach($pastoral_proyecto as $pastoral_p)
              { ?>
                   <div id="InfoGeneral<?php echo $pastoral_p->getId() ?>" style="display:none;">
                   </br>
                   <img src="<?php echo $pastoral_p->getLogoUrl() ?>" alt="<?php echo $pastoral_p->getNombre() ?>" width="250" height="150" />
                   </br></br>
                   <b>Descripci&oacute;n: </b><span><?php echo $pastoral_p->getDescripcion() ?></span>
                   </div>
              <?php } ?>
          </li>
        </ul>

      </div><!--/.well -->
    </div><!--/span-->

    
    <div class="span7">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoProyecto" href="#proyecto">
              <h5 style="font-size:16px;"><i class="icon-chevron-down"></i> Versiones</h5>
            </a>
          </div>
          <div id="proyecto" class="accordion-body in">
            <div class="accordion-inner">

              <div id='detallevProyecto'>
                 <div id = "div_general" style="display:none;">

                    <?php foreach ($pastoral_proyecto as $pastoral_p): ?>

                    <?php
                    // informacion de las instancias de este proyecto
                    $ids = array();
                    $anos = array();
                    $versiones = array();
                    $logos = array();

                    ?>
                    <?php foreach ($pastoral_proyecto_versions as $pastoral_proyecto_version): ?>

                    <?php
                    //Vemos si es un proyecto de este tipo: 
                    if($pastoral_p->getId()==$pastoral_proyecto_version->getProyectoId()){
                        $anos = array_merge($anos, array($pastoral_proyecto_version->getAno()));
                        $versiones = array_merge($versiones, array($pastoral_proyecto_version->getVersion()));
                        $ids = array_merge($ids, array($pastoral_proyecto_version->getId()));
                        $logos = array_merge($logos, array($pastoral_proyecto_version->getLogoUrl()));
                    }
                    ?>

                    <?php endforeach; ?>
                    <div id="Proyecto<?php echo $pastoral_p->getId() ?>" style="display:none;">
                      <table class="table table-bordered table-striped" align='center' valign='top' border='1'>
                        <thead>
                          <tr>
                            <th>Versi&oacute;n</th>
                            <th>A&ntilde;o</th>
                            <th>Logo</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $contador = 0; ?>
                          <?php $cantidad_versiones = count($ids); ?>
                          <?php foreach ($ids as $id): ?>
                        <tr>
                          <td><a href="<?php echo (url_for('proyecto/menuInstancia').'/id/'.$ids[$cantidad_versiones-1]) ?>" onclick="SetearComoJefeNacional('<?php echo $ids[$cantidad_versiones-1]?>')"><?php echo $pastoral_p->getNombre().' - '.$versiones[$cantidad_versiones-1] ?></td>
                          <td><?php echo $anos[$cantidad_versiones-1] ?></td>
                          <td><img src="<?php echo $logos[$cantidad_versiones-1] ?>"  width="100" height="50"/></td>
                        </tr>
                        <?php $cantidad_versiones--; ?>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                      <?php endforeach; ?>
                </div>
              </div>  
              
            </div>
          </div> <!--End info estadisticas-->
      </div> <!--End acordeon-->

  </div>
</div>   


<input type="hidden" name="GrupoRadioInfo" value="RadioGeneral" id="RadioGeneral" checked="false"></input>


<div class="accordion" id="infoEstadisticasP">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoEstadisticasP" href="#estadisticasP">
        <h5 style="font-size:16px;"><i class="icon-chevron-down"></i> Estad&iacute;sticas</h5>
      </a>
    </div>
    <div id="estadisticasP" class="accordion-body in">
      <div class="accordion-inner">
      
          <?php foreach ($pastoral_proyecto as $pastoral_p): ?>
          <div id="Proyecto<?php echo $pastoral_p->getId() ?>_metricas" style="display:none;">
          <input type="hidden" id="vacio_o_no_<?php echo $pastoral_p->getId() ?>" value="vacio">
          <div class="span9 span-fixed-sidebar tab-content">
          <div id="chart1_<?php echo $pastoral_p->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>
          <div id="chart5_<?php echo $pastoral_p->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>
          <div id="chart6_<?php echo $pastoral_p->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>
          <div id="chart7_<?php echo $pastoral_p->getId() ?>" style= " height: 250px; position: relative; " class="jqplot-target"></div>
          </div>
          </div>
          <?php endforeach; ?>
         
      </div>
    </div>
</div> <!--End acordeon-->

<?php } ?>



<?php if($esJefe){ ?>

<!--NAVEGACIÔŽ-->
<div class="" style="text-align:left" >
  &raquo;
  <?php if($esDirector){ ?> 
  <a align="left" href="<?php echo url_for('proyecto/index') ?>">
    <span style='font-size:10px;color:blue'>Proyectos</span>
  </a>
  
  <?php } ?>
  <?php if($esJefe && !$esDirector){ ?> 
    <?php if($sf_user->getAttribute('usuario_cargo')->getPastoralCargo()->getVProyecto()==1){ ?> 
    <a align="left" href="<?php echo url_for('proyecto/index') ?>">
      <span style='font-size:10px;color:blue'><?php echo $pastoral_proyecto_del_jefe ?></span>
    </a>
    <?php } ?>
  <?php } ?>
</div>
<!--/NAVEGACIÔŽ-->

<!--ENCABEZADO-->
<div class="page-header">
<h1>Proyectos <small>Pastoral UC</small></h1>
</div>
<!--/ENCABEZADO-->

<!--LINKS DERECHOS-->
<!--/LINKS DERECHOS-->

<input type="hidden" id="director_o_jefe" value="jefe">

<div class="container-fluid">
  <div class="row-fluid row">
  
    <div class="span5">
      <div class="well sidebar-nav-fixed">
      
        <ul class="nav nav-stacked">
          <li class="nav-header">Proyecto</li> <!-- se pueden poner mas de estos para subcategorias -->
          <li>
            <select id = 'dropdownProyectos' name ='dropdownProyectos' class="btn" READONLY> <!--READONLY-->
                <option id = "<?php echo $pastoral_proyecto_del_jefe->getId() ?>" value="<?php echo $pastoral_proyecto_del_jefe->getId() ?>"><?php echo $pastoral_proyecto_del_jefe->getNombre() ?></option>
            </select>
          </li>
          <li>
                   <div id="InfoGeneral<?php echo $pastoral_proyecto_del_jefe->getNombre() ?>">
                   </br>
                   <img src="<?php echo $pastoral_proyecto_del_jefe->getLogoUrl() ?>" alt="<?php echo $pastoral_proyecto_del_jefe->getNombre() ?>" width="250" height="250" />
                   </br></br>
                   <b>Descripci&oacute;n: </b><span><?php echo $pastoral_proyecto_del_jefe->getDescripcion() ?></span>
                   </div>
          </li>
        </ul>

      </div><!--/.well -->
    </div><!--/span-->

    
    <div class="span7">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoProyecto" href="#proyecto">
              <h5 style="font-size:16px;"><i class="icon-chevron-down"></i> Versiones</h5>
            </a>
          </div>
          <div id="proyecto" class="accordion-body in">
            <div class="accordion-inner">

              <div id='detallevProyecto'>
                 <div id = "div_general">

                    <?php
                    // informacion de las instancias de este proyecto
                    $ids = array();
                    $anos = array();
                    $versiones = array();
                    $logos = array();
                    ?>
                    <?php foreach ($pastoral_proyecto_versions as $pastoral_proyecto_version): ?>

                    <?php
                    //Vemos si es un proyecto de este tipo: 
                    if($pastoral_proyecto_del_jefe->getId()==$pastoral_proyecto_version->getProyectoId()){
                        $anos = array_merge($anos, array($pastoral_proyecto_version->getAno()));
                        $versiones = array_merge($versiones, array($pastoral_proyecto_version->getVersion()));
                        $ids = array_merge($ids, array($pastoral_proyecto_version->getId()));
                        $logos = array_merge($logos, array($pastoral_proyecto_version->getLogoUrl()));
                    }
                    ?>
                    <?php endforeach; ?>
                    <div id="Proyecto<?php echo $pastoral_proyecto_del_jefe->getId() ?>">
                     
                      <table class="table table-bordered table-striped" align='center' valign='top' border='1'>
                        <thead>
                          <tr>
                            <th>Versi&oacute;n</th>
                            <th>A&ntilde;o</th>
                            <th>Logo</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $contador = 0; ?>
                          <?php $cantidad_versiones = count($ids); ?>
                          <?php foreach ($ids as $id): ?>
                        <tr>
                          <td><a href="<?php echo (url_for('proyecto/menuInstancia').'/id/'.$ids[$cantidad_versiones-1]) ?>" click='SetearComoJefeNacional('<?php echo $ids[$cantidad_versiones-1] ?>')'><?php echo $pastoral_proyecto_del_jefe->getNombre().' - '.$versiones[$cantidad_versiones-1] ?></td>
                          <td><?php echo $anos[$cantidad_versiones-1] ?></td>
                          <td><img src="<?php echo $logos[$cantidad_versiones-1] ?>"  width="100" height="50"/></td>
                        </tr>
                        <?php $cantidad_versiones--; ?>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                    </div>
                 
                </div>
              </div>  
              
            </div>
          </div> <!--End info estadisticas-->
      </div> <!--End acordeon-->

  </div>
</div>   
<?php } ?>



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




  
