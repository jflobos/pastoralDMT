<?php

/**
 * PastoralLocalidadFantasia form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PastoralLocalidadFantasiaForm extends BasePastoralLocalidadFantasiaForm
{
  public function configure()
  {
    $this->validatorSchema->setPostValidator(
    
      new sfValidatorDoctrineUnique(
        array('model' => 'PastoralLocalidadFantasia', 'column' => array('nombre')),
        array('invalid' => 'El nombre del sector ya esta ocupado.')
      )
    
    );
    
    $this->widgetSchema['esta_embebida']=new sfWidgetFormInputHidden();
    
    
    $this->useFields(array('nombre', 'descripcion', 'foto_url', 'esta_embebida'));
    
    $this->validatorSchema->setOption('allow_extra_fields', true);
  }
}
