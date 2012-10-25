<div class="page-header">
  <h1> <?php echo $pastoral_proyecto_version->getNombre() ?></h1>
  <h1><small>Editar Jefe <?php echo $cargo?></small></h1>
</div>

<input type="hidden"  id="id_proyecto" value="<?php echo $pastoral_proyecto_version->getId() ?>"></input>
<input type="hidden" id="id_cargo" value="<?php echo $id_cargo ?>"></input>

<?php if($jefeEditar!=null){ ?>
    <input type="hidden" id="id_jefe_viejo" value="<?php echo $jefeEditar->getId() ?>"></input>
<?php } else{ ?>
    <input type="hidden" id="id_jefe_viejo" value="-1"></input>
<?php } ?>


<div class="page-header">

    <tr><td><b>Seleccione el Jefe <?php echo $cargo?>:</b></td> 
        <td>
          <?php
          echo "<select id ='jefe_editar' class='chzn-select' name='jefe_editar'>";
          // Jefe seleccionado:
          if($jefeEditar!=null)
          {
            echo '<option value="'.$jefeEditar->getId().'" selected="selected">';  
            echo $jefeEditar.' - ACTUAL';									
            echo '</option>'; 
          }
          else{
             echo '<option value=""  id="">- Seleccione el jefe que desea -</option>';
          }
          // Opciones a elegir
          foreach($posibles_jefes as $u){ 			
            if($u->getId()!=$jefeEditar->getId()){              
              echo '<option value="'.$u->getId().'">'; 
              echo $u;   
              echo '</option>';                
            }
          }
          echo "</select>";
          ?>

          
        </td>
    </tr>
</div>

<div class="page-header">
&nbsp;<a href="<?php echo url_for('/index.php/proyecto/menuInstancia?id='.$id.'') ?>"><b>Volver</b></a>
<button type="button" id="submit_eliminar_jefe" name= "submit_eliminar_jefe"> Eliminar </button>
<button type="button" id="submit_editar_jefe" name= "submit_editar_jefe"> 
Guardar
</button>
</div>
