<?php

/**
 * zonas actions.
 *
 * @package    pastoral
 * @subpackage zonas
 * @author     Grupo5
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class zonasActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    
  public function executeIndex(sfWebRequest $request)
  {
    $this->proyecto_id = $request->getParameter('proyecto');
    $this->regiones = Doctrine_Core::getTable('PastoralGrupo')->findByProyectoVersionId($this->proyecto_id)->toArray();    
  }
  public function executeGetZonasPorSalidaJSON(sfWebRequest $request){    
    $this->proyecto_id = $request->getParameter('proyecto');
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode(PastoralSalidaTable::getSalidasPorProyecto($this->proyecto_id)));
  }
}
