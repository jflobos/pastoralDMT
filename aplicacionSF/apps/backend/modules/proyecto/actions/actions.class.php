<?php

/**
 * proyecto actions.
 *
 * @package    pastoral
 * @subpackage proyecto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class proyectoActions extends sfActions
{
  
  public function executeIndex(sfWebRequest $request)
  {
    
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $this->esDirector = false;
    $this->esJefe = false;
    if($uc){
      $cargo_actual = $uc->getPastoralCargo(); 
      $pv_id = $uc->getProyectoVersionId();
      $g_id = $uc->getGrupoId();
      $m_id = $uc->getMisionId();
      $esDirector = false;
      $esDelProyecto = false;
      
      if($cargo_actual->getEsDirector()==1){
        $esDirector = true;
        $this->esDirector = true;        
      }
      
      
      if(!$esDirector)
      {	
        if(($cargo_actual->getVProyecto()!=1))
        {	
              $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
        }
        else {
            $this->esJefe = true;
            $this->pastoral_proyecto_version_del_jefe = Doctrine_Core::getTable('PastoralProyectoVersion')->findOneById($uc->getProyectoVersionId());
            $this->pastoral_proyecto_del_jefe = Doctrine_Core::getTable('PastoralProyecto')->findOneById($this->pastoral_proyecto_version_del_jefe->getProyectoId());  
        }        
      }
    }
    
    else{
        $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
    }
    
    
    $this->pastoral_proyecto_versions = Doctrine_Core::getTable('PastoralProyectoVersion')
      ->createQuery('a')
      ->execute();
      
    $this->pastoral_proyecto = Doctrine_Core::getTable('PastoralProyecto')
      ->createQuery('b')
      ->execute();
  }
  
  public function executeEstadisticasVersion(sfWebRequest $request){
      
      $proyecto_version_id = $request->getParameter('id');
      
      //chequear permisos
      $uc = $this->getUser()->getAttribute('usuario_cargo');
      if($uc){
          $cargo_actual = $uc->getPastoralCargo();
          $this->cargo_actual = $cargo_actual;  
            
          if($cargo_actual->getVProyectoversion()!=1)
          {	
            $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
          }       
            
      }
        
      else{
          $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
      }
  
      $this->pastoral_proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->find($proyecto_version_id);
      $this->forward404Unless($this->pastoral_proyecto_version);
      $this->misiones =Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoVersionQuery($proyecto_version_id)->execute();    
      $this->pastoral_proyecto = Doctrine_Core::getTable('PastoralProyecto')->getNombreProyectoPorId($this->pastoral_proyecto_version->getProyectoId());
  }
  
  public function executeEstadisticasGrupo(sfWebRequest $request){
  
      $proyecto_version_id = $request->getParameter('id');
      
      //chequear permisos
      $uc = $this->getUser()->getAttribute('usuario_cargo');
      $this->esDirector = false;
      if($uc){
          $cargo_actual = $uc->getPastoralCargo(); 
          $pv_id = $uc->getProyectoVersionId();
          $g_id = $uc->getGrupoId();
          $m_id = $uc->getMisionId();
          $esDirector = false;
          $esDelProyecto = false;
          
          if($cargo_actual->getEsDirector()==1){
            $esDirector = true;  
            $this->esDirector = false;
          }
          
          if($pv_id==$proyecto_version_id){
              $esDelProyecto = true;      
          }
          
          if(!$esDirector){
            if($cargo_actual->getVProyectoversion()!=1)
            {	
              $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
            }       
          }   
        }
        
      else{
          $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
      }
  
      $this->pastoral_grupo = Doctrine_Core::getTable('PastoralGrupo')->find(array($request->getParameter('id_grupo')));
      $this->proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->find(array($request->getParameter('id_version')));
      $this->pastoral_proyecto = Doctrine_Core::getTable('PastoralProyecto')->find(array($request->getParameter('id_proyecto')));
      
      $this->forward404Unless($this->pastoral_grupo);
      $this->forward404Unless($this->proyecto_version);
      $this->forward404Unless($this->pastoral_proyecto);

  
  }
  
  public function executeEstadisticasMision(sfWebRequest $request){
  
      $proyecto_version_id = $request->getParameter('id_version');
      
      //chequear permisos
      $uc = $this->getUser()->getAttribute('usuario_cargo');
      $this->esDirector = false;
      if($uc){
          $cargo_actual = $uc->getPastoralCargo(); 
          $pv_id = $uc->getProyectoVersionId();
          $g_id = $uc->getGrupoId();
          $m_id = $uc->getMisionId();
          $esDirector = false;
          $esDelProyecto = false;
          
          if($cargo_actual->getEsDirector()==1){
            $esDirector = true;
            $this->esDirector = true; 
          }
          
          if($pv_id==$proyecto_version_id){
              $esDelProyecto = true;      
          }
          
          if(!$esDirector){
            if(($cargo_actual->getVProyectoversion()!=1))
            {	
              $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
            }       
          }   
        }
        
      else{
          $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
      }
  
  
      $this->pastoral_mision = Doctrine_Core::getTable('PastoralMision')->find(array($request->getParameter('id_mision')));
      $this->pastoral_grupo = Doctrine_Core::getTable('PastoralGrupo')->find(array($request->getParameter('id_grupo')));
      $this->proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->find(array($request->getParameter('id_version')));
      $this->pastoral_proyecto = Doctrine_Core::getTable('PastoralProyecto')->find(array($request->getParameter('id_proyecto')));
      
      $this->forward404Unless($this->pastoral_mision);
      $this->forward404Unless($this->pastoral_grupo);
      $this->forward404Unless($this->proyecto_version);
      $this->forward404Unless($this->pastoral_proyecto);
  
  }
  
  protected function getInscritosPorDia($pv_id ,$pv_fecha, $confirmados = false){
    $retorno[0] =  Array();
    $retorno[1] =  Array();
    $q = Doctrine_Query::create()
        ->addSelect('u.id')->distinct()
        ->addSelect('mue.id')
        ->addSelect('DATEDIFF(mue.created_at,"'.(string)$pv_fecha.'") as day')
        ->addSelect('COUNT(mue.created_at) as number')
        ->from('PastoralMisionUsuarioEstado mue')
        ->andWhere('pv.id = ?',$pv_id)        
        ->andWhere('mue.created_at > 0')        
        ->leftJoin('mue.PastoralUsuario u')
        ->leftJoin('mue.PastoralMision m')
        ->leftJoin('m.PastoralGrupo g')
        ->leftJoin('g.PastoralProyectoVersion pv')  
        ->addOrderBy('mue.created_at ASC')
        ->addGroupBy('DAY(mue.created_at)'  )
        ->addGroupBy('MONTH(mue.created_at)')
        ->addGroupBy('YEAR(mue.created_at)' )
        ->andWhereNotIn('mue.estado_postulacion_id', array(1,5));
    if($confirmados){
        $q->andWhereNotIn('mue.estado_postulacion_id', array(2));
    }    
    $array = $q->fetchArray();
    $total = 0;    
    for($i=0;$i<count($array);$i++){ 
      $total += $array[$i]["number"];
      $date = $array[$i]["day"];
      array_push($retorno[1],(int)$total);
      array_push($retorno[0],(int)$date);
    }
    return $retorno;
  }
  
  public function executeAjaxInscritosVSAceptados(sfWebRequest $request)
  { 
    $pv_id = $request->getParameter('pv_id');    
    $q1 = Doctrine_Query::create()
        ->addSelect('mue.created_at')
        ->from('PastoralMisionUsuarioEstado mue')
        ->andWhere('pv.id = ?',$pv_id)
        ->andWhere('mue.created_at > 0')
        ->leftJoin('mue.PastoralMision m')
        ->leftJoin('m.PastoralGrupo g')
        ->leftJoin('g.PastoralProyectoVersion pv')
        ->addOrderBy('mue.created_at ASC');        
    $pv_fecha = $q1->fetchArray();
    $pv_fecha = $pv_fecha[0]['created_at'];   
    
    $aux = $this->getInscritosPorDia($pv_id, $pv_fecha, false);
    $respuesta[0] = $aux[0];
    $respuesta[1] = $aux[1];    
    
    $aux = $this->getInscritosPorDia($pv_id, $pv_fecha, true);    
    $respuesta[2] = $aux[0];
    $respuesta[3] = $aux[1];    
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($respuesta)); 
  }
  public function executeAjaxInscritosAcumulados(sfWebRequest $request)
  {
    $respuesta[0] = Array();
    $respuesta[1] = Array();
    $respuesta[2] = Array();
    $respuesta[3] = Array();
    $pv_id = $request->getParameter('pv_id');    
    $q1 = Doctrine_Query::create()
        ->addSelect('mue.created_at')
        ->from('PastoralMisionUsuarioEstado mue')
        ->andWhere('pv.id = ?',$pv_id)
        ->andWhere('mue.created_at > 0')
        ->leftJoin('mue.PastoralMision m')
        ->leftJoin('m.PastoralGrupo g')
        ->leftJoin('g.PastoralProyectoVersion pv')
        ->addOrderBy('mue.created_at ASC')
        ;        
    $pv_fecha = $q1->fetchArray();
    $pv_fecha = $pv_fecha[0]['created_at'];
    $aux = $this->getInscritosPorDia($pv_id, $pv_fecha, false);
    $respuesta[0] = $aux[0];
    $respuesta[1] = $aux[1];  
    
    $p_id = Doctrine_Core::getTable('PastoralProyectoVersion')->findOneById($pv_id)->getProyectoId();
    $q1 = Doctrine_Query::create()
        ->from('PastoralProyectoVersion pv')
        ->leftJoin('pv.PastoralProyecto p')
        ->addSelect('p.id')
        ->addSelect('pv.id')
        ->andWhere('p.id = ?',$p_id)
        ->andWhere('pv.id < ?',$pv_id)
        ->addOrderBy('pv.id DESC');
    $pv2_id = $q1->fetchArray();
    if(count($pv2_id)>0){
        $pv2_id = $pv2_id[0]['id'];
        if($pv2_id>0){
            $q1 = Doctrine_Query::create()
                ->addSelect('mue.created_at')
                ->from('PastoralMisionUsuarioEstado mue')
                ->andWhere('pv.id = ?',$pv2_id)
                ->andWhere('mue.created_at > 0')                
                ->leftJoin('mue.PastoralMision m')
                ->leftJoin('m.PastoralGrupo g')
                ->leftJoin('g.PastoralProyectoVersion pv')
                ->addOrderBy('mue.created_at ASC');                
                $pv_fecha = $q1->fetchArray();
                $pv_fecha = $pv_fecha[0]['fecha_inscripcion'];                
            $aux = $this->getInscritosPorDia($pv2_id, $pv_fecha, false);
            $respuesta[2] = $aux[0];
            $respuesta[3] = $aux[1];
        }
    }    
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($respuesta)); 
  }
  
  public function executeAjaxEstadisticasGlobales(sfWebRequest $request)
  {
    $proyecto_id = $request->getParameter('id_proyecto');
    
    $respuesta = array();    
    $proyecto = Doctrine_Core::getTable('PastoralProyectoVersion')->findOneById($proyecto_id);
    
    $generos = array();
    $necesidades_abarcadas = array();
    $experiencia = array();
    $edades = array();
    $movimientos = array();
    $carreras = array();
    
    $generos['Hombres'] = 0;
    $generos['Mujeres'] = 0;
    
    $texto = '';
    $datos = array();
    $proyectos_version = Doctrine_Core::getTable('PastoralProyectoVersion')->findByProyectoId($proyecto_id);
    if($proyectos_version != null)
    {
      foreach($proyectos_version as $proyecto_version)
      { 
        $grupos = Doctrine_Core::getTable('PastoralGrupo')->findByProyectoVersionId($proyecto_version->getId());
        if($grupos != null)
        {
          foreach($grupos as $grupo)
          {      
            $misiones = Doctrine_Core::getTable('PastoralMision')->findByGrupoId($grupo->getId());        
            $necesidades_abarcadas = array();
            
            if($misiones != null)
            {
            foreach($misiones as $mision)
              {                 
                $generos['Hombres'] += $mision->countHombres();
                $generos['Mujeres'] += $mision->countMujeres();  
                $necesidades = $mision->getNecesidadMisiones();  
                 if($texto == '')
                  $texto = 'mue.mision_id = ?';
                else
                  $texto = $texto.' OR mue.mision_id = ?';
                $datos[] = $mision->getId();
                if($mision->getLocalidadId()>0){            
                  $necesidades_abarcadas['Necesidades abarcadas']= array_key_exists('Necesidades abarcadas',$necesidades_abarcadas)? $necesidades_abarcadas['Necesidades abarcadas'] += $necesidades->count():$necesidades->count();
                  $necesidades_abarcadas['Otras necesidades']= array_key_exists('Otras necesidades',$necesidades_abarcadas)?$necesidades_abarcadas['Otras necesidades'] += $mision->getPastoralLocalidad()->getNecesidades()->count()-$necesidades->count():$mision->getPastoralLocalidad()->getNecesidades()->count()-$necesidades->count();
                }
              }
            }
          }
        }
      }
    }  
    $edades = $proyecto->cantidadPorEdades($texto, $datos);
    
    $movimientos_religiosos = Doctrine_Core::getTable('PastoralMovimiento')->findAll();
    foreach($movimientos_religiosos as $mr)
    {
      $res = $mr->cantidad($texto, $datos);
      if($res!=0)
        $movimientos[$mr->getNombre()] = $res;
    }
    
    $carr = Doctrine_Core::getTable('PastoralCarrera')->findAll();
    
    foreach($carr as $c)
    {
      $total = $c->cantidad($texto, $datos);
      if($total != 0)
      {
        $carreras[$c->getNombre()] =$total;
      }
    }
    
    $respuesta[0]=array_keys($generos);
    $respuesta[1]=array_values($generos);
    $respuesta[4]=$edades[0];
    $respuesta[5]=$edades[1];
    $respuesta[6]=array_keys($movimientos);
    $respuesta[7]=array_values($movimientos);
    $respuesta[8]=array_keys($carreras);
    $respuesta[9]=array_values($carreras);
    $respuesta[10]=array_keys($necesidades_abarcadas);
    $respuesta[11]=array_values($necesidades_abarcadas);    
    $respuesta[12]= $proyecto_id;
    
    return $this->renderText(json_encode($respuesta));
  }
  
  public function executeAjaxEstadisticaProyecto(sfWebRequest $request)
  { 
	$proyecto_version_id = $request->getParameter('id_version');
     
    $respuesta = array();    
    $proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->findOneById($proyecto_version_id);    
    $generos = array();
    $necesidades_abarcadas = array();
    $experiencia = array();
    $edades = array();
    $movimientos = array();
    $carreras = array();
    
    $generos['Hombres'] = 0;
    $generos['Mujeres'] = 0;
    $texto = '';
    $datos = array();
    $grupos = Doctrine_Core::getTable('PastoralGrupo')->findByProyectoVersionId($proyecto_version_id);
    if($grupos != null)
    {
      foreach($grupos as $grupo)
      {      
        $misiones = Doctrine_Core::getTable('PastoralMision')->findByGrupoId($grupo->getId());        
        $necesidades_abarcadas = array();
        
        if($misiones != null)
        {
        foreach($misiones as $mision)
          {                 
            $generos['Hombres'] += $mision->countHombres();
            $generos['Mujeres'] += $mision->countMujeres();  
            $necesidades = $mision->getNecesidadMisiones();  
             if($texto == '')
              $texto = 'mue.mision_id = ?';
            else
              $texto = $texto.' OR mue.mision_id = ?';
            $datos[] = $mision->getId();
            if($mision->getLocalidadId()>0){            
              $necesidades_abarcadas['Necesidades abarcadas']= array_key_exists('Necesidades abarcadas',$necesidades_abarcadas)? $necesidades_abarcadas['Necesidades abarcadas'] += $necesidades->count():$necesidades->count();
              $necesidades_abarcadas['Otras necesidades']= array_key_exists('Otras necesidades',$necesidades_abarcadas)?$necesidades_abarcadas['Otras necesidades'] += $mision->getPastoralLocalidad()->getNecesidades()->count()-$necesidades->count():$mision->getPastoralLocalidad()->getNecesidades()->count()-$necesidades->count();
            }
          }
        }
      }
    }
    
    $edades = $proyecto_version->cantidadPorEdades($texto, $datos);
    
    $movimientos_religiosos = Doctrine_Core::getTable('PastoralMovimiento')->findAll();
    foreach($movimientos_religiosos as $mr)
    {
      $res = $mr->cantidad($texto,$datos);
      if($res!=0)
        $movimientos[$mr->getNombre()] = $res;
    }
    
    $carr = Doctrine_Core::getTable('PastoralCarrera')->findAll();
    
    foreach($carr as $c)
    {
      $total = $c->cantidad($texto,$datos);
      if($total != 0)
      {
        $carreras[$c->getNombre()] =$total;
      }
    }
    
    $respuesta[0]=array_keys($generos);
    $respuesta[1]=array_values($generos);
    $respuesta[4]=$edades[0];
    $respuesta[5]=$edades[1];
    $respuesta[6]=array_keys($movimientos);
    $respuesta[7]=array_values($movimientos);
    $respuesta[8]=array_keys($carreras);
    $respuesta[9]=array_values($carreras);
    $respuesta[10]=array_keys($necesidades_abarcadas);
    $respuesta[11]=array_values($necesidades_abarcadas);
    
    return $this->renderText(json_encode($respuesta)); 
  }

  // Para crear una INSTANCIA DE UN PROYECTO
  
  public function executeNew(sfWebRequest $request)
  { 
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
      if($uc){
      $cargo_actual = $uc->getPastoralCargo(); 
      $pv_id = $uc->getProyectoVersionId();
      $g_id = $uc->getGrupoId();
      $m_id = $uc->getMisionId();
      $esDirector = false;      
      if($cargo_actual->getEsDirector()==1){
        $esDirector = true;  
      }      
      if(!$esDirector)
      {	
        $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
      }
    }    
    else{
        $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
    }    
    $this->posibles_jefes = Doctrine_Core::getTable('PastoralUsuario')->findAll();
    $this->form = new PastoralProyectoVersionForm();    
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $jefes_nacional_id = $request->getParameter('jefe_nacional');
    $jefes_finanzas_id = $request->getParameter('jefe_finanzas');
    $jefes_inscripcion_id = $request->getParameter('jefe_inscripcion');
    $jefes_extranjeros_id = $request->getParameter('jefe_extranjeros');
    
    if($jefes_nacional_id!= NULL)
    {		
      $jefes_nacionales_seleccionados = array();
      foreach($jefes_nacional_id as $id)
        $jefes_nacionales_seleccionados[] = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id);
      
      $this->jefes_nacionales_seleccionados = $jefes_nacionales_seleccionados;
    }
    
    if($jefes_finanzas_id!= NULL)
    {	
      $jefes_finanzas_seleccionados = array();
      foreach($jefes_finanzas_id as $id)
        $jefes_finanzas_seleccionados[] = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id);
      
      $this->jefes_finanzas_seleccionados = $jefes_finanzas_seleccionados;
    }
    
    if($jefes_inscripcion_id!= NULL && $jefe_inscripcion_id!=-1)
    {				
      $jefes_inscripciones_seleccionados = array();
      foreach($jefes_finanzas_id as $id)
        $jefes_inscripciones_seleccionados[] = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id);
      
      $this->jefes_inscripciones_seleccionados = $jefes_inscripciones_seleccionados;
    }
    
    if($jefes_extranjeros_id!= NULL && $jefe_extranjeros_id!=-1)
    {				
      $jefes_extranjeros_seleccionados = array();
      foreach($jefes_finanzas_id as $id)
        $jefes_extranjeros_seleccionados[] = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id);
      
      $this->jefes_extranjeros_seleccionados = $jefes_extranjeros_seleccionados;
    }
    
    $this->posibles_jefes = Doctrine_Core::getTable('PastoralUsuario') ->findAll();
        
    $this->form = new PastoralProyectoVersionForm();

    $this->processForm($request, $this->form, 'nuevo', -1);

    $this->setTemplate('new');
  }
  
  // Para crear un PROYECTO
  
  public function executeNewProyecto(sfWebRequest $request)
  {
    
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
      if($uc){
      $cargo_actual = $uc->getPastoralCargo(); 
      $pv_id = $uc->getProyectoVersionId();
      $g_id = $uc->getGrupoId();
      $m_id = $uc->getMisionId();
      $esDirector = false;
      
      if($cargo_actual->getEsDirector()==1){
        $esDirector = true;  
      }
      
      if(!$esDirector)
      {	
        $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
      }
    }
    
    else{
        $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
    }
    
    $this->form = new PastoralProyectoForm();
  }

  public function executeCreateProyecto(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PastoralProyectoForm();

    $this->processFormNoInstancia($request, $this->form);

    $this->setTemplate('newProyecto');
  }

  
  // Editar Proyecto VERSION
  public function executeEdit(sfWebRequest $request)
  {
      $proyecto_version_id = $request->getParameter('id');
      
      //chequear permisos
      $uc = $this->getUser()->getAttribute('usuario_cargo');
      if($uc){
          $cargo_actual = $uc->getPastoralCargo();
          $this->cargo_actual = $cargo_actual;    
          $pv_id = $uc->getProyectoVersionId();
          $g_id = $uc->getGrupoId();
          $m_id = $uc->getMisionId();
          $esDirector = false;
          $esDelProyecto = false;
          
          if($cargo_actual->getEsDirector()==1){
            $esDirector = true;  
          }
          
          if($pv_id==$proyecto_version_id){
              $esDelProyecto = true;      
          }
          
          if(!$esDirector){
            if(($cargo_actual->getVProyectoversion()!=1 || !$esDelProyecto))
            {	
              $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
            }       
          }   
        }
        
      else{
          $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
      }
    
    $this->posibles_jefes = Doctrine_Core::getTable('PastoralUsuario')->findAll();
    $this->forward404Unless($pastoral_proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->find(array($request->getParameter('id'))), sprintf('Object pastoral_proyecto_version does not exist (%s).', $request->getParameter('id')));
  
    if($esDirector){
      $this->form = new PastoralProyectoVersionForm($pastoral_proyecto_version);
    }
    else{
      $this->form = new ProyectoEditVersionForm($pastoral_proyecto_version);
    }
  
  }
  
  // Editar PROYECTO
  public function executeEditProyecto(sfWebRequest $request)
  {
    $proyecto_version_id = $request->getParameter('id');
    
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    if($uc){
        $cargo_actual = $uc->getPastoralCargo();
        $this->cargo_actual = $cargo_actual;        
        $pv_id = $uc->getProyectoVersionId();
        $esDelProyecto = false;
        
        if($cargo_actual->getEsDirector()==1){
          $esDirector = true;
          $esDelProyecto = true;
        }
            
        if($pv_id){          
            if($pv_id==$proyecto_version_id)
                $esDelProyecto = true;                   
        }
        
        if(!$esDirector){
          if($cargo_actual->getEProyectoversion()!=1 || !$esDelProyecto)
          {	
            $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
          }       
        }   
      }
      
    else{
        $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
    }
    
    $this->posibles_jefes = Doctrine_Core::getTable('PastoralUsuario')->findAll();
    $this->form = new PastoralProyectoVersionForm();
    
    $this->forward404Unless($pastoral_proyecto = Doctrine_Core::getTable('PastoralProyecto')->find(array($request->getParameter('id'))), sprintf('El objeto pastoral_mision no existe (%s).', $request->getParameter('id')));
    $this->form = new PastoralProyectoForm($pastoral_proyecto);
  }
  
    public function executeUpdateProyecto(sfWebRequest $request)
  {
    
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pastoral_proyecto = Doctrine_Core::getTable('PastoralProyecto')->find(array($request->getParameter('id'))), sprintf('Object pastoral_proyecto_version does not exist (%s).', $request->getParameter('id')));
    $this->form = new PastoralProyectoForm($pastoral_proyecto);

    $this->processFormNoInstancia($request, $this->form);

    $this->setTemplate('editProyecto');
    
  }

  public function executeUpdate(sfWebRequest $request)
  {
    
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pastoral_proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->find(array($request->getParameter('id'))), sprintf('Object pastoral_proyecto_version does not exist (%s).', $request->getParameter('id')));
    $this->form = new PastoralProyectoVersionForm($pastoral_proyecto_version);

    $this->processForm($request, $this->form, 'editado', $pastoral_proyecto_version->getId());

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    
    $this->posibles_jefes = Doctrine_Core::getTable('PastoralUsuario')->findAll();
    $this->form = new PastoralProyectoVersionForm();
    
    $request->checkCSRFProtection();

    $this->forward404Unless($pastoral_proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->find(array($request->getParameter('id'))), sprintf('Object pastoral_proyecto_version does not exist (%s).', $request->getParameter('id')));
    $pastoral_proyecto_version->delete();

    $this->redirect('proyecto/index');
  }
  
    public function executeDeleteProyecto(sfWebRequest $request)
  {
    
    $this->posibles_jefes = Doctrine_Core::getTable('PastoralUsuario')->findAll();
    $this->form = new PastoralProyectoVersionForm();
    
    $request->checkCSRFProtection();

    $this->forward404Unless($pastoral_proyecto = Doctrine_Core::getTable('PastoralProyecto')->find(array($request->getParameter('id'))), sprintf('Object pastoral_proyecto_version does not exist (%s).', $request->getParameter('id')));
    $pastoral_proyecto->delete();

    $this->redirect('proyecto/index');
  }
  
  public function executeAjaxGenerarToken(sfWebRequest $request){
        $version_id = $request->getParameter('proyecto_version_id');
        $proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->findOneById($version_id);
        $mail = $request->getParameter('mail');
        $nombre = $request->getParameter('nombre');
        
        if($proyecto_version){
          $proyecto = Doctrine_Core::getTable('PastoralProyecto')->findOneById($proyecto_version->getProyectoId());
        }
        
        $nombre_proyecto = $proyecto->getNombre();
        
        $random = rand(11111, 99999); 
        $token = Array();
        $token[0] = sha1($nombre_proyecto.$random);
        
        try{
          $proyecto_version->set('token', $token[0]);
          $fecha_actual = date('Y-m-d H:m:s');
          
          $token[1] = $fecha_actual;
          $proyecto_version->set('fecha_creacion_token', $fecha_actual);
          $proyecto_version->save();
        }
        catch(sfException $e){
          $token[0] = -1;
        }
 
// Si no hubo problemas, se envian los mails al director de misiones y a los jefes nacionales. 
if($token[0]!=-1){
        $this->getContext()->getConfiguration()->loadHelpers('Url');       
        $url_diadesalida =   url_for('diadesalida/index?token='.$token[0], true);
        $cargo_nacional = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe Nacional');   
        $jefesNacionales = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorInstanciaYPorCargo($version_id, $cargo_nacional->getId());
        
        //Enviamos mail a los jefes nacionales
        foreach($jefesNacionales as $jefe){
            $user = Doctrine_Core::getTable('SfGuardUser')->findOneById($jefe->getUserId()); 
            $nombre_jefe = $jefe->getNombre();
            $mail_jefe = $user->getEmailAddress();
            
            $mensaje_jefe = $this->getMailer()->compose(
            array('pastoral@pastoraluc.cl' => 'Pastoral UC'),
            $mail_jefe,
            'Nuevo Token',
            <<<EOF
Hola {$nombre_jefe},
      
Se ha generado un nuevo token para ingresar al modulo dia de salida del proyecto {$nombre_proyecto}.
El nuevo token es : {$token[0]}
 
El url al cual debe ingresar es : {$url_diadesalida} 

Saludos.
EOF
    );
 
            $this->getMailer()->send($mensaje_jefe);
        
        } // fin del foreach
        
      // Enviamos el mail al director:  
      $mensaje = $this->getMailer()->compose(
      array('pastoral@pastoraluc.cl' => 'Pastoral UC'),
      $mail,
      'Nuevo Token',
      <<<EOF
Hola {$nombre},
      
Se ha generado un nuevo token para ingresar al dia de salida del proyecto {$nombre_proyecto}.
El nuevo token es : {$token[0]}

El url al cual debe ingresar es : {$url_diadesalida}

Saludos.
EOF
    );
 
          $this->getMailer()->send($mensaje);
        
} // fin del if token[0]!=-1
        
        return $this->renderText(json_encode($token)); 
  
  } // fin del ajax generar token
  
  // Pagina index para info de Instancia:
  public function executeMenuInstancia(sfWebRequest $request)
  {
    $proyecto_version_id = $request->getParameter('id');
    $this->forward404Unless($pastoral_proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->find(array($request->getParameter('id'))), sprintf('El objeto pastoral_mision_version no existe (%s).', $request->getParameter('id')));
    
    $versiones_todas_de_este_proyecto = Doctrine_Core::getTable('PastoralProyectoVersion')->findByProyectoId($pastoral_proyecto_version->getProyectoId());   
    $cantidad_versiones = $versiones_todas_de_este_proyecto->count();
    
    $boolEsElUltimo = false;
    $contador_versiones = 1;
    
    foreach($versiones_todas_de_este_proyecto as $version_de_este_proyecto){
      if($contador_versiones==$cantidad_versiones){
          if($version_de_este_proyecto->getId()==$pastoral_proyecto_version->getId()){
              $boolEsElUltimo = true;
          }    
      }     
      $contador_versiones++;
    }
    
    $q = Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoVersionQuery($proyecto_version_id);
    $q = Doctrine_Core::getTable('PastoralMision')->addMisionesActivasQuery($q);
    $misiones_activas = $q->execute();    
    $num = $misiones_activas->count();  
    if($num>0 || $boolEsElUltimo)
       $this->proyecto_activo = true;
    else
       $this->proyecto_activo = false;
       
    $this->id_jefe_visitando_sitio = -1;
    $this->esJefe = false;
    $this->esDirector = false;
    $this->esDelProyecto = false;
    
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');   
    
    $id_para_token = $this->getUser()->getGuardUser()->getProfile()->getId();
    $pastoral_usuario_token = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id_para_token);
    $this->forward404Unless($pastoral_usuario_token);   
    $nombre_token = $pastoral_usuario_token->getNombre();
    $this->nombre_token = $nombre_token;    
    $usuario_para_sacar_mail = Doctrine_Core::getTable('SfGuardUser')->findOneById($id_para_token);    
    $this->forward404Unless($usuario_para_sacar_mail); 
    $mail_token = $usuario_para_sacar_mail->getEmailAddress();
    $this->mail_token = $mail_token;
    
    if($uc){
        $cargo_actual = $uc->getPastoralCargo();
        $this->cargo_actual = $cargo_actual;        
        $pv_id = $uc->getProyectoVersionId();
        $g_id = $uc->getGrupoId();
        $m_id = $uc->getMisionId();
        $esDirector = false;
        $esDelProyecto = false;
        if($cargo_actual->getEsDirector()==1){
          $esDirector = true;
          $this->esDirector = true; 
          $this->esDelProyecto = true;
        }
        
        
        if($pv_id && !$esDirector){          
            if($pv_id==$proyecto_version_id){
                $esDelProyecto = true;
                $this->esDelProyecto = true;
                $this->id_jefe_visitando_sitio = $uc->getUsuarioId();
                $this->esJefe = true;
            }
            
            if($pv_id!=$proyecto_version_id){
                $this->esDelProyecto = false;   
                $this->esJefe = true;            
            }
        }
        
        if(!$esDirector){
          if($cargo_actual->getVProyectoversion()!=1)
          {	
            $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
          }       
        }   
      }
      
    else{
        $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
    }
    
    
    
    $this->pastoral_proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->find(array($request->getParameter('id')));
    
    $this->pastoral_proyecto = Doctrine_Core::getTable('PastoralProyecto')->getNombreProyectoPorId($this->pastoral_proyecto_version->getProyectoId());
    
    $this->pastoral_grupos_version = Doctrine_Core::getTable('PastoralGrupo')->getGruposPorIdVersion(array($request->getParameter('id')));
    $proyecto_version = $this->pastoral_proyecto_version;
    $id = $request->getParameter('id'); 
    
    $cargo_finanzas = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe de Finanzas');
    $cargo_inscripciones = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe de Inscripciones');
    $cargo_extranjeros = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe de Extranjeros');
    $cargo_nacional = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe Nacional');
    
    $this->jefesFinanzas= Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorInstanciaYPorCargo($id, $cargo_finanzas->getId());
    // Jefe de Inscripciones (id cargo = 7)
    $this->jefesInscripciones= Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorInstanciaYPorCargo($id, $cargo_inscripciones->getId());
    // Jefe Nacional (id cargo = 9)
    $this->jefesNacionales= Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorInstanciaYPorCargo($id, $cargo_nacional->getId());
    // Jefe de Extranjeros (id cargo = 11)
    $this->jefesExtranjeros= Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorInstanciaYPorCargo($id, $cargo_extranjeros->getId());
  
    $token = $this->pastoral_proyecto_version->getToken();
    $fecha_token = $this->pastoral_proyecto_version->getFechaCreacionToken();
    
    if($token){
      list($ano,$mes,$dia) = explode("-",$fecha_token);   
      $ano_dif = date("Y") - $ano;
      $mes_dif = date("m") - $mes;
      $dia_dif = date("d") - $dia;
      
      if($ano_dif>0){             
          $proyecto_version->set('token', null);
          $proyecto_version->set('fecha_creacion_token', null);
          $proyecto_version->save();
      }
      else if($ano_dif==0){
          if($mes_dif>0){
              $proyecto_version->set('token', null);
              $proyecto_version->set('fecha_creacion_token', null);
              $proyecto_version->save();
          }
          else if($mes_dif==0){
              if($dia_dif>0){
                  $proyecto_version->set('token', null);
                  $proyecto_version->set('fecha_creacion_token', null);
                  $proyecto_version->save();
              }
          }
      }
    }
    
    $this->token = $this->pastoral_proyecto_version->getToken();
    $this->fechaToken = $this->pastoral_proyecto_version->getFechaCreacionToken();
    
  }
  
  public function executeEditJefe(sfWebRequest $request)
  {
      
      $proyecto_version_id = $request->getParameter('id');
      
      //chequear permisos
      $uc = $this->getUser()->getAttribute('usuario_cargo');
      if($uc){
          $cargo_actual = $uc->getPastoralCargo(); 
          $pv_id = $uc->getProyectoVersionId();
          $g_id = $uc->getGrupoId();
          $m_id = $uc->getMisionId();
          $esDirector = false;
          $esDelProyecto = false;
          
          if($cargo_actual->getEsDirector()==1){
            $esDirector = true;  
          }
          
          if($pv_id==$proyecto_version_id){
              $esDelProyecto = true;      
          }
          
          if(!$esDirector){
            if(($cargo_actual->getEProyectoversion()!=1 || !$esDelProyecto))
            {	
              $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
            }       
          }   
        }
        
      else{
          $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
      }
      
      $this->posibles_jefes = Doctrine_Core::getTable('PastoralUsuario')->findAll();
      $this->form = new PastoralProyectoVersionForm();
      
      $this->cargo = $request->getParameter('cargo');   
      $cargo = $request->getParameter('cargo');
      $this->pastoral_proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->find(array($request->getParameter('id')));
      $id_usuario = $request->getParameter('id_usuario');
      
      $id = $request->getParameter('id');
      $this->id = $request->getParameter('id');
      
      $this->posibles_jefes = Doctrine_Core::getTable('PastoralUsuario') ->findAll();
      
      $cargo_nacional = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe Nacional');
      $this->cargo_nacional = $cargo_nacional;
      $cargo_finanzas = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe de Finanzas');    
      $this->cargo_finanzas = $cargo_finanzas;
      $cargo_inscripciones = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe de Inscripciones');  
      $this->cargo_inscripciones = $cargo_inscripciones;
      $cargo_extranjeros = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe de Extranjeros');
      $this->cargo_extranjeros = $cargo_extranjeros;
      
      if($cargo == 'Nacional'){          
          $jefes = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorInstanciaYPorCargo($id, $cargo_nacional->getId());         
          $this->id_cargo = $cargo_nacional->getId();
          foreach($jefes as $jefe){
            if($jefe->getId()==$id_usuario){
                $this->jefeEditar = $jefe;
            }
          }         
      }
      
      else if($cargo == 'de Finanzas'){
          $jefes = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorInstanciaYPorCargo($id, $cargo_finanzas->getId());         
          $this->id_cargo = $cargo_finanzas->getId();
          foreach($jefes as $jefe){
            if($jefe->getId()==$id_usuario){
                $this->jefeEditar = $jefe;
            }
          }         
      }
      
      else if($cargo == 'de Inscripciones'){        
          $jefes = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorInstanciaYPorCargo($id, $cargo_inscripciones->getId());         
          $this->id_cargo = $cargo_inscripciones->getId();
          foreach($jefes as $jefe){
            if($jefe->getId()==$id_usuario){
                $this->jefeEditar = $jefe;
            }
          }         
      }
      
      else if($cargo == 'de Extranjeros'){
          $jefes = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorInstanciaYPorCargo($id, $cargo_extranjeros->getId());         
          $this->id_cargo = $cargo_extranjeros->getId();
          foreach($jefes as $jefe){
            if($jefe->getId()==$id_usuario){
                $this->jefeEditar = $jefe;
            }
          }         
      }
      
  }
  
  public function executeMasJefesInstancia(sfWebRequest $request)
  {
  
  	  $proyecto_version_id = $request->getParameter('id');
      
      //chequear permisos
      $uc = $this->getUser()->getAttribute('usuario_cargo');
      if($uc){
          $cargo_actual = $uc->getPastoralCargo(); 
          $pv_id = $uc->getProyectoVersionId();
          $g_id = $uc->getGrupoId();
          $m_id = $uc->getMisionId();
          $esDirector = false;
          $esDelProyecto = false;
          
          if($cargo_actual->getEsDirector()==1){
            $esDirector = true;  
          }
          
          if($pv_id==$proyecto_version_id){
              $esDelProyecto = true;      
          }
          
          if(!$esDirector){
            if(($cargo_actual->getEProyectoversion()!=1 || !$esDelProyecto))
            {	
              $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
            }       
          }   
        }
        
      else{
          $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
      }
    
    $cargo_nacional = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe Nacional');
    $this->cargo_nacional = $cargo_nacional;
    $cargo_finanzas = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe de Finanzas');    
    $this->cargo_finanzas = $cargo_finanzas;
    $cargo_inscripciones = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe de Inscripciones');  
    $this->cargo_inscripciones = $cargo_inscripciones;
    $cargo_extranjeros = Doctrine_Core::getTable('PastoralCargo')->findOneByNombre('Jefe de Extranjeros');
    $this->cargo_extranjeros = $cargo_extranjeros;
    
    $this->posibles_jefes = Doctrine_Core::getTable('PastoralUsuario')->findall();
    $this->form = new PastoralProyectoVersionForm();
    
    $this->pastoral_proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->find(array($request->getParameter('id')));
  
  }
  
  public function executeAjaxMasJefeInstancia(sfWebRequest $request)
  {
        // Obtenemos los valores que nos pasa el ajax:
        $id_jefe = $request->getParameter('id_jefe');
        $id_cargo = $request->getParameter('id_cargo');
        $id_proyecto = $request->getParameter('proyecto');
        $return = 0;
        
        $cargo = new PastoralUsuarioCargo();
        $cargo  ->setUsuarioId($id_jefe)
                ->setCargoId($id_cargo)
                ->setProyectoVersionId($id_proyecto)
                ->save();  
        $return = 1;
        
        return $this->renderText(json_encode($return));
  }
  
  public function executeAjaxEditarJefeInstancia(sfWebRequest $request)
  {
      // Obtenemos los valores que nos pasa el ajax:
      $id_jefe_nuevo = $request->getParameter('id_nuevo');
      $id_jefe_viejo = $request->getParameter('id_viejo');
      $id_cargo = $request->getParameter('cargo');
      $id_proyecto = $request->getParameter('proyecto');
      
      
        $return = 0;
      
      // Vemos si realmente hubo un cambio:
      if($id_jefe_nuevo != $id_jefe_viejo){
            
            $jefeNuevo = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id_jefe_nuevo);
            $exJefe = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id_jefe_viejo);
            
            $usuario_cargo = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporIdUsuarioProyectoVersionCargo($id_proyecto, $id_jefe_viejo, $id_cargo);
            $usuario_cargo->setUsuarioId($id_jefe_nuevo);
            try{
              $usuario_cargo->save();
              $return = 1;
              
              $usuario = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id_jefe_nuevo);
              
              $this->getUser()->setFlash('editar_jefe', sprintf('Se ha editado exitosamente el jefe seleccionado. El nuevo jefe es '.$usuario));

            }
            catch(sfException $e){
              $return = 0;
              $this->getUser()->setFlash('editar_jefe', sprintf('Error! No se ha podido editar. Intentelo de nuevo mas tarde.'));              
            }
            
      }
     // Si no hubo cambios:
      else{
            $return = 0;
      }
      
      return $this->renderText(json_encode($return));
  
  }

  public function executeAjaxEliminarJefeInstancia(sfWebRequest $request)
  {
      // Obtenemos los valores que nos pasa el ajax:
      $id_jefe = $request->getParameter('id_j');
      $id_cargo = $request->getParameter('cargo');
      $id_proyecto = $request->getParameter('proyecto');
      $return = 0;
      
      $jefeEliminar = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($id_jefe);
        
      $usuario_cargo = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporIdUsuarioProyectoVersionCargo($id_proyecto, $id_jefe, $id_cargo);
      try{
        $usuario_cargo->delete();
        $return = 1;   
        $this->getUser()->setFlash('editar_jefe', sprintf('Se ha eliminado exitosamente el jefe seleccionado. Dicho usuario ya no es jefe del proyecto.'));

      }
      catch(sfException $e){
          $return = 0;
          $this->getUser()->setFlash('editar_jefe', sprintf('Error! No se ha podido eliminar el jefe seleccionado. Intentelo de nuevo mas tarde.'));              
      }
      
      return $this->renderText(json_encode($return));
  
  }  
  
  protected function processForm(sfWebRequest $request, sfForm $form, $nuevo_o_editado, $id_version)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $booleanExiste = 0;
    
    $proyectos = Doctrine_Core::getTable('PastoralProyecto')
      ->createQuery('b')
      ->execute();
    
    
    if($form->isValid()){        
        
        $ano = $request->getPostParameter('pastoral_proyecto_version[ano]');   
        $version = $request->getPostParameter('pastoral_proyecto_version[version]'); 
        $proyecto_id = $request->getPostParameter('pastoral_proyecto_version[proyecto_id]');
        
        $p_versiones = Doctrine_Core::getTable('PastoralProyectoVersion')->findByProyectoId($proyecto_id);
        
        foreach($p_versiones as $p_version){
              if($p_version->getAno()==$ano && $p_version->getVersion()==$version){
                  $booleanExiste = 1;
              }
        }

        // Si el proyecto no es nuevo (esta editando), quizas edito un campo distinto al ano o version, y en ese caso va a decir que ya existia. 
        if($nuevo_o_editado=='editado'){
            $booleanExiste = 0;
        }

    
        if ($booleanExiste==0)
        {
               
            $pastoral_proyecto_version = $form->save();
            
            // Esto solo se hace si el proyeto es creado...al editar esto no se hace. 
            if($nuevo_o_editado == 'nuevo'){
            
              //Agrego grupo donde Dios me quiera
                $grupo = new PastoralGrupo();         
                $grupo  ->setNombre('Donde Dios me Quiera')
                      ->setProyectoVersionId($pastoral_proyecto_version->getId())
                      ->save();
            
            
                //agrego Zona donde Dios me quiera
                $salida = Doctrine_Core::getTable('PastoralSalida')->findOneByNombre("Santiago");
                $localidad = Doctrine_Core::getTable('PastoralLocalidad')->findOneByNombre("Donde Dios me Quiera");
                $zona = new PastoralMision();
                $zona
                ->setInscripcionAbierta('1')
                ->setSalidaId($salida->getId())
                ->setLocalidadId($localidad->getId())
                ->setGrupoId($grupo->getId())
                ->save()
                ;
            
                // Obtenemos los ID de los jefes seleccionados:
                $jefes_nacional_id = $request->getParameter('jefe_nacional');
                $jefes_finanzas_id = $request->getParameter('jefe_finanzas');
                $jefes_inscripcion_id = $request->getParameter('jefe_inscripcion');
                $jefes_extranjeros_id = $request->getParameter('jefe_extranjeros');
                $jefeNacional = false;

                
                if($jefes_nacional_id!=null ){
                    
                  $jefesActuales = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefeNacionalYProyecto($pastoral_proyecto_version->getId())->execute();
                  $jefes_id = $jefes_nacional_id;
                  
                  $existe_jefe = 0;
                  if($jefes_id!=NULL)
                  {
                    foreach($jefes_id as $jefe_id)
                    {
                    $existe_jefe = 0;
                    foreach($jefesActuales as $jefe)
                    {
                      if($jefe['usuario_id'] == $jefe_id)
                        $existe_jefe = 1;
                    }
                    if($existe_jefe == 0)
                    {
                      $cargo_misionero = Doctrine_Core::getTable('PastoralCargo')->getCargoPorNombre("Jefe Nacional");
                      $cargo = new PastoralUsuarioCargo();
                      $cargo
                        ->setUsuarioId($jefe_id)
                        ->setCargoId($cargo_misionero->getId())
                        ->setProyectoVersionId($pastoral_proyecto_version->getId())
                        ->save()
                        ;
                      
                      $usuario = Doctrine_Core::getTable('PastoralUsuario')->findOneById($jefe_id); 
                      $usuario->borrarUsuarioDeMueDelProyectoVersion($pastoral_proyecto_version->getId());
                      
                      $nu = new PastoralNotificacionUsuario();
                      $nu->setRecibeId($jefe_id);
                      $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
                      $nu->setEnviado("Direcci&oacute;n");
                      $nu->setAsunto("Jefe Nacional");
                      $nu->setMensaje("Felicitaciones, has sido seleccionado como jefe Nacional de ".$pastoral_proyecto_version->getNombre());
                      $nu->save();
                    }
                    }
                  }
                  
                  foreach($jefesActuales as $jefe)
                  {
                    $existe_jefe = 0;
                    foreach($jefes_id as $jefe_id)
                    {
                      if($jefe['usuario_id'] == $jefe_id)
                        $existe_jefe = 1;
                    }
                    if($existe_jefe == 0)
                    {			
                      $jefe->delete();
                    }
                  }
                     
                  $jefeNacional = true;
                }
                
                if($jefes_finanzas_id!=null)
                {
                  $jefesActuales = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefeFinanzasYProyecto($pastoral_proyecto_version->getId())->execute();
                  $jefes_id = $jefes_finanzas_id;
                  
                  $existe_jefe = 0;
                  if($jefes_id!=NULL)
                  {
                    foreach($jefes_id as $jefe_id)
                    {
                    $existe_jefe = 0;
                    foreach($jefesActuales as $jefe)
                    {
                      if($jefe['usuario_id'] == $jefe_id)
                        $existe_jefe = 1;
                    }
                    if($existe_jefe == 0)
                    {
                      $cargo_misionero = Doctrine_Core::getTable('PastoralCargo')->getCargoPorNombre("Jefe de Finanzas");
                      $cargo = new PastoralUsuarioCargo();
                      $cargo
                        ->setUsuarioId($jefe_id)
                        ->setCargoId($cargo_misionero->getId())
                        ->setProyectoVersionId($pastoral_proyecto_version->getId())
                        ->save();
                        
                      
                      $usuario = Doctrine_Core::getTable('PastoralUsuario')->findOneById($jefe_id); 
                      $usuario->borrarUsuarioDeMueDelProyectoVersion($pastoral_proyecto_version->getId());
                      
                      $nu = new PastoralNotificacionUsuario();
                      $nu->setRecibeId($jefe_id);
                      $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
                      $nu->setEnviado("Direcci&oacute;n");
                      $nu->setAsunto("Jefe Finanzas");
                      $nu->setMensaje("Felicitaciones, has sido seleccionado como jefe de Finanzas de ".$pastoral_proyecto_version->getNombre());
                      $nu->save();
                    }
                    }
                  }
                  
                  foreach($jefesActuales as $jefe)
                  {
                    $existe_jefe = 0;
                    foreach($jefes_id as $jefe_id)
                    {
                      if($jefe['usuario_id'] == $jefe_id)
                        $existe_jefe = 1;
                    }
                    if($existe_jefe == 0)
                    {			
                      $jefe->delete();
                    }
                  }             
                }
                
                if($jefes_inscripcion_id!=null)
                {
                  $jefesActuales = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefeInscripcionesYProyecto($pastoral_proyecto_version->getId())->execute();
                  $jefes_id = $jefes_inscripcion_id;
                  
                  $existe_jefe = 0;
                  if($jefes_id!=NULL)
                  {
                    foreach($jefes_id as $jefe_id)
                    {
                    $existe_jefe = 0;
                    foreach($jefesActuales as $jefe)
                    {
                      if($jefe['usuario_id'] == $jefe_id)
                        $existe_jefe = 1;
                    }
                    if($existe_jefe == 0)
                    {
                      $cargo_misionero = Doctrine_Core::getTable('PastoralCargo')->getCargoPorNombre("Jefe de Inscripciones");
                      $cargo = new PastoralUsuarioCargo();
                      $cargo
                        ->setUsuarioId($jefe_id)
                        ->setCargoId($cargo_misionero->getId())
                        ->setProyectoVersionId($pastoral_proyecto_version->getId())
                        ->save();
                        
                        
                      $usuario = Doctrine_Core::getTable('PastoralUsuario')->findOneById($jefe_id); 
                      $usuario->borrarUsuarioDeMueDelProyectoVersion($pastoral_proyecto_version->getId());
                    
                      $nu = new PastoralNotificacionUsuario();
                      $nu->setRecibeId($jefe_id);
                      $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
                      $nu->setEnviado("Direcci&oacute;n");
                      $nu->setAsunto("Jefe de Inscripciones");
                      $nu->setMensaje("Felicitaciones, has sido seleccionado como jefe de Inscripciones de ".$pastoral_proyecto_version->getNombre());
                      $nu->save();
                    }
                    }
                  }
                  
                  foreach($jefesActuales as $jefe)
                  {
                    $existe_jefe = 0;
                    foreach($jefes_id as $jefe_id)
                    {
                      if($jefe['usuario_id'] == $jefe_id)
                        $existe_jefe = 1;
                    }
                    if($existe_jefe == 0)
                    {			
                      $jefe->delete();
                    }
                  }  
                }
                
                if($jefes_extranjeros_id!=null)
                {
                  $jefesActuales = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefeExtranjerosYProyecto($pastoral_proyecto_version->getId())->execute();
                  $jefes_id = $jefes_extranjeros_id;
                  
                  $existe_jefe = 0;
                  if($jefes_id!=NULL)
                  {
                    foreach($jefes_id as $jefe_id)
                    {
                      $existe_jefe = 0;
                      foreach($jefesActuales as $jefe)
                      {
                        if($jefe['usuario_id'] == $jefe_id)
                          $existe_jefe = 1;
                      }
                      if($existe_jefe == 0)
                      {
                        $cargo_misionero = Doctrine_Core::getTable('PastoralCargo')->getCargoPorNombre("Jefe de Extranjeros");
                        $cargo = new PastoralUsuarioCargo();
                        $cargo
                          ->setUsuarioId($jefe_id)
                          ->setCargoId($cargo_misionero->getId())
                          ->setProyectoVersionId($pastoral_proyecto_version->getId())
                          ->save(); 
                          
                        
                        $usuario = Doctrine_Core::getTable('PastoralUsuario')->findOneById($jefe_id); 
                        $usuario->borrarUsuarioDeMueDelProyectoVersion($pastoral_proyecto_version->getId());
                        
                        $nu = new PastoralNotificacionUsuario();
                        $nu->setRecibeId($jefe_id);
                        $nu->setEnviaId($this->getUser()->getGuardUser()->getProfile()->getId());
                        $nu->setEnviado("Direcci&oacute;n");
                        $nu->setAsunto("Jefe Extranjeros");
                        $nu->setMensaje("Felicitaciones, has sido seleccionado como jefe de Extranjeros de ".$pastoral_proyecto_version->getNombre());
                        $nu->save();
                      }
                    }
                  }
                  
                  foreach($jefesActuales as $jefe)
                  {
                    $existe_jefe = 0;
                    foreach($jefes_id as $jefe_id)
                    {
                      if($jefe['usuario_id'] == $jefe_id)
                        $existe_jefe = 1;
                    }
                    if($existe_jefe == 0)
                    {			
                      $jefe->delete();
                    }
                  }
                } 
            } // fin del if es nuevo                
            
            foreach($proyectos as $p){
              // Revisamos si es del proyecto seleccionado:
              if($p->getId() == $pastoral_proyecto_version->getProyectoId()){
                  $nombre = $p->getNombre();
              }
            }
            
            if($nuevo_o_editado == 'nuevo'){
                  $this->getUser()->setFlash('instancia_exitosa', sprintf('Se ha creado exitosamente la instancia "'.$pastoral_proyecto_version->getAno().'" del proyecto "'.$nombre.'". Si lo desea puede crear, a continuacion, un grupo para esta instancia del proyecto.'));
            }
            
            $uc = $this->getUser()->getAttribute('usuario_cargo');
            $cargo_actual = $uc->getPastoralCargo(); 
            
            $proyecto_id = $request->getParameter('proyecto_id');
            $uc2 = new PastoralUsuarioCargo();
            $uc2
                  ->setUsuarioId($uc->getUsuarioId())
                  ->setCargoId($cargo_actual)
                  ->setProyectoVersionId($pastoral_proyecto_version->getId());
                  
            $this->getUser()->setAttribute('usuario_cargo', $uc2); 
            if($nuevo_o_editado == 'nuevo'){
              $this->redirect('grupo/new');
            }
            if($nuevo_o_editado == 'editado'){
              $this->redirect('proyecto/menuInstancia?id='.$pastoral_proyecto_version->getId());
            }
            
        } // fin if no existe el proyecto
        
         else{
          $this->getUser()->setFlash('instancia_fallida', sprintf('Error! La instancia de este proyecto ya existe. Ingrese correctamente los datos.'));
          if($nuevo_o_editado == 'nuevo'){
              $this->redirect('proyecto/new');
          }
          if($nuevo_o_editado == 'editado'){
              $this->redirect('proyecto/edit?id='.$id_version);
          }
        }
    } // fin if form is valid
    
    else{
        $this->getUser()->setFlash('instancia_fallida', sprintf('Error! Falta completar campos obligatorios. Ingrese correctamente los datos.'));
        if($nuevo_o_editado == 'nuevo'){
              $this->redirect('proyecto/new');
        }
        if($nuevo_o_editado == 'editado'){
              $this->redirect('proyecto/edit?id='.$id_version);
        }  
    }
  }
  
  protected function processFormNoInstancia(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    
    if ($form->isValid())
    { 
      $pastoral_proyecto = $form->save();

      $this->redirect('proyecto/index');
    }
  }
  
  public function executeAjaxEstadisticaGrupo(sfWebRequest $request)
  {   
    $grupo_id = $request->getParameter('grupo_id');    
    $respuesta = array();
    
    $misiones = Doctrine_Core::getTable('PastoralMision')->findByGrupoId($grupo_id);
    $generos = array();
    $generos['Hombres'] = 0;
    $generos['Mujeres'] = 0;
    
    $necesidades_abarcadas = array();
    
    if($misiones != null)
    {
    foreach($misiones as $mision)
      {                     
        $generos['Hombres'] += $mision->countHombres();
        $generos['Mujeres'] += $mision->countMujeres();       
      
        $necesidades = $mision->getNecesidadMisiones();  
        if($mision->getLocalidadId()>0){
          $necesidades_abarcadas['Necesidades abarcadas']= array_key_exists('Necesidades abarcadas',$necesidades_abarcadas)? $necesidades_abarcadas['Necesidades abarcadas'] += $necesidades->count():$necesidades->count();
          $necesidades_abarcadas['Otras necesidades']= array_key_exists('Otras necesidades',$necesidades_abarcadas)?$necesidades_abarcadas['Otras necesidades'] += $mision->getPastoralLocalidad()->getNecesidades()->count()-$necesidades->count():$mision->getPastoralLocalidad()->getNecesidades()->count()-$necesidades->count();
        }
      }
    }
    
    $grupo = Doctrine_Core::getTable('PastoralGrupo')->findOneById($grupo_id);   
    $edades = $grupo->cantidadPorEdades();
    
    $movimientos = array();
    $movimientos_religiosos = Doctrine_Core::getTable('PastoralMovimiento')->findAll();
    foreach($movimientos_religiosos as $mr)
    {
      $res = $mr->cantidadPorGrupo($grupo_id);
      if($res!=0)
        $movimientos[$mr->getNombre()] = $res;
    }
    
    $carreras = array();
    $carr = Doctrine_Core::getTable('PastoralCarrera')->findAll();
    
    foreach($carr as $c)
    {
      $total = $c->cantidadPorGrupo($grupo_id);
      if($total != 0)
      {
        $carreras[$c->getNombre()] =$total;
      }
    }
      
      $respuesta[0]=array_keys($generos);
      $respuesta[1]=array_values($generos);
      $respuesta[2]=$edades[0];
      $respuesta[3]=$edades[1];
      $respuesta[4]=array_keys($movimientos);
      $respuesta[5]=array_values($movimientos);
      $respuesta[6]=array_keys($carreras);
      $respuesta[7]=array_values($carreras);
      $respuesta[8]=array_keys($necesidades_abarcadas);
      $respuesta[9]=array_values($necesidades_abarcadas);
      $respuesta[10] = $grupo_id;
      
      return $this->renderText(json_encode($respuesta));
  }
  
  
  public function executeAjaxEstadisticaZona(sfWebRequest $request){
  
    $mision_id = $request->getParameter('mision_id');    
    $respuesta = array();
    
    $mision = Doctrine_Core::getTable('PastoralMision')->findOneById($mision_id);
    
    $generos = array();
    $necesidades_abarcadas = array();
    $experiencia = array();
    $edades = array();
    $movimientos = array();
    $carreras = array();
    
    $generos['Hombres'] = $mision->countHombres();
    $generos['Mujeres'] = $mision->countMujeres();
    
    $necesidades = $mision->getNecesidadMisiones();
    $necesidades_abarcadas = array();
    $necesidades_abarcadas['Necesidades abarcadas'] = $necesidades->count();
    $necesidades_abarcadas['Otras necesidades'] = $mision->getPastoralLocalidad()->getNecesidades()->count()-$necesidades->count();

    $edades = $mision->cantidadPorEdades();
    
    $movimientos_religiosos = Doctrine_Core::getTable('PastoralMovimiento')->findAll();
    foreach($movimientos_religiosos as $mr)
    {
      $res = $mr->cantidadPorMision($mision_id);
      if($res!=0)
        $movimientos[$mr->getNombre()] = $res;
    }
    
    $carr = Doctrine_Core::getTable('PastoralCarrera')->findAll();
    
    foreach($carr as $c)
    {
      $total = $c->cantidadPorMision($request->getParameter('mision_id'));
      if($total != 0)
      {
        $carreras[$c->getNombre()] =$total;
      }
    }
    
    $respuesta[0]=array_keys($generos);
    $respuesta[1]=array_values($generos);
    $respuesta[4]=$edades[0];
    $respuesta[5]=$edades[1];
    $respuesta[6]=array_keys($movimientos);
    $respuesta[7]=array_values($movimientos);
    $respuesta[8]=array_keys($carreras);
    $respuesta[9]=array_values($carreras);
    $respuesta[10]=array_keys($necesidades_abarcadas);
    $respuesta[11]=array_values($necesidades_abarcadas);
    $respuesta[12] =  $mision_id;
    
    return $this->renderText(json_encode($respuesta));
 
  }
  
  
  public function executeGrupo(sfWebRequest $request){
  
      $this->pastoral_grupo = Doctrine_Core::getTable('PastoralGrupo')->find(array($request->getParameter('id')));      
      $this->proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->findOneById($this->pastoral_grupo->getProyectoVersionId());   
      $proyecto_version_id = $this->proyecto_version->getId();
      $q = Doctrine_Core::getTable('PastoralMision')->addMisionesPorProyectoVersionQuery($proyecto_version_id);
      $q = Doctrine_Core::getTable('PastoralMision')->addMisionesActivasQuery($q);
      $misiones_activas = $q->execute();    
      $num = $misiones_activas->count();  
      if($num>0)
        $this->proyecto_activo = true;
      else
        $this->proyecto_activo = false;
      
      $this->esDirector = false;
      $this->esDelProyecto = false;
    
      //chequear permisos
      $uc = $this->getUser()->getAttribute('usuario_cargo');
      if($uc){
        $cargo_actual = $uc->getPastoralCargo();
        $this->cargo_actual = $cargo_actual;        
        $pv_id = $uc->getProyectoVersionId();
        $g_id = $uc->getGrupoId();
        $m_id = $uc->getMisionId();
        $esDirector = false;
        $esDelProyecto = false;
        
        if($cargo_actual->getEsDirector()==1){
          $esDirector = true;
          $this->esDirector = true; 
          $this->esDelProyecto = true;
        }
        
        if($pv_id==$proyecto_version_id){
            $esDelProyecto = true;
            $this->esDelProyecto = true;
        }
        
        if(!$esDirector){
          // Le pido que pueda ver proyecto version ya que esta pagina es para el director y los jefes. 
          if($cargo_actual->getVProyectoversion()!=1)
          {	
            $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
          }       
        }   
      }
      
      else{
          $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
      }
      
      //$this->posibles_jefes = Doctrine_Core::getTable('PastoralUsuario')->getUsuarios();
      
      $this->forward404Unless($this->pastoral_grupo);
      
      $this->pastoral_proyecto = Doctrine_Core::getTable('PastoralProyecto')->getNombreProyectoPorId($this->proyecto_version->getProyectoId());
      
      $this->zonas = Doctrine_Core::getTable('PastoralMision')->addMissionesPorGrupoQuery($request->getParameter('id'))->fetchArray();
    
      $jefesActuales = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYGrupo($this->pastoral_grupo->getId())->execute();
      $jefes = array();
      foreach($jefesActuales as $jef)
      {
        $temp = Doctrine_Core::getTable('PastoralUsuario')->getUsuarioPorId($jef['usuario_id']); 	
        $jefes[] = $temp;
      }
      $this->jefes = $jefes;
 
      $pastoral_misions = Doctrine_Core::getTable('PastoralMision')->addMissionesPorGrupoQuery($request->getParameter('id'))->execute(); 
    
      $salidas = array();
      $localidades = array();
      $fechas_inicio = array();
      $fechas_termino = array();
      $sectores = array();
    
      foreach($pastoral_misions as $pm){
      
        $id_salida = $pm->getSalidaId();
        $id_localidad = $pm->getLocalidadId();		
        $id_localidad_fantasia = $pm->getLocalidadFantasiaId();
        
        $q2 = Doctrine_Query::create()
          ->from('PastoralSalida s')
          ->andWhere('s.id = ?',$id_salida);
          
        $salida = $q2->fetchOne();
		
        $q4 = Doctrine_Query::create()
          ->from('PastoralLocalidadFantasia s')
          ->andWhere('s.id = ?',$id_localidad_fantasia);
          
        $sector = $q4->fetchOne();
        
        $q3 = Doctrine_Query::create()
          ->from('PastoralLocalidad l')
          ->andWhere('l.id = ?',$id_localidad);
          
        $localidad = $q3->fetchOne();
        
        if($id_salida!= NULL)
          $salidas = array_merge($salidas, (array)$salida->getNombre());
        else
        $salidas = array_merge($salidas, (array)'');
        if($id_localidad!= NULL)
          $localidades = array_merge($localidades, (array)$localidad->getNombre());
        else
        $localidades = array_merge($localidades, (array)'');
        if($id_localidad_fantasia!= NULL)
        $sectores = array_merge($sectores, (array)$sector->getNombre());
        else
         $sectores = array_merge($sectores, (array)'');
		
		
        $fecha_inicio = $pm->getFechaInicio();
        $fecha_termino = $pm->getFechaTermino();
        
        if($fecha_inicio!= NULL)
        {
          $fecha_inicio = preg_replace('/00:00:00/', '', $pm->getFechaInicio());
          $fechas_inicio = array_merge($fechas_inicio, (array)$fecha_inicio);
        }
        else
          $fechas_inicio = array_merge($fechas_inicio, (array)'');	
        
        if($fecha_termino!= NULL)
        {
          $fecha_termino = preg_replace('/00:00:00/', '', $pm->getFechaTermino());
          $fechas_termino = array_merge($fechas_termino, (array)$fecha_termino);
        }
        else
          $fechas_termino = array_merge($fechas_termino, (array)'');
        
      
      }
      $this->pastoral_misions = $pastoral_misions;
      $this->salidas = (array)$salidas;
      $this->sectores = (array)$sectores;
      $this->localidades = (array)$localidades;
      $this->fechas_inicio = (array)$fechas_inicio;
      $this->fechas_termino = (array)$fechas_termino;
      
  }
  
  public function executeMision(sfWebRequest $request)
  {
	
    $mision_id = $request->getParameter('mision_id');
    $this->pastoral_mision = Doctrine_Core::getTable('PastoralMision')->findOneById($mision_id);
    
    $this->grupo = Doctrine_Core::getTable('PastoralGrupo')->findOneById($this->pastoral_mision->getGrupoId());
    $this->proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->findOneById($this->grupo->getProyectoVersionId());
    $this->proyecto = Doctrine_Core::getTable('PastoralProyecto')->findOneById($this->proyecto_version->getProyectoId());
        
    $proyecto_version_id = $this->proyecto_version->getId();
    $this->id_jefe_visitando_sitio = -1;
    $this->esJefe = false;
    $this->esDirector = false;
    
    //chequear permisos
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    if($uc){
        $cargo_actual = $uc->getPastoralCargo();
        $this->cargo_actual = $cargo_actual;        
        $pv_id = $uc->getProyectoVersionId();
        $g_id = $uc->getGrupoId();
        $m_id = $uc->getMisionId();
        $esDirector = false;
        $esDelProyecto = false;
        
        if($cargo_actual->getEsDirector()==1){
          $esDirector = true;
          $this->esDirector = true; 
        }
        
        if($pv_id==$proyecto_version_id){
            $esDelProyecto = true;
            $this->id_jefe_visitando_sitio = $uc->getUsuarioId();
            $this->esJefe = true;
        }
        
        if(!$esDirector){
          if(($cargo_actual->getVProyectoversion()!=1 || !$esDelProyecto))
          {	
            $this->redirect("/backend_dev.php/usuario/PermisoDenegado");
          }       
        }   
      }
      
    else{
        $this->redirect("/backend_dev.php/usuario/PermisoDenegado"); 
    }
    
    
    
    $this->forward404Unless($this->pastoral_mision);
    $this->forward404Unless($this->proyecto_version);
    $this->forward404Unless($this->grupo);
    
    $jefes_uc = Doctrine_Core::getTable('PastoralUsuarioCargo')->addUCporJefesYMision($mision_id)->fetchArray();
    $jefes = array();
    
    for($i=0;$i<count($jefes_uc);$i++)
    {
      $jefes[$i] = Doctrine_Core::getTable('PastoralUsuario')->findOneById($jefes_uc[$i]['usuario_id']);
    }
    $this->jefes = $jefes;
    
    $misioneros_uc = Doctrine_Core::getTable('PastoralMisionUsuarioEstado')->findByMisionId($mision_id)->toArray();
    $misioneros = array();
    
    for($i=0;$i<count($misioneros_uc);$i++)
    {
      $misioneros[$i] = Doctrine_Core::getTable('PastoralUsuario')->findOneById($misioneros_uc[$i]['usuario_id']);
    }
    $this->misioneros = $misioneros;
  }
    
  public function executeSetearComoJefeDeProyecto(sfWebRequest $request)
  {
    $proyecto_id = $request->getParameter('proyecto_id');
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    if($proyecto_id !=-1)
    {
      $proyecto_version = Doctrine_Core::getTable('PastoralProyectoVersion')->addUltimoProyectoVersionDeProyecto($proyecto_id)->execute();
      if($proyecto_version!=null)
      {
        $uc2 = new PastoralUsuarioCargo();
        $uc2
              ->setUsuarioId($uc->getUsuarioId())
              ->setCargoId($cargo_actual)
              ->setProyectoVersionId($proyecto_version[0]->getId())
              ;
        $this->getUser()->setAttribute('usuario_cargo', $uc2); 
        $respuesta = array();
        $respuesta[0] = $uc2->getProyectoVersion()->getNombre();
        $respuesta[1] = $uc->getPastoralCargo()->getNombre();
        return $this->renderText(json_encode($respuesta));
        
      }
    }
    else
    {
      $respuesta = array();
      $respuesta[0] = 'Pastoral UC';
      $respuesta[1] = $uc->getPastoralCargo()->getNombre();
      return $this->renderText(json_encode($respuesta));
    }
    
    return $this->renderText('');  
  }  
  
  public function executeSetearComoJefeDeProyectoVersion(sfWebRequest $request)
  {
    $proyecto_version_id = $request->getParameter('proyecto_id');
    $uc = $this->getUser()->getAttribute('usuario_cargo');
    $cargo_actual = $uc->getPastoralCargo(); 
    if($proyecto_version_id!=null)
    {
      $uc2 = new PastoralUsuarioCargo();
      $uc2
            ->setUsuarioId($uc->getUsuarioId())
            ->setCargoId($cargo_actual)
            ->setProyectoVersionId($proyecto_version_id)
            ;
      $this->getUser()->setAttribute('usuario_cargo', $uc2); 
      $respuesta = array();
      $respuesta[0] = $uc2->getProyectoVersion()->getNombre();
      $respuesta[1] = $uc->getPastoralCargo()->getNombre();
      return $this->renderText(json_encode($respuesta));
    }
    else
    {
      $respuesta = array();
      $respuesta[0] = 'Pastoral UC';
      $respuesta[1] = $uc->getPastoralCargo()->getNombre();
      return $this->renderText(json_encode($respuesta));
    }
    
    return $this->renderText('');  
  } 
}
