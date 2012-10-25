<div class="page-header">
  <h1>Evaluaci&oacute;n Post Misi&oacute;n <small>Pastoral UC</small></h1>
</div>

<div>
  <h3 fontsize="8">Sede de Talleres de la Zona XXX<br><small>Ingrese los datos que se solicitan</small></h3>
</div>

<div align="right">
  <button align="right" title="nueva sede" style="background-color:white" class="btn"><img src="http://openclipart.org/image/250px/svg_to_png/16951/jean_victor_balin_add_blue.png" width="15" height="15"/></button>
</div>  

<?php foreach ($sedes as $sede):?>
<div class="accordion-heading">
    <div class="accordion" id="infoJefes">
        <div class="accordion-group">  
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoJefes" href="#sede<?php echo $sede->getId() ?>">
                <h4><i class="icon-chevron-down"></i>   <?php echo $sede->getNombre() ?></h4>
            </a>
        </div>                           
        <div id="sede<?php echo $sede->getId() ?>" class="accordion-body collapse">
            <div class="accordion-inner">
                <h3>Direccion: <small><?php echo $sede->getDireccion() ?></small></h3>               
                <table  class= "table table-bordered">
                    <thead>
                      <tr>
                          <th fontsize="10" nowrap="nowrap">Encargado</th>
                          <th fontsize="10" nowrap="nowrap">Cargo</th>
                          <th fontsize="10" nowrap="nowrap">Tel&eacute;fono</th>
                          <th></th>
                      </tr>
                    </thead>
                    <tbody>    
                        <?php foreach($contactos_all as $contacto):?>
                        <?php if($contacto->getLugarId() == $sede->getId()):?>
                        <tr>
                            <td fontsize="8" nowrap="nowrap"><?php echo $contacto->getNombre() ?></td>
                            <td fontsize="8" nowrap="nowrap"><?php echo $contacto->getCargo()?></td>
                            <td fontsize="8" nowrap="nowrap"><?php echo $contacto->getTelefono()?></td>
                            <td>
                                <div class = "btn-group">
                                    <button title="editar contacto" style="background-color:white" class="btn"><img src="http://openclipart.org/image/250px/svg_to_png/122155/1298512738.png"  width="15" height="18"/></button>     
                                    <button title="eliminar contacto" style="background-color:white" class="btn"><img src="http://openclipart.org/image/250px/svg_to_png/68/Andy_Trash_Can.png"  width="15" height="18"/></button>
                                </div>
                            </td>
                        </tr>
                        <?php endif;endforeach; ?>
                        <tr style="border-color:white">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><button align="right" title="nuevo contacto" style="background-color:white" class="btn"><img src="http://openclipart.org/image/250px/svg_to_png/5578/msewtz_Business_Person.png" width="15" height="15"/></button></td></tr>
                    </tbody>
                </table>
                <h3>Comentarios</h3>
                <h4><small>¿Recomendarias este lugar?, ¿c&oacute;mo conseguirlo?, ¿qu&eacute; hay que llevar?</small></h4>
                <textarea class="input-xlarge"></textarea>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<button align = "center" name = "salir sin enviar" value = "Salir sin enviar"  class="btn sin_enviar">Salir sin enviar</button>
<button align = "center" name = "Enviar" value = "Enviar" class="btn btn-primary con_enviar">Enviar</button>
