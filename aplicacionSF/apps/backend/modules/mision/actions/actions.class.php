<?php

/**
 * mision actions.
 *
 * @package    pastoral
 * @subpackage mision
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class misionActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo();
    
    
    if($cargo_actual->getVMisiones()==0)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }
    
    $pastoral_misions = array();
    if($uc->getMisionId()!=null)
    {
      $this->redirect("mision/show?mision_id=".$uc->getMisionId());
    }
    else if($uc->getGrupoId()!=null)
    {
      $gru_id = $uc->getGrupoId();
      $pastoral_misions = Doctrine_Core::getTable('PastoralMision')->addMissionesPorGrupoQuery($gru_id)->execute();
    }  
    else if($uc->getProyectoVersionId()!=null)
    {
      $pro_id = $uc->getProyectoVersionId();
      $pastoral_misions = Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoVersionQuery($pro_id)->execute();
    }
    else
    {
      $pro_id = $uc->getProyectoVersion()->getProyectoId();
      $pastoral_misions = Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoQuery($pro_id)->execute();
    }  
        
    $this->pastoral_misions = $pastoral_misions;
    $this->proyecto = $uc->getProyectoVersion()->getPastoralProyecto();
    
  }

  public function executeShow(sfWebRequest $request)
  {
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $this->cargo_actual = $uc->getPastoralCargo(); 
    
    $mision_id = $request->getParameter('mision_id');
    $this->pastoral_mision = Doctrine_Core::getTable('PastoralMision')->findOneById($mision_id);
    $this->pastoral_localidad_fantasia = Doctrine_Core::getTable('PastoralLocalidadFantasia')->findOneById($this->pastoral_mision->getLocalidadFantasiaId());
    $this->forward404Unless($this->pastoral_mision);    
    $this->filtros = Doctrine_Core::getTable('PastoralFiltro')->FindAll();    
    $this->mf = Doctrine_Core::getTable('PastoralMisionFiltro')->FindByMisionId($request->getParameter('mision_id'));
  
    if($uc->puedeVerMision($this->pastoral_mision)==0)
    {
      $this->redirect("usuario/PermisoDenegado");
    } 
    if($this->cargo_actual->getVMisiones()==0)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }
    
    $jefes_uc = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYMision($mision_id)->fetchArray();
    $jefes = array();
    
    for($i=0;$i<count($jefes_uc);$i++)
    {
      $jefes[$i] = Doctrine_Core::getTable('PastoralUsuario')->findOneById($jefes_uc[$i]['usuario_id']);
    }
    $this->jefes = $jefes;
    
    $misioneros_uc = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision_id)->toArray();
    $misioneros = array();
    
    for($i=0;$i<count($misioneros_uc);$i++)
    {
      $misioneros[$i] = Doctrine_Core::getTable('PastoralUsuario')->findOneById($misioneros_uc[$i]['usuario_id']);
    }
    $this->misioneros = $misioneros;
  }  
  
  public function executeNew(sfWebRequest $request)
  {
	//chequear permisos
	$uc = $this->getUser()->getAttribute('usuario_cargo');
	$cargo_actual = $uc->getPastoralCargo(); 
  	if($cargo_actual->getCBMisiones()==0){	
		$this->redirect("usuario/PermisoDenegado");
	}
	$this->proyecto_version_id = $uc->getProyectoVersion()->getId();	
	$this->jefes = Doctrine_Core::getTable('PastoralUsuario')->getPotencialesJefes($this->proyecto_version_id ,null);
	$this->filtros = Doctrine_Core::getTable('PastoralFiltro')->FindAll();
  	$this->universidades = Doctrine_Core::getTable('PastoralUniversidad')->FindAll();
  	$this->carreras = Doctrine_Core::getTable('PastoralCarrera')->FindAll();
  
	//preparación del form
  	$this->form = new PastoralMisionForm();
  
  }
  
  public function executeCreate(sfWebRequest $request)
  {			
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    if($cargo_actual->getCBMisiones()==0)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }
      $this->forward404Unless($request->isMethod(sfRequest::POST));
    $jefes_id = $request->getParameter('jefe');
    $jefes_selec = array();
    if($jefes_id!= NULL)
    {
      foreach($jefes_id as $jefe_id)
      {
        $temp = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($jefe_id);
        $jefes_selec[] = ($temp);		
      }
      $this->jefes_seleccionados = $jefes_selec;
    }
    $this->proyecto_version_id = $uc->getProyectoVersion()->getId();	
    $this->jefes = Doctrine_Core::getTable('PastoralUsuario') ->getPotencialesJefes($proyecto_version_id,$jefes_selec);  
    $this->filtros = Doctrine_Core::getTable('PastoralFiltro')->FindAll();    
    $this->universidades = Doctrine_Core::getTable('PastoralUniversidad')->FindAll();
    $this->carreras = Doctrine_Core::getTable('PastoralCarrera')->FindAll();
    $this->form = new PastoralMisionForm();
	
    $this->processForm($request, $this->form);
	

    $this->setTemplate('new');
  }

 public function executeEdit(sfWebRequest $request)
  {	
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    
    $this->forward404Unless($pastoral_mision = Doctrine_Core::getTable('PastoralMision')->find(array($request->getParameter('id'))), sprintf('Object pastoral_mision does not exist (%s).', $request->getParameter('id')));
    
    if($uc->puedeEditarMision($pastoral_mision)==0)
    {
      $this->redirect("usuario/PermisoDenegado");
    }
    if($cargo_actual->getEMisiones()==0)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }
    $this->filtros = Doctrine_Core::getTable('PastoralFiltro')->FindAll();    
    $this->universidades = Doctrine_Core::getTable('PastoralUniversidad')->FindAll();
    $this->carreras = Doctrine_Core::getTable('PastoralCarrera')->FindAll();
    $this->filtros_parametros = Doctrine_Core::getTable('PastoralMisionFiltro')->FindByMisionId($request->getParameter('id'));
    $jefesActuales = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYMision($pastoral_mision)->execute();
    $jefes_selec = array();
    if($jefesActuales!= NULL)
    {
      foreach($jefesActuales as $jefe)
      {
        $temp = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($jefe['usuario_id']); 	
        $jefes_selec[] = $temp;
      }
      $this->jefes_seleccionados = $jefes_selec;
    }
    $this->proyecto_version_id = $uc->getProyectoVersion()->getId();	
    $this->jefes = Doctrine_Core::getTable('PastoralUsuario') ->getPotencialesJefes($this->proyecto_version_id,$jefesActuales);
      $this->form = new PastoralMisionForm($pastoral_mision);
    if($uc->getMisionId()!=null)
    {
      $widget = new sfWidgetFormInputText();
      $widget->setAttribute('readonly','readonly');
      $this->form->setWidget('cuota',$widget);
    }
    
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pastoral_mision = Doctrine_Core::getTable('PastoralMision')->find(array($request->getParameter('id'))), sprintf('Object pastoral_mision does not exist (%s).', $request->getParameter('id')));
    
    if($uc->puedeEditarMision($pastoral_mision)==0)
    {
      $this->redirect("usuario/PermisoDenegado");
    }
    if($cargo_actual->getEMisiones()==0)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }
    
    $this->filtros = Doctrine_Core::getTable('PastoralFiltro')->FindAll();    
    $this->universidades = Doctrine_Core::getTable('PastoralUniversidad')->FindAll();
    $this->carreras = Doctrine_Core::getTable('PastoralCarrera')->FindAll();
    $this->filtros_parametros = Doctrine_Core::getTable('PastoralMisionFiltro')->FindByMisionId($request->getParameter('id'));
    $jefes_id = $request->getParameter('jefe');
    $jefes_selec = array();
    if($jefes_id!= NULL)
    {
      foreach($jefes_id as $jefe_id)
      {
        $temp = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($jefe_id);
        $jefes_selec[] = ($temp);		
      }
      $this->jefes_seleccionados = $jefes_selec;
    }    
    $this->proyecto_version_id = $uc->getProyectoVersion()->getId();	
    $this->jefes = Doctrine_Core::getTable('PastoralUsuario') ->getPotencialesJefes($this->proyecto_version_id,$jefes_selec);
    
    $this->form = new PastoralMisionForm($pastoral_mision);
    if($uc->getMisionId()!=null)
    {
      $widget = new sfWidgetFormInputText();
      $widget->setAttribute('readonly','readonly');
      $this->form->setWidget('cuota',$widget);
    }

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    if($cargo_actual->getCBMisiones()==0)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }
    $this->forward404Unless($pastoral_mision = Doctrine_Core::getTable('PastoralMision')->find(array($request->getParameter('id'))), sprintf('Object pastoral_mision does not exist (%s).', $request->getParameter('id')));
    $pastoral_mision->delete();

    $this->redirect('mision/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {	
  
	$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {		
      $pastoral_mision = $form->save();
      
      
      $jefesActuales = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYMision($pastoral_mision)->execute();
      $jefes_id = $request->getParameter('jefe');
      
      $existe_jefe = 0;
      
      foreach($jefes_id as $jefe_id)
      {
        $existe_jefe = 0;
        foreach($jefesActuales as $jefe)
        {
          if($jefe['usuario_id'] == $jefe_id)
            $existe_jefe = 1;
        }
        if($existe_jefe == 0)
        {
          $cargo_misionero = Doctrine_Core::getTable('PastoralCargo')->getCargoPorNombre("Jefe de Zona");
          $cargo = new PastoralUsuarioCargo();
          $cargo
            ->setUsuarioId($jefe_id)
            ->setCargoId($cargo_misionero->getId())
            ->setMisionId($pastoral_mision->getId())
            ->save()
            ;            
            
          $usuario = Doctrine_Core::getTable('PastoralUsuario')->findOneById($jefe_id); 
          $usuario->borrarUsuarioDeMueDelProyectoVersion($pastoral_mision->getPastoralGrupo()->getProyectoVersionId());
          
          $nu = new PastoralNotificacionUsuario();
          $nu->setRecibeId($jefe_id);
          $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
          $nu->setEnviado("Direcci&oacute;n");
          $nu->setAsunto("Jefe de Zona");
          $nu->setMensaje("Felicitaciones, has sido seleccionado como jefe de Zona de ".$pastoral_mision->getNombre()." de ".$pastoral_mision->getPastoralGrupo()->getPastoralProyectoVersion()->getNombre());
          $nu->save();
        }  
      }
	  
      foreach($jefesActuales as $jefe)
      {
      $existe_jefe = 0;
      foreach($jefes_id as $jefe_id)
      {
        if($jefe['usuario_id'] == $jefe_id)
          $existe_jefe = 1;
      }
      if($existe_jefe == 0)
      {			
        $jefe->delete();
      }
      }
      
      //guardar los Filtros Creados      
      $filtros = Doctrine_Core::getTable('PastoralFiltro') ->addFiltros()->execute();   
      if($request->getParameter('id')!=null)
        $filtros_parametros = Doctrine_Core::getTable('PastoralMisionFiltro')->FindByMisionId($request->getParameter('id'));
      $texto = $request->getParameter('infoFiltros');
      $arreglo = explode(";",$texto); 
      $nombre_filtro;
      $parametro;
      $nfil = 1;
      for ($i = 0; $i<count($arreglo); $i++) {
      
        $permiso = $arreglo[$i];
        if($nfil == 6)
        {
          $parametro = $arreglo[$i+1].';'.$arreglo[$i+2]; 
          $i=$i+2;
        }
        else if($nfil == 7)
        {
          $parametro = $arreglo[$i+1].';'.$arreglo[$i+2];    
          $i=$i+2;
        }
        else
        {
          $i++;
          $parametro = $arreglo[$i];
        }
        if($permiso == 'true')
        {
          $encontrado = 0;
          if($filtros_parametros!=null)
          {
            foreach($filtros_parametros as $mf)
            {
              if($mf->getFiltroId() == $nfil)
              {
                if($parametro!=$mf->getparametros())
                  $mf ->setParametros($parametro)
                      ->save();
                $encontrado = 1;                
                break;
              }
            }
          }
          if($parametro != "" && $encontrado ==0)
          {
            $filtro = new PastoralMisionFiltro();
            $filtro
              ->setMisionId($pastoral_mision->getId())
              ->setFiltroId($nfil)
              ->setParametros($parametro)
              ->save()
              ;        
          }            
        }
        else if($permiso=='false')
        {
          if($filtros_parametros!=null)
          {
            foreach($filtros_parametros as $mf)
            {
              if($mf->getFiltroId() == $nfil)
              {
                $mf ->delete();
              }
              break;
            }
          }
        }
        $nfil++;
      }      
      
      $donde = $request->getParameter('guardar_y_nueva');
      
      if($donde)
        $this->redirect('mision/new');
      else
        $this->redirect('mision/index');
    }
	
  }
  
  public function executeAjaxSectorCambio(sfWebRequest $request)
  {
    $sector_id = $request->getParameter('sector_id'); 
    $localidades = Doctrine_Core::getTable('PastoralLocalidad')->findByLocalidadFantasiaId($sector_id);
    
    $zona = array();
    $zona[] = '- Seleccione la localidad de la mision -';
	  
	  foreach($localidades as $localidad){
		$zona[] = $localidad['nombre'];
    	$zona[] = $localidad['id'];
	  }
    
	return $this->renderText(json_encode($zona));
  }
  
  public function executeAjaxProyectoCambio(sfWebRequest $request)
  {
    $proyecto_version_id = $request->getParameter('proyecto_version_id'); 
    $grupos = Doctrine_Core::getTable('PastoralGrupo')->findByProyectoVersionId($proyecto_version_id);
    
    $grupo = array();
	  
    if($grupos != null)
    {
      foreach($grupos as $grup){
      $grupo[] = $grup['nombre'];
      $grupo[] = $grup['id'];
      }
    }
    
		return $this->renderText(json_encode($grupo));
  }
  
   public function executeAjaxGrupoCambio(sfWebRequest $request)
  {
    $grupo_id = $request->getParameter('grupo_id'); 
    $grup = Doctrine_Core::getTable('PastoralGrupo')->findById($grupo_id);
    
    $grupo = array();
    
    $grupo[] = $grup[0]['cuota'];
    $grupo[] = $grup[0]['fecha_inicio'];
    $grupo[] = $grup[0]['fecha_termino'];
    
		return $this->renderText(json_encode($grupo));
  }
  
  public function executeAjaxEstadoInscripcionCambio(sfWebRequest $request)
  {
    $inscripcion_abierta = $request->getParameter('inscripcion_abierta'); 
    $mision_id = $request->getParameter('mision_id');
    
    $mision = Doctrine_Core::getTable('PastoralMision')->findOneById($mision_id);
    
    $mision->setInscripcionAbierta($inscripcion_abierta)
           ->save();
    
    $respuesta = 1;
		return $this->renderText(json_encode($respuesta));
  }
    
  public function executeAjaxEstadisticaMisionGenero(sfWebRequest $request)
  {
		$mision_id = $request->getParameter('mision_id');    
    $respuesta = array();
    
    $mision = Doctrine_Core::getTable('PastoralMision')->findOneById($mision_id);
    
    $generos = array();
    
    $generos['Hombres'] = $mision->countHombres();
    $generos['Mujeres'] = $mision->countMujeres();
    
    $respuesta[0]=array_keys($generos);
    $respuesta[1]=array_values($generos);
    
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaMisionNecesidades(sfWebRequest $request)
  {
		$mision_id = $request->getParameter('mision_id');    
    $respuesta = array();
    
    $mision = Doctrine_Core::getTable('PastoralMision')->findOneById($mision_id);
    $necesidades = $mision->getNecesidadMisiones();
    
    $necesidades_abarcadas = array();
    
    $necesidades_abarcadas['Necesidades abarcadas'] = $necesidades->count();
    $necesidades_abarcadas['Otras necesidades'] = $mision->getPastoralLocalidad()->getNecesidades()->count()-$necesidades->count();

    $respuesta[0]=array_keys($necesidades_abarcadas);
    $respuesta[1]=array_values($necesidades_abarcadas);
    
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaMisionExperiencia(sfWebRequest $request)
  {
		$mision_id = $request->getParameter('mision_id');    
    $respuesta = array();
    
    $mision = Doctrine_Core::getTable('PastoralMision')->findOneById($mision_id);
    $misioneros_uc = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision_id);
    
    $experiencia = array();

    foreach($misioneros_uc as $misionero_uc)
    {
      
      $misionero = $misionero_uc->getPastoralUsuario();
      if($misionero->fueAMision($mision->getId()))
      {
        $exp  = $misionero->getMUEs()->count()-1;
        $experiencia[$exp] = array_key_exists($exp,$experiencia)?$experiencia[$exp]+=1:1;
      }
    }
    $respuesta[0]=array_keys($experiencia);
    $respuesta[1]=array_values($experiencia);
    
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaMisionEdades(sfWebRequest $request)
  {
		$mision_id = $request->getParameter('mision_id');       
    $mision = Doctrine_Core::getTable('PastoralMision')->findOneById($mision_id);
    $respuesta = $mision->cantidadPorEdades();
    
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaMisionMovimiento(sfWebRequest $request)
  {
		$mision_id = $request->getParameter('mision_id');    
    $respuesta = array();    
    $movimientos = array();
    $movimientos_religiosos = Doctrine_Core::getTable('PastoralMovimiento')->findAll();
    foreach($movimientos_religiosos as $mr)
    {
      $res = $mr->cantidadPorMision($mision_id);
      if($res!=0)
        $movimientos[$mr->getNombre()] = $res;
    }
    $respuesta[0]=array_keys($movimientos);
    $respuesta[1]=array_values($movimientos);
    
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaMisionCarreras(sfWebRequest $request)
  {
		$respuesta = array();
    
    $mision = Doctrine_Core::getTable('PastoralMision')->findOneById($request->getParameter('mision_id'));
    $carreras = array();
    $carr = Doctrine_Core::getTable('PastoralCarrera')->findAll();
    
    foreach($carr as $c)
    {
      $total = $c->cantidadPorMision($request->getParameter('mision_id'));
      if($total != 0)
      {
        $carreras[$c->getNombre()] =$total;
      }
    }
    
    $respuesta[0]=array_keys($carreras);
    $respuesta[1]=array_values($carreras);
    
    return $this->renderText(json_encode($respuesta));
  }
}
