<?php
 
class localidadComponents extends sfComponents
{
  public function executeContactos(sfWebRequest $request)
  {
    // if($request->getParameter('id') != null)
    // {
      // $localidad = Doctrine_Core::getTable('PastoralLocalidad')->find(array($request->getParameter('id')));
    // }
    // else if($request->getParameter('mision_id') != null)
    // {
      // $mision = Doctrine_Core::getTable('PastoralMision')->findOneById($request->getParameter('mision_id'));
      
      // $localidad = Doctrine_Core::getTable('PastoralLocalidad')->findOneById($mision->getLocalidadId());
    // }
    
    $localidad = Doctrine_Core::getTable('PastoralLocalidad')->findOneById($this->localidad_id);
    
    $this->pastoral_localidad = $localidad;
    $this->contactos = Doctrine_Core::getTable('PastoralContacto')
                          ->addContactosPorLocalidadQuery($localidad->getId())
                          ->execute();
    $this->alojamientos = $localidad->getLugaresPorTipo('Alojamiento');

    $this->parroquias = $localidad->getLugaresPorTipo('Parroquia');
    
    $municipalidades = $localidad->getLugaresPorTipo('Municipalidad');
    
    if(count($municipalidades) > 0)
      $this->municipalidad = $municipalidades[0];
    else
      $this->municipalidad = null;
      
    
    $this->checklist_form = new PastoralPerfilAlojamientoForm();
      
    $this->tipos_contacto = Doctrine_Core::getTable('PastoralTipoContacto')->findAll();
  }
}