<?php

/**
 * PastoralMisionFiltro
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    pastoral
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PastoralMisionFiltro extends BasePastoralMisionFiltro
{

  public function estaActivo()
  {
    if($this->getPastoralFiltro()->getNombre() =='Edad minima')
    {
     return $this->getParametros();
    }
    else if($this->getPastoralFiltro()->getNombre() =='Total de inscritos')
    {
      $mision = $this->getPastoralMision();
      $total = $mision->countMujeres() +  $mision->countHombres();
      $maximo = $this->getParametros();
      if($maximo <= $total)
        return $total;   
    }
    else if($this->getPastoralFiltro()->getNombre() =='Maximo porcentaje de hombres')
    {
      $mision = $this->getPastoralMision();
      $total = $mision->countMujeres() +  $mision->countHombres();
      $porcentaje = ($mision->countHombres()*100)/$total;
      $maximo_porcentaje = $this->getParametros();
      if($maximo_porcentaje <= $porcentaje)
        return $porcentaje;   
    }
    else if($this->getPastoralFiltro()->getNombre() =='Maximo porcentaje de mujeres')
    {
      $mision = $this->getPastoralMision();
      $total = $mision->countMujeres() +  $mision->countHombres();
      $porcentaje = ($mision->countMujeres()*100)/$total;
      $maximo_porcentaje = $this->getParametros();
      if($maximo_porcentaje <= $porcentaje)
        return $porcentaje;   
    }
    else if($this->getPastoralFiltro()->getNombre() =='Movimiento')
    {
      $maximo = $this->getParametros();
      $mision = $this->getPastoralMision();
      $misioneros_uc = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision->getId());
      
      $movimientos = array();      
      $movimientos_religiosos = Doctrine_Core::getTable('PastoralMovimiento')->findAll();
      foreach($movimientos_religiosos as $mr)
      {
        if($mr->getNombre()!= 'Ninguno')
        {
          $res = $mr->cantidadPorMision($this->getMisionId());
          $movimientos[$mr->getNombre()] = $res;
          if($maximo <= $movimientos[$mr->getNombre()])
          {
           return $mr->getNombre();
          }
        }
      }       
    }    
    else if($this->getPastoralFiltro()->getNombre() =='Universidad')
    {  
      $parametros = explode(';',$this->getParametros());
      $maximo = $parametros[1];
      $universidad = Doctrine_Core::getTable('PastoralUniversidad')->FindOneById($parametros[0]);
      if($universidad != null)
      {
        $total = $universidad->cantidadPorMision($this->getMisionId());
        if($maximo <= $total)
        {
         return $total;
        }
      }
    }
    
    else if($this->getPastoralFiltro()->getNombre() =='Carrera')
    {  
      $parametros = explode(';',$this->getParametros());
      $maximo = $parametros[1];
      $carrera = Doctrine_Core::getTable('PastoralCarrera')->FindOneById($parametros[0]);
      if($carrera != null)
      {
        $total = $carrera->cantidadPorMision($this->getMisionId());
        if($maximo <= $total)
        {
         return $total;
        }
      }
    }
    
    
    return '';
  }
  
  public function esGeneral()
  {
    $nombre = $this->getPastoralFiltro()->getNombre();
    if( $nombre =='Total de inscritos')
      return true;
    
    return false;   
  }
  
  public function puedePostular($usuario)
  {
    if($this->getPastoralFiltro()->getNombre() =='Edad minima')
    {
     $minima =  $this->getParametros();
     if($usuario->getEdad() < $minima)
      return false;
    }   
    else if($this->getPastoralFiltro()->getNombre() =='Movimiento')
    {
      $movimiento_religioso = $usuario->getPastoralMovimiento();
      
      if($movimiento_religioso!=null)
      {
        $maximo = $this->getParametros();
        $misioneros_uc = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($this->getMisionId());
        
        if($movimiento_religioso->getNombre()!= 'Ninguno')
        {
          $cuenta = $movimiento_religioso->cantidadPorMision($this->getMisionId());
          //agrego el potencial misionero
          $cuenta = $cuenta +1;
          if($maximo <= cuenta)
          {
           //no se admiten m�s postulantes de este movimiento
           return false;
          }
        }         
      }
    }    
    else if($this->getPastoralFiltro()->getNombre() =='Universidad')
    {  
      $parametros = explode(';',$this->getParametros());
      $maximo = $parametros[1];
      $universidad = Doctrine_Core::getTable('PastoralUniversidad')->FindOneById($parametros[0]);
      if($universidad == $usuario->getPastoralUniversidad)
      {
        if($universidad != null)
        {
          $total = $universidad->cantidadPorMision($this->getMisionId());
          //agrego potencial postulante
          $total = $total+1;
          if($maximo <= $total)
          {
           return false;
          }
        }
      }
    }    
    else if($this->getPastoralFiltro()->getNombre() =='Carrera')
    {  
      $parametros = explode(';',$this->getParametros());
      $maximo = $parametros[1];
      $carrera = Doctrine_Core::getTable('PastoralCarrera')->FindOneById($parametros[0]);
      if($universidad == $usuario->getPastoralUniversidad)
      {
        if($carrera != null)
        {
          $total = $carrera->cantidadPorMision($this->getMisionId());
          //agrego potencial postulante
          $total = $total+1;
          if($maximo <= $total)
          {
           return false;
          }
        }
      }
    }
    
    else if($this->getPastoralFiltro()->getNombre() =='Maximo porcentaje de mujeres')
    {
      $mision = $this->getPastoralMision();
      $hombres = $mision->countHombres();
      $mujeres = $mision->countMujeres();
      if($usuario->getSexo == 'Masculino')
        $hombres++;
      else if($usuario->getSexo == 'Femenino')
        $mujeres++;
      $total =  $hombres + $mujeres  ;
      $porcentaje = ($mujeres*100)/$total;
      $maximo_porcentaje = $this->getParametros();
      if($maximo_porcentaje <= $porcentaje)
        return false;   
    }
    
    else if($this->getPastoralFiltro()->getNombre() =='Maximo porcentaje de hombres')
    {
      $mision = $this->getPastoralMision();
      $hombres = $mision->countHombres();
      $mujeres = $mision->countMujeres();
      if($usuario->getSexo == 'Masculino')
        $hombres++;
      else if($usuario->getSexo == 'Femenino')
        $mujeres++;
      $total =  $hombres + $mujeres  ;
      $porcentaje = ($hombres*100)/$total;
      $maximo_porcentaje = $this->getParametros();
      if($maximo_porcentaje <= $porcentaje)
        return false;   
    }
    
    return true;
  }  

}