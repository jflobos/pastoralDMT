<?php

/**
 * PastoralUsuario form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PastoralUsuarioForm extends BasePastoralUsuarioForm
{
  public function configure()
  {
      
      $this->useFields(array('rut', 'nombre', 'apellido_paterno', 'apellido_materno', 'fecha_nacimiento',
     'telefono_celular', 'sexo', 'universidad_id', 'carrera_id', 'movimiento_id'));
     
      $this->widgetSchema->setFormFormatterName('custom');
      $this->embedRelation('User');

      
  }
}
