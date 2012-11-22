<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]--> 
<?php $cargo = $sf_user->getAttribute('usuario_cargo')->getPastoralCargo();?>
<div>    
<div class="page-header">
 <h1><?php echo $pastoral_mision->getNombre() ?> <small>Pastoral UC</small></h1>
</div>
<div style="margin-bottom: 10px;">
    <a href="<?php echo url_for('mision/index') ?>"><button class="btn btn-info">Atr&aacute;s</button></a>
    <?php if($cargo_actual->getEMisiones()!=0): ?> 
    <a href="<?php echo url_for('mision/edit?id='.$pastoral_mision->getId()) ?>"><button class="btn btn-info">Editar zona</button></a>
    <?php endif; ?> 
 </div> 
<!-- Tabla con detalles de las inscripciones -->
<div>
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Localidad</th>
      <th>Grupo</th>
      <th>Inscritos&nbsp;/&nbsp;Cupos</th>
      <th>Mujeres</th>
      <th>Inscritos UC</th>
      <th>Lugar de salida</th>
      <th>Cuota</th>
      <th>Estado inscripciones</th>
      <th>Estado en web proyecto</th>
    </tr>
  </thead>
  <tbody>
    <?php 
	    $countHombres = $pastoral_mision->countHombres();
	    $countMujeres = $pastoral_mision->countMujeres();
	    $total = $countHombres+$countMujeres;
	    $universidad = Doctrine_Core::getTable('PastoralUniversidad')->find(15);
	    $totalUc = $universidad->cantidadPorMision($pastoral_mision->getId());    
	    $zona_filtro = Doctrine_Core::getTable('PastoralMisionFiltro')->findByMisionId($pastoral_mision->getId());
	    $cupos = '&infin;';
	    if($zona_filtro!= null)
	    {
	      foreach($zona_filtro as $zf)
	      {
	      if($zf->getPastoralFiltro()->getNombre() == 'Total de inscritos')
	          $cupos = $zf->getParametros();
	      }
	    }
    ?>
    <tr>
        <td><a title='Ver Localidad' href="<?php echo url_for("localidad/show?id=".$pastoral_mision->getLocalidadId()); ?>">
          <?php echo $pastoral_mision->getPastoralLocalidad()->getNombre()?></a>
          <a class="btn btn-mini right" title="Elegir Localidad"
          href="<?php echo url_for('localidad/unirAZona').'?mision_id='.$pastoral_mision->getId();?>">
          <i class="icon-pencil"></i></a>
        </td>
        <td><?php echo $pastoral_mision->getPastoralGrupo()->getNombre()?></td>
        <td id="centrar"><?php echo $total.' / '.$cupos?></td>    
        <td id="centrar"><?php if($total!=0) {echo $countMujeres.' ('.round($countMujeres*100/($total)).'&#37;)';}?></td>        
        <td id="centrar"><?php if($total!=0) {echo $totalUc.' ('.round($totalUc*100/($total)).'&#37;)';}?></td>
        <td id="centrar"><?php echo $pastoral_mision->getPastoralSalida()->getNombre() ?></td>
        <td id="centrar"><?php echo $pastoral_mision->getCuota() ?></td>
        <?php 
        $able = '';
        $title = 'Cambiar estado de incripciones';
        if($pastoral_mision->getFechaTermino() < date("Y-m-d")&&$pastoral_mision->getPastoralLocalidad()->getNombre()!='Donde Dios me Quiera')
        {
          $able = 'disabled="disabeled"';
          $title = 'La zona ya termin&oacute;';
        }
        else if($pastoral_mision->estaActiva()&&$pastoral_mision->getPastoralLocalidad()->getNombre()!='Donde Dios me Quiera')
        {
          $able = 'disabled="disabeled"';
          $title = 'La zona ya empez&oacute;';
        }
        else if($pastoral_mision->filtroGeneralActivo()&&$pastoral_mision->getPastoralLocalidad()->getNombre()!='Donde Dios me Quiera')
        {
          $able = 'disabled="disabeled"';
          $title = 'Cerrada por filtro activado';
        }
        $inscripcion_abierta = $pastoral_mision->estaInscripcionAbierta();        
        if(!$inscripcion_abierta)
          $inscripcion = 'Cerrada';
        else
          $inscripcion = 'Abierta';
        ?>
        <?php if(!$cargo->getEMisiones()){ $able = 'disabled="disabled"'; $title="No puedes cambiar el estado de inscripciones";}?>
        <?php if($inscripcion=='Abierta'):?>
          <td id="centrar"><button id='inscripcion' <?php echo$able ?> title= '<?php echo$title ?>' class="btn btn-success"><?php echo $inscripcion ?></button></td>
        <?php else:?>
          <td id="centrar"><button id='inscripcion' <?php echo$able ?> title= '<?php echo$title ?>' class="btn btn-danger"><?php echo $inscripcion ?></button></td>
        <?php endif;?>
        <?php if(!$cargo->getEMisiones()){ $able = 'disabled="disabled"';}?>
        <?php if($pastoral_mision->getZonaVisible()):?>
          <td id="centrar"><button id='visibilidad' <?php echo$able ?> title= '<?php echo$title ?>' class="btn btn-success">Visible</button></td>
        <?php else:?>
          <td id="centrar"><button id='visibilidad' <?php echo$able ?> title= '<?php echo$title ?>' class="btn btn-danger">Oculta</button></td>
        <?php endif;?>
        
    </tr>
  </tbody>
