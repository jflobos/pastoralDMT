<?php
 
class notificacionComponents extends sfComponents
{
  public function executeNotificaciones()
  {
    $usuario_id = $this->getUser()->getGuardUser()->getProfile()->getId();
    $this -> notificaciones_nuevas_count = Doctrine_Core::getTable('PastoralNotificacionUsuario')->countNotificacionesNuevasDeUsuario($usuario_id);
    $this -> notificaciones = Doctrine_Core::getTable('PastoralNotificacionUsuario')->getTopNotificacionesPorUsuarioQuery($usuario_id)->execute();
  }
}