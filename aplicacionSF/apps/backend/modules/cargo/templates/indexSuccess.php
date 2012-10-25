<br/>
<h1>Historial de Participaciones <small><?php echo($usuario->getNombreCompleto())?></small></h1>
<br/>

<h1><small>Cargos</small></h1>
<?php if($pastoral_usuario_cargos->count()>0):?>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Cargo</th>
        <th>Proyecto Versi&oacute;n</th>
        <th>Grupo</th>
        <th>Zona</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pastoral_usuario_cargos as $pastoral_usuario_cargo): ?>
      <tr>
        <td><?php echo "<a href='".url_for('cargo/index')."?uc_id=".$pastoral_usuario_cargo->getId()."' value='".$pastoral_usuario_cargo->getId()."'>".$pastoral_usuario_cargo->getPastoralCargo()->getNombre()."</a>" ?></td>
        <?php if($pastoral_usuario_cargo->getMisionId()>0):
          $mision = $pastoral_usuario_cargo->getPastoralMision();
          $grupo  = $mision->getPastoralGrupo();
          $pv     = $grupo->getPastoralProyectoVersion();
          echo "<td>".$pv->getNombre()."</td>";
          echo "<td>".$grupo->getNombre()."</td>";
          echo "<td>".$mision->getNombre()."</td>";
          elseif($pastoral_usuario_cargo->getGrupoId()>0):
          $grupo  = $pastoral_usuario_cargo->getPastoralGrupo();
          $pv     = $grupo->getPastoralProyectoVersion();
          echo "<td>".$pv->getNombre()."</td>";
          echo "<td>".$grupo->getNombre()."</td>";
          echo "<td></td>";
          elseif($pastoral_usuario_cargo->getProyectoVersionId()>0):
          $pv = $pastoral_usuario_cargo->getPastoralProyectoVersion();
          echo "<td>".$pv->getNombre()."</td>";
          echo "<td></td>";
          echo "<td></td>";
          else:
          echo "<td></td>";
          echo "<td></td>";
          echo "<td></td>";
        endif;
        ?>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  
<?php else: 
    echo "<div class='alert alert-info'>".$usuario->getNombreCompleto()." no tiene cargos.</div>";
endif; ?>  

<h1><small>Misiones</small></h1>

<?php if($misiones->count()>0):?>

  <table class="table table-bordered ">
    <thead>
      <tr>
        <th>Proyecto Versi&oacute;n</th>
        <th>Grupo</th>
        <th>Zona</th>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($misiones as $mue): ?>
      <tr>
        <?php 
          $mision = $mue->getPastoralMision();
          $grupo  = $mision->getPastoralGrupo();
          $pv     = $grupo->getPastoralProyectoVersion();
          echo "<td>".$pv->getNombre()."</td>";
          echo "<td>".$grupo->getNombre()."</td>";
          echo "<td>".$mision->getPastoralLocalidadFantasia()->getNombre()."</td>";
          echo "<td>".$mue->getPastoralEstadoPostulacion()->getNombre()."</td>";
        ?>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: 
    echo "<div class='alert alert-info'>".$usuario->getNombreCompleto()." no se ha inscrito a misiones.</div>";
endif; ?>  