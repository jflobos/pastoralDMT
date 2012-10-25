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

    <b>Nombre: </b><input type="input" name="nombreMisionero" id="nombreMisionero" READONLY></input>
    <br>
    <b>Celular: </b><input type="input" name="celularMisionero" id="celularMisionero" READONLY></input>
    <br>
    <b>Proyecto: </b><input type="input" name="proyectoMisionero" id="proyectoMisionero" READONLY></input>
    <br>
    <b>Grupo: </b><input type="input" name="grupoMisionero" id="grupoMisionero" READONLY></input>
    <br>
    <b>Zona: </b><input type="input" name="zonaMisionero" id="zonaMisionero" READONLY></input>
    <br>
    
    <h2><small>Informaci&oacute;n de Pago</small></h2>
    <b>VALOR CUOTA GENERAL: </b><input type="input" name="cuotaMisionero" id="cuotaMisionero" READONLY></input>
    <br>
    <b>Estado de pago - CUOTA GENERAL </b><input type="input" name="estadoCuota" id="estadoCuota" READONLY>
    <br> 
    
    <div id="div_infoCuotaSolidaria" style="display:none;">
    <b>Cuota Solidaria (pago adicional) </b><input type="input" name="cuotaSolidariaReadOnly" id="cuotaSolidariaReadOnly" READONLY>
    <br>
    </div>
    
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
    
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
   
</div>