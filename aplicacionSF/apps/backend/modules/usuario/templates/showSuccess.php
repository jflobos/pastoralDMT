<div class="page-header">
  <h1>
          <?php
        if($mostrar_postulacion == 1):?>
        Bienvenido <?php echo $pastoral_usuario->getNombre(); ?>, ¡ya puedes inscribirte! 
        <?php 
        else: ?>
        Felicidades <?php echo $pastoral_usuario->getNombre(); ?>, ¡ya estás inscrito! 
        <?php
        endif ?>
        <small>Pastoral UC</small></h1>
</div>

<div class="container-fluid">
  <div class="row-fluid row">
      
      <?php
        if($mostrar_postulacion == 1):
            include_partial('inscripcion', array('mostrar_postulacion' => $mostrar_postulacion, 'pastoral_misiones'=>$pastoral_misiones)) ; 
        else: 
        //Mostramos los detalles de la inscripcion activa:
        ?>
        

         <div class="tab-pane active" id="inscripcion">
            <div class="tab-pane well" >
              <h1><small>Información de la Inscripción</small></h1>
              <table class="table table-bordered table-striped" id="info_localidad"> 
                <tbody>
                  <colgroup>
                   <col class="span3">
                   <tr><th>Estado de Inscripción: </th><td><?php echo $estado_postulacion->PastoralEstadoPostulacion->getNombre();?></td></tr>
                  </colgroup>
                </tbody>
              </table>

              <!--ESta sección necesita mostrar la información real de la zona a la que se postulo además de informar las metodologías de cambio de usuario-->
              <!--div class="page-header">
                <h1>Informaci&oacute;n</h1>
              </div-->
              <p><font size=1>*Si por motivos de fuerza mayor necesitas cambiar tu inscripción, por favor envía un correo a inscripciones@pastoral.cl</font></p>
              
              <h1><center><small><font size=4 color="black"><?php echo $localidad_fantasia->getNombre();?></font></small></center> </h1>
              <center><img src="<?php echo $localidad_fantasia->getFotoUrl();?>"></center> 
              <table class="table table-bordered table-striped" id="info_localidad">
                <tbody>
                  <tr>
                    <th> Localidad: </th>
                    <td> <?php echo $localidad_fantasia->getNombre();?></td>
                  </tr>
                  <tr>
                    <th> Descripción: </th>
                    <td> <?php echo $localidad_fantasia->getDescripcion();?></td>
                  </tr>
                  <?php                     
                      foreach($array_jefes_muc as $muc) {
                        echo "<tr><th> Jefe: </th><td>".$muc->PastoralUsuario->getNombreCompleto()."</td></tr>";
                      }
                   ?>
                </tbody>
                <colgroup>
                  <col class="span3">
                </colgroup>
              </table>


            </div>
         </div>
        
      <?php endif;?>
      
 </div><!--/row-->
</div><!--/.fluid-container-->