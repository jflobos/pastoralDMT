<?php
/**
 * Handle file uploads via XMLHttpRequest
 */
class Estadisticas {
    public static function getEstadisticasProyectoVersion($proyecto_id){
        $retorno = array();        
        $retorno['totales'] = array();
        $retorno['totales']['sum'] = Estadisticas::procesarEstadisticasGenerales(Estadisticas::getEstadisticasProyectoVersionCore($proyecto_id)->fetchArray());
        $retorno['totales']['mujeres'] = Estadisticas::procesarEstadisticasGenerales(Estadisticas::getMujeresQuery(Estadisticas::getEstadisticasProyectoVersionCore($proyecto_id))->fetchArray());
        //UC en BD es el 15
        $retorno['uc'] = array();
        $retorno['uc']['sum'] = Estadisticas::procesarEstadisticasGenerales(Estadisticas::getUCQuery(Estadisticas::getEstadisticasProyectoVersionCore($proyecto_id))->fetchArray());
        $retorno['uc']['mujeres'] = Estadisticas::procesarEstadisticasGenerales(Estadisticas::getMujeresQuery(Estadisticas::getUCQuery(Estadisticas::getEstadisticasProyectoVersionCore($proyecto_id)))->fetchArray());
        return $retorno;        
    }
    public static function getEstadisticasProyectoGrupo($grupo_id){
        $retorno = array();        
        $retorno['totales'] = array();
        $retorno['totales']['sum'] = Estadisticas::procesarEstadisticasGenerales(Estadisticas::getEstadisticasGrupoCore($grupo_id)->fetchArray());
        $retorno['totales']['mujeres'] = Estadisticas::procesarEstadisticasGenerales(Estadisticas::getMujeresQuery(Estadisticas::getEstadisticasGrupoCore($grupo_id))->fetchArray());
        //UC en BD es el 15
        $retorno['uc'] = array();
        $retorno['uc']['sum'] = Estadisticas::procesarEstadisticasGenerales(Estadisticas::getUCQuery(Estadisticas::getEstadisticasGrupoCore($grupo_id))->fetchArray());
        $retorno['uc']['mujeres'] = Estadisticas::procesarEstadisticasGenerales(Estadisticas::getMujeresQuery(Estadisticas::getUCQuery(Estadisticas::getEstadisticasGrupoCore($grupo_id)))->fetchArray());
        return $retorno;        
    }
     protected static function getEstadisticasGeneralesCore(){
        $q = Doctrine_Query::create()
                ->select('pep.id, pep.nombre,COUNT(pep.id)')
                ->from('PastoralEstadoPostulacion pep')
                ->leftJoin('pep.PastoralMisionUsuarioEstado pmue')
                ->leftJoin('pmue.PastoralUsuario pu')
                ->leftJoin('pmue.PastoralMision pm')
                ->leftJoin('pm.PastoralLocalidadFantasia plf')
                ->leftJoin('pm.PastoralGrupo pg')
                ->leftJoin('pg.PastoralProyectoVersion ppv')
                ->groupBy('pep.id');
        return $q;
    }
    protected static function getEstadisticasProyectoVersionCore($proyecto_id){
        $q = Estadisticas::getEstadisticasGeneralesCore()                
                ->where('ppv.id = ?', $proyecto_id);        
        return $q;
    }
    protected static function getEstadisticasGrupoCore($grupo_id){
        $q = Estadisticas::getEstadisticasGeneralesCore()                
                ->where('pg.id = ?', $grupo_id);
        return $q;
    }    
    protected static function getUCQuery($query){
        $query->leftJoin('pu.PastoralUniversidad as puni')
                ->andWhere('puni.id = 15'); 
        return $query;
    }    
    protected static function getMujeresQuery($query){
        $query->andWhere('pu.sexo = ?','Femenino'); 
        return $query;
    }
    protected static function procesarEstadisticasGenerales($data){
        $retorno = array(
            'inscritos' => 0,
            'bajas' => 0,
            'aceptados' => 0,
            'pendientes' => 0,
            'confirmados'=> 0);
        foreach($data as $field){
            //Filtramos en base al id del estado de postulacion
            switch($field['id']){
                case 1:
                    $retorno['bajas']+=$field['COUNT'];
                    break;
                case 2:
                    $retorno['pendientes']+=$field['COUNT'];
                    break;
                case 3:
                    $retorno['aceptados']+=$field['COUNT'];
                    break;
                case 4:
                    $retorno['confirmados']+=$field['COUNT'];
                    break;
                case 5:
                    $retorno['bajas']+=$field['COUNT'];
                    break;
                case 6:
                    $retorno['bajas']+=$field['COUNT'];
                    break;
                case 7:
                    $retorno['confirmados']+=$field['COUNT'];
                    break;
            }
        }
        $retorno['inscritos'] = $retorno['bajas'] + $retorno['pendientes'] + $retorno['aceptados'] + $retorno['confirmados'];
        return $retorno;
    }    
}