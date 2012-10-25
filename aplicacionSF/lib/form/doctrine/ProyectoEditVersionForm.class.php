<?php

/**
 * PastoralProyectoVersion form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProyectoEditVersionForm extends BasePastoralProyectoVersionForm
{
  public function configure(){  
  
      parent::configure(); 
        
      $this->widgetSchema['proyecto_id'] = new sfWidgetFormInputText();
      $this->widgetSchema['proyecto_id']-> setAttribute('readonly', 'true');
        
      $this->widgetSchema['ano'] =  new sfWidgetFormInputText();
      
      $this->widgetSchema['version'] =  new sfWidgetFormInputText();  

      $this->widgetSchema['logo_url'] =  new sfWidgetFormInputText();       
      
      $this->useFields(array('proyecto_id', 'ano', 'version', 'logo_url'));
      
      
      $this->widgetSchema->setLabels(array(
			'proyecto_id'         => 'Proyecto *',
      'ano'   => 'A&ntilde;o *',
      'version'         => 'Versi&oacute;n *',
      'logo_url'        => 'URL del logo',
      ));

      unset($this['proyecto_id']);      
        
  }
}
