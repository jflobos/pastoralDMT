<?php

/**
 * PastoralUsuario form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UsuarioRegistroForm extends BasePastoralUsuarioForm
{
  public function configure()
  {
      $this->disableLocalCSRFProtection();
      
      $this->useFields(array('rut', 'es_extranjero', 'nombre', 'apellido_paterno', 'apellido_materno', 'fecha_nacimiento',
      'sexo','telefono_celular', 'telefono_emergencia', 'region_id', 'comuna_id', 'direccion',
      'tipo_institucion_id', 'universidad_id', 'carrera_id', 'ano_ingreso', 'colegio_id',
      'movimiento_id', 'enfermedades_alergias'));
      
      $this->setDefault('es_extranjero',false);
      $this->widgetSchema['sexo']->setOption('multiple', false);
      $this->widgetSchema['sexo']->setOption('expanded', true);
      $this->widgetSchema['carrera_id']->addOption('order_by',array('nombre','asc'));
      
      $this->widgetSchema['comuna_id'] = new sfWidgetFormChoice(array(
				'renderer_class' => 'sfWidgetFormDoctrineJQueryAutocompleter',
				'choices' => array(),
				'renderer_options' => array(
									'model' => 'PastoralComuna',
									'url'   => ('AjaxGetComunas'),
                  'config' => '{ width: 220, max: 5, highlight:false, multiple: false, scroll: true, scrollHeight: 300}'									
				)));
      
      $this->widgetSchema['colegio_id'] = new sfWidgetFormChoice(array(
      		'renderer_class' => 'sfWidgetFormDoctrineJQueryAutocompleter',
      		'choices' => array(),
      		'renderer_options' => array(
      				'model' => 'PastoralColegio',
      				'url'   => ('AjaxGetColegios'),
      				'config' => '{ width: 220, max: 5, highlight:false, multiple: false, scroll: true, scrollHeight: 300}'
      		)));
      
      $currentYear = date("Y");
      $birthdayYears = range($currentYear-50, $currentYear-14);
      $this->widgetSchema['fecha_nacimiento'] = new sfWidgetFormDate( array('format' => '%day% - %month% - %year%',
      'years' => array_combine($birthdayYears, $birthdayYears), 
      'months'=> array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',
      9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre')));
      
      $this->widgetSchema->setFormFormatterName('custom');      
      $this->embedRelation('User');

     

    $this->widgetSchema->setLabels(array(
      'rut'                              => 'Rut:',
      'es_extranjera'                   => '¿Eres extranjero?:',
      'nombre'                       => 'Nombre:',
      'apellido_paterno'          => 'Apellido Paterno:',
      'apellido_materno'         => 'Apellido Materno:',
      'fecha_nacimiento'         => 'Fecha de Nacimiento:',
      'sexo'                           => 'Sexo:',
      
      'telefono_celular'           => 'Celular:',
      'telefono_emergencia'    => 'Teléfono de Emergencia:',
      'comuna_id'                  => 'Comuna:',
      'direccion'                     => 'Dirección:',
      
      'tipo_institucion_id'        => 'Tipo de Institución de Estudios:',
      'universidad_id'             => 'Universidad:',
      'carrera_id'                   => 'Carrera:',
      'ano_ingreso'                => 'Año de Ingreso:',
      'colegio_id'                   => 'Colegio:',
      'User'					=> 'Mail y contrase&ntilde;a con el que ver&aacute;s el estado de tu inscripci&oacute;n',
      'movimiento_id'             => '¿Perteneces a algún movimiento?',
      'enfermedades_alergias' => '¿Alguna enfermedad o alergia?',
		)); 
    
    $rutUniqueValidator = new sfValidatorDoctrineUnique(
            array('model' => 'PastoralUsuario', 'column' => array('rut')),
            array('invalid' => 'Este rut ya está registrado.')
          );
    $rutNotNullValidator = new sfValidatorCallback(array(
            'callback' => array($this, 'checkNullRut')
          ));
    $checkExtranjeroValidator = new sfValidatorCallback(array(
          'callback' => array($this, 'checkExtranjero')
        ));
    
    $this->mergePostValidator(
      new sfValidatorOr(array(
        new sfValidatorAnd(array(
          $rutUniqueValidator,
          $rutNotNullValidator
        ))
        ,
        $checkExtranjeroValidator
        
      ))
    );
    
    
      
  }
  
  
  public function checkExtranjero($validator, $values, $argument)
  {
    //die(var_dump($values));
    if(!$values['es_extranjero'])
    {
      $es = new sfValidatorErrorSchema($validator, array());
      throw $es;
    }
    
    return $values;
  }
  
  public function checkNullRut($validator, $values, $argument)
  {
    if($values['rut'] == "" )
    {
      $error = new sfValidatorError($validator, "Requerido.");
      $es = new sfValidatorErrorSchema($validator, array('rut' => $error));
      throw $es;
    }
    
    return $values;
  }
  
}
