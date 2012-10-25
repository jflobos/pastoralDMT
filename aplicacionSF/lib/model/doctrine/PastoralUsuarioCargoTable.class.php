<?php

/**
 * PastoralUsuarioCargoTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PastoralUsuarioCargoTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PastoralUsuarioCargoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PastoralUsuarioCargo');
    }
    
    public function addUCporUsuarioQuery($usuario_id, Doctrine_Query $q = null)
    {
            if (is_null($q))
            {
                $q = Doctrine_Query::create()
                  ->from('PastoralUsuarioCargo uc');
            }       
            $alias = $q->getRootAlias();
            $q->addWhere($alias.'.usuario_id = ?',$usuario_id)
            ->leftJoin($alias.'.PastoralCargo c')
            //if mision_id > 0
            ->leftJoin($alias.'.PastoralMision m')
            ->leftJoin('m.PastoralGrupo mg')
            ->leftJoin('m.PastoralLocalidadFantasia lf')
            ->leftJoin('mg.PastoralProyectoVersion mpv')
            ->leftJoin('mpv.PastoralProyecto mp')
            //if grupo_id>0
            ->leftJoin($alias.'.PastoralGrupo g')
            ->leftJoin('g.PastoralProyectoVersion gpv')
            ->leftJoin('gpv.PastoralProyecto gp')
            //if pv_id > 0
            ->leftJoin($alias.'.PastoralProyectoVersion pv')
            ->leftJoin('pv.PastoralProyecto pvp')

        ;
        
          return $q;
    }
    
    public function addOrdenDescQuery( Doctrine_Query $q = null)
    {
        if (is_null($q))
        {
            $q = Doctrine_Query::create()
              ->from('PastoralUsuarioCargo uc');
        }       
        $alias = $q->getRootAlias();
        $q ->addOrderBy('uc.created_at DESC');  
          return $q;
    }
    
    public function addUCporJefesYMision($mision_id, Doctrine_Query $q = null)
    {
    if (is_null($q))
        {
            $q = Doctrine_Query::create()
              ->from('PastoralUsuarioCargo uc');
        }    
        $alias = $q->getRootAlias();
        
        $cargo_id =  Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe de Zona')->getId();
        
        $q  ->where($alias.'.mision_id = ?',$mision_id)
            ->andWhere($alias.'.cargo_id = ?',$cargo_id);
          return $q;
    }
  
  
    public function addUsuarioCargo($mision_id, Doctrine_Query $q = null)
    {
		if (is_null($q))
		  {
			$q = Doctrine_Query::create()
			  ->from('PastoralUsuarioCargo u');
		  }
      return $q;
    }
	
	public function addUCporJefesYGrupo($grupo_id, Doctrine_Query $q = null)
    {
    if (is_null($q))
        {
            $q = Doctrine_Query::create()
              ->from('PastoralUsuarioCargo uc');
        }    
        $alias = $q->getRootAlias();
        
        $cargo_id =  Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe Regional')->getId();
        
        $q  ->where($alias.'.grupo_id = ?',$grupo_id)
            ->andWhere($alias.'.cargo_id = ?',$cargo_id);
          return $q;
    }
    
    public function addUCporIdUsuarioProyectoVersionCargo($version_id, $usuario_id, $cargo_id, Doctrine_Query $q = null)
    {
        if (is_null($q)){
            $q = Doctrine_Query::create()
              ->from('PastoralUsuarioCargo uc');
        } 
        
        $alias = $q->getRootAlias();
        
        $q  ->where($alias.'.proyecto_version_id = ?',$version_id)
            ->andWhere($alias.'.cargo_id = ?',$cargo_id)
            ->andWhere($alias.'.usuario_id = ?',$usuario_id);
          
        return $q->fetchOne();
    }
    
    public function addUCporJefeNacionalYProyecto($proyecto_version_id, Doctrine_Query $q = null)
    {
    if (is_null($q))
        {
            $q = Doctrine_Query::create()
              ->from('PastoralUsuarioCargo uc');
        }    
        $alias = $q->getRootAlias();
        
        $cargo_id =  Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe Nacional')->getId();
        
        $q  ->where($alias.'.proyecto_version_id = ?',$proyecto_version_id)
            ->andWhere($alias.'.cargo_id = ?',$cargo_id);
          return $q;
    }
    
    public function addUCporJefeFinanzasYProyecto($proyecto_version_id, Doctrine_Query $q = null)
    {
    if (is_null($q))
        {
            $q = Doctrine_Query::create()
              ->from('PastoralUsuarioCargo uc');
        }    
        $alias = $q->getRootAlias();
        
        $cargo_id =  Doctrine_Core::getTable('PastoralCargo')->findOneByNombre("Jefe de Finanzas")->getId();
        
        $q  ->where($alias.'.proyecto_version_id = ?',$proyecto_version_id)
            ->andWhere($alias.'.cargo_id = ?',$cargo_id);
          return $q;
    }
    
    public function addUCporJefeInscripcionesYProyecto($proyecto_version_id, Doctrine_Query $q = null)
    {
    if (is_null($q))
        {
            $q = Doctrine_Query::create()
              ->from('PastoralUsuarioCargo uc');
        }    
        $alias = $q->getRootAlias();
        
        $cargo_id =  Doctrine_Core::getTable('PastoralCargo')->findOneByNombre("Jefe de Inscripciones")->getId();
        
        $q  ->where($alias.'.proyecto_version_id = ?',$proyecto_version_id)
            ->andWhere($alias.'.cargo_id = ?',$cargo_id);
          return $q;
    }
    
    public function addUCporJefeExtranjerosYProyecto($proyecto_version_id, Doctrine_Query $q = null)
    {
    if (is_null($q))
        {
            $q = Doctrine_Query::create()
              ->from('PastoralUsuarioCargo uc');
        }    
        $alias = $q->getRootAlias();
        
        $cargo_id =  Doctrine_Core::getTable('PastoralCargo')->findOneByNombre("Jefe de Extranjeros")->getId();
        
        $q  ->where($alias.'.proyecto_version_id = ?',$proyecto_version_id)
            ->andWhere($alias.'.cargo_id = ?',$cargo_id);
          return $q;
    }
}