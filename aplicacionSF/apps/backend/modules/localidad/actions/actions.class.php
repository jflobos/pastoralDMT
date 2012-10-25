<?php

/**
 * localidad actions.
 *
 * @package    pastoral
 * @subpackage localidad
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class localidadActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->pastoral_localidads = Doctrine_Core::getTable('PastoralLocalidad')
      ->createQuery('a')
      ->execute();
      
    $this->proyecto = Doctrine_Core::getTable('PastoralProyecto')->findOneById($this -> getUser()->getAttribute('proyecto_id'));
  }

  public function executeShow(sfWebRequest $request)
  {
    $localidad = Doctrine_Core::getTable('PastoralLocalidad')->find(array($request->getParameter('id')));
    $this->forward404Unless($localidad);
    
    $this->pastoral_localidad = $localidad;
       
    $this->comentarios_activos = $localidad->getNecesidadesActivas();
    $this->comentarios_cubiertos = $localidad->getNecesidadesCubiertas();
    
    $this->tipos_comentarios = Doctrine_Core::getTable('PastoralTipoNecesidad')->findAll();
    
    
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PastoralLocalidadForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PastoralLocalidadForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($pastoral_localidad = Doctrine_Core::getTable('PastoralLocalidad')->find(array($request->getParameter('id'))), sprintf('Object pastoral_localidad does not exist (%s).', $request->getParameter('id')));
    $this->form = new PastoralLocalidadForm($pastoral_localidad);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pastoral_localidad = Doctrine_Core::getTable('PastoralLocalidad')->find(array($request->getParameter('id'))), sprintf('Object pastoral_localidad does not exist (%s).', $request->getParameter('id')));
    $this->form = new PastoralLocalidadForm($pastoral_localidad);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($pastoral_localidad = Doctrine_Core::getTable('PastoralLocalidad')->find(array($request->getParameter('id'))), sprintf('Object pastoral_localidad does not exist (%s).', $request->getParameter('id')));
    $pastoral_localidad->delete();

    $this->redirect('localidad/index');
  }

   public function executeEditar(sfWebRequest $request)
  {
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $pastoral_localidad = $form->save();

      $this->redirect('localidad/edit?id='.$pastoral_localidad->getId());
    }
  }
  
  public function executeAjaxGetLocalidades(sfWebRequest $request)
  {
  
    return $this->renderText(json_encode(Doctrine_Core::getTable('PastoralLocalidad')->findAll()->toArray()));
  }
  
  public function executeUnirAZona(sfWebRequest $request)
  {
    $this->mision = Doctrine_Core::getTable('PastoralMision')->findOneById($request->getParameter('mision_id'));
    $this->form = new PastoralLocalidadCustomForm();
    $this->form->setDefault('localidad_fantasia_id', $this->mision->getLocalidadFantasiaId());
  }
  
  public function executeCrearYUnir(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    
    $mision = Doctrine_Core::getTable('PastoralMision')->findOneById($request->getParameter('mision_id'));
    
    //Si es que eligió una localidad y no la creó.
    if($request->getParameter("localidad_id") != -1)
    {
      $mision->setLocalidadId($request->getParameter("localidad_id"))
             ->save();
             
      $this->redirect('mision/show?mision_id='.$request->getParameter('mision_id'));
    }

    //En caso de que la haya creado...
    $this->form = new PastoralLocalidadCustomForm();
    

    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
      $localidad = $this->form->save();
      
      $localidad->setLocalidadFantasiaId($request->getParameter('sector_id'))
                ->save();
      
      $mision->setLocalidadId($localidad->getId())
             ->save();

      $this->redirect('mision/show?mision_id='.$request->getParameter('mision_id'));
    }
    
    $this->mision = $mision;
    $this->setTemplate('unirAZona');
  }
  
  public function executeAjaxGetInfoLugar(sfWebRequest $request)
  {
    $lugar = Doctrine_Core::getTable('PastoralLugar')->getLugarYContactosPorId($request->getParameter('id'));
    return $this->renderText(json_encode($lugar->toArray()));
  }
  
  public function executeAjaxGetLugar(sfWebRequest $request)
  {
    $lugar = Doctrine_Core::getTable('PastoralLugar')->findOneById($request->getParameter('id'));
    return $this->renderText(json_encode($lugar->toArray()));
  }
  
  public function executeAjaxCrearActualizarContacto(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $localidad_id = $request->getParameter('localidad_id');
    $lugar_id = $request->getParameter('lugar_id');
    $nombre = $request->getParameter('nombre');
    $cargo = $request->getParameter('cargo');
    $telefono = $request->getParameter('telefono');
    
    $tipo = $request->getParameter('tipo_contacto');
    

    if($id > 0)
      $contacto = Doctrine_Core::getTable('PastoralContacto')->findOneById($id);
    else
      $contacto = new PastoralContacto();
    
    
    
    
    if($lugar_id > 0)
    {
      $lugar = Doctrine_Core::getTable('PastoralLugar')->findOneById($lugar_id);
      $contacto -> setLugarId($lugar_id);
      $contacto -> setTipoContactoId($lugar->getTipoContactoId());
    }
    else
    {
      $contacto -> setLocalidadId($localidad_id);
      $contacto -> setTipoContactoId($tipo);
    }
      
    $contacto -> setNombre($nombre)
              -> setCargo($cargo)
              -> setTelefono($telefono)
              ->save()
              ;
    //TODO: catch error
    
    return $this->renderText(json_encode(array("status"=>"success", "contacto"=>$contacto->toArray(),
                                                "tipo_contacto"=>$contacto->getPastoralTipoContacto()->getNombre())  ));
  }
  
  public function executeAjaxEliminarContacto(sfWebRequest $request)
  {
    $contacto = Doctrine_Core::getTable('PastoralContacto')->findOneById($request->getParameter('id'));
    
    $contacto->delete();
    
    return $this->renderText(json_encode(  array("status"=>"success")  ));
  }
  
  public function executeAjaxCrearActualizarLugar(sfWebRequest $request)
  {
    $lugar_id = $request->getParameter('lugar_id');
    $localidad_id = $request->getParameter('localidad_id');
    $tipo = Doctrine_Core::getTable('PastoralTipoContacto')->findOneByNombre($request->getParameter('nombre_tipo_lugar'));
    $nombre = $request->getParameter('nombre');
    $direccion = $request->getParameter('direccion');
    $comentario = $request->getParameter('comentario');
    
    if($lugar_id > 0)
    {
      $lugar = Doctrine_Core::getTable('PastoralLugar')->findOneById($lugar_id);
    }
    else
    {
      $lugar = new PastoralLugar();
      $lugar -> setTipoContactoId($tipo->getId());
    }
      
    $lugar  -> setNombre($nombre)
            -> setDireccion($direccion)
            -> setComentario($comentario)
            -> setLocalidadId($localidad_id)
            -> save()
            ;
    //TODO: catch error
    
    return $this->renderText(json_encode(  array("status"=>"success", "lugar"=>$lugar->toArray())  ));
  }
  
  public function executeAjaxActualizarLugar(sfWebRequest $request)
  {
    $lugar = Doctrine_Core::getTable('PastoralLugar')->findOneById($request->getParameter('id'));
    
    $lugar->setNombre($request->getParameter('nombre'))
          ->setDireccion($request->getParameter('direccion'))
          ->setComentario($request->getParameter('comentario'))
          ->save();
    return $this->renderText(json_encode(  array("status"=>"success", "lugar"=>$lugar)  ));
  }
  
  public function executeAjaxActualizarChecklistLugar(sfWebRequest $request)
  {
    $lugar = Doctrine_Core::getTable('PastoralLugar')->findOneById($request->getParameter('id'));
    $perfil = Doctrine_Core::getTable('PastoralPerfilAlojamiento')->findOneByLugarId($request->getParameter('id'));
    
    if( $perfil != null)
      $perfil->reset();
    else{
      $perfil = new PastoralPerfilAlojamiento();
      $perfil->setLugarId($lugar->getId());
    }
    
    parse_str($request->getParameter('checklist'), $checklist);
    foreach(array_keys($checklist['pastoral_perfil_alojamiento']) as $item)
    {
      $perfil->set($item, 1);
    }
    $perfil->save();
    return $this->renderText(json_encode(  array("status"=>"success", "checklist"=>$checklist, "perfil"=>$perfil->toArray())  ));
  }
  
  public function executeAjaxActualizarComentarioLugar(sfWebRequest $request)
  {
    $lugar = Doctrine_Core::getTable('PastoralLugar')->findOneById($request->getParameter('id'));
    
    $lugar->setComentario($request->getParameter('comentario'))
          ->save();
    return $this->renderText(json_encode(  array("status"=>"success")  ));
  }
  
  public function executeAjaxCrearComentario(sfWebRequest $request)
  {
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $comentario = new PastoralNecesidad();
    $tipo_comentario =  Doctrine_Core::getTable('PastoralTipoNecesidad')->findOneByNombre($request->getParameter('tipo'));
    $estado_comentario =  Doctrine_Core::getTable('PastoralEstadoNecesidad')->findOneByNombre('Pendiente');
    
    if($request->getParameter('latitud') != null && $request->getParameter('longitud') != null)
    {
      $comentario -> setLatitud($request->getParameter('latitud'))
                  -> setLongitud($request->getParameter('longitud'));
    }
    
    
    $comentario -> setLocalidadId($request->getParameter('localidad_id'))
                -> setDescripcion($request->getParameter('descripcion'))
                -> setTipoNecesidadId($tipo_comentario->getId())
                -> setEstadoNecesidadId($estado_comentario->getId())
                -> setUsuarioCreadorId($usuario->getId())
                -> setUsuarioEditorId($usuario->getId())
                -> save();
    
    $q = Doctrine_Core::getTable('PastoralNecesidad')->getNecesidadPorIdQuery($comentario->getId());
    $comentario_array = $q->fetchOne()->toArray();
    
    return $this->renderText(json_encode(  array("status"=>"success", "comentario"=>$comentario_array)  ));
  }
  
  
  public function executeAjaxUpdateComentario(sfWebRequest $request)
  {
    $comentario = Doctrine_Core::getTable('PastoralNecesidad')->findOneById($request->getParameter('id'));
    
    if($request->getParameter('latitud') != null && $request->getParameter('longitud') != null)
    {
      $comentario -> setLatitud($request->getParameter('latitud'))
                  -> setLongitud($request->getParameter('longitud'));
    }
   
    $comentario -> setDescripcion($request->getParameter('descripcion'))
                -> setUsuarioEditorId($this->getUser()->getGuardUser()->getProfile()->getId())
                -> save();
    
    $q = Doctrine_Core::getTable('PastoralNecesidad')->getNecesidadPorIdQuery($request->getParameter('id'));
    $comentario_array = $q->fetchOne()->toArray();
    
    return $this->renderText(json_encode(  array("status"=>"success", "comentario"=>$comentario_array)  ));
  }
  
  public function executeAjaxBorrarComentario(sfWebRequest $request)
  {
    $comentario = Doctrine_Core::getTable('PastoralNecesidad')->findOneById($request->getParameter('id'));
    
    $comentario -> delete();
    
    //TODO: catch error
    
    return $this->renderText(json_encode(  array("status"=>"success", "comentario"=>$comentario->toArray()) ));
  }
  
  public function executeAjaxSolucionarComentario(sfWebRequest $request)
  {
    $comentario = Doctrine_Core::getTable('PastoralNecesidad')->findOneById($request->getParameter('id'));
    
    $estadoComentario = Doctrine_Core::getTable('PastoralEstadoNecesidad')->findOneByNombre("Cubierta");
    
    $comentario -> setEstadoNecesidadId($estadoComentario->getId())
                -> setUsuarioEditorId($this->getUser()->getGuardUser()->getProfile()->getId())
                -> save();
    
    //TODO: catch error
    
    $q = Doctrine_Core::getTable('PastoralNecesidad')->getNecesidadPorIdQuery($request->getParameter('id'));
    $comentario_array = $q->fetchOne()->toArray();
    $comentario_array['creador'] = $comentario->getPastoralProyectoVersion()?$comentario->getPastoralProyectoVersion()->getNombre():"";
    
    return $this->renderText(json_encode(  array("status"=>"success", "comentario"=>$comentario_array)  ));
  }
  
  public function executeAjaxGetComentarios(sfWebRequest $request)
  {
    $localidad = Doctrine_Core::getTable('PastoralLocalidad')->findOneById($request->getParameter('id'));
    
    $comentarios = $localidad->getNecesidadesActivas();
    
    //TODO: catch error
    
    return $this->renderText(json_encode(  array("status"=>"success", "comentarios"=>$comentarios->toArray())  ));
  }
  
  public function executeAjaxGetComentario(sfWebRequest $request)
  {
    $q = Doctrine_Core::getTable('PastoralNecesidad')->getNecesidadPorIdQuery($request->getParameter('id'));
    $comentario = $q->fetchOne();
    $comentario_array['creador'] = $comentario->getPastoralProyectoVersion()?$comentario->getPastoralProyectoVersion()->getNombre():"";
    
    return $this->renderText(json_encode(  array("status"=>"success", "comentario"=>$comentario->toArray())  ));
  }
  
  
  
}
