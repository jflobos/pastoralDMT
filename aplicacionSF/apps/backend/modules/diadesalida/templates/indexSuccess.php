<div class="page-header">
  <h1>D&iacute;a de salida - <?php echo $proyecto->getNombre().' - '.$proyecto_version->getAno() ?><small> Pastoral UC</small></h1>
</div>

<div id= "buscarRut" class="menup">
   <ul>
        <b>RUT del misionero: </b><input type="input" name="buscarRutInput" id="buscarRutInput" ></input>
   </ul>
   <ul>
   <button id="buscarPorRut" class="btn btn-info"><b>Buscar</b></button>
   </ul>
</div>

<input type="hidden" id="p_version_id" value="<?php echo $proyecto_version->getId() ?>">


<div id="resultado" style="display:none;" class="menup">  
    <h2><small>Informaci&oacute;n Voluntario</small></h2>
    
    <table class="table table-condensed table-striped">
      <tr>
        <th>Nombre: </th>
        <td><input type="input" name="nombreMisionero" id="nombreMisionero" READONLY></input></td>
      </tr>      
      <tr>
        <th>Celular: </th>
        <td><input type="input" name="celularMisionero" id="celularMisionero" READONLY></input></td>
      </tr>
      <tr>
        <th>Proyecto:</th>
        <td><input type="input" name="proyectoMisionero" id="proyectoMisionero" READONLY></input></td> 
      </tr>
      <tr>
        <th>Regi&oacute;n:</th>
        <td><input type="input" name="grupoMisionero" id="grupoMisionero" READONLY></input></td>
      </tr>
      <tr>
        <th>Zona:</th>
        <td><input type="input" name="zonaMisionero" id="zonaMisionero" READONLY></input></td>
      </tr>    
    </table>
    
    <h2><small>Informaci&oacute;n de Pago</small></h2>
    
    <table class="table table-condensed table-striped">
      <tr>
        <th>Valor Cuota: </th>
        <td><input type="input" name="cuotaMisionero" id="cuotaMisionero" READONLY></input></td>
      </tr>
      <tr>
        <th>Estado de pago: </th>
        <td><input type="input" name="estadoCuota" id="estadoCuota" READONLY></td>
      </tr>      
      <tr>
        <div id="div_infoCuotaSolidaria" style="display:none;">
          <th>Cuota Solidaria: </th>
          <td><input type="input" name="cuotaSolidariaReadOnly" id="cuotaSolidariaReadOnly" READONLY></td>
          
        </div>
      </tr>
    </table>
    
    
    
    <div id="cambios" style="display:none;" class="menup">
    <b>&iquest;Guardar como pagada? </b><input type="checkbox" name="pagoCuota" id="pagoCuota">
    <br>
    <h2><small>Cuota Solidaria</small></h2>
    <h4>Si el voluntario paga una cantidad superior al valor de su cuota,<h4>
    <h4>ingresa la diferencia, a continuaci&oacute;n, como 'CUOTA SOLIDARIA'.</h4>
    <br>
    <b>Agregar Cuota Solidaria </b><input type="input" name="cuotaSolidaria" id="cuotaSolidaria">
    <br>
    <br>
    <button class="btn btn-info" id="BotonEstadoDePago"><b>Guardar Cambios</b></button>
    </div>
</div>