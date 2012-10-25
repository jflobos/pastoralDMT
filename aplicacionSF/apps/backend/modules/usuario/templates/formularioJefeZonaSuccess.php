<div class="page-header">
  <h1>Evaluaci&oacute;n Post Misi&oacute;n <small>Pastoral UC</small></h1>
</div>
<div>
  <h3 fontsize="8">Voluntarios de la Zona <?php echo $mues[0]->getPastoralMision()->getNombre()?><br><small>Marque maximo a 6 voluntarios que usted recomendaria para tener cargos mas altos</small></h3>
  </div>

    <div id="aciones_y_botones" class="btn-toolbar">
      <div class="btn-group ">
      <?php if($enviado==0):?>
            <button class="btn btn-mini select_all" ><i class="icon-check"></i></button></button>
            <button class="btn btn-mini select_none"><i class="icon-edit"></i></button></button>
        <?php endif;?>
      </div>
    </div>
<table  class= "table table-bordered">
  <thead>
    <tr>
      <th fontsize="10" nowrap="nowrap">Nombre</th>
      <th fontsize="10" nowrap="nowrap">Edad</th>
      <th fontsize="10" nowrap="nowrap">Sexo</th>
      <th fontsize="10" nowrap="nowrap">Estudios</th>
      <th fontsize="10" nowrap="nowrap">Carrera</th>
      <th fontsize="10" nowrap="nowrap">Asistencia</th>
      <th fontsize="10" nowrap="nowrap">Recomendaci&oacute;n</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($mues as $mue):$pastoral_usuario = $mue->getPastoralUsuario();if($pastoral_usuario->debioIrAMision($mue->getMisionId())): ?>
    <tr>
      <td fontsize="8" nowrap="nowrap"><a data-toggle="modal" href="#informacion_usuario_<?php echo $pastoral_usuario->getId()?>"><?php echo $pastoral_usuario->getNombreCompleto() ?></a></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getEdad() ?></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getSexo() ?></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getEstudios()?></td>
      <td fontsize="8" nowrap="nowrap"><?php echo $pastoral_usuario->getEstudios2()?></td>
      <td fontsize="8" nowrap="nowrap">
          <input <?php if($pastoral_usuario->fueAMision($mue->getMisionId())==1){echo'checked="yes" ';}if($enviado){echo'disabled="disabled"';}  ?> type="CHECKBOX"  name ="asistio" value ="<?php echo($mue->getId());?>"></input>
      </td>
      <td fontsize="8" class="max3<?php if(!$enviado):if($pastoral_usuario->getSexo()=='M'){echo 'm';}else{echo 'f';} endif;?>" nowrap="nowrap">
      <?php
          if($enviado){
              if($mue->getRecomendadoPorJefes()==1){
                  echo ("<input type='CHECKBOX' checked='yes' disabled='disabled' name= 'recomiendo' value= ".$mue->getId()."></input>");
              }else{
                  echo ("<input type='CHECKBOX' disabled='disabled' name= 'recomiendo' value= ".$mue->getId()."></input>");
              }
          }else{
              if($mue->getMarcadoPorJefes()==1){
                  echo ("<input type='CHECKBOX' checked='yes' name= 'recomiendo' value= ".$mue->getId()."></input>");
              }else{
                  echo ("<input type='CHECKBOX' name= 'recomiendo' value= ".$mue->getId()."></input>");
              }
          }
      ?>
      </td>
    </tr>
    <?php endif;endforeach; ?>
  </tbody>
</table>

<?php foreach($mues as $mue):$pastoral_usuario = $mue ->getPastoralUsuario(); ?>
<div id="informacion_usuario_<?php echo $pastoral_usuario->getId()?>" class="modal hide">
<div class="modal-header"><button class="close" data-dismiss="modal">&times;</button><h3><?php echo $pastoral_usuario->getNombreCompleto() ?><h3></div>
<div class="modal-body"><table  bordercolor="white">
  <tbody>
      <tr><th>Edad</th><td nowrap="nowrap"><?php echo $pastoral_usuario->getEdad() ?></td>                                                        </tr>
      <tr><th>Sexo</th><td nowrap="nowrap"><?php echo $pastoral_usuario->getSexo() ?></td>                                                       </tr>
      <tr><th>Estudios</th><td nowrap="nowrap"><?php echo $pastoral_usuario->getEstudios()?></td>                              </tr>
      <tr><th>Carrera</th><td nowrap="nowrap"><?php echo $pastoral_usuario->getEstudios2()?></td>                               </tr>
      <tr><th>Comuna</th><td nowrap="nowrap"><?php echo $pastoral_usuario->getPastoralComuna()->getNombre()?></td>             </tr>
      <tr><th>Movimiento</th><td nowrap="nowrap"><?php echo $pastoral_usuario->getPastoralMovimiento()->getNombre()?></td>     </tr>
      <tr><th>Alergias/Enfermedades</th><td nowrap="nowrap"><?php echo $pastoral_usuario->getEnfermedadesAlergias()?></td>                           </tr>
  </tbody>
</table>
<h3>COMENTARIO</h3>
<textarea class="input-xlarge" id="textarea_<?php echo $mue->getId();?>" <?php if($enviado){echo'disabled="disabled"';}?> rows="4"><?php echo $mue->getEvalDescripcion()?></textarea></div>
  <div class="modal-footer">
    <a href="#" class ="btn" data-dismiss = "modal">Cerrar</a>
    <?php if(!$enviado):?>
        <a href="#" class ="btn btn-primary guardar_comentarios_usuario" value ="<?php echo $mue->getId();?>" data-dismiss = "modal">Guardar</a>
     <?php endif; ?>
  </div>
</div>
<?php endforeach; ?>


<?php if(!$enviado){?>
    <div class="alert alert-info" id="mensaje_enviado"></div>
    <br/>
    <br/>
    <button align = "center" name = "salir sin enviar" value = "Salir sin enviar"  class="btn sin_enviar">Salir sin Enviar</button>
    <button align = "center" name = "Enviar" value = "Enviar" class="btn btn-primary con_enviar">Enviar</button>
<?php } ?>

  <!--<a href="<?php echo url_for('usuario/new') ?>">New</a>-->