</table>
</div>
<!-- Tabla con detalles de las inscripciones -->

<!-- Acordion con la info de Localidad de Fantasia -->
<div class="accordion" id="infoFantasia">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoJefes" href="#info">
        <h5><i class="icon-chevron-down"></i> Informaci&oacute;n para postulantes</h5>
      </a>
    </div>
    <div id="info" class="accordion-body collapse">
      <div class="accordion-inner">
        <table class="table table-bordered table-striped">
          <thead>            
          </thead> 
          <tbody>
            <tr>
              	<th>Nombre P&uacute;blico:</th>
                <td><?php echo $pastoral_localidad_fantasia?></td>                  
            </tr>
            <tr>
            	<th>Descripci&oacute;n:</th>
            	<?php if($pastoral_localidad_fantasia->getDescripcion() != ''):?>
            		<td class="descripcion_localidad_fantasia_container">
                            <div id="descripcion_localidad_fantasia_texto">
                                <?php echo $pastoral_localidad_fantasia->getDescripcion()?>
                            </div>
                            <a class="btn btn-small btn-mini btn-info cambiar_descripcion_zona_fantasia" data-toggle="modal" href="#modal">Cambiar</a>
                        </td>                        
            	<?php else:?>
            		<td class="descripcion_localidad_fantasia_container">
                            No se ha agregado una descripci&oacute;n para la zona                            
                            <a class="btn btn-small btn-mini btn-info agregar_descripcion_zona_fantasia" data-toggle="modal" href="#modal">Agregar</a>                            
                        </td>                        
            	<?php endif;?>                
            </tr>
            <tr>
            	<th>Foto:</th>
            	<?php if($pastoral_localidad_fantasia->getFotoUrl() != ''):?>
            		<td class="imagen_localidad_fantasia">
                            <img style="max-width: 500px;" src="<?php echo public_path('uploads/infoZonas/localidadFantasia/'.$pastoral_localidad_fantasia->getFotoUrl()) ?>"/>
                            <a class="btn btn-small btn-mini btn-info cambiar_imagen_zona_fantasia">Cambiar</a>
                        </td>                        
            	<?php else:?>
            		<td class="imagen_localidad_fantasia">
                            No hay foto disponible
                            <a class="btn btn-small btn-mini btn-info cambiar_imagen_zona_fantasia">Agregar</a>
                        </td>                        
            	<?php endif;?>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Fin acordion con los jefes de la zona -->
