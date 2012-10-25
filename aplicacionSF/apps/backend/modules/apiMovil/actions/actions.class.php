<?php

/**
 * apiMovil actions.
 *
 * @package    pastoral
 * @subpackage apiMovil
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class apiMovilActions extends sfActions
{

  public function executeAjaxTestLogin(sfWebRequest $request)
  {
    if(!$this->getUser()->isAuthenticated())
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No esta loguiado.')));
      
    return $this->renderText(json_encode(array('status'=>'success', 'mensaje' => 'Esta loguiado.')));
  }
  
  public function executeAjaxLogout(sfWebRequest $request)
  {
    if($this->getUser()->isAuthenticated())
    {      
       $this->getUser()->signOut();
       return $this->renderText(json_encode(array('status'=>'success', 'mensaje' => 'Deslogueado exitoso.')));
    }
    
    return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No estaba loguiado.')));
  }
  
  public function executeAjaxLogin(sfWebRequest $request)
  {
  
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      $this->getUser()->signOut();
    }
     
    $user = $request->getParameter('user');
    $pass = $request->getParameter('pass');

    $guard_user = Doctrine_Core::getTable('sfGuardUser')->getGuardUserByUsername($user);

    if($guard_user != null)
    {
      $this->getUser()->signin($guard_user);


      if($this->getUser()->checkPassword($pass))
      {
        return $this->renderText(json_encode( array('status'=>'success', 'mensaje' => 'Login exitoso' , 'user'=>$user, 'checkpass'=>$this->getUser()->checkPassword($pass) 
        , "auten" =>$this->getUser()->isAuthenticated())));
      }
    }
    
    $this->getUser()->signOut();
    return $this->renderText(json_encode(array('status'=> 'error', 'mensaje' => 'Error en usuario o contraseña')));

  }
  
  public function executeAjaxObtenerComentarios(sfWebRequest $request)
  {
        
    if(!$this->getUser()->isAuthenticated())
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No esta loguiado.')));
       
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $localidad = $usuario->getMisionActual()->getPastoralLocalidad();
    
    $comentarios = $localidad->getNecesidadesActivas();

    return $this->renderText(json_encode( array('status'=>'success', 'comentarios'=>$comentarios->toArray()) ));
        
  }
  
  public function executeAjaxCrearComentario(sfWebRequest $request)
  {
    if(!$this->getUser()->isAuthenticated())
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No esta loguiado.')));
    
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $mision = $usuario->getMisionActual();
    $estado_comentario =  Doctrine_Core::getTable('PastoralEstadoNecesidad')->findOneByNombre('Pendiente');

    $necesidad = new PastoralNecesidad();
    $necesidad->setUsuarioCreadorId( $usuario->getId())
              ->setDescripcion( $request->getParameter('descripcion'))
              ->setEstadoNecesidadId($estado_comentario->getId())
              ->setLatitud( $request->getParameter('latitud') )
              ->setLongitud( $request->getParameter('longitud') )
              ->setLocalidadId( $mision->getLocalidadId() )
              ->setTipoNecesidadId( $request->getParameter('tipo_necesidad_id') );
 
    try {
      $necesidad->save();
    } catch (Doctrine\ORM\NoResultException $e) {
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al subir el comentario.')));
    } catch (Exception $e) {
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al subir el comentario.')));
    }

    $necesidad_mision = new PastoralNecesidadMision();
    $necesidad_mision ->setMisionId($mision->getId());
    $necesidad_mision ->setNecesidadId($necesidad->getId());
    try {
    $necesidad_mision ->save();
    } catch (Doctrine\ORM\NoResultException $e) {
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al subir el comentario (3).')));
    } catch (Exception $e) {
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al subir el comentario (4).')));
    }
     
    return $this->renderText(json_encode(array('status'=>'success', 'mensaje'=>'Comentario subido exitosamente.',
    'comentario'=>$necesidad->toArray())));
        
  }
  
  public function executeAjaxObtenerTiposComentarios(sfWebRequest $request)
  {
        
    if(!$this->getUser()->isAuthenticated())
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No esta loguiado.')));
    
    $tipos_comentarios = Doctrine_Core::getTable('PastoralTipoNecesidad')->getTiposNecesidadesQuery()->fetchArray();
     
    return $this->renderText(json_encode(array('status'=>'success', 'tipos_comentarios'=> $tipos_comentarios)));
      
  }
  
  public function executeAjaxGetInfoMision(sfWebRequest $request)
  {
    if(!$this->getUser()->isAuthenticated())
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No esta loguiado.')));
      
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $mision_actual = $usuario->getMisionActual();
    $informacion = Array();
    $informacion['mision'] = $mision_actual->toArray();
    $informacion['grupo'] = $mision_actual->getPastoralGrupo()->toArray();
    $pv =  $mision_actual->getPastoralGrupo()->getPastoralProyectoVersion();
    $informacion['proyecto_version'] = $pv->toArray();
    $informacion['proyecto'] = $pv->getPastoralProyecto()->toArray();
    return $this->renderText(json_encode( array('status'=>'success', 'informacion'=>$informacion) ));
    
  }
  
  public function executeAjaxEditarComentario(sfWebRequest $request)
  {
    if(!$this->getUser()->isAuthenticated())
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No esta loguiado.')));
    
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $mision_actual= $usuario->getMisionActual();

    if($mision_actual == null)
      $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'No esta en una zona activa.')));

    $necesidad = Doctrine_Core::getTable('PastoralNecesidad')->findOneById($request->getParameter('id'));

    if($necesidad == null)
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'No encontrada el comentario por editar.')));

    $necesidad->setUsuarioEditorId( $usuario->getId());
    
    $parametros = $request->getGetParameters();
    
    try {
      foreach($parametros as $parametro => $value)
      {
        if($parametro == "id")
          continue;
          
        $necesidad->set($parametro, $request->getParameter($parametro));
      }
    } catch (Exception $e) {
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Parametro incorrecto al editar comentario.')));
    }

    try {
      $necesidad->save();
    } catch (Doctrine\ORM\NoResultException $e) {
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al editar el comentario.')));
    } catch (Exception $e) {
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al editar el comentario.')));
    }

     
    return $this->renderText(json_encode(array('status'=>'success', 'mensaje'=>'Comentario editado exitosamente.')));
        
  }
  
  public function executeAjaxBorrarComentario(sfWebRequest $request)
  {
    if(!$this->getUser()->isAuthenticated())
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No esta loguiado.')));
    
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $mision_actual= $usuario->getMisionActual();

    if($mision_actual == null)
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'No esta en una zona activa.')));

    $necesidad = Doctrine_Core::getTable('PastoralNecesidad')->findOneById($request->getParameter('id'));

    if($necesidad == null)
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'No encontrada la necesidad por borrar.')));



    try {
    $necesidad->delete();
    } catch (Doctrine\ORM\NoResultException $e) {
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al borrar el comentario.')));
    } catch (Exception $e) {
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'Error al borrar el comentario.')));
    }


    return $this->renderText(json_encode(array('status'=>'success', 'mensaje'=>'Comentario borrada exitosamente.')));
        
  }
  
  public function executeAjaxGetMisioneros(sfWebRequest $request)
  {
    if(!$this->getUser()->isAuthenticated())
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No esta loguiado.')));

    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $mision_actual= $usuario->getMisionActual();

    if($mision_actual == null)
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'No esta en una zona activa.')));

    $misioneros = $mision_actual->getMisionerosActivos();

    $misioneros_array = array();

    foreach($misioneros as $misionero)
    {
      $misionero_array['id'] = $misionero->getId();
      $misionero_array['nombre'] = $misionero->getNombreCompleto();
      $misionero_array['email'] = $misionero->getEmail();
      $misionero_array['celular'] = $misionero->getTelefonoCelular();
      array_push($misioneros_array, $misionero_array);
    }
     
    return $this->renderText(json_encode(array('status'=>'success', 'misioneros'=> $misioneros_array)));
        
  }
  
  public function executeAjaxObtenerLugarYContactos(sfWebRequest $request)
  {
    if(!$this->getUser()->isAuthenticated())
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No esta loguiado.')));
      
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $mision_actual = $usuario->getMisionActual();
    
    if($mision_actual == null)
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'No esta en una zona activa.')));
      
    if($mision_actual->getLocalidadId() == null)
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje'=>'No tiene localidad asociada.')));
    
    $localidad = $mision_actual->getPastoralLocalidad();
    
    $contactos = Doctrine_Core::getTable('PastoralContacto')
                          ->addContactosPorLocalidadQuery($localidad->getId())
                          ->execute();
    $alojamientos = $localidad->getLugaresPorTipo('Alojamiento');

    $parroquias = $localidad->getLugaresPorTipo('Parroquia');
    
    $municipalidades = $localidad->getLugaresPorTipo('Municipalidad');
    
    if(count($municipalidades) > 0)
      $municipalidad = $municipalidades[0];
    else
      $municipalidad = null;
      
    return $this->renderText(json_encode(array('status'=>'success', 'contactos'=> $contactos->toArray(),
    'municipalidad' => $municipalidad->toArray(), 'alojamientos'=> $alojamientos->toArray(), 
    'parroquias'=> $parroquias->toArray() )));
    
  }
  
  public function executeAjaxGetInfoLugar(sfWebRequest $request)
  {
    if(!$this->getUser()->isAuthenticated())
      return $this->renderText(json_encode(array('status'=>'error', 'mensaje' => 'No esta loguiado.')));
  
    $lugar = Doctrine_Core::getTable('PastoralLugar')->getLugarYContactosPorId($request->getParameter('id'));
    return $this->renderText( json_encode( array( 'status'=>'success', 'lugar' =>$lugar->toArray() ) ) );
  }
  
  public function executeAjaxTestDeCarga(sfWebRequest $request)
  {
    $lugar = Doctrine_Core::getTable('PastoralLugar')->getLugarYContactosPorId($request->getParameter('id'));
    return $this->renderText( json_encode( array( 'status'=>'success', 'lugar' =>$lugar->toArray() ) ) );
  }
  
}
