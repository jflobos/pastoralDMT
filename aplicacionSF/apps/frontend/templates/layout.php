<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <style>
    	select{
    		width: 160px;
    	}
    </style>
  </head>

<header>
  <?php if($sf_user->isAuthenticated()) : ?>
            
    <div class="">
              <a href="<?php echo url_for('@homepage'); ?>">Estado Inscripción</a> 
              |
              <a href="<?php echo url_for('usuario/informacion'); ?>">Mi Cuenta</a> 
              <?php if($sf_user->getProfile()->veCoevaluacion()):?>
                |
                <a href="<?php echo url_for('usuario/formularioCoEvaluacion')?>">Coevaluaci&oacute;n</a>
              <?php endif;?>
              |
              <a href="<?php echo url_for('@sf_guard_signout'); ?>">Cerrar Sesión</a>
    </div>
  <?php endif;?>
</header>
  <body>
    <div id="content" class="embedido" style="width: 800px; margin-left: auto; margin-right: auto;">
    <?php echo $sf_content ?>
    </div>
  </body>
</html>