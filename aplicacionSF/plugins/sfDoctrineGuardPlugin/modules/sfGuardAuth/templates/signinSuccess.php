<?php use_helper('I18N') ?>

<h1><?php echo __('Signin', null, 'sf_guard') ?></h1>
<?php echo "PROYECTO: ".$proyecto_dado;?>
<?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form, 'proyecto_dado' => $proyecto_dado)) ?>