<!-- Acordion con los jefes de la zona -->
<div class="accordion" id="infoJefes">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoJefes" href="#jefes">
        <h5><i class="icon-chevron-down"></i> Jefes de Zona</h5>
      </a>
    </div>
    <div id="jefes" class="accordion-body collapse">
      <div class="accordion-inner">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
                <th>Edad</th>
                <th>Estudios</th>
                <th>Celular</th>  
                <th>Movimiento</th>  
            </tr>
          </thead>
          <tbody>
            <?php foreach ($jefes as $jefe): ?>
              <tr>
                  <td><b><?php echo $jefe ?></b></td>
                  <td><?php echo $jefe->getEdad() ?></td>
                  <td><?php echo $jefe->getEstudios() ?></td>
                  <td><?php echo $jefe->getTelefonoCelular() ?></td>
                  <td><?php echo $jefe->getPastoralMovimiento() ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Fin acordion con los jefes de la zona -->


<!-- Acordion info zona -->
<div class="accordion" id="infoZOna">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoZona" href="#zona">
        <h5><i class="icon-chevron-down"></i> Información de Zona</h5>
      </a>
    </div>
    <div id="zona" class="accordion-body collapse">
      <div class="accordion-inner">
        <input type="hidden" id="misionId" value="<?php echo $pastoral_mision->getId() ?>"/>
        <table class="table table-bordered table-striped">
          <tbody>  
                <tr><th>Fecha inicio</th><td><?php echo date('j-n-Y',strtotime($pastoral_mision->getFechaInicio())) ?></td><th>Fecha t&eacute;rmino</th><td><?php echo date('j-n-Y',strtotime($pastoral_mision->getFechaTermino())) ?></td></tr>
                <tr><th>Descripci&oacute;n</th><td colspan=3><?php echo $pastoral_mision->getDescripcion() ?></td></tr>
          </tbody>
        </table>
        <?php if($pastoral_mision->getLocalidadId() > 0): ?>
          <input type="hidden" id="localidad_id" value="<?php echo $pastoral_mision->getLocalidadId(); ?>"/>
          <?php include_component('localidad','contactos', array('localidad_id'=>$pastoral_mision->getLocalidadId())); ?>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
<!-- Acordion con los info zona -->


<!-- Acordion con los filtros -->
<div class="accordion" id="infoFiltros">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#infoFiltros" href="#filtros">
        <h5><i class="icon-chevron-down"></i> Filtros de inscripci&oacute;n</h5>
      </a>
    </div>
    <div id="filtros" class="accordion-body collapse">
      <div class="accordion-inner">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Filtro</th>
                <th>Activo</th> 
                <th colspan=2>Par&aacute;metro</th> 
                <th>Valor</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($filtros as $filtro): ?>
              <tr>
                  <td><?php echo $filtro->getNombre() ?></td>
                  <td><?php
                    $seteado = 0;
                    foreach($mf as $mision_filtro):
                      if($mision_filtro->getFiltroId() == $filtro->getId()):          
                        $valor = $mision_filtro->estaActivo();
                        if($valor!= ''):?>
                          <center><i class="icon-ok"></i></td></center>         
                        <?php endif; 
                        if($valor== ''):?>
                          <center></td></center>               
                        <?php endif; 
                        $seteado= 1;  
                        if($filtro->getNombre() != 'Universidad'&&$filtro->getNombre() != 'Carrera')
                        {
                          ?> <td Colspan=2><?php echo $mision_filtro->getParametros(); 
                          }?></td><?php
                        if($filtro->getNombre() == 'Universidad')
                        {
                          $param = explode(';',$mision_filtro->getParametros());
                          $univ = Doctrine_Core::getTable('PastoralUniversidad')->FindOneById($param[0]);
                          ?> <td><?php echo $univ; ?></td>
                          <td><?php echo $param[1]; ?></td><?php
                        }
                        if($filtro->getNombre() == 'Carrera')
                        {
                          $param = explode(';',$mision_filtro->getParametros());
                          $univ = Doctrine_Core::getTable('PastoralCarrera')->FindOneById($param[0]);
                          ?> <td><?php echo $univ; ?></td>
                          <td><?php echo $param[1]; ?></td><?php
                        }
                        ?>             
                        <td><?php echo $valor; ?></td>
                        <?php endif; endforeach; 
                    if($seteado == 0):?>            
                        <center></td></center> 
                    
                  <td colspan=2></td>
                  <td></td>
                </tr>
              <?php endif; endforeach; ?>
          </tbody>
        </table>
        <?php if($cargo_actual->getEMisiones()!=0): ?>  
        <a style="float:center;" class="btn btn-mini right" title="Editar filtros"
          href="<?php echo url_for('mision/edit?id='.$pastoral_mision->getId()) ?>">
          Editar filtros</a>
        <?php endif; ?>  
      </div>
    </div>
  </div>
  <br/>
