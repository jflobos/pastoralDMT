<div class="page-header">
  <h1>Información Personal <small>Pastoral UC</small></h1>
</div>

<div class="container well span8">

      
    <?php if ($sf_user->hasFlash('edicion_exitosa')): ?>
      <div class="alert alert-info span6"  id="info_tabla_vacia" style="text-align:center"><?php echo $sf_user->getFlash('edicion_exitosa') ?></div>
    <?php endif ?>

  <div class="row">
    <div class="span8 span-fixed-sidebar">
        <h1><small>Información personal</small></h1>
        <br/>
        <table class="table table-bordered table-striped" > 
          <tbody>
            <colgroup>
              <col class="span2">
              <col class="span3">
            </colgroup>
            <tr>
              <th>Nombre:</th>
              <td><?php echo $pastoral_usuario->getNombre() ?> <?php echo $pastoral_usuario->getApellidoPaterno() ?> <?php echo $pastoral_usuario->getApellidoMaterno() ?></td>
            </tr>
            <tr>
              <th>Rut:</th>
              <td><?php echo $pastoral_usuario->getRut() ?></td>
            </tr>
            <tr>
              <th>E-mail:</th>
              <td><?php echo $pastoral_usuario->getUser()->getEmailAddress() ?></td>
            </tr>
            <tr>
              <th>Celular:</th>
              <td><?php echo $pastoral_usuario->getTelefonoCelular() ?></td>
            </tr>
            <tr>
              <th>Teléfono de Emergencia:</th>
              <td><?php echo $pastoral_usuario->getTelefonoEmergencia() ?></td>
            </tr>
            <tr>
              <th>Sexo:</th>
              <td><?php echo $pastoral_usuario->getSexo() ?></td>
            </tr>
            <tr>
              <th>Enfermedades / Alergias:</th>
              <td><?php echo $pastoral_usuario->getEnfermedadesAlergias() ?></td>
            </tr>
            
          </tbody>
        </table>
        <div class = "span7">
          <a href="<?php echo url_for('@homepage') ?>"><button class="btn btn-info">Volver</button></a>
          <a href="<?php echo url_for('usuario/edit') ?>"><button class="btn btn-info">Editar</button></a>
        </div>
   </div><!--/span-->
 </div><!--/row-->
</div><!--/.fluid-container-->
