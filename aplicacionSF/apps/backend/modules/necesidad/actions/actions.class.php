<?php

/**
 * necesidad actions.
 *
 * @package    pastoral
 * @subpackage necesidad
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class necesidadActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->pastoral_necesidads = Doctrine_Core::getTable('PastoralNecesidad')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->pastoral_necesidad = Doctrine_Core::getTable('PastoralNecesidad')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->pastoral_necesidad);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PastoralNecesidadForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PastoralNecesidadForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($pastoral_necesidad = Doctrine_Core::getTable('PastoralNecesidad')->find(array($request->getParameter('id'))), sprintf('Object pastoral_necesidad does not exist (%s).', $request->getParameter('id')));
    $this->form = new PastoralNecesidadForm($pastoral_necesidad);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pastoral_necesidad = Doctrine_Core::getTable('PastoralNecesidad')->find(array($request->getParameter('id'))), sprintf('Object pastoral_necesidad does not exist (%s).', $request->getParameter('id')));
    $this->form = new PastoralNecesidadForm($pastoral_necesidad);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($pastoral_necesidad = Doctrine_Core::getTable('PastoralNecesidad')->find(array($request->getParameter('id'))), sprintf('Object pastoral_necesidad does not exist (%s).', $request->getParameter('id')));
    $pastoral_necesidad->delete();

    $this->redirect('necesidad/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $pastoral_necesidad = $form->save();

      $this->redirect('necesidad/edit?id='.$pastoral_necesidad->getId());
    }
  }
  
  
  ####################################### API MOVIL ###############################################################
 
  public function executeAjaxGetNecesidades(sfWebRequest $request)
  {
        
    if($this->getUser()->isAuthenticated())
    {
       
       $usuario_id = $this->getUser()->getGuardUser()->getProfile()->getId();
       
       $necesidades = Doctrine_Core::getTable('PastoralNecesidad')->getNecesidadesActivasPorUsuario($usuario_id);
       
       return $this->renderText(json_encode( array('status'=>'success', 'necesidades'=>$necesidades) ));
     }
     
     return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Necesita estar logueado.')));
        
  }
  
  public function executeAjaxSetNecesidad(sfWebRequest $request)
  {
    if($this->getUser()->isAuthenticated())
    {
    
       $usuario_id = $this->getUser()->getGuardUser()->getProfile()->getId();
       $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporMisionActivaYUsuarioQuery($usuario_id)->fetchOne();
       
       $necesidad = new PastoralNecesidad();
       $necesidad->setUsuarioCreadoId( $usuario_id);
       $necesidad->setNombre( $request->getParameter('nombre'));
       $necesidad->setDescripcion( $request->getParameter('descripcion'));
       $necesidad->setCoordenadaX( $request->getParameter('coordenada_x') );
       $necesidad->setCoordenadaY( $request->getParameter('coordenada_y') );
       $necesidad->setLocalidadId( $mue->PastoralMision->getLocalidadId() );
       $necesidad->setTipoNecesidadId( $request->getParameter('tipo_necesidad') );
       
       try {
        $necesidad->save();
      } catch (Doctrine\ORM\NoResultException $e) {
        return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al subir la necesidad (1).')));
      } catch (Exception $e) {
        return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al subir la necesidad (2).')));
      }
      
      $necesidad_mision = new PastoralNecesidadMision();
      $necesidad_mision ->setMisionId($mue->getMisionId());
      $necesidad_mision ->setNecesidadId($necesidad->getId());
      try {
      $necesidad_mision ->save();
      } catch (Doctrine\ORM\NoResultException $e) {
        return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al subir la necesidad (3).')));
      } catch (Exception $e) {
        return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al subir la necesidad (4).')));
      }
      
      return $this->renderText(json_encode(array('status'=>'success', 'mensaje'=>'Necesidad subida exitosamente.')));
     }
     
     return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Necesita estar logueado.')));
        
  }
  
  public function executeAjaxGetTiposNecesidades(sfWebRequest $request)
  {
        
    if($this->getUser()->isAuthenticated())
    {
    
      $tipos_necesidades = Doctrine_Core::getTable('PastoralTipoNecesidad')->getTiposNecesidadesQuery()->fetchArray();
       
      return $this->renderText(json_encode(array('status'=>'success', 'tipos_necesidades'=> $tipos_necesidades)));
    }
     
    return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Necesita estar logueado.')));
        
  }
  
  public function executeAjaxLogout(sfWebRequest $request)
  {
    if($this->getUser()->isAuthenticated())
    {      
       $this->getUser()->signOut();
       return $this->renderText(json_encode(array('status'=>'success', 'mensaje' => 'Deslogueado exitoso.')));
    }
    
    return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No estaba loguiado.')));
  }
  
  public function executeAjaxEditNecesidad(sfWebRequest $request)
  {
    if($this->getUser()->isAuthenticated())
    {
    
       $usuario = $this->getUser()->getGuardUser()->getProfile();
       $mision_actual= $usuario->getMisionActual();
       
       if($mision_actual == null)
        return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'No esta en una zona activa.')));
       
       $necesidad = Doctrine_Core::getTable('PastoralNecesidad')->findOneById($request->getParameter('id'));
       return $this->renderText(json_encode($necesidad->toArray()));
       if($necesidad == null)
        return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'No encontrada la necesidad por editar.')));
       
       $necesidad->setUsuarioEditadoId( $usuario_id);
       $necesidad->setDescripcion( $request->getParameter('descripcion'));
       
       try {
        $necesidad->save();
      } catch (Doctrine\ORM\NoResultException $e) {
        return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al editar la necesidad.')));
      } catch (Exception $e) {
        return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al editar la necesidad.')));
      }

       
      return $this->renderText(json_encode(array('status'=>'success', 'mensaje'=>'Necesidad editada exitosamente.')));
     }
     
     return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Necesita estar logueado.')));
        
  }

  
  
  
  
}
