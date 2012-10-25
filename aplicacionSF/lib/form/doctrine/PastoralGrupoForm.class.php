<?php

/**
 * PastoralGrupo form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PastoralGrupoForm extends BasePastoralGrupoForm
{
  public function configure()
  {  
	$this->useFields(array('nombre', 'descripcion','cuota','fecha_inicio','fecha_termino','proyecto_version_id'));	

  	$this->widgetSchema['fecha_inicio'] = new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,'culture'=>'en' ));
	$this->widgetSchema['fecha_termino'] = new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,'culture'=>'en' ));  
  }  
  
}
