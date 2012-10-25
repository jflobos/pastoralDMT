<?php

/**
 * PastoralLocalidad form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PastoralLocalidadCustomForm extends BasePastoralLocalidadForm
{
  public function configure()
  {
    $this->widgetSchema['localidad_fantasia_id'] = new sfWidgetFormDoctrineChoice(array(
        'model' => 'PastoralLocalidadFantasia',
        'query' => Doctrine_Query::create()->from('PastoralLocalidadFantasia lf'), 
        'add_empty' => '- Seleccione un sector -' ));
        
    $this->validatorSchema['localidad_fantasia_id'] = new sfValidatorPass();
    
    
    $this->useFields(array('nombre', 'localidad_fantasia_id', 'latitud', 'longitud'));
      
    $this->validatorSchema->setOption('allow_extra_fields', true);
    
    $this->widgetSchema->setLabel('localidad_fantasia_id', 'Sector');
    
    
  }
  
  
}
