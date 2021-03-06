<?php

/**
 * PastoralNecesidadTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PastoralNecesidadTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PastoralNecesidadTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PastoralNecesidad');
    }
    
    public function getArrayNecesidadesActivasPorUsuario($usuario_id)
    {
        $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporMisionActivaYUsuarioQuery($usuario_id)->fetchOne();
        
        if($mue != null)
          return $this->getNecesidadesActivasPorLocalidadQuery($mue->PastoralMision->getLocalidadId())->fetchArray();
        
    }
    
    public function getNecesidadPorIdQuery($id)
    {
        $q = Doctrine_Query::create()
            ->from('PastoralNecesidad n')
            ->where('n.id = ?',$id)
            ->leftJoin('n.PastoralEstadoNecesidad en')
            ->leftJoin('n.PastoralTipoNecesidad tn');
            //->leftJoin('n.PastoralUsuario u');
        return $q;
    }
    
    public function getNecesidadesActivasPorLocalidadQuery($localidad_id)
    {
        $q = Doctrine_Query::create()
            ->from('PastoralNecesidad n')
            ->where('n.localidad_id = ?',$localidad_id)
            ->leftJoin('n.PastoralEstadoNecesidad en')
            ->leftJoin('n.PastoralTipoNecesidad tn')
            ->andWhere('en.nombre != "Cubierta"')
            ->orderBy('n.updated_at DESC');
        return $q;
    }
    
    public function getNecesidadesCubiertasPorLocalidadQuery($localidad_id)
    {
        $q = Doctrine_Query::create()
            ->from('PastoralNecesidad n')
            ->where('n.localidad_id = ?',$localidad_id)
            ->leftJoin('n.PastoralEstadoNecesidad en')
            ->andWhere('en.nombre = "Cubierta"')
            ->orderBy('n.updated_at DESC');
        return $q;
    }

  
}