<!-- Acordion con los filtros -->

<div id="edades_acordion" class="btn_acordion">&#9658; Estad&iacute;stica - Edades</div>
<div id="chart5" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="movimientos_religiosos_acordion" class="btn_acordion">&#9658; Estad&iacute;stica - Movimientos Religiosos</div>
<div id="chart6" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="carreras_acordion" class="btn_acordion">&#9658; Estad&iacute;stica - Carreras</div>
<div id="chart7" style=" height: 250px; position: relative; " class="jqplot-target"></div>

<div id="experiencia_acordion" class="btn_acordion">&#9658; Estad&iacute;stica - Experiencia</div>
<div id="chart4" style= " height: 250px; position: relative; " class="jqplot-target"></div>

<div id="misioneros_acordion" class="btn_acordion">&#9658; Misioneros</div>
<div id="misioneros">
  <table class="table table-bordered table-striped">
  <thead>
      <tr>
        <th>Nombre</th>
        <th>Edad</th>
        <th>Estudios</th>
        <th>Celular</th>  
        <th>Movimiento</th>  
        <th>Universidad</th>
      </tr>
    </thead>
    <tbody>
      <?php $misioneros = $misioneros ?>
    <?php foreach ($misioneros as $misionero):if($misionero->fueAMision($pastoral_mision->getId())): ?>
      <tr>
          <td><?php echo $misionero ?></td>
          <td><?php echo $misionero->getEdad() ?></td>
          <td><?php echo $misionero->getEstudios() ?></td>
          <td><?php echo $misionero->getTelefonoCelular() ?></td>
          <td><?php echo $misionero->getPastoralMovimiento() ?></td>
          <td><?php echo $misionero->getPastoralCarrera()->getNombre() ?></td>
      </tr>
    <?php endif;endforeach; ?>
    <tr><td Colspan = 5><a href='<?php echo url_for('usuario/inscritos') ?>'>Para modificar informaci&oacute;n de los inscritos haz clic aqu&iacute;</a> </td></tr>
    </tbody>
  </table>
</div>
</div> 
<div>
    <a href="<?php echo url_for('mision/index') ?>"><button class="btn btn-info">Atr&aacute;s</button></a>
    <?php if($cargo_actual->getEMisiones()!=0): ?> 
    <a href="<?php echo url_for('mision/edit?id='.$pastoral_mision->getId()) ?>"><button class="btn btn-info">Editar zona</button></a>
    <?php endif; ?> 
 </div> 
<br></br>
</div>
<div id="modal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Editar Sector</h3>
  </div>
  <div id="form-editar-localidad-fantasia" class="modal-body">    
      Cargando informaci&oacute;n
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal" >Cerrar</a>
    <a href="#" class="btn btn-primary enviar_informacion">Guardar</a>
  </div>
