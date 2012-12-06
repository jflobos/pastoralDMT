<?php use_helper('I18N') ?>

<div align = "center"> 
<div class="page-header">
  <h1>Login <small>Pastoral UC   
  </small></h1>
</div>
<?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form, 'proyecto_dado' => $proyecto_dado, 'proyecto_id' => $proyecto_id)) ?>
</div>