<?php

/**
 * PastoralLocalidad
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    pastoral
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PastoralLocalidad extends BasePastoralLocalidad
{

      public function __toString()
      {
        return $this->getNombre();
      }

      public function getNecesidades()
      {
          return Doctrine_Core::getTable('PastoralNecesidad')->findByLocalidadId($this->getId());
      }
      
      public function getNecesidadesActivas()
      {
          return Doctrine_Core::getTable('PastoralNecesidad')
                  ->getNecesidadesActivasPorLocalidadQuery($this->getId())->execute();
      }
      
      public function getNecesidadesCubiertas()
      {
          return Doctrine_Core::getTable('PastoralNecesidad')
                  ->getNecesidadesCubiertasPorLocalidadQuery($this->getId())->execute();
      }
      
      public function getLugaresPorTipo($tipoContacto)
      {
        $q = Doctrine_Query::create()
            ->from('PastoralLugar lu')
            ->leftJoin('lu.PastoralTipoContacto tc')
            ->leftJoin('lu.PastoralContacto c')
            ->where('lu.localidad_id = ?', $this->getId())
            ->andWhere('tc.nombre = ?', $tipoContacto);
        if($tipoContacto == "Alojamiento")
          $q->leftJoin('lu.PastoralPerfilAlojamiento pa');
        return $q->execute();
      }
      
      public function getContactos()
      {
        $q = Doctrine_Core::getTable('PastoralContacto')
                          ->addContactosPorLocalidadQuery($this->getId());
        return $q->execute();
      }
}