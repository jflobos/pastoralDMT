<?php

/**
 * PastoralSalida form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PastoralSalidaForm extends BasePastoralSalidaForm
{
  public function configure()
  {

    $this->validatorSchema->setPostValidator(
    
      new sfValidatorDoctrineUnique(
        array('model' => 'PastoralSalida', 'column' => array('nombre')),
        array('invalid' => 'El nombre de la salida ya esta ocupado.')
      )
    
    );
    
    $this->widgetSchema['nueva_salida']=new sfWidgetFormInputHidden();
    
    
    $this->useFields(array('nombre', 'descripcion', 'nueva_salida'));
    
    $this->validatorSchema->setOption('allow_extra_fields', true);
  
  }
}
