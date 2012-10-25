<div class="container-fluid">
  <div class="row-fluid row">
    <div class="span4">
      <div class="well sidebar-nav-fixed">
        <ul class="nav nav-stacked">
          <li class="nav-header">Salida</li> <!-- se pueden poner mas de estos para subcategorias -->
          <li>
            <select id = 'salidas' name ='salidas' class="btn">
              <option value= '-1'>--Salida--</option>
              <?php 
                 if(isset($pastoral_misiones))
                 {
                   foreach($pastoral_misiones as $mision)
                   {
                       echo '<option value=\''.$mision->getSalidaId().'\'>';  
                       echo $mision->getPastoralSalida()->getNombre();
                       echo '</option>';
                   }
                 }
              ?>
              </select>
          </li>
          <li class="nav-header">Grupo</li>
          <li><select id ='grupos' name='grupos' class="btn" ></select></li>
          <li class="nav-header">Zonas</li>
          <li><ul class="nav nav-tabs nav-stacked" id="zonas_lista"></ul></li>
        </ul>
      </div><!--/.well -->
    </div><!--/span-->
            

            
    <div class="span7 well" id="content_zonas">
      </br> 
      <span class="span4" id="resultado_postulacion" ></span> 
      <div id="zonas_mini">
      </div>
      
           
      <div id='detalle-mision'>
        
     
        <div class="span5">
          
          <button type="button" data-loading-text="Cargando" id = "submit_btn" class="submit_postulacion btn btn-warning ">Postular</button>
          <br/>
          <br/>
          <ul class="thumbnails" id="foto_localidad">
          </ul>
          <table class="table table-bordered table-striped" id="info_localidad"> 
            <tbody>
              <colgroup>
               <col class="span3">
              </colgroup>
            </tbody>
          </table>
          <input type="hidden" val="" id="zona_id"/>
        </div>
      </div > 
    </div>
  </div>   
</div>

