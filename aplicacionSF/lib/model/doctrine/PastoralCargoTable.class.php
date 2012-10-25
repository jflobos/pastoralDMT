<?php

/**
 * PastoralCargoTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PastoralCargoTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PastoralCargoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PastoralCargo');
    }
    
    public function addCargosMisioneros(Doctrine_Query $q = null)
    {
         if (is_null($q))
        {
            $q = Doctrine_Query::create()
              ->from('PastoralCargo c');
        }
        $alias = $q->getRootAlias();
        $q ->andWhere('c.es_misionero = 1');
        return $q;
    }
    
    public function getCargoPorNombre($nombre_cargo)
    {
        $q = Doctrine_Query::create()
            ->from('PastoralCargo c')
            ->where('c.nombre = ?',$nombre_cargo);
        return $q->fetchOne();
    }
    
    public function getArrayCargoPorId($cargo_id)
    {
        $q = Doctrine_Query::create()
            ->from('PastoralCargo c')
            ->where('c.id = ?',$cargo_id);
        return $q->fetchArray();
    }
    
}