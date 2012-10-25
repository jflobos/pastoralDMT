<?php

/**
 * cargo actions.
 *
 * @package    pastoral
 * @subpackage cargo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cargoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $uc_id = $request->getParameter('uc_id');
    $user_id = $this->getUser()->getGuardUser()->getProfile()->getId();
    if($uc_id > 0){
        $uc = Doctrine_Core::getTable('PastoralUsuarioCargo')->findOneById($uc_id);
        if($uc->getUsuarioId() == $user_id )
        {
            $this->getUser()->setAttribute('usuario_cargo', $uc);
            #TODO: CAMBIAR EL PROYECTO ACTUAL
        }
    }
    $this->usuario = Doctrine_Core::getTable('PastoralUsuario')->findOneById($user_id);
    $q = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporUsuarioQuery($user_id);
    $q = Doctrine_Core::getTable('PastoralUsuarioCargo')->addOrdenDescQuery($q);
    $this->pastoral_usuario_cargos = $q->execute();
    $this->misiones = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByUsuarioId($user_id);
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->pastoral_usuario_cargo = Doctrine_Core::getTable('PastoralUsuarioCargo')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->pastoral_usuario_cargo);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PastoralUsuarioCargoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PastoralUsuarioCargoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($pastoral_usuario_cargo = Doctrine_Core::getTable('PastoralUsuarioCargo')->find(array($request->getParameter('id'))), sprintf('Object pastoral_usuario_cargo does not exist (%s).', $request->getParameter('id')));
    $this->form = new PastoralUsuarioCargoForm($pastoral_usuario_cargo);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pastoral_usuario_cargo = Doctrine_Core::getTable('PastoralUsuarioCargo')->find(array($request->getParameter('id'))), sprintf('Object pastoral_usuario_cargo does not exist (%s).', $request->getParameter('id')));
    $this->form = new PastoralUsuarioCargoForm($pastoral_usuario_cargo);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($pastoral_usuario_cargo = Doctrine_Core::getTable('PastoralUsuarioCargo')->find(array($request->getParameter('id'))), sprintf('Object pastoral_usuario_cargo does not exist (%s).', $request->getParameter('id')));
    $pastoral_usuario_cargo->delete();

    $this->redirect('cargo/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $pastoral_usuario_cargo = $form->save();

      $this->redirect('cargo/edit?id='.$pastoral_usuario_cargo->getId());
    }
  }
}
