<?php

/**
 * notificacion actions.
 *
 * @package    pastoral
 * @subpackage notificacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class notificacionActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
     $usuario_id = $this->getUser()->getGuardUser()->getProfile()->getId(); 
     $notificaciones = Doctrine_Core::getTable('PastoralNotificacionUsuario')->addNotificacionesPorUsuarioQuery($usuario_id)->execute();
     $this->pastoral_notificacion_usuarios = $notificaciones;
  }

  public function executeShow(sfWebRequest $request)
  {
    $necesidad = Doctrine_Core::getTable('PastoralNotificacionUsuario')->findOneById($request->getParameter('notificacion_id'));
    $this->forward404Unless($necesidad);
    $usuario_id = $this->getUser()->getGuardUser()->getProfile()->getId(); 
    if($necesidad->getRecibeId()!=$usuario_id)
    {
        $this->forward404();
    }
    $necesidad->setLeido(1);
    $necesidad->save();
    $this->pastoral_notificacion_usuario= $necesidad;
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PastoralNotificacionUsuarioForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PastoralNotificacionUsuarioForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($pastoral_notificacion_usuario = Doctrine_Core::getTable('PastoralNotificacionUsuario')->find(array($request->getParameter('id'))), sprintf('Object pastoral_notificacion_usuario does not exist (%s).', $request->getParameter('id')));
    $this->form = new PastoralNotificacionUsuarioForm($pastoral_notificacion_usuario);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pastoral_notificacion_usuario = Doctrine_Core::getTable('PastoralNotificacionUsuario')->find(array($request->getParameter('id'))), sprintf('Object pastoral_notificacion_usuario does not exist (%s).', $request->getParameter('id')));
    $this->form = new PastoralNotificacionUsuarioForm($pastoral_notificacion_usuario);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($pastoral_notificacion_usuario = Doctrine_Core::getTable('PastoralNotificacionUsuario')->find(array($request->getParameter('id'))), sprintf('Object pastoral_notificacion_usuario does not exist (%s).', $request->getParameter('id')));
    $pastoral_notificacion_usuario->delete();

    $this->redirect('notificacion/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $pastoral_notificacion_usuario = $form->save();

      $this->redirect('notificacion/edit?id='.$pastoral_notificacion_usuario->getId());
    }
  }
}
