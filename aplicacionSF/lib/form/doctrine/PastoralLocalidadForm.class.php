<?php

/**
 * PastoralLocalidad form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PastoralLocalidadForm extends BasePastoralLocalidadForm
{
  public function configure()
  {
    $this->widgetSchema['localidad_fantasia_id'] = new sfWidgetFormDoctrineChoice(array(
        'model' => 'PastoralLocalidadFantasia',
        'query' => Doctrine_Query::create()->from('PastoralLocalidadFantasia lf'), 
        'add_empty' => '- Seleccione un sector -' ));
        
    $loc_fantasia_form = new PastoralLocalidadFantasiaForm();
    $loc_fantasia_form->widgetSchema->setFormFormatterName('custom');
    $loc_fantasia_form->setDefault('esta_embebida', 0);
    $this->embedForm('localidad_fantasia', $loc_fantasia_form);
    
    
    $validatorLocFantasia = clone $this->validatorSchema['localidad_fantasia'];
    
    
    $this->validatorSchema['localidad_fantasia'] = new sfValidatorPass();
    
    $this->mergePostValidator(
      new sfValidatorOr(array(
        new sfValidatorAnd(array(
          new sfValidatorSchemaFilter('localidad_fantasia', $validatorLocFantasia),
          new sfValidatorDoctrineUnique(
            array('model' => 'PastoralLocalidadFantasia', 'column' => array('nombre')),
            array('invalid' => 'El nombre del sector ya esta ocupado.')
          )
        ))
        ,
        new sfValidatorCallback(array(
          'callback' => array($this, 'checkNuevaLocFantasia')
        ))
        
      ))
    );
    
    
    $this->useFields(array('nombre', 'localidad_fantasia_id', 'localidad_fantasia', 'coord_x', 'coord_y'));
      
    $this->validatorSchema->setOption('allow_extra_fields', true);
    
    $this->widgetSchema->setLabel('localidad_fantasia_id', 'Sector');
    $this->widgetSchema->setLabel('localidad_fantasia', 'Nuevo sector');
    
    
    
    //$this->mergePostValidator(new LocalidadValidatorSchema());
  }
  
  
  public function checkNuevaLocFantasia($validator, $values, $argument)
  {
    //die(var_dump($values));
    if($values['localidad_fantasia']['esta_embebida'] == 1)
    {
      $es = new sfValidatorErrorSchema($validator, array());
      throw $es;
    }

 
    return $values;
  }
}
