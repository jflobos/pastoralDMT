<div class="container">
  <div class="row center">
    <div class="span8 well">
      <?php if($mostrar_postulacion == 1):?>
      <p>&iquest;Quieres participar en <strong><?php echo $proyecto_version->getNombre()?></strong>?</p>
      <form action="<?php echo url_for("usuario/inscribirExtranjero");?>">
         <input type="hidden" name="pv_id" value="<?php echo $proyecto_version->getId()?>"/>
      <p><input type="submit" class="btn btn-success" value="An&oacute;tame!"/></p>
      </form>
      <?php elseif($mostrar_postulacion == 0):?>
        Estas inscrit@ en <strong><?php echo $proyecto_version->getNombre()?></strong>. El jefe de zona se contactar&aacute; contigo.
      <?php elseif($mostrar_postulacion == -1):?>
        No hay zonas disponibles para postular.
      <?php endif;?>
    </div>
  </div>   
</div>

