<?php

/**
 * PastoralLocalidadTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PastoralLocalidadTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PastoralLocalidadTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PastoralLocalidad');
    }
    
    public function getArrayLocalidadPorId($localidad_id)
    {
        $q = Doctrine_Query::create()
            ->from('PastoralLocalidad l')
            ->where('l.id = ?',$localidad_id);
        return $q->fetchArray();
    }
	
	public function getLocalidadPorId($localidad_id)
    {
        $q = Doctrine_Query::create()
            ->from('PastoralLocalidad l')
            ->where('l.id = ?',$localidad_id);
        return $q;
    }
	
	public function getLocalidades()
	  {
		$query = Doctrine_Query::create()
        ->from('PastoralLocalidad a');
		
		return $query ->execute();		
	  }  
    
    public function getLocalidadPorIdFetchOne($localidad_id)
    {
        $q = Doctrine_Query::create()
            ->from('PastoralLocalidad l')
            ->where('l.id = ?',$localidad_id);
        return $q->fetchOne();
    }
	 
}