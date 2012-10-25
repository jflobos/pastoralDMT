<table>
  <tbody>
  <?php if ($sf_user->hasFlash('instancia_exitosa')): ?>
    <tr>
      <td></td>
      <td>
        <div class="alert alert-info span5"  id="info_tabla_vacia" style="text-align:center">
        <?php echo $sf_user->getFlash('instancia_exitosa') ?>
        </div>
      </td>
    </tr>
  <?php endif ?>
  </tbody>
</table>

<div class="page-header">
  <h1>Nuevo Grupo <small>Pastoral UC</small></h1>
</div>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<link rel="stylesheet" type="text/css" href="/css/chosen.css" />
<script type="text/javascript" src="/js/chosen.jquery.js"></script>


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
      <input id='guardar_y_nuevo' name='guardar_y_nuevo' type="submit" value="Guardar y Nuevo" />
			<input id='guardar' name='guardar' type="submit" value="Guardar" />
		  </td>
		</tr>
		</tfoot>
		  <tbody>
			<tr>
        		<?php echo $form['proyecto_version_id']->renderRow(array('readonly' => 'readonly')) ?>
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
								echo "<select id ='jefe' class='chzn-select' MULTIPLE name='jefe[]' >";
								
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
			
	  <?php echo $form->renderHiddenFields() ?>
		  </tbody>
		</table>	
	</form>  
 <br></br>