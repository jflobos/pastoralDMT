<?php

/**
 * PastoralProyectoVersion form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PastoralProyectoVersionForm extends BasePastoralProyectoVersionForm
{
  public function configure(){  
  
      $proyecto_nombres_Array = array('- Seleccione el Proyecto -');
      $proyectos = Doctrine_Core::getTable('PastoralProyecto')->getProyectos();
      $ids_proyecto = array(-1);
  
      foreach ($proyectos as $pid)
      {  
        $proyecto_nombres_Array = array_merge($proyecto_nombres_Array,array($pid['nombre']));
        $ids_proyecto = array_merge($ids_proyecto, array($pid['id']));
           
      }
  
      $proyectos_con_ids = array_combine($ids_proyecto, $proyecto_nombres_Array);
      
      $this->widgetSchema['proyecto_id'] = new sfWidgetFormChoice(array(
				'choices' => $proyectos_con_ids));
        
      $this->widgetSchema['ano'] =  new sfWidgetFormInputText();
      
      $this->widgetSchema['version'] =  new sfWidgetFormInputText();  

      $this->widgetSchema['logo_url'] =  new sfWidgetFormInputText();       
      
      $this->useFields(array('proyecto_id', 'ano', 'version', 'logo_url'));
      
      
      $this->widgetSchema->setLabels(array(
			'proyecto_id'     => 'Proyecto*',
      'ano'             => 'A&ntilde;o*',
      'version'         => 'Versi&oacute;n*',
      'logo_url'        => 'URL del logo',
      )); 
      
      $this->validatorSchema['ano'] = new sfValidatorString(array(
      'required'   => true,
      ));
      $this->validatorSchema['version'] = new sfValidatorString(array(
      'required'   => true,
      ));
      

	    
  }
}
