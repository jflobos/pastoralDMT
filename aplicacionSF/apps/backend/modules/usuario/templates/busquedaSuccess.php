<!--NAVEGACIÓN-->
<div class="" style="text-align:left" >
  &raquo;
  <a align="left" href="<?php echo url_for('usuario/busqueda');?>">
    <span style='font-size:10px;color:blue'>B&uacute;squeda</span>
  </a>
</div>
<!--/NAVEGACIÓN-->

<!--ENCABEZADO-->
<div class="page-header">
<h1>B&uacute;squeda / Reporte de Voluntarios <small>Pastoral UC</small></h1>
</div>
<!--/ENCABEZADO-->

<!--LINKS DERECHOS-->
<!--/LINKS DERECHOS-->


<h1><small>Filtros</small></h1>
<?php $uc = $sf_user->getAttribute('usuario_cargo');?>
<!-- proyecto -->
<b>&emsp; &emsp; Participaciones &#9658; &nbsp; &nbsp; &nbsp; &thinsp; &thinsp;</b>
<select id='proyecto' class="span2 change_filter agrupacion">
    <?php if(!$uc->getMisionId()>0 && !$uc->getGrupoId()>0){?><!-- NO ES JEFE DE ZONA NI REGIONAL -->
      <option value="-1" selected='selected'>&#8212;&#8212; Proyecto &#8212;&#8212;</option>
      <?php foreach($proyectos as $proyecto): ?> 
          <option value="<?php echo $proyecto->getId()?>"> <?php echo $proyecto->getNombre()?></option>
      <?php endforeach;?> 
    <?php }else{?>
      <option value="<?php echo $proyectos->getId()?>"> <?php echo $proyectos->getNombre()?></option>
    <?php }?>
 </select>
 
 <!-- proyecto_version -->
 <select id='proyecto_version' class="span2 change_filter agrupacion">
    <?php if(!$uc->getMisionId()>0 && !$uc->getGrupoId()>0){?><!-- NO ES JEFE DE ZONA NI REGIONAL -->
      <option value="-1" selected='selected'>&#8212;&#8212; Versi&oacute;n &#8212;&#8212;</option>
      <?php foreach($proyectos_versiones as $proyecto_version): ?> 
          <option value="<?php echo $proyecto_version->getId()?>"> <?php echo $proyecto_version->getNombre()?></option>
      <?php endforeach?> 
    <?php }else{?>
      <option value="<?php echo $proyectos_versiones->getId()?>"> <?php echo $proyectos_versiones->getNombre()?></option>
    <?php }?>
 </select>

  <!-- grupo -->
 <select id='grupo' class="span2 change_filter agrupacion">
    <?php if(!$uc->getMisionId()>0 && !$uc->getGrupoId()>0){?><!-- NO ES JEFE DE ZONA NI REGIONAL -->
      <option value="-1" selected='selected'>&#8212;&#8212; Grupo &#8212;&#8212;</option>
      <?php foreach($grupos as $grupo): ?> 
          <option value="<?php echo $grupo->getId()?>"> <?php echo $grupo->getNombre()?></option>
      <?php endforeach?> 
    <?php }else{?>
      <option value="<?php echo $grupos->getId()?>"> <?php echo $grupos->getNombre()?></option>
    <?php }?>
 </select>

 <!-- zona -->
 <select id='mision' class="span2 change_filter agrupacion">
    <?php if(!$uc->getMisionId()>0){?><!-- NO ES JEFE DE ZONA  -->
      <option value="-1" selected='selected'>&#8212;&#8212; Zona &#8212;&#8212;</option>
      <?php foreach($misiones as $mision): ?> 
          <option value="<?php echo $mision->getId()?>"> <?php echo $mision->getNombre()?></option>
      <?php endforeach?> 
    <?php }else{?>
      <option value="<?php echo $misiones->getId()?>"> <?php echo $misiones->getNombre()?></option>
    <?php }?>
 </select>
 <br/>
 
 <b>&emsp; &emsp; Informaci&oacute;n Personal &#9658;</b>
 <!-- Universidad -->
 <select id='universidad' class="span2 change_filter">
  <option value="-3" selected='selected'>&#8212;&#8212; Estudios &#8212;&#8212;</option>
  <option value="-1">Colegio</option>
  <option value="-2">Universidad</option>
   <?php foreach($universidades as $universidad): ?> 
   <option value="<?php echo $universidad->getId()?>"> <?php echo $universidad->getNombre()?></option>
   <?php endforeach?> 
 </select> 
 
 <!-- Carreras -->
 <select id='carrera' class="span2 change_filter">
  <option value="-1" selected='selected'>&#8212;&#8212; Carrera &#8212;&#8212;</option>
   <?php foreach($carreras as $carrera): ?> 
   <option value="<?php echo $carrera->getId()?>"> <?php echo $carrera->getNombre()?></option>
   <?php endforeach?> 
 </select> 
 
 <!-- Movimiento -->
 <select id='movimiento' class="span2 change_filter">
  <option value="-1" selected='selected'>&#8212;&#8212; Movimiento &#8212;&#8212;</option>
   <?php foreach($movimientos as $movimiento): ?> 
   <option value="<?php echo $movimiento->getId()?>"> <?php echo $movimiento->getNombre()?></option>
   <?php endforeach?> 
 </select>
 
 <select id='sexo' class="span2 change_filter">
  <option value="-1" selected='selected'>&#8212;&#8212; Sexo &#8212;&#8212;</option>
  <option value="1">Masculino</option>
  <option value="2">Femenino</option> 
 </select>
 
 <br/>
 
  <b>&emsp; &emsp; Historial &#9658; &nbsp; &nbsp; &nbsp; &nbsp; &emsp; &thinsp; &thinsp; &thinsp; &thinsp; &thinsp;</b>
  <!-- Cargos y Recomendaciones-->
 <select id='cargo' class="span2 change_filter">
  <option value="-1" selected='selected'>&#8212;&#8212; Cargos &#8212;&#8212;</option>
   <?php foreach($cargos as $cargo): ?> 
   <option value="<?php echo $cargo->getId()?>"> <?php echo $cargo->getNombre()?></option>
   <?php endforeach?> 
 </select> 
 &nbsp; *Recomendaciones (Jefes/Compa&ntilde;eros):
 <input type="checkbox" class="change_filter" id='rj'/>  RJ
 <input type="checkbox" class="change_filter" id='rc'/>  RC
 

    <div class="input-append">
    &emsp; &emsp; 
        <input class="span4" id="busqueda_string" size="16" type="text" placeholder="Nombre Apellidos" value="<?php if(strlen($busqueda)>0){echo $busqueda;}?>"></input>
        <button id="busqueda" class="btn btn-success" type="button">Buscar</button>
    </div>
 <br/>
 

<h1><small>Usuarios</small></h1>

<div id="info_usuarios"></div>
  
<div class="alert alert-info" id="info_tabla_vacia"></div>

<table  id="tabla_usuarios" class= "table table-bordered"></table>
<div id="paginacion"></div>
<input type="hidden" id="pagina" value="1"></input>