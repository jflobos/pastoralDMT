<h1>Edit Pastoral grupo</h1>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>



<form action="<?php echo url_for('grupo/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
	<table class=" table-bordered table-striped table-condensed" class="btn">
		<tfoot>
		<tr>
		  <td colspan="2">
			&nbsp;<a href="<?php echo url_for('/index.php/grupo') ?>">Volver</a>
      <?php if (!$form->getObject()->isNew()&&$borrar): ?>
            &nbsp;<?php 
              echo link_to('Borrar', 'grupo/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => '¿Estas seguro?')) ?>
      <?php endif; ?>
			<input id='guardar' type="submit" value="Guardar" />
		  </td>
		</tr>
		</tfoot>	
		  <tbody>
			<tr>
				<?php echo $form['proyecto_version_id']->renderRow(array('style' => 'display: none;')) ?>
				<?php echo $form['nombre']->renderRow() ?> 			  
				<?php echo $form['descripcion']->renderRow() ?>
				<?php echo $form['cuota']->renderRow() ?>
				<?php echo $form['fecha_inicio']->renderRow() ?>
				<?php echo $form['fecha_termino']->renderRow() ?>
			</tr>			
			<tr colspan = "2">
				<td >Jefes
						<td >
							<?php
								echo "<select id ='jefe' class='chzn-select' MULTIPLE name='jefe[]'>";
								
								foreach($jefes_seleccionados as $jefe)
								{
									echo '<option value="'.$jefe->getId().'"selected="selected">';  
									echo $jefe->getNombre().' '.$jefe->getApellidoPaterno();
									echo '</option>';
								}
								foreach($jefes as $jefe)
								{
									echo '<option value="'.$jefe->getId().'">';  
									echo $jefe;
									echo '</option>';
								}
								echo "</select></td>";
							?>
						</td>
				</td>
			</tr> 
			
			<?php echo $form->renderHiddenFields() ?>
		  </tbody>
		</table>	
	</form>  
 <br/>