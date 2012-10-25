<div class="page-header">
 <h1>Crear Zona<small> Pastoral UC</small></h1>
</div>

 <!--	 <?php include_partial('form', array('form' => $form)) ?>  -->

<form action="<?php echo url_for('mision/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>  
  <input type="hidden" id="pastoral_mision_proyecto_version_id" value="<?php echo $proyecto_version_id ?>  " />
	<table class=" table-bordered table-striped table-condensed" class="btn">
		<tfoot>
		<tr>
		  <td colspan="2">
			&nbsp;<a href="<?php echo url_for('/index.php/mision') ?>">Volver</a>
      <input id='guardar_y_nueva' name='guardar_y_nueva' type="submit" value="Guardar y Nueva" />
			<input id='guardar' type="submit" value="Guardar" />
		  </td>
		</tr>
		</tfoot>
		  <tbody>
			<tr>		 
        <?php echo $form['grupo_id']->renderRow() ?>            
				<?php echo $form['localidad_fantasia_id']->renderRow() ?> 	
				<?php echo $form['nuevo_sector']->renderRow() ?>		
				<?php echo $form['localidad_id']->renderRow() ?>
				<?php echo $form['fecha_inicio']->renderRow() ?>
				<?php echo $form['fecha_termino']->renderRow() ?>				
				<?php echo $form['salida_id']->renderRow() ?>
				<?php echo $form['nueva_salida']->renderRow() ?>					 
				<?php echo $form['cuota']->renderRow() ?>         
				<?php echo $form['descripcion']->renderRow() ?>
				<?php echo $form['inscripcion_abierta']->renderRow() ?>
				<?php echo $form->renderHiddenFields() ?>			 	
				<td>Jefes
          <td>
		<?php
              echo "<select id ='jefe' class='chzn-select' MULTIPLE name='jefe[]'>";              
              foreach($jefes_seleccionados as $jefe)
              {
                echo '<option title='.$jefe->getId().' value="'.$jefe->getId().'selected="selected" >';  
                echo $jefe->getNombre().' '.$jefe->getApellidoPaterno().' '.$jefe->getApellidoMaterno();									
                echo '</option>';
              }
              foreach($jefes as $jefe)
              {
                echo '<option title='.$jefe->getId().' value="'.$jefe->getId().'">';  
                echo $jefe->getNombre().' '.$jefe->getApellidoPaterno().' '.$jefe->getApellidoMaterno();	
                echo '</option>';
              }
              echo "</select></td>";
        ?>
					</td>						
				</td>
				<tr>
					<td>Filtros
						<td>
							<a data-toggle="modal" href="#filtros" >Filtros</a>
						</td>
					</td>
				</tr>	
			</tr> 
			 <input type= 'hidden' id='info' name="infoFiltros" type="string" />
		  </tbody>
		</table>	
	</form>  
  

<div class="modal" id="filtros"  data-backdrop="static" >
  <div class="modal-header">
    <button class="close" data-dismiss="modal">X</button>
    <h3>Filtros</h3>
  </div>
  <div class="modal-body"> 		
	  <table class=" table-bordered table-striped table-condensed" >
      <form>
        <tfoot>
          <?php
            foreach($filtros as $filtro)
            {
              if($filtro->getNombre() == 'Universidad')
              {
                echo "<tr><td><input type='checkbox' Id='".$filtro."'>";
                echo '  '.$filtro;                                    
                echo '<br></td>';   
               
                echo "<td align= right><select id ='universidad' name='universidad[]'>";
                foreach($universidades as $universidad)
                {
                  echo '<option  value="'.$universidad->getId().'">';  
                  echo $universidad->getNombre();	
                  echo '</option>';
                }
                echo "</select></td>";
                echo "<td><input id='".$filtro."_valor' name='".$filtro."_valor' style='width : 60px;' 'type='text' onkeypress='validate(event)' /></td></tr>";
              }
              else if($filtro->getNombre() == 'Carrera')
              {
                echo "<tr><td><input type='checkbox' Id='".$filtro."'>";
                echo '  '.$filtro;                                    
                echo '<br></td>';   
               
                echo "<td align= right><select id ='carrera' name='carrera[]'>";
                foreach($carreras as $carrera)
                {
                  echo '<option  value="'.$carrera->getId().'">';  
                  echo $carrera->getNombre();	
                  echo '</option>';
                }
                echo "</select></td>";
                echo "<td><input id='".$filtro."_valor' name='".$filtro."_valor' style='width : 60px;' 'type='text' onkeypress='validate(event)' /></td></tr>";
              }
              else
              {
                echo "<tr><td COLSPAN=2><input type='checkbox' Id='".$filtro."'>";
                echo '  '.$filtro;                                    
                echo '<br></td>';   
                echo "<td width='10%'><input id='".$filtro."_valor' name='".$filtro."_valor' style='width : 60px;' 'type='text' onkeypress='validate(event)' /></td></tr>";
              }   
            }
          ?>          
        </tfoot>
       <tbody>
        <div id="nuevo_filtro">
        </div>
       </tbody>
      </form>
    </table>
    
    <div class="modal-footer">
      <a href="#" class="btn" data-dismiss="modal" >Cerrar</a>
      <a href="#" class="btn" data-dismiss="modal" Id='guard'>Guardar</a>
    </div>
  </div>
</div>

 <br></br>

 

