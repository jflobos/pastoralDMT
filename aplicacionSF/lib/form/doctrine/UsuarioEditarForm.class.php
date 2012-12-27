<?php

/**
 * PastoralUsuario form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UsuarioEditarForm extends UsuarioRegistroForm
{
  public function configure()
  {
      parent::configure();
      
      $this->widgetSchema['rut']-> setAttribute('readonly', 'true');
      $this->widgetSchema['sexo'] = new sfWidgetFormInputText();
      $this->widgetSchema['sexo']-> setAttribute('readonly', 'true');
      $this->widgetSchema['User']['email_address']-> setAttribute('readonly', 'true');
      $this->widgetSchema['nombre']-> setAttribute('readonly', 'true');
      $this->widgetSchema['apellido_paterno']-> setAttribute('readonly', 'true');
      $this->widgetSchema['apellido_materno']-> setAttribute('readonly', 'true');
      $this->widgetSchema['fecha_nacimiento']-> setAttribute('readonly', 'true');      
  }
  

}
