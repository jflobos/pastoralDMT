<div class="page-header">
  <h1>Inscritos <small>Pastoral UC</small></h1>
</div>
<!----------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------FILTROS------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------->
<?php if($misiones_activas->count()>0):?>
<div class="row-fluid">
  <h1><small>Filtros</small></h1>
  <h1 id='testing'></h1>
    <div class="span12">
      <table>
        <tr>
          <td>
            <?php
              if(!$sf_user->getAttribute('usuario_cargo')->getMisionId()>0)
              {
                  echo "<select id ='misiones_postulantes' class='btn change_table' >";
                  echo "<option value= '-1' selected='selected'>&#8212;&#8212; Filtro Zona &#8212;&#8212;</option>";
                  foreach($misiones_activas as $m)
                  {
                      echo '<option value="'.$m->getId().'">';  
                      echo $m->getPastoralLocalidadFantasia()->getNombre()." - ".$m->getPastoralGrupo()->getNombre();
                      echo '</option>';
                  }
                  echo "</select></td>";
              }
              else
              {
                  echo "<select disabled='disabled' id='misiones_postulantes' class='btn change_table'>";
                  echo "<option value='".$misiones_activas[0]->getId()."' selected='selected'>";  
                  echo $misiones_activas[0]->getPastoralLocalidadFantasia()->getNombre();
                  echo '</option>';
                  echo "</select></td>";
              }
            ?>
          <td>
            <?php
                echo " <select id ='estados_postulantes' class='btn change_table' ><option value= '-1' selected='selected'>&#8212;&#8212; Filtro Estado &#8212;&#8212;</option>";
                foreach($estados_posibles as $e)
                {
                    echo '<option value="'.$e->getId().'">';  
                    echo $e->getNombre();
                    echo '</option>';
                }
                echo "</select>";
            ?>
          </td>
        </tr>
      </table>
   </div>

<!------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------INFO USUARIOS--------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------->

<h1 class='acciones_seleccionados'><small>Edici&oacute;n</small></h1>
  <div class="span12">
    <table>
       <tr class='acciones_seleccionados'>
          <td>
          
            <?php
              if(!$sf_user->getAttribute('usuario_cargo')->getMisionId()>0)
              {  
                  if($cargo->getEInscritosMision() ==1){
                      echo "<select id='mision_nueva'>";
                  }else{
                      echo "<select disabled='disabled' id='mision_nueva'>";
                  }
                  echo "<option value= '-1' selected='selected'>&#8212;&#8212; Zona &#8212;&#8212;</option>";
                  foreach($misiones_activas as $m)
                  {
                      echo '<option value="'.$m->getId().'" zona="'.$m->getPastoralLocalidadFantasia()->getNombre().'" cuota="'.$m->getCuota().'">';  
                      echo $m->getPastoralLocalidadFantasia()->getNombre().' - '.$m->getPastoralGrupo()->getNombre();
                      echo '</option>';
                  }
                  echo "</select></td>";
              }
              else
              {
                    echo "<select class='btn' disabled='disabled' id='mision_nueva'>";
                    echo "<option value='".$misiones_activas[0]->getId()."' selected='selected'>";  
                    echo $misiones_activas[0]->getPastoralLocalidadFantasia()->getNombre();
                    echo '</option>';
                    echo "</select></td>";
              }
            ?>
          <td><button class='btn btn-warning guardar_cambios'>Editar</button></td>
          
        </tr>
    </table>
  </div>
<h1><small>Inscritos</small></h1>
<!-----------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------ACCIONES CHECKBOX---------------------------------------------------
------------------------------------------------------------------------------------------------------------------------>
  <!-- WARNING NOTHING SELECTED -->
<div class="alert alert-info row"  id="info_tabla_vacia" style="text-align:center;margin:0 auto 0 auto;"></div>
  <div class="span12">
    <div id="aciones_y_botones" class="btn-toolbar">
      <div class="btn-group ">
        <button class="btn btn-mini select_all"><i class="icon-check"></i></button>
        <button class="btn btn-mini select_none"><i class="icon-edit"></i></button>     
      </div>
    </div>
<!------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------TABLA----------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------->
    <table class="table table-bordered" cellpadding="5" id="postulantes_content"></table>
    <div id="paginacion"></div>
    <input type="hidden" id="pagina" value="1"></input>
  </div>
  
  <!------------------------------------------------------------------------------------------------------------------------
---------------------------------------------------INFO USUARIOS----------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------->
  <div id="flag_zona_information"></div>
  <div id="info_usuarios"></div>
  
<!------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------FLAGS----------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------->
  <div id="flag_cuota_information"></div>

<!------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------JS-----------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------->
</div>
<?php else:?>
  <div class="alert alert-error">
  <br/><br/>Lo sentimos, no hay zonas activas.
  <br/><br/><br/>
  </div>
<?php endif; ?>