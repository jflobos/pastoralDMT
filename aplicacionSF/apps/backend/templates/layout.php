<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <script type="text/javascript">
        //Libreria para el manejo de routing
        var routing = (function(){
            var getPath = function(){
                return '<?php echo public_path(); ?>';
            }
            return {
                public_path:  function public_path(path){
                        if(path)
                            retorno = getPath()+path;
                        else
                            retorno = getPath();
                        return retorno; 
                },
                url_for: function url_for(module, action){
                    return getPath()+'backend.php'+'/'+module+'/'+action;
                }
            }
        })();        
    </script>
  </head>

<header>
   <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a> 
        <?php if($sf_user->isAuthenticated()) :?>
            <?php $uc = $sf_user->getAttribute('usuario_cargo');
                    if($uc != null )  /* -----------TIENE CARGO --------------*/
                    { 
                          $cargo_actual = $uc->getPastoralCargo();
                          $texto = $uc->getProyectoVersion();
                          if($uc->getProyectoVersion()==null)
                            $texto = 'Pastoral UC';?>
                          
                          
                          <a id='99876' align="left" style="width:200px;height:18px" class="brand" href="<?php echo url_for('cargo/index'); ?>"><?php
                          echo "<span><span style='font-size:20px;'>".$texto."</span></br><span style='font-size:10px;'>".$uc->getPastoralCargo()->getNombre()."</span></span>";
                          ?></a>
                          
                          <div class="nav-collapse">
                              <ul class="nav">
                                  
                            <?php if($cargo_actual->getEProyecto()){ ?>
                                  <li><a href="<?php echo url_for('proyecto/index'); ?>">Proyectos</a></li>
                            <?php } ?>
                            <?php if($cargo_actual->getVProyectoversion() && !$cargo_actual->getEProyecto()){ ?>
                                  <li><a href="<?php echo url_for('proyecto/menuInstancia?id='.$uc->getProyectoVersionId()); ?>">Proyecto</a></li>
                            <?php } ?>
                            <?php if($cargo_actual->getVGrupo())
                                  { 
                                    $tipo ='';
                                    if($uc->getProyectoVersion()==null)
                                      $tipo= 'style="display:none;"';
                                    $plural = 's';
                                    if($uc->getGrupoId()){$plural='';}?>
                                    <li <?php echo $tipo ?> id='768531'><a  href="<?php echo url_for('grupo/index'); ?>"><?php echo ($plural!='') ? 'Regiones':'Regi&oacute;n'  ?></a></li>    
                            <?php }
                                  if($cargo_actual->getVMisiones()){ 
                                    $tipo ='';
                                    if($uc->getProyectoVersion()==null)
                                      $tipo= 'style="display:none;"';
                                    $plural = 's';
                                    if($uc->getMisionId()){$plural='';}?>
                                    <li <?php echo $tipo ?> id='768532'><a href="<?php echo url_for('mision/index'); ?>">Zona<?php echo $plural ?></a></li>
                            <?php }?>
                            <?php if($cargo_actual->getVMisioneros())
                                  {?>
                                      <li><a href="<?php echo url_for('usuario/inscritos'); ?>">Inscritos</a></li>
                            <?php } ?>
                            <?php if($cargo_actual->getVeExtranjeros())
                                  {?>
                                      <li><a href="<?php echo url_for('extranjero/registrado'); ?>">Extranjeros</a></li>
                            <?php } ?>
                              </ul>
                        
                        <ul class="nav pull-right">
                           
                            <?php if($cargo_actual->getVeEvaluacionMision() && $uc->getPastoralMision()->getLocalidadId() > 0)
                                  {?>
                                  <li><form class="move-top btn btn-danger"><a style="color: #ffffff;" href="<?php echo url_for('usuario/formularioLocalidad?mision='.$uc->getMisionId()); ?>">Evaluaci&oacute;n</a></form>&emsp;</li>            
                            <?php } ?>                           
                           <li class="active">
                                <form class="navbar-search pull-left" action="<?php echo url_for('usuario/busqueda');?>" method="get">
                                    <input name="busqueda" type="text" class="search-query span1" placeholder="B&uacute;squeda de Usuarios" style="width:133px;height:14px"></input>
                                </form>
                           </li>
                           <?php  include_component('notificacion','notificaciones');?>
                           <li class="dropdown" id="menu1">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#menu1">
                                 <i class="icon-user icon-white"></i> 
                                   <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu" align="left" size="width:30px">
                                 <li><a href="<?php echo url_for('cargo/index'); ?>">&nbsp; Historial</a></li>
                                 <li><a href="<?php echo url_for('usuario/informacion'); ?>">&nbsp; Mi Cuenta</a></li>
                                 <li class="divider"></li>
                                 <li><a href="<?php echo url_for('@sf_guard_signout'); ?>">&nbsp; Cerrar Sesi&oacute;n</a></li>
                              </ul>
                            </li>
                        </ul>

                    <?php
                    }else                /* -----------MISIONERO --------------*/
                    {?>
                          <a class="brand" href="<?php echo url_for('usuario/informacion'); ?>">Mision Pa&iacute;s</a>
                          <div class="nav-collapse">
                        <ul class="nav">

                        </ul>
                        <ul class="nav pull-right">
                           <?php  include_component('notificacion','notificaciones');?>
                           <li class="dropdown" id="menu1">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#menu1">
                                 <i class="icon-user"></i> 
                                   <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu" align="left">
                                 <li><a href="<?php echo url_for('usuario/informacion'); ?>">&nbsp; Configuraci&oacute;n</a></li>
                                 <li class="divider"></li>
                                 <li><a href="<?php echo url_for('@sf_guard_signout'); ?>">&nbsp; Cerrar Sesi&oacute;n</a></li>
                              </ul>
                            </li>
                        </ul>
    
              <?php }?>
      
                  <?php else:?><!-- USER NOT AUTHENTICATED -->
                            <a class="brand" href="<?php echo url_for('usuario/informacion'); ?>">Pastoral</a>
                            <div class="nav-collapse">
                                <ul class="nav">
                                    <li class="active"><a href="<?php echo url_for('@sf_guard_signin'); ?>">Login</a></li>
                                </ul>
          <?php endif;?>
        </div><!-- /.nav-collapse -->
      </div>
    </div><!-- /navbar-inner -->
  </div><!-- /navbar -->
</header>

  <body>
    <div id="content">
    </br>
    </br>
    </br>
    <?php echo $sf_content ?>
    </div>
  </body>
</html>