</div>
<script type="text/javascript">    
    $(document).ready(function(){
        graficosModule.initGraficoMision();
        $('.cambiar_descripcion_zona_fantasia').click(function(){
            //Ver como agregar el tipo de accion en el AJAX que llama al agregar dato            
            imprimirFormulario('descripcion','editar');            
        });
        $('.agregar_descripcion_zona_fantasia').click(function(){
            //Cambiar el valor del modal-body
            imprimirFormulario('descripcion','agregar');            
        });
        $('.cambiar_imagen_zona_fantasia').click(function(){
            imprimirFormulario('imagen', 'cambiar');
        });
        $('.enviar_informacion').click(function(){
            var texto = $('.text_area_descripcion_form_localidad_fantasia').val();
            $.ajax({
                url: '<?php echo url_for('mision/nombreFantasiaEdit?id='.$pastoral_localidad_fantasia->getId()) ?>',
                type: 'POST',
                data:{
                    info: texto
                },
              success: function(data){                
                $('.descripcion_localidad_fantasia_container').empty();
                $('.descripcion_localidad_fantasia_container').append('<div id="descripcion_localidad_fantasia_texto">'+data.texto+'</div>');
                $('.descripcion_localidad_fantasia_container').append('<a class="btn btn-small btn-mini btn-info cambiar_descripcion_zona_fantasia" data-toggle="modal" href="#modal">Cambiar</a>');
                //Volvemos a suscribir el evento
                $('.cambiar_descripcion_zona_fantasia').click(function(){
                    //Ver como agregar el tipo de accion en el AJAX que llama al agregar dato            
                    imprimirFormulario('descripcion','editar');      
                });
                $('#modal').modal('hide');
              }
            });
        });
    });
    function imprimirFormulario(tipo_de_dato, accion){
        modal_form = $('#form-editar-localidad-fantasia');
        modal_form.empty();        
        if(tipo_de_dato == 'descripcion'){            
            modal_form.append('<div id="tipo_de_dato_form_localidad_fantasia" style="display: none;" valor="descripcion"/>');
            modal_form.append("<fieldset><legend>Descripci&oacute;n</legend>"); 
            if(accion == 'agregar'){                                          
                modal_form.append('<textarea class="text_area_descripcion_form_localidad_fantasia" rows="8" style="width: 495px">Agregar</textarea>');
            }            
            else{
                modal_form.append('<textarea class="text_area_descripcion_form_localidad_fantasia" rows="8" style="width: 495px"></textarea>');
                $('.text_area_descripcion_form_localidad_fantasia').append($.trim($('#descripcion_localidad_fantasia_texto').text()));
            }
        }
        else{
            modal_form.append('<div id="tipo_de_dato_form_localidad_fantasia" style="display: none;" valor="imagen"/>');
            modal_form.append('<div id="imagen_localidad_fantasia"></div>');
            modal_form.append('<div class="drop_area">Arrastra una imagen hacia aqui</div>');
            createUploader();
            $('#modal').modal('toggle');
        }
    }
    function createUploader(){    
        //Agregar evento para el fin de la carga de los datos.
        var uploader = new qq.FileUploader({
            element: document.getElementById('imagen_localidad_fantasia'),
            action: '<?php echo url_for('mision/getImagenLocalidadFantasiaAjax?id='.$pastoral_localidad_fantasia->getId()) ?>',
            debug: false,
            extraDropzones: [qq.getByClass(document, 'drop_area')[0]],
            multiple: false,
            onComplete: function(id, fileName, responseJSON){                
                $('.imagen_localidad_fantasia').empty();
                $('.imagen_localidad_fantasia').append('<img style="max-width: 500px;" src="<?php echo public_path('uploads/infoZonas/localidadFantasia/') ?>'+responseJSON.url+'"/>');
                $('.imagen_localidad_fantasia').append('<a class="btn btn-small btn-mini btn-info cambiar_imagen_zona_fantasia">Cambiar</a>');
                //Agregamos el listener al evento
                $('.cambiar_imagen_zona_fantasia').click(function(){
                    imprimirFormulario('imagen', 'cambiar');
                });
                $('#modal').modal('hide');
            }
        });           
    }
</script>
<br/>
<br/>
<br/>