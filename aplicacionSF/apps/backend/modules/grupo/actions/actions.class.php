<?php

/**
 * grupo actions.
 *
 * @package    pastoral
 * @subpackage grupo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class grupoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    if($cargo_actual->getVGrupo()!=1)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }
    if($uc->getGrupoId()!=null)
    {	
      $this->redirect("grupo/show?id=".$uc->getGrupoId());	
    }      
    
    if($uc->getProyectoVersionId()!=null)
    {	
      $this->pastoral_grupos = Doctrine_Core::getTable('PastoralGrupo')->FindByProyectoVersionId($uc->getProyectoVersionId());
    }
    
    $this->proyecto_id = $this -> getUser()->getAttribute('proyecto_id');
     
    $q4 = Doctrine_Query::create()
          ->from('PastoralProyecto pp')
          ->andWhere('pp.id = ?',$this->proyecto_id);
    $aux = $q4->execute();
    $this->proyecto = $aux[0];
    
  }

  public function executeShow(sfWebRequest $request)
  {
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    $this->pastoral_grupo = Doctrine_Core::getTable('PastoralGrupo')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->pastoral_grupo);
    if($cargo_actual->getVGrupo()!=1)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }  
    if($uc->puedeVerGrupo($this->pastoral_grupo)==0)
    {
      $this->redirect("usuario/PermisoDenegado");
    }
      
    $this->zonas = Doctrine_Core::getTable('PastoralMision')->addMissionesPorGrupoQuery($request->getParameter('id'))->fetchArray();
    
    $jefesActuales = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYGrupo($this->pastoral_grupo->getId())->execute();
    $jefes = array();
    foreach($jefesActuales as $jef)
    {
      $temp = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($jef['usuario_id']); 	
      $jefes[] = $temp;
    }
    $this->jefes = $jefes;
    
      
    $pastoral_misions = Doctrine_Core::getTable('PastoralMision')->addMissionesPorGrupoQuery($request->getParameter('id'))->execute();
	

    $salidas = array();
    $localidades = array();
	  $fechas_inicio = array();
	  $fechas_termino = array();
	  $sectores = array();
    
      foreach($pastoral_misions as $pm){
      
        $id_salida = $pm->getSalidaId();
        $id_localidad = $pm->getLocalidadId();		
        $id_localidad_fantasia = $pm->getLocalidadFantasiaId();
        
        $q2 = Doctrine_Query::create()
          ->from('PastoralSalida s')
          ->andWhere('s.id = ?',$id_salida);
          
        $salida = $q2->fetchOne();
		
        $q4 = Doctrine_Query::create()
          ->from('PastoralLocalidadFantasia s')
          ->andWhere('s.id = ?',$id_localidad_fantasia);
          
        $sector = $q4->fetchOne();
        
        $q3 = Doctrine_Query::create()
          ->from('PastoralLocalidad l')
          ->andWhere('l.id = ?',$id_localidad);
          
        $localidad = $q3->fetchOne();
        
        if($id_salida!= NULL)
          $salidas = array_merge($salidas, (array)$salida->getNombre());
        else
          $salidas = array_merge($salidas, (array)'');
        if($id_localidad!= NULL)
          $localidades = array_merge($localidades, (array)$localidad->getNombre());
        else
          $localidades = array_merge($localidades, (array)'');
        if($id_localidad_fantasia!= NULL)
          $sectores = array_merge($sectores, (array)$sector->getNombre());
        else
          $sectores = array_merge($sectores, (array)'');
		
		
        $fecha_inicio = $pm->getFechaInicio();
        $fecha_termino = $pm->getFechaTermino();
		
        if($fecha_inicio!= NULL)
        {
          $fecha_inicio = preg_replace('/00:00:00/', '', $pm->getFechaInicio());
          $fechas_inicio = array_merge($fechas_inicio, (array)$fecha_inicio);
        }
        else
          $fechas_inicio = array_merge($fechas_inicio, (array)'');	
        
        if($fecha_termino!= NULL)
        {
          $fecha_termino = preg_replace('/00:00:00/', '', $pm->getFechaTermino());
          $fechas_termino = array_merge($fechas_termino, (array)$fecha_termino);
        }
        else
          $fechas_termino = array_merge($fechas_termino, (array)'');
		
      
      }
    $this->pastoral_misions = $pastoral_misions;
    $this->salidas = (array)$salidas;
    $this->sectores = (array)$sectores;
    $this->localidades = (array)$localidades;
    $this->fechas_inicio = (array)$fechas_inicio;
    $this->fechas_termino = (array)$fechas_termino;
  }

  public function executeNew(sfWebRequest $request)
  {
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    if($cargo_actual->getCBGrupo()!=1)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }
    $this->form = new PastoralGrupoForm();	
    $proyecto_version_id = $uc->getProyectoVersion()->getId();	    
    $this->jefes = Doctrine_Core::getTable('PastoralUsuario') ->getPotencialesJefes($proyecto_version_id,NULL);
    $this->form->setDefault('proyecto_version_id',$proyecto_version_id);
    
  }

  public function executeCreate(sfWebRequest $request)
  {
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    if($cargo_actual->getCBGrupo()!=1)
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
    $proyecto_version_id = $uc->getProyectoVersion()->getId();	
    $this->jefes = Doctrine_Core::getTable('PastoralUsuario') ->getPotencialesJefes($proyecto_version_id,$jefes_selec);
    $this->form = new PastoralGrupoForm();	
    $this->form->setDefault('proyecto_version_id',$proyecto_version_id);

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    $this->forward404Unless($pastoral_grupo = Doctrine_Core::getTable('PastoralGrupo')->find(array($request->getParameter('id'))), sprintf('Object pastoral_grupo does not exist (%s).', $request->getParameter('id')));
    $this->borrar = 0;
    if($cargo_actual->getCBGrupo()==1)
    {	      
      $this->borrar = 1;
    } 
    if($cargo_actual->getEGrupo()!=1)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }       
    if($uc->puedeEditarGrupo($pastoral_grupo)==0)
    {
      $this->redirect("usuario/PermisoDenegado");
    }
    $jefesActuales = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYGrupo($pastoral_grupo->getId())->execute();
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
    $proyecto_version_id = $uc->getProyectoVersion()->getId();
    $this->jefes = Doctrine_Core::getTable('PastoralUsuario') ->getPotencialesJefes($proyecto_version_id,$jefes_selec);
    $this->form = new PastoralGrupoForm($pastoral_grupo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pastoral_grupo = Doctrine_Core::getTable('PastoralGrupo')->find(array($request->getParameter('id')))
    		, sprintf('Object pastoral_grupo does not exist (%s).'
    		, $request->getParameter('id')));
    if($cargo_actual->getEGrupo()!=1)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }    
    if($uc->puedeEditarGrupo($pastoral_grupo)==0)
    {
      $this->redirect("usuario/PermisoDenegado");
    }
    $this->borrar = 0;
    if($cargo_actual->getCBGrupo()==1)
    {	      
      $this->borrar = 1;
    } 
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
    $proyecto_version_id = $pastoral_grupo->getProyectoVersionId();
    $this->jefes = Doctrine_Core::getTable('PastoralUsuario') ->getPotencialesJefes($proyecto_version_id,$jefes_selec);
    $this->form = new PastoralGrupoForm($pastoral_grupo);    
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 

    $this->forward404Unless($pastoral_grupo = Doctrine_Core::getTable('PastoralGrupo')->find(array($request->getParameter('id'))), sprintf('Object pastoral_grupo does not exist (%s).', $request->getParameter('id')));
    if($cargo_actual->getCBGrupo()!=1)
    {	
      $this->redirect("usuario/PermisoDenegado");
    }    
    if($uc->puedeVerGrupo($pastoral_grupo)==0)
    {
      $this->redirect("usuario/PermisoDenegado");
    }
    
    
    $pastoral_grupo->delete();

    $this->redirect('grupo/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {    
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $pastoral_grupo = $form->save();	  
      $jefesActuales = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYGrupo($pastoral_grupo->getId())->execute();
      $jefes_id = $request->getParameter('jefe');      
      $existe_jefe = 0;
      if($jefes_id!=NULL)
      {
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
          $cargo_misionero = Doctrine_Core::getTable('PastoralCargo')->getCargoPorNombre("Jefe Regional");
          $cargo = new PastoralUsuarioCargo();
          $cargo
            ->setUsuarioId($jefe_id)
            ->setCargoId($cargo_misionero->getId())
            ->setGrupoId($pastoral_grupo->getId())
            ->save()
            ;
            
          $usuario = Doctrine_Core::getTable('PastoralUsuario')->findOneById($jefe_id); 
          $usuario->borrarUsuarioDeMueDelProyectoVersion($pastoral_grupo->getProyectoVersionId());
          
          $nu = new PastoralNotificacionUsuario();
          $nu->setRecibeId($jefe_id);
          $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
          $nu->setEnviado("Direcci&oacute;n");
          $nu->setAsunto("Jefe de Grupo");
          $nu->setMensaje("Felicitaciones, has sido seleccionado como jefe de Grupo de ".$pastoral_grupo->getNombre()." de ".$pastoral_grupo->getPastoralProyectoVersion()->getNombre());
          $nu->save();
        }
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
      $donde = $request->getParameter('guardar_y_nuevo');
      
      if($donde)
        $this->redirect('grupo/new');
      else
        $this->redirect('grupo/index');
    }
  }
  
  public function executeAjaxEstadisticaGrupoGenero(sfWebRequest $request)
  {   
    $grupo_id = $request->getParameter('grupo_id');    
    $respuesta = array();
    
    $misiones = Doctrine_Core::getTable('PastoralMision')->findByGrupoId($grupo_id);
    $generos = array();
    $generos['Hombres'] = 0;
    $generos['Mujeres'] = 0;
    
    if($misiones != null)
    {
    foreach($misiones as $mision)
      {                     
        $generos['Hombres'] += $mision->countHombres();
        $generos['Mujeres'] += $mision->countMujeres();       
      }
    }
    
    $respuesta[0]=array_keys($generos);
    $respuesta[1]=array_values($generos);
    
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaGrupoNecesidades(sfWebRequest $request)
  {   
    $grupo_id = $request->getParameter('grupo_id');    
    $respuesta = array();
    
    $misiones = Doctrine_Core::getTable('PastoralMision')->findByGrupoId($grupo_id);
    
    $necesidades_abarcadas = array();
    
    if($misiones != null)
    {
    foreach($misiones as $mision)
      {     
        $necesidades = $mision->getNecesidadMisiones();  
        if($mision->getLocalidadId()>0){
          $necesidades_abarcadas['Necesidades abarcadas']= array_key_exists('Necesidades abarcadas',$necesidades_abarcadas)? $necesidades_abarcadas['Necesidades abarcadas'] += $necesidades->count():$necesidades->count();
          $necesidades_abarcadas['Otras necesidades']= array_key_exists('Otras necesidades',$necesidades_abarcadas)?$necesidades_abarcadas['Otras necesidades'] += $mision->getPastoralLocalidad()->getNecesidades()->count()-$necesidades->count():$mision->getPastoralLocalidad()->getNecesidades()->count()-$necesidades->count();
        }
      }
    }
    
    $respuesta[0]=array_keys($necesidades_abarcadas);
    $respuesta[1]=array_values($necesidades_abarcadas);
    
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaGrupoExperiencia(sfWebRequest $request)
  {   
    $grupo_id = $request->getParameter('grupo_id');    
    $respuesta = array();
    
    $misiones = Doctrine_Core::getTable('PastoralMision')->findByGrupoId($grupo_id);
    
    $experiencia = array();
    
    if($misiones != null)
    {
    foreach($misiones as $mision)
      {
        $misioneros_uc = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision->getId());        
        if($misioneros_uc != null)
        {
          foreach ($misioneros_uc as $misionero_uc)
          {
            $misionero = $misionero_uc->getPastoralUsuario();
            if($misionero->fueAMision($mision->getId()))
            {
              $exp  = $misionero->getMUEs()->count()-1;
              $experiencia[$exp] = array_key_exists($exp,$experiencia)?$experiencia[$exp]+=1:1;
            }
          }
        }
      }
    }
    
    $respuesta[0]=array_keys($experiencia);
    $respuesta[1]=array_values($experiencia);
    
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaGrupoEdades(sfWebRequest $request)
  {   
    $respuesta = array();   
    $grupo = Doctrine_Core::getTable('PastoralGrupo')->findOneById($request->getParameter('grupo_id'));   
    $respuesta = $grupo->cantidadPorEdades();
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaGrupoMovimiento(sfWebRequest $request)
  { 
    $grupo_id = $request->getParameter('grupo_id');    
    $respuesta = array();    
    $movimientos = array();
    $movimientos_religiosos = Doctrine_Core::getTable('PastoralMovimiento')->findAll();
    foreach($movimientos_religiosos as $mr)
    {
      $res = $mr->cantidadPorGrupo($grupo_id);
      if($res!=0)
        $movimientos[$mr->getNombre()] = $res;
    }
    $respuesta[0]=array_keys($movimientos);
    $respuesta[1]=array_values($movimientos);
    
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaGrupoCarrera(sfWebRequest $request)
  {   
    $respuesta = array();
    
    $carreras = array();
    $carr = Doctrine_Core::getTable('PastoralCarrera')->findAll();
    
    foreach($carr as $c)
    {
      $total = $c->cantidadPorGrupo($request->getParameter('grupo_id'));
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
