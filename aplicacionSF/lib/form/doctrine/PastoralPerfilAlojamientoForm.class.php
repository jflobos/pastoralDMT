<?php

/**
 * PastoralPerfilAlojamiento form.
 *
 * @package    pastoral
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PastoralPerfilAlojamientoForm extends BasePastoralPerfilAlojamientoForm
{
  public function configure()
  {
    $this->disableLocalCSRFProtection();
    unset($this['id'], $this['lugar_id']);
  }
}
