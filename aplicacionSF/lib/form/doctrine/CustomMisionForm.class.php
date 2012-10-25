<?php

/**
 * PastoralMision form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CustomMisionForm extends BasePastoralMisionForm
{
  public function configure()
  {	
            
		$this->widgetSchema['fecha_inicio'] = new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,'culture'=>'es' ));
		$this->widgetSchema['fecha_termino'] = new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,'culture'=>'es' ));
		$this->widgetSchema['fecha_inicio_inscripcion'] = new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,'culture'=>'es' ));
		$this->widgetSchema['fecha_termino_inscripcion'] = new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,'culture'=>'es' ));
		
    $this->widgetSchema['proyecto_version_id'] = new sfWidgetFormDoctrineChoice(array(
          'model' => 'PastoralProyectoVersion',
          'query' => Doctrine_Query::create()->from('PastoralProyectoVersion pv'), 
          'add_empty' => '- Seleccione una version del proyecto -' ));
          
		$this->widgetSchema['salida_id'] = new sfWidgetFormDoctrineChoice(array( 
          'model' => 'PastoralSalida',
          'query' => Doctrine_Query::create()->from('PastoralSalida s'), 
          'add_empty' => '- Seleccione una salida -'  ));    
    
		$this->widgetSchema['localidad_id'] = new sfWidgetFormDoctrineChoice (array(
          'model' => 'PastoralLocalidad',
					'query' => Doctrine_Query::create()->from('PastoralLocalidad l'),
          'add_empty' => '- Seleccione una localidad -'  ));
		$this->widgetSchema['localidad_fantasia_id'] = new sfWidgetFormDoctrineChoice (array(
          'model' => 'PastoralLocalidadFantasia',
					'query' => Doctrine_Query::create()->from('PastoralLocalidadFantasia lf'), 
          'add_empty' => '- Seleccione una localidad de fantasia -'  )); 

    
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(new sfValidatorDoctrineUnique(
      array('model' => 'PastoralMision', 'column' => array('nombre')),
      array('invalid' => 'El nombre de la misi&oacute;n ya esta ocupado.')
    ))));
    
    $salida_form = new PastoralSalidaForm();
    $salida_form->widgetSchema->setFormFormatterName('custom');
    $salida_form->setDefault('nueva_salida', 0);
    $this->embedForm('salida', $salida_form);
    
    

    
    $validatorSalida = clone $this->validatorSchema['salida'];
    
    
    $this->validatorSchema['salida'] = new sfValidatorPass();
    
    $this->mergePostValidator(
      new sfValidatorOr(array(
        new sfValidatorAnd(array(
          new sfValidatorSchemaFilter('salida', $validatorSalida),
          new sfValidatorDoctrineUnique(
            array('model' => 'PastoralSalida', 'column' => array('nombre')),
            array('invalid' => 'El nombre de la salida ya esta ocupado.')
          )
        ))
        ,
        new sfValidatorCallback(array(
          'callback' => array($this, 'checkNuevaSalida')
        ))
        
      ))
    );

    
    
    
    $this->useFields(array('nombre', 'descripcion', 'fecha_inicio', 'fecha_termino', 'fecha_inicio_inscripcion',
      'fecha_termino_inscripcion', 'proyecto_version_id', 'salida_id', 'salida', 'localidad_id',
      'localidad_fantasia_id'));
      
    $this->validatorSchema->setOption('allow_extra_fields', true);
    

      
	

    

    
    
    
    
    
    
    
	}
  
  public function checkNuevaSalida($validator, $values, $argument)
  {
    //die(var_dump($values));
    if($values['salida']['nueva_salida'] == 1)
    {
      $es = new sfValidatorErrorSchema($validator, array());
      throw $es;
    }

 
    return $values;
  }
  

  
	

}

