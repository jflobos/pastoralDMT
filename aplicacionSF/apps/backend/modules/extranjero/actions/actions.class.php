<?php

/**
 * extranjero actions.
 *
 * @package    pastoral
 * @subpackage extranjero
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class extranjeroActions extends sfActions
{
  public function executeRegistrado(sfWebRequest $request)
  {
      $uc = $this->getUser()->getAttribute('usuario_cargo');
      $cargo = $uc->getPastoralCargo();
      if($cargo->getVeExtranjeros()==0)
          $this->redirect("usuario/PermisoDenegado");
      
      $this->estados_posibles = Doctrine_Core::getTable('PastoralEstadoPostulacion')->findAll();
      
      $this->cargo = $cargo;
      
      if($uc->getMisionId()>0)
          $q = Doctrine_Core::getTable('PastoralMision')->addMisionPorIdQuery($uc->getMisionId());
      else if($uc->getGrupoId()>0)
          $q = Doctrine_Core::getTable('PastoralMision')->addMissionesPorGrupoQuery($uc->getGrupoId()); 
      else if($uc->getProyectoVersionId()>0)
          $q = Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoVersionQuery($uc->getProyectoVersionId()); 
      else
          $this->redirect('usuario/informacion');
      
      $q = Doctrine_Core::getTable('PastoralMision')->addMisionesActivasQuery($q);
      
      $this->misiones_activas = $q->execute();

      $this->cargos_posibles = Doctrine_Core::getTable('PastoralCargo')->addCargosMisioneros()->execute();
  }
  
  public function executeAjaxEditarExtranjeros(sfWebRequest $request)
  {
      $selected      = $request->getParameter('selected');
      $mision_nueva = $request->getParameter('mision_nueva');        
      $respuesta = 1;
      foreach($selected as $ei_id)
      {
          $ei = Doctrine_Core::getTable('PastoralExtranjeroInscrito')->findOneById($ei_id);
          $usuario = $ei->getPastoralUsuario();
          
          if($mision_nueva>0)
          {
            $nu = new PastoralNotificacionUsuario();
            $nu->setRecibeId($usuario->getId());
            $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
            $nu->setEnviado("Inscripciones");
            $nu->setAsunto("Cambio de Zona");
            $nu->setMensaje("Te hemos cambiado a la siguiente Zona:".Doctrine_Core::getTable('PastoralMision')->findOneById($mision_nueva)->getPastoralLocalidadFantasia()->getNombre());
            $nu->save();
            $muec = new PastoralMisionUsuarioEstado();
            $muec->setUsuarioId($usuario->getId());
            $muec->setMisionId($mision_nueva);
            $muec->setEstadoPostulacionId(Doctrine_Core::getTable('PastoralEstadoPostulacion')->findOneByNombre('Aceptado')->getId());
            $muec->setDescripcionZona("Ingresa aquí tus comentarios");
            try {
                $muec->save();
            } catch (Doctrine\ORM\NoResultException $e) {
                $respuesta = 0;
            } catch (Exception $e) {
                $respuesta = 0;
            }
                
          }
      }
      return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxGetExtranjeros(sfWebRequest $request)
  {
    $mision_id  = $request->getParameter('mision_id');
    $estado_id  = $request->getParameter('estado_id');
    $pagina     =    $request->getParameter('pagina');
    
    $pagina     = $pagina > 0?$pagina:$pagina=1;     
    $resultados_por_pagina = 50;
    
    $usuario    = $this->getUser()->getGuardUser()->getProfile();
    $uc         = $this->getUser()->getAttribute('usuario_cargo');
    $cargo      = $uc->getPastoralCargo();
    
    $mues_query = Doctrine_Query::create()->from('PastoralExtranjeroInscrito ei');
    $mues_query = Doctrine_core::getTable('PastoralExtranjeroInscrito')->fullLeftJoin($mues_query);
    
    if($mision_id > 0)
        $mues_query->andWhere('m.id = ?',$mision_id);
        
    if($estado_id > 0)
        $mues_query->andWhere('ep.id = ?',$estado_id);
        
    if($uc->getMisionId()>0)
        $mues_query->andWhere('ei.proyecto_version_id = ?',$uc->getPastoralMision()->getPastoralGrupo()->getProyectoVersionId());
        
    if($uc->getGrupoId()>0)
        $mues_query->andWhere('ei.proyecto_version_id = ?',$uc->getPastoralGrupo()->getProyectoVersionId());
        
    if($uc->getProyectoVersionId()>0)
        $mues_query->andWhere('ei.proyecto_version_id = ?',$uc->getProyectoVersionId());
    
    //$mues_query->andWhere('m.fecha_termino > ?',date('Y-m-d H:i:s', time()));
    
    $mues_query = Doctrine_core::getTable('PastoralExtranjeroInscrito')->fullSelects($mues_query);

    $mues_query->addOrderBy('mue.id');
    $mues_query->addOrderBy('u.nombre');
    $mues_query->addOrderBy('u.apellido_paterno');
    
    $mues_query->GroupBy('u.id');
    
    $paginador  = new Doctrine_Pager($mues_query,$pagina,$resultados_por_pagina);
    
    $mues = $paginador->execute()->toArray();
    
    $res = Array();
    
    $res[0] = $cargo->toArray();
    
    if($cargo->getEInscritosMision()==1)
    {
        $mis = Array();
        $misiones_ = "";
        if($uc->getGrupoId() > 0){
            $misiones_ = Doctrine_Core::getTable('PastoralMision')->addMissionesPorGrupoQuery($uc->getGrupoId() );
        }
        else if($uc->getProyectoVersionId() > 0){
            $misiones_ = Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoVersionQuery($uc->getProyectoVersionId());
        }
        else if($uc->getProyectoId() > 0){
            $misiones_ = Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoQuery($uc->getProyectoId());
        }
        $misiones_ = Doctrine_Core::getTable('PastoralMision')->addMisionesActivasQuery($misiones_);
        $i = 0;
        foreach($misiones_ as $m)
        {
          $mis[$i]['id']=$m->getId();
          $mis[$i]['nombre']=$m->getNombre();
          $i++;
        }
        $res[1] = $mis;
    }
    
    $res[2] = $mues;
    $res[3] = ceil($paginador->getNumResults()/$resultados_por_pagina);//numero de paginas
    
    return $this->renderText(json_encode($res));
  }
}
