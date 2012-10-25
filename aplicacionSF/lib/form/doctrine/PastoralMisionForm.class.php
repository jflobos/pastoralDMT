<?php

/**
 * PastoralMision form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PastoralMisionForm extends BasePastoralMisionForm
{
  public function configure()
  {
	  
	$zona = array('- Seleccione la localidad de la mision -');
  	$ids_localidades_Array = array(NULL);
    $mision =$this->getObject();
	  
    if($mision!= NULL)
    {
      if($mision->getLocalidadFantasiaId()!=NULL)
      {
        $localidades = Doctrine_Core::getTable('PastoralLocalidad')->findByLocalidadFantasiaId($mision->getLocalidadFantasiaId());   
        foreach($localidades as $localidad){
        $ids_localidades_Array = array_merge($ids_localidades_Array, array($localidad['id']));
        $zona = array_merge($zona,(array)$localidad['nombre']);
        }
      }
    }
	  
	  $zona_con_ids = array_combine($ids_localidades_Array, $zona);
	  
	  
	  
	  $salida = array('- Seleccione el lugar de salida -');
	  $ids_salida = array(NULL);
	  $puntosPartida = Doctrine_Core::getTable('PastoralSalida')->getSalidas();
	 
	  
	  foreach ($puntosPartida as $puntoPartida)
	  {
		$ids_salida = array_merge($ids_salida,(array)$puntoPartida['id']);
		$salida = array_merge($salida,(array)$puntoPartida['nombre']);
	  }
		
	  $salida = array_merge($salida,(array)'- Crear nueva Salida -');
	  $ids_salida = array_merge($ids_salida, array(-2));  
	  $salida_con_ids = array_combine($ids_salida, $salida);
	  
	  $fantasia = array('- Seleccione el nombre del sector -');
	  $ids_fantasia = array(NULL);
	  $localidadesFantasia = Doctrine_Core::getTable('PastoralLocalidadFantasia')->getLocalidadesFantasia();
	  
	  
	  foreach ($localidadesFantasia as $localidadFantasia)
	  {
		$fantasia = array_merge($fantasia,(array)$localidadFantasia['nombre']);
		$ids_fantasia = array_merge($ids_fantasia,(array)$localidadFantasia['id']);
	  }
		
	  $fantasia = array_merge($fantasia,(array)'- Crear nuevo Sector -');
	  $ids_fantasia = array_merge($ids_fantasia, array(-2));
	  
	  $fantasia_con_ids = array_combine($ids_fantasia, $fantasia);
	   
	  $JefeArray = array('- Seleccione el jefe de la mision -');
	  $Jefes = Doctrine_Core::getTable('PastoralUsuario')->findAll();
	  $ids_jefe = array(NULL);
	  
	  foreach ($Jefes as $jefe)
	  {
	  
		$string = $jefe['nombre'].' '.$jefe['apellido_paterno'].' '.$jefe['apellido_materno'];
		
		$JefeArray = array_merge($JefeArray, (array)$string);
		$ids_jefe = array_merge($ids_jefe, (array)$jefe['id']);
	  }
	  
	  $Jefes_con_ids = array_combine($ids_jefe, $JefeArray); 

	   $this->useFields(array('descripcion','fecha_inicio','fecha_termino',
							  'grupo_id','salida_id','localidad_id','localidad_fantasia_id','cuota','inscripcion_abierta'));
	  
	  
				
	  $this->widgetSchema['fecha_inicio'] = new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,'culture'=>'en' ));
	  $this->widgetSchema['fecha_termino'] = new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,'culture'=>'en' ));
	  				
	  $this->widgetSchema['salida_id'] = new sfWidgetFormChoice(array(
				'choices' => $salida_con_ids));
    
	  $nuevaSalidaForm = new PastoralSalidaForm();
	  $this->embedForm('nueva_salida', $nuevaSalidaForm);
				
	  $this->widgetSchema['localidad_id'] = new sfWidgetFormChoice(array(
				'choices' => $zona_con_ids));
				
	  $this->widgetSchema['localidad_fantasia_id'] = new sfWidgetFormChoice(array(
				'choices' => $fantasia_con_ids));
	  
	  $nuevaLocalidadFantasiaForm = new PastoralLocalidadFantasiaForm();
	  $this->embedForm('nuevo_sector', $nuevaLocalidadFantasiaForm);
	  
	  $this->widgetSchema['nuevo_sector']['foto_url'] = new sfWidgetFormInputText();
	  
	  $this->validatorSchema['nuevo_sector']['nombre']->setOption('required', false);
	  
	  $this->validatorSchema['localidad_fantasia_id']  = new sfValidatorChoice(array('choices' => $ids_fantasia, 'required' =>false));
		
	  $this->validatorSchema['nueva_salida']['nombre']->setOption('required', false);
	  
	  $this->validatorSchema['salida_id']  = new sfValidatorChoice(array('choices' => $ids_salida, 'required' =>false));
    
    
	  	  
    $this->widgetSchema->setLabels(array(
      'descripcion'         => 'Descripción',
			'Fecha_termino'   => 'Fecha de término',
			'salida_id' => 'Lugar de salida',
			'localidad_fantasia_id' => 'Sector',
		)); 
    $this->widgetSchema['nuevo_sector']['descripcion']->setLabel('Descripción');
    $this->widgetSchema['nueva_salida']['descripcion']->setLabel('Descripción');
	  }

	public function saveEmbeddedForms($con = null, $forms = null)
	{
	  if (null === $forms)
	  {
		$salida = $this->getValue('nueva_salida');
		$forms = $this->embeddedForms;
		  if (!isset($salida[$forms]))
		  {
			unset($forms['nueva_salida']);
		  }
		$fantasia =  $this->getValue('nuevo_sector');
		 if (!isset($fantasia[$forms]))
		  {
			unset($forms['nuevo_sector']);
		  }
	  }
	 
	  return parent::saveEmbeddedForms($con, $forms);
	}

	public function doSave($con = null)
	{
		
		$salida = $this->values['salida_id'];		
		$sal = new PastoralSalida();
		if($salida == -2 && $this->values['nueva_salida']['nombre'] !='')
		{
			$sal->setNombre($this->values['nueva_salida']['nombre']);
			$sal->setDescripcion($this->values['nueva_salida']['descripcion']);
			$sal->save();
			$this->values['salida_id'] = $sal->getId();
		}
		
		
		$localidad = $this->values['localidad_fantasia_id'];		
		$loc = new PastoralLocalidadFantasia();
		if($localidad == -2 && $this->values['nuevo_sector']['nombre'] !='')
		{
			$loc->setNombre($this->values['nuevo_sector']['nombre']);
			$loc->setDescripcion($this->values['nuevo_sector']['descripcion']);
			$loc->setFotoUrl($this->values['nuevo_sector']['foto_url']);
			$loc->save();
			$this->values['localidad_fantasia_id'] = $loc->getId();
		}		

		parent::doSave($con);
	}
}
