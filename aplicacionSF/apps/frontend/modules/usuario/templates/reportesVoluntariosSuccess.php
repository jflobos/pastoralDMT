<div class="page-header">
  <h1>Reportes Voluntarios<small>Pastoral UC</small></h1>
</div>

<div>
  <h3 fontsize="8">Voluntarios Recomendados</h3>
</div>

 <select class="span2">
 <!-- proyecto -->
   <?php foreach($proyectos as $proyecto): ?> 
   <option value="<?php echo $proyecto->getId()?>"> <?php echo $proyecto->getNombre()?></option>
   <?php endforeach;?> 
 </select>
 
 <select class="span2">
 <!-- version -->
   <?php foreach($proyectos as $proyecto): ?> 
   
   <?php endforeach?> 
 </select>
 
 <select class="span2">
 <!-- año -->
   <option value="2008">2008</option>
   <option value="2009">2009</option>
   <option value="2010">2010</option>
   <option value="2011">2011</option>
 </select>
 
 <select class="span2">
 <!-- Universidad -->
   <?php foreach($universidades as $universidad): ?> 
   <option value="<?php echo $universidad->getId()?>"> <?php echo $universidad->getNombre()?></option>
   <?php endforeach?> 
 </select>
 
 <select class="span2">
  <option value="masculino">Masculino</option>
  <option value="femenino">Femenino</option> 
 </select>
 
 <table  class= "table table-bordered">
  <thead>
    <tr>
      <th fontsize="10" nowrap="nowrap">Nombre</th>
      <th fontsize="10" nowrap="nowrap">Edad</th>
      <th fontsize="10" nowrap="nowrap">Estudios</th>
      <th fontsize="10" nowrap="nowrap">Carrera</th>
      <th fontsize="10" nowrap="nowrap">Celular</th>
      <th fontsize="10" nowrap="nowrap">RJ</th>
      <th fontsize="10" nowrap="nowrap">RC</th>      
    </tr>
  </thead>
  <tbody>
  <!--ACA EL IF TIENE QUE SER ¿TIENE ALGÚN TIPO DE RECOMENDACIÓN?-->
    <?php foreach ($mues as $mue):$pastoral_usuario = $mue->getPastoralUsuario();if($pastoral_usuario->debioIrAMision($mue->getMisionId())): ?>
    <tr>
      <td fontsize="8" nowrap="nowrap"><a data-toggle="modal" href="#informacion_usuario_<?php echo $pastoral_usuario->getId()?>"><?php echo $pastoral_usuario->getNombreCompleto() ?></a></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getEdad() ?></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getEstudios()?></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getEstudios2()?></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getTelefonoCelular()?></td>   
      <!--<td fontsize="8" nowrap="nowrap"><?php //echo $pastoral_usuario->getRecomendacionJefe()?></td>
      <td fontsize="8" nowrap="nowrap"><?php //echo $pastoral_usuario->getRecomendacionCompañeros()?></td>-->   
    </tr>
    <?php endif;endforeach; ?>
  </tbody>
</table>

<?php foreach($mues as $mue):$pastoral_usuario = $mue ->getPastoralUsuario(); ?>
<div id="informacion_usuario_<?php echo $pastoral_usuario->getId()?>" class="modal hide">
<div class="modal-header"><button class="close" data-dismiss="modal">&times;</button><h3>Historial de <?php echo $pastoral_usuario->getNombreCompleto() ?><h3></div>
<div class="modal-body"><table  bordercolor="white">
  <tbody>
      <tr><th>n° Asistencias:</th><td nowrap="nowrap">#</td>                                                                              </tr>
      <tr><th>Cargos Anteriores</th><td nowrap="nowrap">"todos los cargos anteriores para este proyecto"</td>      </tr>
      <tr><th>Comentarios</th><td nowrap="nowrap">"todos los comentarios para estos cargos (con autor)"</td>      </tr>
  </tbody>
</table>
</div>
  <div class="modal-footer">
    <a href="#" class ="btn" data-dismiss = "modal">Cerrar</a>
      </div>
</div>
<?php endforeach; ?>


