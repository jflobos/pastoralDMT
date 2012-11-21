<?php

/**
 * PastoralMision
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    pastoral
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PastoralMision extends BasePastoralMision
{
  public function getNombre()
  {
    if($this->getLocalidadFantasiaId()=='') 
      return $this->getPastoralLocalidad()->getNombre()." - ".$this->getPastoralGrupo()->getPastoralProyectoVersion()->getVersion();
    
    return $this->getPastoralLocalidadFantasia()->getNombre()." - ".$this->getPastoralGrupo()->getPastoralProyectoVersion()->getVersion();
      
  }
  
  public function getPostulacionActiva($usuario_id)
  {
        $q1 = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporUsuarioQuery($usuario_id);
        $mues = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporMisionQuery($this->getId(),$q1)->execute();
        foreach($mues as $mue)            
        {
            //Revisamos el estado de postulacion:
            $estadosQueEstanEnMision = array(2,3,4,6,7);            
            if(in_array($mue->getPastoralEstadoPostulacion()->getId(), $estadosQueEstanEnMision))
              //&& $mue->getPastoralMision()->getFechaTermino() > date("Y-m-d"))
            {
              return $mue;
            }
        }
     return null;
  }
  
  public function countHombres()
  {
        $q1 = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporHombresQuery();
        $q2 = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporMisionQuery($this->getId(),$q1);
        return count($q2->fetchArray());
  }
  
  public function countMujeres()
  {
        $q1 = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporMujeresQuery();
        $q2 = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporMisionQuery($this->getId(),$q1);
        return count($q2->fetchArray());
  }
  
  public function getNecesidadMisiones()
  {
        return Doctrine_Core::getTable('PastoralNecesidadMision')->findByMisionId($this->getId());
  }
  
  
  public function finalizada()
  {      
    if($this->getFechaTermino() < date("Y-m-d"))
      return true;
    
    else
      return false;
  }
  
  
  //Retorna true si la zona esta actualmente llevandose a cabo, false en caso contrario
  public function estaActiva()
  {      
    if($this->getFechaInicio() < date("Y-m-d") && $this->getFechaTermino() > date("Y-m-d"))
      return true;
    
    else
      return false;
  }
  
  public function estaInscripcionAbierta()
  {
    if($this->getPastoralLocalidad()->getNombre()=='Donde Dios me Quiera')
      return $this->getInscripcionAbierta();
    if(!$this->estaActiva() && $this->getInscripcionAbierta() && $this->getFechaInicio() > date("Y-m-d"))
      return true;
    
    else
      return false;
  }
  
  public function filtroGeneralActivo()
  {
    $mision_filtros = Doctrine_Core::getTable('PastoralMisionFiltro')->findByMisionId($this->getId());
    foreach($mision_filtros as $mf)
    {
      if($mf->esGeneral())
        if($mf->estaActivo() != '')
          return true;
    }
    
    return false;
  }
  
  public function puedePostular($usuario)
  {
    $mision_filtros = Doctrine_Core::getTable('PastoralMisionFiltro')->findByMisionId($this->getId());
    foreach($mision_filtros as $mf)
    {
      if(!$mf->esGeneral())
      {
        $retorno = $mf->puedePostular($usuario);
        if(!$retorno)
          return $retorno;
      }
    }
    
    return true;
  }  
  
  public function getMisionerosActivos()
  {
    $q = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporMisionQuery($this->getId());
    
    $alias = $q->getRootAlias();
    $q -> leftJoin($alias.'.PastoralEstadoPostulacion ep')
        //-> andWhere('ep.Nombre = "Confirmado"') //TODO: retornar solo los confirmados, cuando esten poblados los fixtures.
    ;
    $mues = $q->execute();
    
    $misioneros = array();
    
    foreach($mues as $mue)
    {
      $misioneros[] = $mue->getPastoralUsuario();
    }
    
    return $misioneros;
    
  }
  
  public function CantidadPorEdades()
  {
    $q1 = Doctrine_Query::create()
            ->select('MAX(u.fecha_nacimiento)') 
            ->from('PastoralUsuario u')
            ->fetchArray();
  
    list($ano,$mes,$dia) = explode("-",$q1[0]['MAX']);
    $edad_minima  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($mes_diferencia < 0)
      $edad_minima--;
    else if($mes_diferencia == 0 && $dia_diferencia<0)
      $edad_minima--;    
            
    $q2 = Doctrine_Query::create()
            ->select('MIN(fecha_nacimiento)') 
            ->from('PastoralUsuario')
            ->fetchArray();
            
    list($ano,$mes,$dia) = explode("-",$q2[0]['MIN']);
    $edad_maxima  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($mes_diferencia < 0)
      $edad_maxima--;
    else if($mes_diferencia == 0 && $dia_diferencia<0)
      $edad_maxima--;
            
                
    $respuesta = array();
    $edades = array();
    while($edad_minima <= $edad_maxima)
    {
    
    $ano = date("Y") - $edad_minima -1;
    $abajo = implode("-",array($ano,date("m"),date("d")));
    $ano ++;
    $arriba = implode("-",array($ano,date("m"),date("d")));
    
    
      $q = Doctrine_Query::create()
              ->select('COUNT(*) as total_edad') 
              ->from('PastoralUsuario u')
              ->where('u.fecha_nacimiento<?',$arriba)   
              ->andwhere('u.fecha_nacimiento>=?',$abajo)
              ;
        $alias = $q->getRootAlias();
        $q -> leftJoin($alias.'.PastoralMisionUsuarioEstado mue')
           -> andWhere('mue.mision_id = ?',$this->getId());
           
      $res = $q->fetchArray();         
      $suma = $res[0]['total_edad'];
      
      if($suma!=0)
        $edades[$edad_minima] =$suma;
      $edad_minima ++;
    }
    ksort($edades);
    $respuesta[0]=array_keys($edades);
    $respuesta[1]=array_values($edades);
    
    return $respuesta;
  }
  
  
}