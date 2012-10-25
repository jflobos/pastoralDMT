<link rel="stylesheet" type="text/css" href="/css/chosen.css" />
<script type="text/javascript" src="/js/chosen.jquery.js"></script>

<style type="text/css">
#guardar
{
  color: #FFFFFF;
  font-size:13px;
  width: 70px;
  margin: 25px;
  padding: 3px 7px;
}
</style>

<!--NAVEGACIÓN-->
<div class="" style="text-align:left" >
  &raquo;
  <?php if($sf_user->getAttribute('usuario_cargo')->getPastoralCargo()->getEsDirector()==1){ ?> 
  <a align="left" href="<?php echo url_for('proyecto/index') ?>">
    <span style='font-size:10px;color:blue'>Proyectos</span>
  </a>
  &raquo;
  <a align="left" href="<?php echo url_for('proyecto/new') ?>">
    <span style='font-size:10px;color:blue'>Instanciar Proyecto</span>
  </a>
  <?php } ?>
</div>
<!--/NAVEGACIÓN-->

<!--ENCABEZADO-->
<div class="page-header">
<h1>Instanciar Proyecto <small>Pastoral UC</small></h1>
</div>
<!--/ENCABEZADO-->

<!--LINKS DERECHOS-->
<!--/LINKS DERECHOS-->

<table>
  <tbody>
  <?php if ($sf_user->hasFlash('instancia_fallida')): ?>
    <tr>
      <td></td>
      <td>
        <div class="alert alert-info span5"  id="info_tabla_vacia" style="text-align:center">
        <?php echo $sf_user->getFlash('instancia_fallida') ?>
        </div>
      </td>
    </tr>
  <?php endif ?>
  </tbody>
</table>

<form action="<?php echo url_for('proyecto/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
	<table class=" table-bordered table-striped table-condensed" class="btn">
		<tfoot>
		<tr>

		</tr>
		</tfoot>
		  <tbody>
			<tr>
				<?php echo $form['proyecto_id']->renderRow() ?> 			  
				<?php echo $form['ano']->renderRow() ?>
				<?php echo $form['version']->renderRow() ?>
        <?php echo $form['logo_url']->renderRow() ?>
				<?php echo $form->renderHiddenFields() ?>		
        
        <?php 
        $carreras = Array();
        $anos = Array();
        $contador = 0;
        ?>
        
        <tr><td>Jefe Nacional *</td>
						<td>
							<?php
              echo "<select id ='jefe_nacional' multiple='multiple' class='chzn-select' name='jefe_nacional[]'>";
              // Jefe Nacional seleccionado:
              if($jefes_nacionales_seleccionados!=null)
							{    
                echo '<option value="'.$jefes_nacionales_seleccionados[0]->getId().'" selected="selected">';  
                echo $jefes_nacionales_seleccionados[0]->getNombre().' '.$jefes_nacionales_seleccionados[0]->getApellidoPaterno();									
                echo '</option>'; 
              }
              // Opciones a elegir
              foreach($posibles_jefes as $u){               
                echo '<option value="'.$u->getId().'">';  			
                echo $u;
                echo '</option>';
              }
              echo "</select>";
              ?>	
            </td>
        </tr>
        
        <tr><td>Jefe de Finanzas</td>
						<td>
							<?php
              echo "<select id ='jefe_finanzas' class='chzn-select' multiple='multiple' name='jefe_finanzas[]'>";
              // Jefe Nacional seleccionado:
              if($jefes_finanzas_seleccionados!=null)
							{
                echo '<option value="'.$jefes_finanzas_seleccionados[0]->getId().'" selected="selected">';  
                echo $jefes_finanzas_seleccionados[0]->getNombre().' '.$jefes_finanzas_seleccionados[0]->getApellidoPaterno();									
                echo '</option>'; 
              }
              // Opciones a elegir
              foreach($posibles_jefes as $u){               
                echo '<option value="'.$u->getId().'">';  			
                echo $u;
                echo '</option>';
              }
              echo "</select>";
              ?>	
            </td>
        </tr>
        
        
        <tr><td>Jefe de Inscripciones</td>
						<td>
							<?php
              echo "<select id ='jefe_inscripc' multiple='multiple' class='chzn-select' name='jefe_inscripcion[]'>";
              // Jefe Nacional seleccionado:
              if($jefes_inscripciones_seleccionados!=null)
							{
                echo '<option value="'.$jefes_inscripciones_seleccionados[0]->getId().'" selected="selected">';  
                echo $jefes_inscripciones_seleccionados[0]->getNombre().' '.$jefes_inscripciones_seleccionados[0]->getApellidoPaterno();									
                echo '</option>'; 
              }
              // Opciones a elegir
              foreach($posibles_jefes as $u){               
                echo '<option value="'.$u->getId().'">';  			
                echo $u;
                echo '</option>';
              }
              echo "</select>";
              ?>	
            </td>
        </tr>
        
        <tr><td>Jefe de Extranjeros</td>
						<td>
							<?php
              echo "<select id ='jefe_extranje' multiple='multiple' class='chzn-select' name='jefe_extranjeros[]'>";
              // Jefe Nacional seleccionado:
              if($jefes_extranjeros_seleccionados!=null)
							{
                echo '<option value="'.$jefes_extranjeros_seleccionados[0]->getId().'" selected="selected">';  
                echo $jefes_extranjeros_seleccionados[0]->getNombre().' '.$jefes_extranjeros_seleccionados[0]->getApellidoPaterno().' ('.$jefes_extranjeros_seleccionados[0]->get;									
                echo '</option>'; 
              }
              // Opciones a elegir
              foreach($posibles_jefes as $u){               
                echo '<option value="'.$u->getId().'">';  			
                echo $u;
                echo '</option>';
              }
              echo "</select>";
              ?>	
            </td>
        </tr>
      
      </tr>
		  </tbody>
		</table>	
    
      <a href="<?php echo url_for('/index.php/proyecto') ?>"><span style='font-size:11px;'>&#9668; </span><span style='font-size:14px;'>Atr&aacute;s</span></a>
			<input class="btn btn-info" id='guardar' type="submit" value="Guardar" />
	</form>  