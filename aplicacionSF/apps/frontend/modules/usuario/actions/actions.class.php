<?php

/**
 * usuario actions.
 *
 * @package    pastoral
 * @subpackage usuario
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuarioActions extends sfActions
{
  private function createPassword($length) 
  {
    $chars = "234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $i = 0;
    $password = "";
    while ($i <= $length) {
      $password .= $chars{mt_rand(0,strlen($chars))};
      $i++;
    }
    return $password;
  }

  public function executeRecuperarPassword(sfWebRequest $request)
  {
  }

  public function executeAjaxPasswordReset(sfWebRequest $request)
  {
    if($request->getParameter('rut') != null)
      $usuario = Doctrine_Core::getTable('PastoralUsuario')->findOneByRut($request->getParameter('rut'));
    else if($request->getParameter('email') != null)
      $usuario = Doctrine_Core::getTable('sfGuardUser')->findOneByEmailAddress($request->getParameter('email'))->getProfile();
      
    if($usuario == null)
      return $this->renderText(json_encode(array('status'=>'error')));
      
    $nuevopass = $this->createPassword(8);
    
    $mensaje = $this->getMailer()->compose(
      array('pastoral@pastoraluc.cl' => 'Pastoral UC'),
      $usuario->getEmail(),
      'Cambio de contraseña',
      <<<EOF
Hola {$usuario->getNombre()},
      
Tu nueva contraseña es : {$nuevopass}
 
Saludos.
EOF
    );
 
    $this->getMailer()->send($mensaje);
    
    $sfGuardUser = $usuario->getUser();
    $sfGuardUser->setPassword($nuevopass);
    $sfGuardUser->save();
    
    return $this->renderText(json_encode(array('status'=>'success')));
  }
 
  
  public function executeLogin(sfWebRequest $request)
  {
    $this->proyecto_id;
  }

  public function executeInformacion(sfWebRequest $request)
  {
     $id = $this->getUser()->getGuardUser()->getProfile()->getId();
    $this->pastoral_usuario = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id);
    $this->forward404Unless($this->pastoral_usuario);
    
    $proyecto_id = $this -> getUser()->getAttribute('proyecto_id');
    
    $misiones_inscribibles= Doctrine_Core::getTable('PastoralMision')->getMisionesPorProyecto($proyecto_id);
    $this -> mostrar_postulacion  = 1;
    if($misiones_inscribibles->count()!=0)
    {
      foreach($misiones_inscribibles as $mision)
      {
        $estadoPostulacion = $mision->getPostulacionActiva($id);
        if($estadoPostulacion)
        {
            $this -> mostrar_postulacion  = 0;
            $this -> mision_usuario = $estadoPostulacion->getPastoralMision();
            $this -> localidad_fantasia = $this -> mision_usuario->getPastoralLocalidadFantasia();
            $this -> estado_postulacion = $estadoPostulacion;
            
            $this->array_jefes_muc = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYMision($this -> mision_usuario->getId() )->execute();
            break;
        }
        if($this -> mostrar_postulacion == 1)
        {
          #Codigo en caso de que se muestre la postulacion
           $this -> pastoral_misiones = Doctrine_Core::getTable('PastoralMision')->getSalidasInscribiblesPorProyecto($proyecto_id);
        }
      }
    }
  }

  public function executeInscripcion(sfWebRequest $request)
  {
    $id = $this->getUser()->getGuardUser()->getProfile()->getId();
    $this->pastoral_usuario = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id);
    $this->forward404Unless($this->pastoral_usuario);
    
    $this->proyecto_id = $this -> getUser()->getAttribute('proyecto_id');
    
    $misiones_inscribibles= Doctrine_Core::getTable('PastoralMision')->getMisionesPorProyecto($this->proyecto_id);
    $this -> mostrar_postulacion  = 1;
    if($misiones_inscribibles->count()!=0)
    {
      foreach($misiones_inscribibles as $mision)
      {
        $estadoPostulacion = $mision->getPostulacionActiva($id);
        if($estadoPostulacion)
        {
            $this -> mostrar_postulacion  = 0;
            $this -> mision_usuario = $estadoPostulacion->getPastoralMision();
            $this -> localidad_fantasia = $this -> mision_usuario->getPastoralLocalidadFantasia();
            $this -> estado_postulacion = $estadoPostulacion;
            $this->array_jefes_muc = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYMision($this -> mision_usuario->getId() )->execute();
            break;
        }
        if($this -> mostrar_postulacion == 1)
        {
          #Codigo en caso de que se muestre la postulacion
           $this -> pastoral_misiones = Doctrine_Core::getTable('PastoralMision')->getSalidasInscribiblesPorProyecto($this->proyecto_id);           
        }
      }
    }
  }


  public function executeShow(sfWebRequest $request)
  {
    $id = $this->getUser()->getGuardUser()->getProfile()->getId();
    $this->pastoral_usuario = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id);
    $this->forward404Unless($this->pastoral_usuario);
    $proyecto_id = $this -> getUser()->getAttribute('proyecto_id');
    if($proyecto_id == null || $proyecto_id == ''){
    	$proyecto_id = $this->pastoral_usuario->getUltimoProyectoAccedidoId();
    }
    $this -> mostrar_postulacion  = 1;
    $misiones = Doctrine_Core::getTable('PastoralMision')->getMisionesPorProyecto($proyecto_id);
    $misiones_inscribibles= Doctrine_Core::getTable('PastoralMision')->getMisionesInscribiblesPorProyecto($proyecto_id);
    
    if($misiones->count()!=0)
    {
      foreach($misiones as $mision)
      {
        $estadoPostulacion = $mision->getPostulacionActiva($id);
        if($estadoPostulacion)
        {
            $this -> mostrar_postulacion  = 0; //Ya esta postulando
            $this -> mision_usuario = $estadoPostulacion->getPastoralMision();
            $this -> localidad_fantasia = $this -> mision_usuario->getPastoralLocalidadFantasia();
            $this -> estado_postulacion = $estadoPostulacion;
            
            $this->array_jefes_muc = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYMision($this -> mision_usuario->getId() )->execute();
            break;
        }
        
      }
      $this -> proyecto_version = $misiones_inscribibles[0]->getPastoralGrupo()->getPastoralProyectoVersion();
      
      if($this->pastoral_usuario->getEsExtranjero() )
      {
        $ei = Doctrine_Core::getTable('PastoralExtranjeroInscrito')->findOneByUsuarioId($id);
        
        if($ei != null && $ei->getProyectoVersionId() == $this -> proyecto_version->getId() )
           $this -> mostrar_postulacion  = 0; //Ya esta postulando
      }
      
      if($this -> mostrar_postulacion == 1)
      {
        #Codigo en caso de que se muestre la postulacion
        $this -> pastoral_misiones = Doctrine_Core::getTable('PastoralMision')->getSalidasInscribiblesPorProyecto($proyecto_id);
      }
    }
    else if($this->pastoral_usuario->getEsExtranjero())
    {
      $this -> mostrar_postulacion  = -1; //Cuando no hay misiones inscribibles
    }
  }
  
  public function executeInscribirExtranjero(sfWebRequest $request)
  {
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $proyecto_version_id = $request->getParameter("pv_id");
    
    if($usuario->getEsExtranjero() == 0)
      $this->forward404();
    
    $ei = Doctrine_Core::getTable('PastoralExtranjeroInscrito')->findOneByUsuarioId($usuario->getId());
    
    if($ei == null)
    {
      $ei = new PastoralExtranjeroInscrito();
      $ei ->setUsuarioId($usuario->getId());
    }
    
    
    $ei -> setProyectoVersionId($proyecto_version_id)
        -> save();
        
    $this->redirect('usuario/show');
    
  }
  
  public function executeIndex(sfWebRequest $request)
  {
  }
  
  public function executeMostrarTodosLosUsuarios(sfWebRequest $request)
  {
    $this->pastoral_usuarios = Doctrine_Core::getTable('PastoralUsuario')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UsuarioRegistroForm();
    //TODO: Cambiar proyeco id
    $this->proyecto_id = $request->getParameter('pid');
  }

  public function executeCreate(sfWebRequest $request)
  {

    $this->proyecto_id = $request->getParameter('pid');
  
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    
    $this->form = new UsuarioRegistroForm();

    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
      $pastoral_usuario = $this->form->save();
      
      if($this->proyecto_id != null)
        $pastoral_usuario->setUltimoProyectoAccedidoId($request->getParameter('pid'));
        
      $pastoral_usuario->save();
      
      $this->getUser()->setFlash('registro_exitoso', sprintf('Su registro se ha realizado exitosamente'));
      
      $this->getUser()->signIn($pastoral_usuario->getUser(), true);
      $this->getUser()->setAttribute('proyecto_id', $request->getParameter('pid'));
      $this->redirect('usuario/show?proyecto_id='.$request->getParameter('pid'));
      //$this->redirect('@sf_guard_signin?pid='.$request->getParameter('pid'));
    } 
    $this -> pastoral_misiones = Doctrine_Core::getTable('PastoralMision')->getSalidasInscribiblesPorProyecto($request->getParameter('pid'));
    $this->setTemplate('new');
  }  

  public function executeEdit(sfWebRequest $request)
  {
      $id = $this->getUser()->getGuardUser()->getProfile()->getId();
      $pastoral_usuario = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id);
      $this->form = new UsuarioEditarForm($pastoral_usuario);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pastoral_usuario = Doctrine_Core::getTable('PastoralUsuario')->find(array($request->getParameter('id'))), sprintf('Object pastoral_usuario does not exist (%s).', $request->getParameter('id')));
    
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    
    $this->form = new UsuarioEditarForm($pastoral_usuario);

    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($pastoral_usuario = Doctrine_Core::getTable('PastoralUsuario')->find(array($request->getParameter('id'))), sprintf('Object pastoral_usuario does not exist (%s).', $request->getParameter('id')));
    $pastoral_usuario->delete();

    $this->redirect('usuario/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
  
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $telefono = $request->getParameter('pastoral_usuario[telefono_celular]');
      if(strlen($telefono)==8)
        $telefono = '+569'.$telefono;
      if(strlen($telefono)==9)
        $telefono = '+56'.$telefono; 
      if(strlen($telefono)==10)
        $telefono = '+5'.$telefono; 
      if(strlen($telefono)==11)
        $telefono = '+'.$telefono; 
      $pastoral_usuario = $form->save();

      $this->getUser()->setFlash('edicion_exitosa', sprintf('Se han editado sus datos exitosamente.'));
      
      $this->redirect('usuario/informacion');
    }
  }
  
  public function executeInscritos(sfWebRequest $request)
  {
      
      $this->estados_posibles = Doctrine_Core::getTable('PastoralEstadoPostulacion')->createQuery('a')->execute();
        
      $usuario = $this->getUser()->getGuardUser()->getProfile();
      $usuario_id = $usuario->getId();
      $cargo = $usuario->getCargoActual()->getPastoralCargo();
      
      $this->verMision = $cargo->getVerMisionerosPorMision();
      $this->verProyecto =  $cargo->getVerMisionerosPorProyecto();
      $this->editarCuota = $cargo->getInscritosModificarCuota();
      $this->editarCargo = $cargo->getInscritosModificarCargo();
      $this->editarEstado = $cargo->getInscritosModificarEstado();
      $this->editarMision = $cargo->getInscritosModificarMision();
      
      $this->cargo = $cargo;
      
      if($this->verMision==1){      
          $this->misiones_activas = $usuario->getCargoActual()->getPastoralMision();         
      }
      else if($this->verProyecto==1)
      {
          $this->misiones_activas = Doctrine_Core::getTable('PastoralMision')->addMisionesActivasPorProyectoQuery($usuario->getCargoActual()->getPastoralProyectoVersion()->getProyectoId())->execute(); 
      }
      else{
          $this->redirect('usuario/show');
      }
      $id_jefe_de_zona = Doctrine_Core::getTable('PastoralCargo')->getCargoPorNombre('Jefe de Zona')->getId();
      $this->cargos_posibles = Doctrine_Core::getTable('PastoralCargo')->addCargosMasBajosQuery($id_jefe_de_zona)->execute();
  }
 
  
  public function executeAjaxGetUserInformation(sfWebRequest $request)
  {
        $usuario_id = $request->getParameter('usuario_id');
        $usuario = Doctrine_Core::getTable('PastoralUsuario')->findOneById($usuario_id);
        $usuario_array = $usuario->toArray();
        $usuario_array['email'] = $usuario->getUser()->getEmailAddress();
        $usuario_array['movimiento'] = $usuario->getPastoralMovimiento()->getNombre();
        $usuario_array['comuna'] = $usuario->getPastoralComuna()->getNombre();
        $usuario_array['tipo_institucion'] = $usuario->getPastoralTipoInstitucion()->getNombre();
        
        if($usuario_array['tipo_institucion'] == "Colegio")
        {
          $usuario_array['colegio_universidad'] = $usuario->getPastoralColegio()->getNombre();
          $usuario_array['ingreso_curso'] = $usuario->getPastoralCurso()->getNombre();
        }
        
        else
        {
          $usuario_array['colegio_universidad'] = $usuario->getPastoralUniversidad()->getNombre();
          $usuario_array['carrera'] = $usuario->getPastoralCarrera()->getNombre();
          $usuario_array['ingreso_curso'] = $usuario->getAnoIngreso();       
        }
        
        if($usuario->getFechaNacimiento() != null && $usuario->getFechaNacimiento() != 0 )
        {
          $usuario_array['fecha_nacimiento'] = $usuario->getDateTimeObject('fecha_nacimiento')->format('d/m/Y');
          $usuario_array['edad'] = $usuario->getEdad();
        }
        
        else
          $usuario_array['fecha_nacimiento'] = null;
        return $this->renderText(json_encode($usuario_array));
  }
  
 
  
  public function executeAjaxGetMisionesPorSalida(sfWebRequest $request)
  {
       if($request->getParameter('proyecto_id')!=null && $request->getParameter('proyecto_id')!=-1)
        $proyecto_id = $request->getParameter('proyecto_id');
       else
        $proyecto_id = $this -> getUser()->getProfile()->getUltimoProyectoAccedidoId();
       
       
      $salida_id = $request->getParameter('salida_id');
      $misiones = Doctrine_Core::getTable('PastoralMision')->getMisionesInscribiblesPorProyectoYSalidaQuery($proyecto_id, $salida_id)->fetchArray();
      $localidad_fantasia[0] = "";
      for($i = 0;$i <count($misiones);$i++)
      {
          $localidad_fantasia_id = $misiones[$i]['localidad_fantasia_id'];
          $localidad_fantasia[$i] = Doctrine_Core::getTable('PastoralLocalidadFantasia')->getArrayLocalidadFantasiaPorId($localidad_fantasia_id);
      }
      return $this->renderText(json_encode($localidad_fantasia));
      
  }
  
  public function executeAjaxGetGruposPorSalida(sfWebRequest $request)
  {
       if($request->getParameter('proyecto_id')!=null && $request->getParameter('proyecto_id')!=-1)
        $proyecto_id = $request->getParameter('proyecto_id');
       else
        $proyecto_id = $this -> getUser()->getProfile()->getUltimoProyectoAccedidoId();
       
      $salida_id = $request->getParameter('salida_id');
      $misiones = Doctrine_Core::getTable('PastoralMision')
                    ->getMisionesInscribiblesPorProyectoYSalidaQuery($proyecto_id, $salida_id)->execute();

      $grupos = array();
      foreach($misiones as $mision)
      {
        $grupo = $mision->getPastoralGrupo();
        
        if(!array_key_exists($grupo->getId(), $grupos))
        {
          $grupos[$grupo->getId()] = $grupo->getNombre();
        }
      }
      return $this->renderText(json_encode($grupos));
      
  }
  
  public function executeAjaxGetMisionesPorGrupo(sfWebRequest $request)
  {
      $grupo_id = $request->getParameter('grupo_id');
      $zonas = Doctrine_Core::getTable('PastoralMision')->findByGrupoId($grupo_id);
      
      $zonas_data = array();
      
      foreach($zonas as $zona)
      {
        if($zona->estaInscripcionAbierta())
        {
          $id = $zona->getId();
          $zonas_data[$id]['nombre'] = $zona->getPastoralLocalidadFantasia()->getNombre();
          $zonas_data[$id]['descripcion'] = $zona->getPastoralLocalidadFantasia()->getDescripcion();
          $zonas_data[$id]['foto_url'] = $zona->getPastoralLocalidadFantasia()->getFotoUrl();
          
        }
      }

      return $this->renderText(json_encode( $zonas_data ));
  }
  
  public function executeAjaxGetInformacionMision(sfWebRequest $request)
  {
      $mision_id = $request->getParameter('mision_id');
      $usuarioCargo = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYMision($mision_id)->fetchArray();
      $mision =  Doctrine_Core::getTable('PastoralMision')->getArrayMisionPorId($mision_id);
      $localidad_fantasia_id = $mision[0]['localidad_fantasia_id'];
      $localidad_id = $mision[0]['localidad_id'];
      $jefes = array();
      
      for($i = 0;$i <count($usuarioCargo);$i++)
      {
        $usuario_id = $usuarioCargo[$i]['usuario_id'];
        $jefes[$i] =  Doctrine_Core::getTable('PastoralUsuario')->findOneById($usuario_id)->getNombreCompleto();
      }
      
      $respuesta = array();
      $respuesta[0] = Doctrine_Core::getTable('PastoralLocalidadFantasia')->getArrayLocalidadFantasiaPorId($localidad_fantasia_id);
      $respuesta[1] = $jefes;
      $respuesta[2] = $mision;
      return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxIngresarPostulante(sfWebRequest $request)
  {
      $mision_id = $request->getParameter('mision_id');
      $mision = Doctrine_Core::getTable('PastoralMision')->find($mision_id);
      $usuario_id = $this->getUser()->getGuardUser()->getProfile()->getId();
      $postulacion_id = Doctrine_Core::getTable('PastoralEstadoPostulacion')->findOneByNombre('Pendiente')->getId();
      $mue = new PastoralMisionUsuarioEstado();
      $mue->usuario_id = $usuario_id;
      $mue->mision_id = $mision_id;
      $mue->estado_postulacion_id = $postulacion_id;
      $mue->cuota = $mision->getCuota();
      $respuesta = 1;
      
      try {
      $mue->save();
      } catch (Doctrine\ORM\NoResultException $e) {
        $respuesta = 0;
      } catch (Exception $e) {
        $respuesta = 0;
      }
      
      return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxGetMUEdeEstadoYMision(sfWebRequest $request)
  {
    //AjaxGetMUEdeEstadoYMision?mision_id=1;estado_id=-1;flag_id=2
    $mision_id = $request->getParameter('mision_id');
    $estado_id = $request->getParameter('estado_id');
    $flag_id =   $request->getParameter('flag_id'); 
    $flag_id = $flag_id == null?$flag_id=-1:$flag_id; 
    
    $q  = $mision_id >0?Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporMisionQuery($mision_id):null;
    $q1 = $estado_id >0?Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporEstadoPostulacionQuery($estado_id,$q):$q;
    
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $cargo = $usuario->getCargoActual()->getPastoralCargo();
    if($cargo->getVerMisionerosPorProyecto()==1)
    {
        $proyecto_version_id = $usuario->getCargoActual()->getProyectoVersionId();
        $q2 = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporProyectoVersionActivoQuery($proyecto_version_id,$q1);
    }else{
        $q2 = $q1;
    }
    $one =1;
    switch($flag_id){
        case '1':
            $q3 = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporFlagZonaQuery($one,$q2);
            break;
        case '2':
          $q3 = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporFlagCuotaQuery($one,$q2);
          break;
        default:
          $q3 = $q2;
          break;
    }
    $q3 = $q3==null?Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->createQuery('a'):$q3;
    $muec = $q3->execute();
    $muecArray = $q3->fetchArray();
    $i = 0;
    
    $respuesta = Array();
    $res = Array();
    
    $res[0] = $cargo->getCrudFlagZona();
    $res[1] = $cargo->getCrudFlagCuota();
    foreach ($muec as $column)
    {
      $usuario = Doctrine_Core::getTable('PastoralUsuario')->findOneById($column->getUsuarioId());
      $usuario_array = $usuario->toArray();
      $usuario_array['email'] = $usuario->getUser()->getEmailAddress();
      $usuario_array['movimiento'] = $usuario->getPastoralMovimiento()->getNombre();
      $usuario_array['comuna'] = $usuario->getPastoralComuna()->getNombre();
      $usuario_array['tipo_institucion'] = $usuario->getPastoralTipoInstitucion()->getNombre();
      
      if($usuario_array['tipo_institucion'] == "Colegio")
      {
        $usuario_array['estudios'] = "Colegio-".$usuario->getPastoralCurso()->getNombre();
        $usuario_array['colegio_universidad'] = 'Colegio';
        $usuario_array['ingreso_curso'] = $usuario->getPastoralCurso()->getNombre();
      }
      else
      {
        $usuario_array['colegio_universidad'] = $usuario->getPastoralUniversidad()->getNombre();
        $usuario_array['carrera'] = $usuario->getPastoralCarrera()->getNombre();
        $usuario_array['estudios'] = $usuario->getPastoralUniversidad()->getSigla()."-".$usuario->getPastoralCarrera()->getNombre();
        $usuario_array['ingreso_curso'] = $usuario->getAnoIngreso();       
      }
      
      if($usuario->getFechaNacimiento() != null && $usuario->getFechaNacimiento() != 0 )
      {
        $usuario_array['fecha_nacimiento'] = $usuario->getDateTimeObject('fecha_nacimiento')->format('d/m/Y');
        $usuario_array['edad'] = $usuario->getEdad();
        
      }
      else
        $usuario_array['fecha_nacimiento'] = null;

      $respuesta[$i][0] = array($usuario_array);
      $respuesta[$i][1] = Doctrine_Core::getTable('PastoralLocalidadFantasia')->getArrayLocalidadFantasiaPorId($column->getPastoralMision()->getPastoralLocalidadFantasia()->getId());
      $respuesta[$i][2] = $column->getPastoralUsuario()->getCargoMisionero()->toArray();
      $respuesta[$i][3] = Doctrine_Core::getTable('PastoralEstadoPostulacion')->getArrayEstadoPorId($column->getEstadoPostulacionId());
      $respuesta[$i][4] = $muecArray[$i];
      $respuesta[$i][5] = $column->getPastoralUsuario()->getUser()->getEmailAddress();
      $i = $i + 1;
    }
    $res[2] = $respuesta;
    return $this->renderText(json_encode($res));
  }


  public function executeAjaxEditarEvaluacion(sfWebRequest $request)
  {
      $asistio = (array)$request->getParameter('asistio');
      $no_asistio = (array)$request->getParameter('no_asistio');
      $recomiendo = (array)$request->getParameter('recomendado');
      $no_recomiendo = (array)$request->getParameter('no_recomendado');
      $enviar = $request->getParameter('enviar');
      $respuesta = 1;
      
      foreach($asistio as $a)
      {
        $estado_id = Doctrine_Core::getTable('PastoralEstadoPostulacion')->findOneByNombre('Confirmado')->getId();
        $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($a);
        echo($enviar);
        if($enviar==1){
          $mue->setEvalEnviada(1);
        }
        $mue->setEstadoPostulacionId( $estado_id );
        try {
            $mue->save();
        } catch (Doctrine\ORM\NoResultException $e) {
            $respuesta = 0;
        } catch (Exception $e) {
            $respuesta = 0;
        }
      }
      
      foreach($no_asistio as $a)
      {
        $estado_id = Doctrine_Core::getTable('PastoralEstadoPostulacion')->findOneByNombre('No asistio')->getId();
        $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($a);
        if($enviar==1){
          $mue->setEvalEnviada(1);
        }
        $mue->setEstadoPostulacionId( $estado_id );
        try {
            $mue->save();
        } catch (Doctrine\ORM\NoResultException $e) {
            $respuesta = 0;
        } catch (Exception $e) {
            $respuesta = 0;
        }
      }
        
      foreach($recomiendo as $r)
      {
        $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($r);
        $mue->setRecomendado(1);
        try {
            $mue->save();
        } catch (Doctrine\ORM\NoResultException $e) {
            $respuesta = 0;
        } catch (Exception $e) {
            $respuesta = 0;
        }
      }
      
      foreach($no_recomiendo as $r)
      {
        $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($r);
        $mue->setRecomendado(0);
        try {
            $mue->save();
        } catch (Doctrine\ORM\NoResultException $e) {
            $respuesta = 0;
        } catch (Exception $e) {
            $respuesta = 0;
        }
      }
      
      return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEditarEvalDescripcion(sfWebRequest $request)
  {
      $mue_id = $request->getParameter('mue_id');
      $descripcion = $request->getParameter('descripcion');
      $respuesta =1;
      $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($mue_id);
      
      $mue->setEvalDescripcion( $descripcion );
      try {
          $mue->save();
      } catch (Doctrine\ORM\NoResultException $e) {
          $respuesta = 0;
      } catch (Exception $e) {
          $respuesta = 0;
      }
      return $this->renderText(json_encode($respuesta));
  }
  

  
  public function executeAjaxGetComunas(sfWebRequest $request)
  {
    
    $comunas = Doctrine_Core::getTable('PastoralComuna')->getComunasPorBusqueda($request->getParameter('q'), $request->getParameter('limit'));
    
    $comunas_array = array();
    
    foreach ($comunas as $comuna)
    {
      $comunas_array[$comuna['id']] = (string) $comuna['nombre'];
    }
	
	  return $this->renderText(json_encode($comunas_array));
  }
  
  public function executeAjaxGetColegios(sfWebRequest $request)
  {
  	$colegios = Doctrine_Core::getTable('PastoralColegio')->getColegiosPorBusqueda($request->getParameter('q'), $request->getParameter('limit'));
  
  	$colegios_array = array();
  
  	foreach ($colegios as $colegio)
  	{
  		$colegios_array[$colegio['id']] = (string) $colegio['nombre'];
  	}
  
  	return $this->renderText(json_encode($colegios_array));
  }
  
  public function executeFormularioCoEvaluacion(sfWebRequest $request)
  {
    $usuario = $this->getUser()->getProfile();
    
    $q = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->addMUEporMisionActivaYUsuarioQuery($usuario->getId());
    
    $mue = $q->fetchOne();
    
    if($mue == null)
      $this->forward404();
      
    $mision = $mue->getPastoralMision();
    $this->enviado = $mue->getCoEvaluacionEnviada();
    $this->mues = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision->getId());
    

  }
  
  public function executeAjaxEditarCoEvaluacion(sfWebRequest $request)
  {
      $recomiendo = (array)$request->getParameter('recomendado');
      
      $user = $this->getUser()->getGuardUser()->getProfile();
      $user_id = $user->getId();
      
      $mision_id = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($recomiendo[0])->getMisionId();
      
      $respuesta = 1;
      
      foreach($recomiendo as $r)
      {
        $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($r);
        $mue->setRecomendadoPorMisioneros($mue->getRecomendadoPorMisioneros()+1);
        try {
            $mue->save();
        } catch (Doctrine\ORM\NoResultException $e) {
            $respuesta = 0;
        } catch (Exception $e) {
            $respuesta = 0;
        }
      }
      
      if($respuesta ==1)
      {
        $mue = $user->getMUEPorMisionId($mision_id);
        $mue->setCoEvaluacionEnviada(1);
        try {
            $mue->save();
        } catch (Doctrine\ORM\NoResultException $e) {
            $respuesta = 0;
        } catch (Exception $e) {
            $respuesta = 0;
        }
      }
      
      return $this->renderText(json_encode($respuesta));
  } 
}
