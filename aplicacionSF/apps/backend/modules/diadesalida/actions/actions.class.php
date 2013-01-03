<?php

/**
 * diadesalida actions.
 *
 * @package    diadesalida
 * @subpackage diadesalida
 * @author     Andres Ossa
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class diadesalidaActions extends sfActions
{
  
    public function executeIndex(sfWebRequest $request){
        $token = $request->getParameter('token');
        
        if($token){          
          $proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->findOneByToken($token);
          if($proyecto_version){
              $fecha_token = $proyecto_version->getFechaCreacionToken();
              list($ano,$mes,$dia) = explode("-",$fecha_token);              
              $ano_dif = date("Y") - $ano;
              $mes_dif = date("m") - $mes;
              $dia_dif = date("d") - $dia;              
              if($ano_dif>0){             
                  $proyecto_version->set('token', '');
                  $proyecto_version->set('fecha_creacion_token', '');
                  $proyecto_version->save();
                  $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
              }
              else if($ano_dif==0){
                  if($mes_dif>0){
                      $proyecto_version->set('token', '');
                      $proyecto_version->set('fecha_creacion_token', '');
                      $proyecto_version->save();
                      $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
                  }
                  else if($mes_dif==0){
                      if($dia_dif>0){
                          $proyecto_version->set('token', '');
                          $proyecto_version->set('fecha_creacion_token', '');
                          $proyecto_version->save();
                          $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
                      }
                  }
              }
              
              $this->proyecto_version = $proyecto_version;
              $this->proyecto = Doctrine_Core::getTable('PastoralProyecto')->findOneById($proyecto_version->getProyectoId());
          
          }
          
          else{
            $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
          } 
        }
        else{
            $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
        }
      
    
    }
    
    
    public function executeAjaxDiaDeSalida(sfWebRequest $request){
      // obtenemos el rut del misionero en cuestion:
      $rut= $request->getParameter('rut_misionero');
      $pv_id = $request->getParameter('version_id');
      
      $retorno = array();
      
      $misionero = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorRut($rut);
    
      if($misionero){
        $mues = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->getMUESporIdUsuario($misionero->getId());             
        
        if($mues){
            $cantidad = count($mues); 
            $mue = $mues[$cantidad-1];
            $misionId = $mue->getMisionId();
            
            if($misionId){
                $retorno[0] = $misionero->getNombre()." ".$misionero->getApellidoPaterno()." ".$misionero->getApellidoMaterno();
                $retorno[1] = $misionero->getTelefonoCelular();
                $mision = Doctrine_Core::getTable('PastoralMision')->findOneById($misionId);
                $proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->findOneById($mision->getPastoralGrupo()->getProyectoVersionId());
                $proyecto = Doctrine_Core::getTable('PastoralProyecto')->findOneById($proyecto_version->getProyectoId());               
                $retorno[2] = $mue->getCuota();
                $retorno[3] = $proyecto->getNombre()." ".$proyecto_version->getAno();
                $retorno[4] = $mue->getCuotaPagada();
                //$localidad = Doctrine_Core::getTable('PastoralLocalidad')->findOneById($mision->getLocalidadId());
                $retorno[6] = $mision->getPastoralLocalidad()->getNombre();
                $grupo = Doctrine_Core::getTable('PastoralGrupo')->findOneById($mision->getGrupoId());
                $retorno[5] = $grupo->getNombre();
                
                $cuota_solidaria = $mue->getCuotaSolidaria();               
                if($cuota_solidaria!=null && $cuota_solidaria!=0){
                  $retorno[7] = $cuota_solidaria;
                }
                else{
                  $retorno[7] = 'NO';
                }
                
                if($proyecto_version->getId()!= $pv_id){
                    $retorno[0] = null;
                    $retorno[1] = 'ERROR! El usuario NO esta asociado a ninguna zona de esta VERSION del PROYECTO '.$proyecto->getNombre();
                }
                
            }
            else{
              $retorno[0] = null;
              $retorno[1] = 'ERROR! El usuario no esta asociado a ninguna zona.';
            }
        }
        else{
          $retorno[0] = null;
          $retorno[1] = 'ERROR! El usuario no esta asociado a ninguna zona.';
        
        }
      }
      
      else {
        $retorno[0] = null;  
        $retorno[1] = 'Error! El rut ingresado no esta asociado a ningun usuario';           
      }
      
      return $this->renderText(json_encode($retorno));
     
    }  

    
     public function executeAjaxCambiarEstadoCuota(sfWebRequest $request){
          // obtenemos el rut del misionero en cuestion:
          $rut = $request->getParameter('rut_misionero'); 
          $cuota_solidaria = $request->getParameter('cuotaSolidaria');
          
          $misionero = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorRut($rut);  
          $return = 0;
          
          if($misionero){
              $mues = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->getMUESporIdUsuario($misionero->getId());             
              if($mues){
                  $cantidad = count($mues); 
                  $mue = $mues[$cantidad-1];                     
                  try{
                    $mue->setCuotaPagada(1);
                    if($cuota_solidaria!=null && $cuota_solidaria!='' && $cuota_solidaria!=0)
                      $mue->setCuotaSolidaria($cuota_solidaria);
                    $mue->save(); 
                    $return = 1;
                  }         
                  catch(sfException $e){
                      $return = 0;
                  }                  
              }      
          }
          
          else{
             $return = 0;
          }
                  
          return $this->renderText(json_encode($return));
    
      }
    
}
