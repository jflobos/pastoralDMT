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
          
<!----------------------------------------------------------------------------------------------------------------------
----------------------------------------------------- MODAL ------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------->
            <div class="modal hide fade in" id="cuota_modal_instantaneas" value="0">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h3 class="nombre_usuario">Cambio de Cuota</h3>
                </div>
                <div class="modal-body">
                <?php
                    if($editarCuota){
                        echo "<input id='cuota_nueva_inmediata' type='numbers' placeholder='cuota'></input>";
                     }?>
                </div>
                <div class="modal-footer">
                    <span href="#" class="btn" data-dismiss="modal">Cerrar</span>
                    <span class="btn btn-primary" id="cambio_cuota_inmediata">Cambiar</span>
                </div>
            </div>

            <div class="modal hide fade in" id="estados_modal_instantaneas" value="0">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h3 class="nombre_usuario">Cambio de Estado</h3>
                </div>
                <div class="modal-body">
                <?php
                    if($editarEstado){
                        echo "<select class='btn' id ='estados_instantaneas' class='btn' >";
                        foreach($estados_posibles as $e){
                            echo '<option value="'.$e->getId().'">'.$e->getNombre().'</option>';
                        }
                        echo "</select>";
                    }?>
                </div>
                <div class="modal-footer">
                    <span class="btn" data-dismiss="modal">Cerrar</span>
                    <span class="btn btn-primary" id="cambio_estado_inmediata">Cambiar</span>
                </div>
            </div>
            
            <div class="modal hide fade in" id="cargos_modal_instantaneas"  value="0">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h3 class="nombre_usuario">Cambio de Cargo</h3>
                </div>
                <div class="modal-body">
                <?php
                    if($editarCargo){
                        echo "<select class='btn' id ='cargos_instantaneas' class='btn' >";
                        echo '<option value="-1">misionero-voluntario</option>';
                        foreach($cargos_posibles as $c){
                            echo '<option value="'.$c->getId().'">'.$c->getNombre().'</option>';
                        }
                        echo "</select>";
                    }?>
                </div>
                <div class="modal-footer">
                    <span class="btn" data-dismiss="modal">Cerrar</span>
                    <span class="btn btn-primary" id="cambio_cargo_inmediata">Cambiar</span>
                </div>
            </div>
            
            <div class="modal hide fade in" id="misiones_modal_instantaneas"  value="0">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h3 class="nombre_usuario">Cambio de Zona</h3>
                </div>
                <div class="modal-body">
                <?php
                    if($editarMision){
                        echo "<select class='btn' id ='misiones_instantaneas' class='btn' >";
                        foreach($misiones_activas as $m){
                            echo "<option value='".$m->getId()."'>".$m->getPastoralLocalidadFantasia()->getNombre()."</option>";
                        }
                        echo "</select>";
                    }?>
                </div>
                <div class="modal-footer">
                    <span class="btn" data-dismiss="modal">Cerrar</span>
                    <span class="btn btn-primary" id="cambio_zona_inmediata">Cambiar</span>
                </div>
            </div>
            
            <?php
              if(!$sf_user->getAttribute('usuario_cargo')->getMisionId()>0)
              {
                  echo "<select class='btn' id ='misiones_postulantes' class='btn' >";
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
                  echo "<select class='btn' disabled='disabled' id='misiones_postulantes'>";
                  echo "<option value='".$misiones_activas[0]->getId()."' selected='selected'>";  
                  echo $misiones_activas[0]->getPastoralLocalidadFantasia()->getNombre();
                  echo '</option>';
                  echo "</select></td>";
              }
            ?>
          <td>
            <?php
                echo " <select id ='estados_postulantes' class='btn' ><option value= '-1' selected='selected'>&#8212;&#8212; Filtro Estado &#8212;&#8212;</option>";
                foreach($estados_posibles as $e)
                {
                    echo '<option value="'.$e->getId().'">';                    
                    echo $e->getNombre();
                    echo '</option>';
                }
                echo "</select>";
            ?>
            
          </td>
         
          <?PHP if($cargo->getCVEBFlagZona()==1 || $cargo->getCVEBFlagCuota()==1)
          {?>
              <td>
                <select id='flag_postulante' class="btn">
                  <option value= '-1' selected='selected'>&#8212;&#8212; Filtro Solicitud &#8212;&#8212;</option>
                  <?php
                  if($cargo->getCVEBFlagZona()==1){
                      echo "<option value= '1'>Solicitud Zona</option>";
                    }
                  if($cargo->getCVEBFlagCuota()==1){
                      echo "<option value= '2'>Solicitud Cuota</option>";
                    }
                  ?>
                </select>
              </td>
    <?php } ?>
        </tr>
      </table>
   </div>

<!------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------INFO USUARIOS--------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------->

<h1 class='acciones_seleccionados'><small>Edición</small></h1>
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
          <td>
            <?php 
                if($cargo->getEInscritosEstado() ==1){
                    echo "<select id='estado_nuevo'><option value='-1'>&#8212;&#8212; Estado &#8212;&#8212;</option>";
                }else{
                    echo "<select id='estado_nuevo' disabled='disabled' ><option value='-1'>&#8212;&#8212; Estado &#8212;&#8212;</option>";
                }
                foreach($estados_posibles as $e)
                {
                    echo '<option value="'.$e->getId().'">';  
                    echo $e->getNombre();
                    echo '</option>';
                }
                echo "</select>";
            ?>
            </td>
          <td>
            <?php 
                if($cargo->getEInscritosCargo() ==1){
                  echo "<select  id='cargo_nuevo' ><option value='-1'>&#8212;&#8212; Cargo &#8212;&#8212;</option>";
                }else{
                  echo "<select  id='cargo_nuevo' disabled='disabled' ><option value='-1'>&#8212;&#8212; Cargo &#8212;&#8212;</option>";
                }
                foreach($cargos_posibles as $c)
                {
                    echo '<option value="'.$c->getId().'">';  
                    echo $c->getNombre();
                    echo '</option>';
                }
                echo "</select>";
            ?>
            </td>
          <td>
              <?php 
              if($cargo->getEInscritosCuota() ==1){
                  echo "<input id='cuota_nueva' type='numbers' placeholder='cuota'></input>";
              }?>
          </td>
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
        <button class="btn btn-mini download_excel" title="Descargar lista a Excel"><img src="/images/excel.bmp" width="14" height="20"></button>      
      </div>
    </div>
<!------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------TABLA----------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------->
    <table class="table-compact table-bordered" cellpadding="5" id="postulantes_content"></table>
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