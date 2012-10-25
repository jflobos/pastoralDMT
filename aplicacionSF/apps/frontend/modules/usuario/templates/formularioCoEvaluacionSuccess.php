<div class="page-header">
  <h1>Coevaluaci&oacute;n<small>Pastoral UC</small></h1>
</div>

<div>
  <h3 fontsize="8">Voluntarios de la Zona <?php echo $mues[0]->getPastoralMision()->getNombre()?><br><small>Marque m&aacute;ximo a 6 voluntarios (3 hombres y 3 mujeres) que usted recomendar&iacute;a para tener cargos con m&aacute;s responsabilidades en futuros proyectos</small></h3>
  </div>
<table  class= "table table-bordered">
  <thead>
    <tr>
      <th fontsize="10" nowrap="nowrap">Nombre</th>
      <th fontsize="10" nowrap="nowrap">Edad</th>
      <th fontsize="10" nowrap="nowrap">Sexo</th>
      <th fontsize="10" nowrap="nowrap">Estudios</th>
      <th fontsize="10" nowrap="nowrap">Carrera</th>
      <?php if(!$enviado):?>
          <th fontsize="10" nowrap="nowrap">Recomendaci&oacute;n</th>
      <?php endif;?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($mues as $mue):$pastoral_usuario = $mue->getPastoralUsuario();if($pastoral_usuario->debioIrAMision($mue->getMisionId())): ?>
    <tr>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getNombreCompleto() ?></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getEdad() ?></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getSexo() ?></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getEstudios()?></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getEstudios2()?></td>
      <?php if(!$enviado):?>
          <td fontsize="8" class="max3<?php if($pastoral_usuario->getSexo()=='Masculino'){echo 'm';}else{echo 'f';} ?>" nowrap="nowrap"><input type="CHECKBOX" name= "recomiendo" value= "<?php echo($mue->getId());?>"></input></td>
      <?php endif;?>
    </tr>
    <?php endif;endforeach; ?>
  </tbody>
</table>

<?php if(!$enviado):?>
    <div class="alert alert-info" id="mensaje_enviado"></div>
    <br/>
    <br/>
    <button align = "center" name = "Enviar" value = "Enviar" class="btn btn-primary con_enviar">Enviar</button>
<?php endif;?>

  <!--<a href="<?php echo url_for('usuario/new') ?>">New</a>-->


<script type="text/javascript" src="/js/bootstrap-dropdown.js"></script>
<script type="text/javascript" src="/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="/js/coEvaluacion.js"></script>

