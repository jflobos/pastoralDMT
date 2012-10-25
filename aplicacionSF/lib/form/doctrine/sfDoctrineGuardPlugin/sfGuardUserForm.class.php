<?php

/**
 * sfGuardUser form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    $this->disableLocalCSRFProtection();
    $this->useFields(array('email_address','password'));
    
    $this->validatorSchema['email_address'] = new sfValidatorEmail( array('required'=>true),array('invalid'=>'Lo sentimos, pero la dirección de correo no es válida.') );
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password']->setOption('required', true);
    $this->widgetSchema['password_confirmation'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_confirmation'] = clone $this->validatorSchema['password'];
 
    $this->widgetSchema->moveField('password_confirmation', 'after', 'password');
 
    $this->mergePostValidator(new sfValidatorSchemaCompare('password', 
    sfValidatorSchemaCompare::EQUAL, 'password_confirmation', array(), 
    array('invalid' => 'Lo sentimos, pero tus contraseñas no coinciden.')));
    
    $this->widgetSchema->setLabels(array(
      'username' => 'E-mail:',
      'email_address' => 'E-mail:',
      'password' => 'Contraseña:',
      'password_confirmation' => 'Confirmación de Contraseña:',
      'remember' => 'Recordarme'
    ));
    
    $this->widgetSchema->setFormFormatterName('embedded');
    
    $this->validatorSchema->getPostValidator()->setMessage('invalid', 'Lo sentimos, este e-mail ya se encuentra registrado.');

  }
}
