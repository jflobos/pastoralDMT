<div class="page-header">
  <h1> <?php echo $pastoral_proyecto_version->getNombre() ?></h1>
  <h1><small>Agregar m&aacute;s jefes</small></h1>
</div>

<input type="hidden"  id="id_proyecto" value="<?php echo $pastoral_proyecto_version->getId() ?>"></input>

<div class="page-header">
    <tr><td><b>Cargo:</b></td> 
        <td>
          <?php
          echo "<select id ='cargo_nuevo' class='chzn-select' name='cargo_nuevo'>";               
              echo '<option value="-1"  id="-1"> </option>';
              echo '<option value="'.$cargo_nacional->getId().'">Jefe Nacional</option>';
              echo '<option value="'.$cargo_inscripciones->getId().'">Jefe de Inscripciones</option>'; 
              echo '<option value="'.$cargo_finanzas->getId().'">Jefe de Finanzas</option>';
              echo '<option value="'.$cargo_extranjeros->getId().'">Jefe de Extranjeros</option>';            
          echo "</select>";
          ?>
        </td>
    </tr>
</div>


<div class="page-header">
    <tr><td><b>Jefe:</b></td> 
        <td>
          <?php
          echo "<select id ='jefe_nuevo' class='chzn-select' name='jefe_nuevo'>";
          echo '<option value=""  id=""></option>';
          // Opciones a elegir
          foreach($posibles_jefes as $u){
            echo '<option value="'.$u->getId().'">';
            echo $u;   
            echo '</option>';
          }
          echo "</select>";
          ?>     
        </td>
    </tr>
</div>

<div class="page-header">
&nbsp;<a href="<?php echo url_for('/index.php/proyecto/menuInstancia?id='.$pastoral_proyecto_version->getId().'') ?>"><b>Volver</b></a>
<button type="button" id="submit_mas_jefes" name= "submit_mas_jefes"> Guardar </button>
</div>
