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

  public function executeFormularioSedeTalleres(sfWebRequest $request)
  {
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo = $uc->getPastoralCargo();
    //probamos que exista un cargo para este usuario 
    //$this->forward404Unless($cargo);
    $mision = $cargo->getPastoralMision();
    //por si el cargo no es un cargo de jefe (solo el cargo de jefe va a tener mision (o misioneros con cargo elevados TODO:filtrarlos ) 
    //$this->forward404Unless($mision_id);
    $this->mues = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision->getId());
    $this->lugares = Doctrine_Core::getTable('PastoralLugar')->findByLocalidadId($mision->getLocalidadId());
    $this->contactos_all = Doctrine_Core::getTable('PastoralContacto') -> findAll();   
  
  $localidad = $mision->getPastoralLocalidad();
    
    $this->pastoral_localidad = $localidad;
    $this->contactos = Doctrine_Core::getTable('PastoralContacto')
                          ->addContactosPorLocalidadQuery($request->getParameter('id'))
                          ->execute();
                          
    $this->sedes = $localidad->getLugaresPorTipo('Sede de Talleres');  
  }

  public function executeFormularioJefeZona(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getProfile();
    $cargo = $this->getUser()->getAttribute('usuario_cargo');
    //probamos que exista un cargo para este usuario 
    $this->forward404Unless($cargo);
    $mision_id = $cargo->getMisionId();
    //por si el cargo no es un cargo de jefe (solo el cargo de jefe va a tener mision (o misioneros con cargo elevados TODO:filtrarlos ) 
    $this->forward404Unless($mision_id);
    $mues = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision_id);
    foreach($mues as $mue)
    {
      $enviado = 0;
      if($mue->getEvalEnviada()==1)
      {
        $enviado = 1;
        break;
      }
    }
    $this->mues = $mues;
    $this->enviado = $enviado;
  }
  
  public function executeFormularioLocalidad(sfWebRequest $request)
  {
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo = $uc->getPastoralCargo();
    $usuario = $this->getUser()->getProfile();
    //probamos que exista un cargo para este usuario 
    $this->forward404Unless($cargo);
    
    $mision = $uc->getPastoralMision();
    
    $this->forward404Unless($cargo->getVeEvaluacionMision());
    
    //se debe poner el id de la mision en el url para solucionar problemas de rutas en el ajax del componente. TODO: buscar mejor solucion
    if($request->getParameter('mision')!= $mision->getId())
      $this->forward404();
      
    $this->mision = $mision;
    
    //$this->forward404Unless($mision_id);
    $mues = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision->getId());
    $this->lugares = Doctrine_Core::getTable('PastoralLugar')->findByLocalidadId($mision->getLocalidadId());
    $this->contactos_all = Doctrine_Core::getTable('PastoralContacto') -> findAll();   
  
    $localidad = $mision->getPastoralLocalidad();
    
    $this->pastoral_localidad = $localidad;
    $this->contactos = Doctrine_Core::getTable('PastoralContacto')
                          ->addContactosPorLocalidadQuery($request->getParameter('id'))
                          ->execute();
                          
    $this->alojamientos = $localidad->getLugaresPorTipo('Alojamiento');

    $this->parroquias = $localidad->getLugaresPorTipo('Parroquia');
    
    $this->municipalidades = $localidad->getLugaresPorTipo('Municipalidad');
    
    $this->agrupaciones = $localidad->getLugaresPorTipo('Agrupaciones Locales');
    
    $this->medios = $localidad->getLugaresPorTipo('Medios de Comunicación');
    
    $this->otros = $localidad->getLugaresPorTipo('Otros');
    
    $this->sedes = $localidad->getLugaresPorTipo('Sede de Talleres'); 
    
    foreach($mues as $mue)
    {
      $enviado = 0;
      if($mue->getEvalEnviada()==1)
      {
        $enviado = 1;
        break;
      }
    }
    $this->mues = $mues;
    $this->enviado = $enviado;
  
  }
  
  public function executeFormularioAlojamiento(sfWebRequest $request)
  {
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo = $uc->getPastoralCargo();
    //probamos que exista un cargo para este usuario 
    //$this->forward404Unless($cargo);
    $mision = $cargo->getPastoralMision();
    //por si el cargo no es un cargo de jefe (solo el cargo de jefe va a tener mision (o misioneros con cargo elevados TODO:filtrarlos ) 
    //$this->forward404Unless($mision_id);
    $this->mues = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision->getId());
    $this->lugares = Doctrine_Core::getTable('PastoralLugar')->findByLocalidadId($mision->getLocalidadId());
    $this->contactos_all = Doctrine_Core::getTable('PastoralContacto') -> findAll();   
  
  $localidad = $mision->getPastoralLocalidad();
    
    $this->pastoral_localidad = $localidad;
    $this->contactos = Doctrine_Core::getTable('PastoralContacto')
                          ->addContactosPorLocalidadQuery($request->getParameter('id'))
                          ->execute();
                          
    $this->alojamientos = $localidad->getLugaresPorTipo('Alojamiento');
    $this->sedes = $localidad->getLugaresPorTipo('Sede de Talleres'); 
  }
  
  public function executeFormularioCoEvaluacion(sfWebRequest $request)
  {
    $usuario = $this->getUser()->getProfile();
    $muesUsuario = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByUsuarioId($usuario->getId());
    
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    if($uc){
        $cargo_actual = $uc->getPastoralCargo();
        if($cargo_actual=='Jefe de Zona' || $cargo_actual=='Jefe Regional' || $cargo_actual=='Jefe Nacional'){
            $this->redirect("usuario/PermisoDenegado");
        }  
    }
    
    if(count($muesUsuario)>0){
      $mueUsuario = $muesUsuario[count($muesUsuario)-1];    
      $this->forward404Unless($mueUsuario);
      $mision = $mueUsuario->getPastoralMision();
      $this->forward404Unless($mision);
      //probamos que exista un cargo para este usuario    
      $this->mues = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision->getId());
      $mue = $usuario->getMUEPorMisionId($mision->getId());
      $this->enviado = $mue->getCoEvaluacionEnviada();
    }
  }
  
  public function executeBusqueda(sfWebRequest $request)
  {
    $user             = $this->getUser()->getGuardUser()->getProfile();
    $uc               = $this->getUser()->getAttribute('usuario_cargo');
    $this->busqueda   = $request->getParameter('busqueda');
    
    $this-> universidades       = Doctrine_Core::getTable('PastoralUniversidad')     ->findAll() ;
    $this-> carreras            = Doctrine_Core::getTable('PastoralCarrera')         ->findAll() ;
    $this-> movimientos         = Doctrine_Core::getTable('PastoralMovimiento')      ->findAll() ;
    $this-> cargos              = Doctrine_Core::getTable('PastoralCargo')           ->findAll() ;

    if($uc->getMisionId()>0){
        $this-> misiones            = $uc->getPastoralMision();
        $this-> grupos              = $uc->getPastoralMision()->getPastoralGrupo();
        $this-> proyectos_versiones = $uc->getPastoralMision()->getPastoralGrupo()->getPastoralProyectoVersion();
        $this-> proyectos           = $uc->getPastoralMision()->getPastoralGrupo()->getPastoralProyectoVersion()->getPastoralProyecto();    
    }
    else if($uc->getGrupoId()>0){
        $this-> misiones            = Doctrine_Core::getTable('PastoralMision')->getMisionesPorIdGrupo($uc->getGrupoId());
        $this-> grupos              = $uc->getPastoralGrupo();
        $this-> proyectos_versiones = $uc->getPastoralGrupo()->getPastoralProyectoVersion();
        $this-> proyectos           = $uc->getPastoralGrupo()->getPastoralProyectoVersion()->getPastoralProyecto();
    }
    else{
        $this-> misiones            = Doctrine_Core::getTable('PastoralMision')          ->findAll() ;
        $this-> grupos              = Doctrine_Core::getTable('PastoralGrupo')           ->findAll() ;
        $this-> proyectos_versiones = Doctrine_Core::getTable('PastoralProyectoVersion') ->findAll() ;
        $this-> proyectos           = Doctrine_Core::getTable('PastoralProyecto')        ->findAll() ;
    }

  }
  
  public function executeAjaxCambioFiltros(sfWebRequest $request)
  {
    $grupo  =             $request->getParameter('grupo');
    $proyecto_version  =  $request->getParameter('proyecto_version');
    $proyecto  =          $request->getParameter('proyecto');
    
    $m = $g = $pv = $res = Array();
    
    if($grupo > 0){
        $m = Doctrine_Core::getTable('PastoralMision')->addMissionesPorGrupoQuery($grupo);
        $m = Doctrine_Core::getTable('PastoralMision')->leftJoinLocalidadFantasia($m)->fetchArray();
    }
    else if($proyecto_version > 0){
        $m = Doctrine_Core::getTable('PastoralMision')->addAllMissionesQuery($proyecto_version);
        $m = Doctrine_Core::getTable('PastoralMision')->leftJoinLocalidadFantasia($m)->fetchArray();
        $g = Doctrine_Core::getTable('PastoralGrupo')->addGrupoPorProyectoVersionQuery($proyecto_version)->fetchArray();
    }
    else if($proyecto > 0){
        $m = Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoQuery($proyecto);
        $m = Doctrine_Core::getTable('PastoralMision')->leftJoinLocalidadFantasia($m)->fetchArray();
        $g = Doctrine_Core::getTable('PastoralGrupo')->addGrupoPorProyectoQuery($proyecto)->fetchArray();
        $pv = Doctrine_Core::getTable('PastoralProyectoVersion')->addProyectoVersionPorProyecto($proyecto);
        $pv = Doctrine_Core::getTable('PastoralProyectoVersion')->leftJoinProyecto($pv )->fetchArray();
    }else{
        $m = Doctrine_Core::getTable('PastoralMision')->addAllMisionesQuery();
        $m = Doctrine_Core::getTable('PastoralMision')->leftJoinLocalidadFantasia($m)->fetchArray();
        $g = Doctrine_Core::getTable('PastoralGrupo')->addAllGruposQuery()->fetchArray();
        $pv = Doctrine_Core::getTable('PastoralProyectoVersion')->addAllProyectoVersionQuery();
        $pv = Doctrine_Core::getTable('PastoralProyectoVersion')->leftJoinProyecto($pv)->fetchArray();
    }
    
    $res[2] = $m;
    $res[1] = $g;
    $res[0] = $pv;
    
    return $this->renderText(json_encode($res));
  }
  
  public function executeAjaxBusqueda(sfWebRequest $request)
  {
  
    $user = $this->getUser()->getGuardUser()->getProfile();
    $cargo = $this->getUser()->getAttribute('usuario_cargo');
    
    $rj =                 $request->getParameter('rj');
    $rc =                 $request->getParameter('rc');
    $mision =             $request->getParameter('mision');
    $grupo  =             $request->getParameter('grupo');
    $proyecto_version  =  $request->getParameter('proyecto_version');
    $proyecto  =          $request->getParameter('proyecto');
    $universidad =        $request->getParameter('universidad');
    $movimiento =         $request->getParameter('movimiento');
    $carrera =            $request->getParameter('carrera');
    $sexo =               $request->getParameter('sexo');
    $busqueda_string =    $request->getParameter('busqueda_string');
    $cargo_filtro =       $request->getParameter('cargo');
    $pagina =             $request->getParameter('pagina')>0?$request->getParameter('pagina'):1;
    
    $resultados_por_pagina = 15;    
    $muesQuery = null;    
    $usuarios = Doctrine_Core::getTable('PastoralUsuario')->getQueryConJoins();

    if($cargo_filtro>0)
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroCargoConJoins($cargo_filtro,$usuarios);
    if($mision>1)
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroMisionConJoins($mision,$usuarios);
    else if($grupo>1)
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroGrupoConJoins($grupo,$usuarios);
    else if($proyecto_version>1)
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroProyectoVersionConJoins($proyecto_version,$usuarios);
    else if($proyecto>1)
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroProyectoConJoins($proyecto,$usuarios);
       
    if($sexo == 1)//hombre
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroSexoMasculinoConJoins($usuarios);
    else if($sexo == 2)//mujer
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroSexoFemeninoConJoins($usuarios);
       
    if($universidad>0)
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroUniversidadConJoins($universidad,$usuarios);
       
    if($carrera>0)
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroCarreraConJoins($carrera,$usuarios);
    
    if($movimiento>0)
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroMovimientoConJoins($movimiento,$usuarios);
    
    if($rj>0)
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroRecomendadoPorJefesConJoins($usuarios);
    if($rc>0)
       $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroRecomendadoPorMisionerosConJoins($usuarios);
       
    if($busqueda_string!=null)
    {
      $busqueda_string = $request->getParameter('busqueda_string');
      $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addFiltroBusquedaConJoins($busqueda_string, $usuarios);   
    }
    
    $usuarios->addSelect('sum(mue.recomendado_por_misioneros) as sumCopares');
    $usuarios->addSelect('sum(mue.recomendado_por_jefes) as sumJefes');
    $usuarios->addSelect('u.nombre');
    $usuarios->addSelect('u.apellido_paterno');
    $usuarios->addSelect('u.apellido_materno');
    $usuarios->addSelect('u.fecha_nacimiento');
    $usuarios->addSelect('u.telefono_celular');
    $usuarios->addSelect('u.tipo_institucion_id');
    $usuarios->addSelect('car.nombre');
    $usuarios->addSelect('uni.sigla');
    $usuarios->addSelect('col.nombre');
    $usuarios->addSelect('mov.nombre');
    $usuarios->addOrderBy('u.nombre');
    $usuarios->addOrderBy('u.apellido_paterno');
    
    $usuarios = Doctrine_Core::getTable('PastoralUsuario')->addAgruparPorUsuarioConJoins($usuarios);
    
    $paginador = new Doctrine_Pager($usuarios,$pagina,$resultados_por_pagina);
    
    $res[0] = $paginador->execute()->toArray();
    $res[1] = ceil($paginador->getNumResults()/$resultados_por_pagina);//numero de paginas
    $res[2] = $cargo;
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($res));
  }
  
  public function executeLogin(sfWebRequest $request)
  {
    $this->proyecto_id;
  }


  public function executeInscripcion(sfWebRequest $request)
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



  public function executeShow(sfWebRequest $request)
  {
    $id = $this->getUser()->getGuardUser()->getProfile()->getId();
    $this->pastoral_usuario = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id);
    $this->forward404Unless($this->pastoral_usuario);
    
    $proyecto_id = $this -> getUser()->getAttribute('proyecto_id');    
    
    $misiones_inscribibles= Doctrine_Core::getTable('PastoralMision')->getMisionesPorProyecto($proyecto_id);
    $this -> mostrar_postulacion  = 1;
    
    if($misiones_inscribibles->count()!=0)
    {
      $this -> proyecto_version = $misiones_inscribibles[0]->getPastoralGrupo()->getPastoralProyectoVersion();
      
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
      
      
      $this->redirect('@sf_guard_signin?pid='.$request->getParameter('pid'));
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
      $pastoral_usuario = $form->save();

      $this->getUser()->setFlash('edicion_exitosa', sprintf('Se han editado sus datos exitosamente.'));
      
      $this->redirect('usuario/informacion');
    }
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
  
  public function executeInscritos(sfWebRequest $request)
  {
      $usuario = $this->getUser()->getGuardUser()->getProfile();
      $uc = $this->getUser()->getAttribute('usuario_cargo');
      if($uc==null)
          $this->redirtect('usuario/permisoDenegado');
      
      $cargo = $uc->getPastoralCargo();
      
      $this->estados_posibles = Doctrine_Core::getTable('PastoralEstadoPostulacion')->findAll();

      $this->editarCuota = $cargo->getEInscritosCuota();
      $this->editarCargo  = $cargo->getEInscritosCargo();
      $this->editarEstado = $cargo->getEInscritosEstado();
      $this->editarMision = $cargo->getEInscritosMision();
      
      $this->cargo = $cargo;
      
      if($uc->getMisionId()>0)
          $q = Doctrine_Core::getTable('PastoralMision')->addMisionPorIdQuery($uc->getMisionId());
      else if($uc->getGrupoId()>0)
          $q = Doctrine_Core::getTable('PastoralMision')->addMissionesPorGrupoQuery($uc->getGrupoId()); 
      else if($uc->getProyectoVersionId()>0)
          $q = Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoVersionQuery($uc->getProyectoVersionId()); 
      else
          $this->redirect('usuario/informacion');
      
      //CAMBIO DE ULTIMO MINUTO CLIENTE LO QUIERE ASI 
      //$q = Doctrine_Core::getTable('PastoralMision')->addMisionesActivasQuery($q);
      
      $this->misiones_activas = $q->execute();

      $id_jefe_de_zona = Doctrine_Core::getTable('PastoralCargo')->getCargoPorNombre('Jefe de Zona')->getId();
      $this->cargos_posibles = Doctrine_Core::getTable('PastoralCargo')->addCargosMisioneros()->execute();
  }
  
  public function executeDownloadExcelAllUsers(sfWebRequest $request)
  {
    $con_mue = $con_mue>0?$con_mue:0;
    $usuarios_query = Doctrine_Query::create()->from('PastoralUsuario u');
    $usuarios_query->leftJoin('u.User user')
          ->leftJoin('u.PastoralComuna com')
          ->leftJoin('u.PastoralMovimiento mov')
          ->leftJoin('u.PastoralUniversidad uni')
          ->leftJoin('u.PastoralCarrera car')
          ->leftJoin('u.PastoralColegio col')
          ->leftJoin('u.PastoralCurso cur')
          ->leftJoin('u.PastoralUsuarioCargo uc')
          ->leftJoin('uc.PastoralCargo cargo')
          ;
    
    $usuarios_query->addOrderBy('u.nombre');
    $usuarios_query->addOrderBy('u.apellido_paterno');
    $usuarios_query->GroupBy('u.id');
    
    $usuarios = $usuarios_query->fetchArray();
   
    $objPHPExcel  = new sfPHPExcel();
    
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Dennis Helm");
    $objPHPExcel->getProperties()->setLastModifiedBy("Dennis Helm");
    $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
    $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
    $objPHPExcel->getProperties()->setCategory("Test result file");

    // Create a first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', "Email");
    $objPHPExcel->getActiveSheet()->setCellValue('B1', "Nombre");
    $objPHPExcel->getActiveSheet()->setCellValue('C1', "Apellido Materno");
    $objPHPExcel->getActiveSheet()->setCellValue('D1', "Apellido Paterno");
    $objPHPExcel->getActiveSheet()->setCellValue('E1', "Rut");
    $objPHPExcel->getActiveSheet()->setCellValue('F1', "Fecha Nacimiento");
    $objPHPExcel->getActiveSheet()->setCellValue('G1', "Telefono Celular");
    $objPHPExcel->getActiveSheet()->setCellValue('H1', "Telefono Emergencia");
    $objPHPExcel->getActiveSheet()->setCellValue('I1', "Sexo");
    $objPHPExcel->getActiveSheet()->setCellValue('J1', "Direccion");
    $objPHPExcel->getActiveSheet()->setCellValue('K1', "Enfermedades");
    $objPHPExcel->getActiveSheet()->setCellValue('L1', "Es extranjero?");
    $objPHPExcel->getActiveSheet()->setCellValue('M1', "Universidad");
    $objPHPExcel->getActiveSheet()->setCellValue('N1', "Carrera");
    $objPHPExcel->getActiveSheet()->setCellValue('O1', "Ano Ingreso");
    $objPHPExcel->getActiveSheet()->setCellValue('P1', "Colegio");
    $objPHPExcel->getActiveSheet()->setCellValue('Q1', "Curso");
    $objPHPExcel->getActiveSheet()->setCellValue('R1', "Movimiento");
    $objPHPExcel->getActiveSheet()->setCellValue('S1', "Comuna");
                                                  
    for($i = 0;$i <count($usuarios);$i++)
    {
        $row = $i+2;
        $usuario = $usuarios[$i];
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $usuario['User']['email_address'] );
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $usuario['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $usuario['apellido_materno'] );
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $usuario['apellido_paterno'] );
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $usuario['rut']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, date("Y-m-d", $usuario['fecha_nacimiento']));
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $usuario['telefono_celular']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $usuario['telefono_emergencia'] );
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $usuario['sexo'] );
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $usuario['direccion'] );
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $usuario['enfermedades_alergias'] );
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $usuario['es_extranjero'] );
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $usuario['PastoralUniversidad']['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $usuario['PastoralCarrera']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $usuario['ano_ingreso'] );
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $usuario['PastoralColegio']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $usuario['PastoralCurso']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $usuario['PastoralMovimiento']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $usuario['PastoralComuna']['nombre'] );    
    }
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition:attachment;filename="usuarios.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');  
    exit;
  } 
  
  public function executeDownloadExcelParticipantes(sfWebRequest $request)
  {         
    $mues_query = Doctrine_Query::create()->from('PastoralMisionUsuarioEstado mue');
    $mues_query ->leftJoin('mue.PastoralUsuario u')
                ->leftJoin('mue.PastoralEstadoPostulacion ep')
                ->leftJoin('mue.PastoralMision m')
                ->leftJoin('m.PastoralGrupo g')
                ->leftJoin('m.PastoralLocalidadFantasia lf')
                ->leftJoin('u.User user')
                ->leftJoin('u.PastoralComuna com')
                ->leftJoin('u.PastoralMovimiento mov')
                ->leftJoin('u.PastoralUniversidad uni')
                ->leftJoin('u.PastoralCarrera car')
                ->leftJoin('u.PastoralColegio col')
                ->leftJoin('u.PastoralCurso cur')
                ->leftJoin('u.PastoralUsuarioCargo uc') 
                ->leftJoin('g.PastoralProyectoVersion pv')
                ->leftJoin('pv.PastoralProyecto p')
                ->leftJoin('uc.PastoralCargo cargo')
          ;

    $mues_query->addOrderBy('u.nombre');
    $mues_query->addOrderBy('u.apellido_paterno');
    
    $mue = $mues_query->fetchArray();
   
    $objPHPExcel  = new sfPHPExcel();
    
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Dennis Helm");
    $objPHPExcel->getProperties()->setLastModifiedBy("Dennis Helm");
    $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
    $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
    $objPHPExcel->getProperties()->setCategory("Test result file");

    // Create a first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', "Email");
    $objPHPExcel->getActiveSheet()->setCellValue('B1', "Nombre");
    $objPHPExcel->getActiveSheet()->setCellValue('C1', "Apellido Materno");
    $objPHPExcel->getActiveSheet()->setCellValue('D1', "Apellido Paterno");
    $objPHPExcel->getActiveSheet()->setCellValue('E1', "Cuota");
    $objPHPExcel->getActiveSheet()->setCellValue('F1', "Rut");
    $objPHPExcel->getActiveSheet()->setCellValue('G1', "Fecha Nacimiento");
    $objPHPExcel->getActiveSheet()->setCellValue('H1', "Telefono Celular");
    $objPHPExcel->getActiveSheet()->setCellValue('I1', "Telefono Emergencia");
    $objPHPExcel->getActiveSheet()->setCellValue('J1', "Sexo");
    $objPHPExcel->getActiveSheet()->setCellValue('K1', "Direccion");
    $objPHPExcel->getActiveSheet()->setCellValue('L1', "Enfermedades");
    $objPHPExcel->getActiveSheet()->setCellValue('M1', "Es extranjero?");
    $objPHPExcel->getActiveSheet()->setCellValue('N1', "Universidad");
    $objPHPExcel->getActiveSheet()->setCellValue('O1', "Carrera");
    $objPHPExcel->getActiveSheet()->setCellValue('P1', "Ano Ingreso");
    $objPHPExcel->getActiveSheet()->setCellValue('Q1', "Colegio");
    $objPHPExcel->getActiveSheet()->setCellValue('R1', "Curso");
    $objPHPExcel->getActiveSheet()->setCellValue('S1', "Movimiento");
    $objPHPExcel->getActiveSheet()->setCellValue('T1', "Comuna");
    $objPHPExcel->getActiveSheet()->setCellValue('U1', "Proyecto");
    $objPHPExcel->getActiveSheet()->setCellValue('V1', "Version");
                                                  
    
    for($i = 0;$i <count($mue);$i++)
    {
        $row = $i+2;
        $usuario = $mue[$i]['PastoralUsuario'];
        $mision = $mue[$i]['PastoralMision'];
        $proyectoVersion = $mision['PastoralGrupo']['PastoralProyectoVersion'];
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $usuario['User']['email_address'] );
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $usuario['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $usuario['apellido_materno'] );
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $usuario['apellido_paterno'] );
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $mue[$i]['cuota'] );
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $usuario['rut']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, date("Y-m-d", $usuario['fecha_nacimiento']));
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $usuario['telefono_celular'] );
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $usuario['telefono_emergencia'] );
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $usuario['sexo'] );
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $usuario['direccion'] );
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $usuario['enfermedades_alergias'] );
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $usuario['es_extranjero'] );
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $usuario['PastoralUniversidad']['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $usuario['PastoralCarrera']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $usuario['ano_ingreso'] );
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $usuario['PastoralColegio']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $usuario['PastoralCurso']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $usuario['PastoralMovimiento']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $usuario['PastoralComuna']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $proyectoVersion['PastoralProyecto']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, $proyectoVersion['version']);
    }    
    
    $objPHPExcel->createSheet();
    $objPHPExcel->setActiveSheetIndex(1);
    
    $objPHPExcel->getActiveSheet()->setCellValue('A1', "Email");
    $objPHPExcel->getActiveSheet()->setCellValue('B1', "Nombre");
    $objPHPExcel->getActiveSheet()->setCellValue('C1', "Apellido Materno");
    $objPHPExcel->getActiveSheet()->setCellValue('D1', "Apellido Paterno");
    $objPHPExcel->getActiveSheet()->setCellValue('E1', "Rut");
    $objPHPExcel->getActiveSheet()->setCellValue('F1', "Fecha Nacimiento");
    $objPHPExcel->getActiveSheet()->setCellValue('G1', "Telefono Celular");
    $objPHPExcel->getActiveSheet()->setCellValue('H1', "Telefono Emergencia");
    $objPHPExcel->getActiveSheet()->setCellValue('I1', "Sexo");
    $objPHPExcel->getActiveSheet()->setCellValue('J1', "Direccion");
    $objPHPExcel->getActiveSheet()->setCellValue('K1', "Enfermedades");
    $objPHPExcel->getActiveSheet()->setCellValue('L1', "Es extranjero?");
    $objPHPExcel->getActiveSheet()->setCellValue('M1', "Universidad");
    $objPHPExcel->getActiveSheet()->setCellValue('N1', "Carrera");
    $objPHPExcel->getActiveSheet()->setCellValue('O1', "Ano Ingreso");
    $objPHPExcel->getActiveSheet()->setCellValue('P1', "Colegio");
    $objPHPExcel->getActiveSheet()->setCellValue('Q1', "Curso");
    $objPHPExcel->getActiveSheet()->setCellValue('R1', "Movimiento");
    $objPHPExcel->getActiveSheet()->setCellValue('S1', "Cargo");
    $objPHPExcel->getActiveSheet()->setCellValue('T1', "Mision");
    $objPHPExcel->getActiveSheet()->setCellValue('U1', "Grupo");
    $objPHPExcel->getActiveSheet()->setCellValue('V1', "Proyevto Version");
                                                  
    $cargos_query = Doctrine_Query::create()->from('PastoralUsuarioCargo uc');
    $cargos_query ->leftJoin('uc.PastoralUsuario u')
                  ->leftJoin('uc.PastoralCargo c')
                  ->leftJoin('u.User user')
                  ->leftJoin('u.PastoralComuna com')
                  ->leftJoin('u.PastoralMovimiento mov')
                  ->leftJoin('u.PastoralUniversidad uni')
                  ->leftJoin('u.PastoralCarrera car')
                  ->leftJoin('u.PastoralColegio col')
                  ->leftJoin('u.PastoralCurso cur')
                  ->leftJoin('uc.PastoralProyectoVersion pv')
                  ->leftJoin('pv.PastoralProyecto p')
                  ->leftJoin('uc.PastoralGrupo g')
                  ->leftJoin('uc.PastoralMision m')
                  ->leftJoin('m.PastoralLocalidadFantasia lf');

    $cargos_query->addOrderBy('u.nombre');
    $cargos_query->addOrderBy('u.apellido_paterno');
                  
    $cargos = $cargos_query->fetchArray();

    for($i = 0;$i <count($cargos);$i++)
    {
        $row = $i+2;
        $usuario = $cargos[$i]['PastoralUsuario'];
        $cargo = $cargos[$i]['PastoralCargo'];
        
        $proyectoVersion = $mision['PastoralGrupo']['PastoralProyectoVersion'];
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $usuario['User']['email_address'] );
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $usuario['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $usuario['apellido_materno'] );
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $usuario['apellido_paterno'] );
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $usuario['rut']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, date("Y-m-d", $usuario['fecha_nacimiento']));
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $usuario['telefono_celular'] );
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $usuario['telefono_emergencia'] );
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $usuario['sexo'] );
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $usuario['direccion'] );
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $usuario['enfermedades_alergias'] );
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $usuario['es_extranjero'] );
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $usuario['PastoralUniversidad']['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $usuario['PastoralCarrera']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $usuario['ano_ingreso'] );
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $usuario['PastoralColegio']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $usuario['PastoralCurso']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $usuario['PastoralMovimiento']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $cargo['nombre'] );
        
        if($cargos[$i]['mision_id']>0)
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $cargos[$i]['PastoralMision']['PastoralLocalidadFantasia']['nombre'] );
        if($cargos[$i]['grupo_id']>0)
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $cargos[$i]['PastoralGrupo']['nombre'] );
        if($cargos[$i]['proyecto_version_id']>0)
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, $cargos[$i]['PastoralProyectoVersion']['PastoralProyecto']['nombre'] ." - ".$cargos[$i]['PastoralProyectoVersion']['version'] );
    }
                  
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition:attachment;filename="participantes.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    // This line will force the file to download  
    
    exit;
  }
  
  public function executeDownloadExcel(sfWebRequest $request)
  {
    $mision_id = $request->getParameter('mision_id');
    $estado_id = $request->getParameter('estado_id');
    $flag_id =   $request->getParameter('flag_id'); 
    $flag_id = $flag_id == null?$flag_id=-1:$flag_id;            
    
    $usuario = $this->getUser()->getGuardUser()->getProfile();
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo = $uc->getPastoralCargo();
    
    $mues_query = Doctrine_Query::create()->from('PastoralMisionUsuarioEstado mue');
    $mues_query->leftJoin('mue.PastoralUsuario u')
          ->leftJOin('mue.PastoralEstadoPostulacion ep')
          ->leftJOin('mue.PastoralMision m')
          ->leftJoin('m.PastoralGrupo g')
          ->leftJoin('m.PastoralLocalidadFantasia lf')
          ->leftJoin('u.User user')
          ->leftJoin('u.PastoralComuna com')
          ->leftJoin('u.PastoralMovimiento mov')
          ->leftJoin('u.PastoralUniversidad uni')
          ->leftJoin('u.PastoralCarrera car')
          ->leftJoin('u.PastoralColegio col')
          ->leftJoin('u.PastoralCurso cur')
          ->leftJoin('u.PastoralUsuarioCargo uc')
          ->leftJoin('g.PastoralProyectoVersion pv')
          ->leftJoin('pv.PastoralProyecto p')
          ->leftJoin('uc.PastoralCargo cargo')
          ;
    
    if($mision_id > 0)
        $mues_query->andWhere('m.id = ?',$mision_id);
        
    if($estado_id > 0)
        $mues_query->andWhere('ep.id = ?',$estado_id);
        
    if($uc->getMisionId()>0)
        $mues_query->andWhere('m.id = ?',$uc->getMisionId());
        
    if($uc->getGrupoId()>0)
        $mues_query->andWhere('g.id = ?',$uc->getGrupoId());
        
    if($uc->getProyectoVersionId()>0)
        $mues_query->andWhere('pv.id = ?',$uc->getProyectoVersionId());
        
    switch($flag_id){
        case '1':
          $mues_query->andwhere('mue.flag_zona = 1');
          break;
        case '2':
          $mues_query->andwhere('mue.flag_cuota = 1');
          break;
    }
    $mues_query->andWhere('m.fecha_termino > ?',date('Y-m-d H:i:s', time()));
    $mues_query->addOrderBy('u.nombre');
    $mues_query->addOrderBy('u.apellido_paterno');
    $mues_query->GroupBy('u.id');
    
    $mue = $mues_query->fetchArray();
   
    $objPHPExcel  = new sfPHPExcel();
    
    // Set properties
    $objPHPExcel->getProperties()->setCreator("Dennis Helm");
    $objPHPExcel->getProperties()->setLastModifiedBy("Dennis Helm");
    $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
    $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
    $objPHPExcel->getProperties()->setCategory("Test result file");

    // Create a first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', "Email");
    $objPHPExcel->getActiveSheet()->setCellValue('B1', "Nombre");
    $objPHPExcel->getActiveSheet()->setCellValue('C1', "Apellido Materno");
    $objPHPExcel->getActiveSheet()->setCellValue('D1', "Apellido Paterno");
    $objPHPExcel->getActiveSheet()->setCellValue('E1', "Cuota");
    $objPHPExcel->getActiveSheet()->setCellValue('F1', "Rut");
    $objPHPExcel->getActiveSheet()->setCellValue('G1', "Fecha Nacimiento");
    $objPHPExcel->getActiveSheet()->setCellValue('H1', "Telefono Fijo");
    $objPHPExcel->getActiveSheet()->setCellValue('I1', "Telefono Celular");
    $objPHPExcel->getActiveSheet()->setCellValue('J1', "Telefono Emergencia");
    $objPHPExcel->getActiveSheet()->setCellValue('K1', "Sexo");
    $objPHPExcel->getActiveSheet()->setCellValue('L1', "Direccion");
    $objPHPExcel->getActiveSheet()->setCellValue('M1', "Enfermedades");
    $objPHPExcel->getActiveSheet()->setCellValue('N1', "Es extranjero?");
    $objPHPExcel->getActiveSheet()->setCellValue('O1', "Universidad");
    $objPHPExcel->getActiveSheet()->setCellValue('P1', "Carrera");
    $objPHPExcel->getActiveSheet()->setCellValue('Q1', "Ano Ingreso");
    $objPHPExcel->getActiveSheet()->setCellValue('R1', "Colegio");
    $objPHPExcel->getActiveSheet()->setCellValue('S1', "Curso");
    $objPHPExcel->getActiveSheet()->setCellValue('T1', "Movimiento");
    $objPHPExcel->getActiveSheet()->setCellValue('U1', "Comuna");
    $objPHPExcel->getActiveSheet()->setCellValue('V1', "Proyecto");
    $objPHPExcel->getActiveSheet()->setCellValue('W1', "Version");
    
    
    for($i = 0;$i <count($mue);$i++)
    {
        $row = $i+2;
        $usuario = $mue[$i]['PastoralUsuario'];
        $mision = $mue[$i]['PastoralMision'];
        $proyectoVersion = $mision['PastoralGrupo']['PastoralProyectoVersion'];
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $usuario['User']['email_address'] );
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $usuario['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $usuario['apellido_materno'] );
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $usuario['apellido_paterno'] );
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $mue[$i]['cuota'] );
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $usuario['rut']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $usuario['fecha_nacimiento'] );
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $usuario['telefono_celular'] );
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $usuario['telefono_emergencia'] );
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $usuario['sexo'] );
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $usuario['direccion'] );
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $usuario['enfermedades_alergias'] );
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $usuario['es_extranjero'] );
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $usuario['PastoralUniversidad']['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $usuario['PastoralCarrera']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $usuario['ano_ingreso'] );
        $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $usuario['PastoralColegio']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $usuario['PastoralCurso']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $usuario['PastoralMovimiento']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $usuario['PastoralComuna']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('V' . $row, $proyectoVersion['PastoralProyecto']['nombre'] );
        $objPHPExcel->getActiveSheet()->setCellValue('W' . $row, $proyectoVersion['version']);
    }    
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition:attachment;filename="misioneros.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    // This line will force the file to download  
    
    exit;
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
  
  public function executeAjaxEditarInscritos(sfWebRequest $request)
  {
      $selected      = $request->getParameter('selected');
      $respuesta = 1;
      foreach($selected as $muec_id)
      {
        $mision_nueva = $request->getParameter('mision_nueva');
        $cargo_nuevo  = $request->getParameter('cargo_nuevo');
        $estado_nuevo = $request->getParameter('estado_nuevo'); 
        $cuota_nueva  = $request->getParameter('cuota_nueva');
        $estado_cambiado = 0;
        $cuota_cambiada = 0;        
        $muec = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($muec_id);
        $cuota = $cuota_nueva>0?$cuota_nueva:$muec->getCuota();
        $mision = $mision_nueva>0?$mision_nueva:$muec->getMisionId();
        $estado = $estado_nuevo>0?$estado_nuevo:$muec->getEstadoPostulacionId();
        if($cargo_nuevo>0)
        {
           $q = Doctrine_Query::create()
             ->from('PastoralUsuarioCargo uc')
             ->where('uc.mision_id = ?',$mision)
             ->andWhere('uc.usuario_id = ?', $muec->getUsuarioId());
           $q->execute()->delete(); 
           $uc = new PastoralUsuarioCargo();
           $uc->setUsuarioId($muec->getUsuarioId());
           $uc->setCargoId($cargo_nuevo);                
           $uc->setMisionId($mision);
           try {
             $uc->save();
           } catch (Doctrine\ORM\NoResultException $e) {
             $respuesta = 0;
           } catch (Exception $e) {
             $respuesta = 0;
           }
           if($respuesta == 1)
           {
              $nu = new PastoralNotificacionUsuario();
              $nu->setRecibeId($muec->getUsuarioId());
              $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
              $nu->setEnviado("Administracion");
              $nu->setAsunto("Cambio de Cargo");
              $nu->setMensaje("Te hemos cambiado de cargo a ".$uc->getPastoralCargo()->getNombre());
              $nu->save();
           }
        }
        if($estado_nuevo>0 && $estado_nuevo!=$muec->getEstadoPostulacionId())
        {
              $estado_cambiado = 1;
              $nu = new PastoralNotificacionUsuario();
              $nu->setRecibeId($muec->getUsuarioId());
              $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
              $nu->setEnviado("Administracion");
              $nu->setAsunto("Estado postulacion");
              $nu->setMensaje("Te hemos cambiado el estado de la postulacion a ".Doctrine_Core::getTable('PastoralEstadoPostulacion')->findOneById($estado)->getNombre());
              $nu->save();
              $muec->setEstadoPostulacionId($estado_nuevo);
        }
        if($cuota_nueva>0 && $cuota_nueva!= $muec->getCuota())
        {
          $cuota_cambiada = 1;
          $nu = new PastoralNotificacionUsuario();
          $nu->setRecibeId($muec->getUsuarioId());
          $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
          $nu->setEnviado("Finanzas");
          $nu->setAsunto("Cambio de Cuota");
          $nu->setMensaje("Te hemos cambiado la cuota a ".$cuota);
          $nu->save();
          $muec->setCuota($cuota);
          $muec->setFlagCuota(0);
          $muec->setDescripcionCuota(" Ingresa aquí tus comentarios ");
        }
        if($mision_nueva>0 && $mision_nueva != $muec->getMisionId())
        {
          $nu = new PastoralNotificacionUsuario();
          $nu->setRecibeId($muec->getUsuarioId());
          $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
          $nu->setEnviado("Inscripciones");
          $nu->setAsunto("Cambio de Zona");
          $nu->setMensaje("Te hemos cambiado a la siguiente Zona:".Doctrine_Core::getTable('PastoralMision')->findOneById($mision)->getPastoralLocalidadFantasia()->getNombre());
          $nu->save();
          $muec->setFlagZona(0);
          $muec->setMisionId($mision);
          if($estado_cambiado == 0)
              $muec->setEstadoPostulacionId(Doctrine_Core::getTable('PastoralEstadoPostulacion')->findOneByNombre('Pendiente')->getId());
          if($cuota_cambiada == 0)
              $muec->setCuota(Doctrine_Core::getTable('PastoralMision')->findOneById($mision)->getCuota());
          $muec->setDescripcionZona("Ingresa aquí tus comentarios");
        }

        try {
        $muec->save();
        } catch (Doctrine\ORM\NoResultException $e) {
          $respuesta = 0;
        } catch (Exception $e) {
          $respuesta = 0;
        }
      }
      return $this->renderText(json_encode($respuesta));
      
  }  
  
  public function executeAjaxGetMisionesPorSalida(sfWebRequest $request)
  {
       if($request->getParameter('proyecto_id')!=null && $request->getParameter('proyecto_id')!=-1)
        $proyecto_id = $request->getParameter('proyecto_id');
       else
        $proyecto_id = $this -> getUser()->getProfile()->getUltimoProyectoAccedidoId();
       
       
      $salida_id = $request->getParameter('salida_id');
      $misiones = Doctrine_Core::getTable('PastoralMision')->getArrayMisionesInscribiblesPorProyectoYSalida($proyecto_id, $salida_id);
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
      $misiones_query = Doctrine_Core::getTable('PastoralMision')->getMisionesInscribiblesPorProyectoYSalidaQuery($proyecto_id, $salida_id);
      $misiones = $misiones_query->execute();
      $grupos = array();
      foreach($misiones as $mision)
      {
        $grupo = $mision->getPastoralGrupo();
        
        if(array_key_exists($grupo->getId(), $grupos))
        {
          
          $grupos[$grupo->getId()] = $grupo->getNombre();
        }
      }
      return $this->renderText(json_encode($grupos));
      
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
        $jefes[$i] =  Doctrine_Core::getTable('PastoralUsuario')->findOneById($usuario_id)->toArray();
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
      $usuario_id = $this->getUser()->getGuardUser()->getProfile()->getId();
      $postulacion_id = Doctrine_Core::getTable('PastoralEstadoPostulacion')->findOneByNombre('Pendiente')->getId();
      $muec = new PastoralMisionUsuarioEstado();
      $muec->setCargoId(Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Misionero-Voluntario')->getId());
      $muec->setUsuarioId($usuario_id);
      $muec->setMisionId($mision_id);
      $muec->setEstadoPostulacionId($postulacion_id);
      $respuesta = 1;
      
      try {
      $muec->save();
      } catch (Doctrine\ORM\NoResultException $e) {
        $respuesta = 0;
      } catch (Exception $e) {
        $respuesta = 0;
      }
      
      return $this->renderText(json_encode($respuesta));
  }
    public function executeAjaxSetMueZona(sfWebRequest $request)
  { 
		$id = $request->getParameter('id');  
		$zona = $request->getParameter('zona_id');  
    $cuota = Doctrine_Core::getTable('PastoralMision')->findOneById($zona)->getCuota();
    $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($id);
    $respuesta = 1;
    if($mue)
    {
      $mue->setMisionId($zona);
      $mue->setCuota($cuota);
      try {
          $mue->save();
      } catch (Doctrine\ORM\NoResultException $e) {
          $respuesta = 0;
      } catch (Exception $e) {
          $respuesta = 0;
      }
    }else
      $respuesta = 0;
    return $this->renderText(json_encode($respuesta));
  }
  
    public function executeAjaxSetMueCuota(sfWebRequest $request)
  { 
		$id = $request->getParameter('id');  
		$cuota = $request->getParameter('cuota');  
    $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($id);
    $respuesta = 1;
    if($mue)
    {
      $mue->setCuota($cuota);
      try {
          $mue->save();
      } catch (Doctrine\ORM\NoResultException $e) {
          $respuesta = 0;
      } catch (Exception $e) {
          $respuesta = 0;
      }
    }else
      $respuesta = 0;
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxSetMueEstado(sfWebRequest $request)
  { 
		$id = $request->getParameter('id');  
		$estado = $request->getParameter('estado');  
    $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($id);
    $respuesta = 1;
    if($mue)
    {
      $mue->setEstadoPostulacionId($estado);
      try {
          $mue->save();
      } catch (Doctrine\ORM\NoResultException $e) {
          $respuesta = 0;
      } catch (Exception $e) {
          $respuesta = 0;
      }
    }else
      $respuesta = 0;
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxSetMueCargo(sfWebRequest $request)
  { 
		$id = $request->getParameter('id');  
		$cargo = $request->getParameter('cargo');  
    $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($id);
    $q = Doctrine_Query::create()
              ->from('PastoralUsuarioCargo uc')
              ->where('uc.mision_id = ?',$mue->getMisionId())
              ->andWhere('uc.usuario_id = ?', $mue->getUsuarioId());
    $q->execute()->delete();
    $respuesta = 1;  
    $uc = new PastoralUsuarioCargo();
    $uc->setUsuarioId($mue->getUsuarioId());
    $uc->setCargoId($cargo);                
    $uc->setMisionId($mue->getMisionId());
    try {
      $uc->save();
    } catch (Doctrine\ORM\NoResultException $e) {
      $respuesta = 0;
    } catch (Exception $e) {
      $respuesta = 0;
    }
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxSetMueSoloZona(sfWebRequest $request)
  { 
		$id = $request->getParameter('id');  
		$zona = $request->getParameter('zona');  
    $mue = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($id);
    $respuesta = 1;
    if($mue)
    {
      $mue->setMisionId($zona);
      try {
          $mue->save();
      } catch (Doctrine\ORM\NoResultException $e) {
          $respuesta = 0;
      } catch (Exception $e) {
          $respuesta = 0;
      }
    }else
      $respuesta = 0;
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxGetInfoUsuarioParaModal(sfWebRequest $request)
  {
    $usuario_id = $request->getParameter('usuario_id');
    $mue_id = $request->getParameter('mue_id');
    $usuario_query = Doctrine_Query::create()->from('PastoralUsuario u');
    $usuario_query = Doctrine_core::getTable('PastoralUsuario')->fullLeftJoin($usuario_query);
    
    $usuario_query->andWhere('u.id = ?',$usuario_id );
    
    $usuario_query = Doctrine_core::getTable('PastoralUsuario')->fullSelects($usuario_query);
    $usuario_array = $usuario_query->fetchArray();
    $respuesta = Array();
    $respuesta[0] = $usuario_array[0];
    $q = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporUsuarioQuery($usuario_id);
    $q = Doctrine_Core::getTable('PastoralUsuarioCargo')->addOrdenDescQuery($q);
    $respuesta[1] = $q->fetchArray();
    
    $respuesta[2] = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->getInfoMisionConJoinsPorUsuarioQuerry($usuario_id)->fetchArray();    
    if($mue_id>0)
      $respuesta[3] = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($mue_id)->getCuota();
    return $this->renderText(json_encode($respuesta));  
  }
  
  public function executeAjaxGetMUEdeEstadoYMision(sfWebRequest $request)
  {
    $mision_id  = $request->getParameter('mision_id');
    $estado_id  = $request->getParameter('estado_id');
    $flag_id    =   $request->getParameter('flag_id'); 
    $pagina     =    $request->getParameter('pagina');
    
    $flag_id    = $flag_id == null?$flag_id=-1:$flag_id; 
    $pagina     = $pagina > 0?$pagina:$pagina=1;     
    $resultados_por_pagina = 50;
    
    $usuario    = $this->getUser()->getGuardUser()->getProfile();
    $uc         = $this->getUser()->getAttribute('usuario_cargo');
    $cargo      = $uc->getPastoralCargo();
    
    $mues_query = Doctrine_Query::create()->from('PastoralMisionUsuarioEstado mue');
    $mues_query = Doctrine_core::getTable('PastoralMisionUsuarioEstado')->fullLeftJoin($mues_query);
    
    if($mision_id > 0)
        $mues_query->andWhere('m.id = ?',$mision_id);
        
    if($estado_id > 0)
        $mues_query->andWhere('ep.id = ?',$estado_id);
        
    if($uc->getMisionId()>0)
        $mues_query->andWhere('m.id = ?',$uc->getMisionId());
        
    if($uc->getGrupoId()>0)
        $mues_query->andWhere('g.id = ?',$uc->getGrupoId());
        
    if($uc->getProyectoVersionId()>0)
        $mues_query->andWhere('pv.id = ?',$uc->getProyectoVersionId());
        
    switch($flag_id)
    {
        case '1':
          $mues_query->andwhere('mue.flag_zona = 1');
          break;
        case '2':
          $mues_query->andwhere('mue.flag_cuota = 1');
          break;
    }
    
    //CAMBIO DE ULTIMO MINUTO CLIENTE LO QUIERE ASI 
    //$mues_query->andWhere('m.fecha_termino > ?',date('Y-m-d H:i:s', time()));
    
    $mues_query = Doctrine_core::getTable('PastoralMisionUsuarioEstado')->fullSelects($mues_query);

    $mues_query->addOrderBy('u.nombre');
    $mues_query->addOrderBy('u.apellido_paterno');
    
    $mues_query->GroupBy('u.id');
    
    $paginador  = new Doctrine_Pager($mues_query,$pagina,$resultados_por_pagina);
    
    $mues = $paginador->execute()->toArray();
    
    $res = Array();
    
    $res[0] = $cargo->toArray();
    
    if($cargo->getEInscritosMision()==1)
    {
        $mis = Array();
        $misiones_ = "";
          
        if($uc->getMisionId()>0)
            $q = Doctrine_Core::getTable('PastoralMision')->addMisionPorIdQuery($uc->getMisionId());
        else if($uc->getGrupoId()>0)
            $q = Doctrine_Core::getTable('PastoralMision')->addMissionesPorGrupoQuery($uc->getGrupoId()); 
        else if($uc->getProyectoVersionId()>0)
            $q = Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoVersionQuery($uc->getProyectoVersionId()); 
        else
            $this->redirect('usuario/informacion');
        
        
      //CAMBIO DE ULTIMO MINUTO CLIENTE LO QUIERE ASI 
      //$q = Doctrine_Core::getTable('PastoralMision')->addMisionesActivasQuery($q);
        
        $misiones_ = $q->execute();
        $i = 0;
        foreach($misiones_ as $m)
        {
          $mis[$i]['id']=$m->getId();
          $mis[$i]['nombre']=$m->getPastoralLocalidadFantasia()->getNombre();
          $mis[$i]['cuota']=$m->getCuota();
          $i++;
        }
        $res[1] = $mis;
    }
    
    $res[2] = $mues;
    $res[3] = ceil($paginador->getNumResults()/$resultados_por_pagina);//numero de paginas
    
    
    return $this->renderText(json_encode($res));
  }

  public function executeAjaxEliminarFlagCuota(sfWebRequest $request)
  {
      $uem_id = $request->getParameter('uem_id');
      $uem = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($uem_id);
      $uem->setDescripcionCuota("Ingresa aquí tus comentarios");
      $uem->setFlagCuota(false);
      $respuesta = 1;
      try {
          $uem->save();
      } catch (DoctrineORMNoResultException $e) {
          $respuesta = 0;
      } catch (Exception $e) {
          $respuesta = 0;
      }
    return $this->renderText(json_encode($respuesta));
  }
  
    public function executeAjaxEliminarFlagZona(sfWebRequest $request)
  {
      $uem_id = $request->getParameter('uem_id');
      $uem = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($uem_id);
      $uem->setDescripcionZona("Ingresa aquí tus comentarios");
      $uem->setFlagZona(false);
      $respuesta = 1;
      try {
          $uem->save();
      } catch (Doctrine\ORM\NoResultException $e) {
          $respuesta = 0;
      } catch (Exception $e) {
          $respuesta = 0;
      }
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEditarFlagZona(sfWebRequest $request)
  {
      $uem_id = $request->getParameter('uem_id');
      $descripcion = $request->getParameter('descripcion');      
      
      $uem = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($uem_id);
      $uem->setDescripcionZona($descripcion);
      $uem->setFlagZona(true);
      $respuesta = 1;
      try {
          $uem->save();
      } catch (Doctrine\ORM\NoResultException $e) {
          $respuesta = 0;
      } catch (Exception $e) {
          $respuesta = 0;
      }
    return $this->renderText(json_encode($respuesta));
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
        if($enviar == 1){
          $mue->setRecomendadoPorJefes(1);
        }else
        {
          $mue->setMarcadoPorJefes(1);
        }
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
        if($enviar == 1){
          $mue->setRecomendadoPorJefes(0);
        }else
        {
          $mue->setMarcadoPorJefes(0);
        }
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
  
  public function executeAjaxEditarFlagCuota(sfWebRequest $request)
  {
      $uem_id = $request->getParameter('uem_id');
      $descripcion = $request->getParameter('descripcion');      
      
      $uem = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findOneById($uem_id);
      $uem->setDescripcionCuota($descripcion);
      $uem->setFlagCuota(true);
      $respuesta = 1;
      try {
          $uem->save();
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
  
  public function executeEditarUsuarioModalAjax(sfWebrequest $request){
      $id = $request->getParameter('usuario_id');
      $this->pastoral_usuario = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id);
      $this->form = new UsuarioEditarForm($this->pastoral_usuario);
  }
  
  
  public function executePermisoDenegado(sfWebRequest $request){
    
  }
}

