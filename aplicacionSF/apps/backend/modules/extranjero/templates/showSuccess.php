<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $pastoral_usuario->getId() ?></td>
    </tr>
    <tr>
      <th>User:</th>
      <td><?php echo $pastoral_usuario->getUserId() ?></td>
    </tr>
    <tr>
      <th>Rut:</th>
      <td><?php echo $pastoral_usuario->getRut() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $pastoral_usuario->getNombre() ?></td>
    </tr>
    <tr>
      <th>Apellido materno:</th>
      <td><?php echo $pastoral_usuario->getApellidoMaterno() ?></td>
    </tr>
    <tr>
      <th>Apellido paterno:</th>
      <td><?php echo $pastoral_usuario->getApellidoPaterno() ?></td>
    </tr>
    <tr>
      <th>Fecha nacimiento:</th>
      <td><?php echo $pastoral_usuario->getFechaNacimiento() ?></td>
    </tr>
    <tr>
      <th>Telefono celular:</th>
      <td><?php echo $pastoral_usuario->getTelefonoCelular() ?></td>
    </tr>
    <tr>
      <th>Telefono emergencia:</th>
      <td><?php echo $pastoral_usuario->getTelefonoEmergencia() ?></td>
    </tr>
    <tr>
      <th>Sexo:</th>
      <td><?php echo $pastoral_usuario->getSexo() ?></td>
    </tr>
    <tr>
      <th>Es extranjero:</th>
      <td><?php echo $pastoral_usuario->getEsExtranjero() ?></td>
    </tr>
    <tr>
      <th>Tipo institucion:</th>
      <td><?php echo $pastoral_usuario->getTipoInstitucionId() ?></td>
    </tr>
    <tr>
      <th>Universidad:</th>
      <td><?php echo $pastoral_usuario->getUniversidadId() ?></td>
    </tr>
    <tr>
      <th>Carrera:</th>
      <td><?php echo $pastoral_usuario->getCarreraId() ?></td>
    </tr>
    <tr>
      <th>Ano ingreso:</th>
      <td><?php echo $pastoral_usuario->getAnoIngreso() ?></td>
    </tr>
    <tr>
      <th>Colegio:</th>
      <td><?php echo $pastoral_usuario->getColegioId() ?></td>
    </tr>
    <tr>
      <th>Curso:</th>
      <td><?php echo $pastoral_usuario->getCursoId() ?></td>
    </tr>
    <tr>
      <th>Movimiento:</th>
      <td><?php echo $pastoral_usuario->getMovimientoId() ?></td>
    </tr>
    <tr>
      <th>Direccion:</th>
      <td><?php echo $pastoral_usuario->getDireccion() ?></td>
    </tr>
    <tr>
      <th>Comuna:</th>
      <td><?php echo $pastoral_usuario->getComunaId() ?></td>
    </tr>
    <tr>
      <th>Enfermedades alergias:</th>
      <td><?php echo $pastoral_usuario->getEnfermedadesAlergias() ?></td>
    </tr>
    <tr>
      <th>Ultimo proyecto accedido:</th>
      <td><?php echo $pastoral_usuario->getUltimoProyectoAccedidoId() ?></td>
    </tr>
    <tr>
      <th>Email validado:</th>
      <td><?php echo $pastoral_usuario->getEmailValidado() ?></td>
    </tr>
    <tr>
      <th>Token:</th>
      <td><?php echo $pastoral_usuario->getToken() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('extranjero/edit?id='.$pastoral_usuario->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('extranjero/index') ?>">List</a>
