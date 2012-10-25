<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <table>
    <tbody>
      
  <?php if ($sf_user->hasFlash('registro_exitoso')): ?>
    <tr>
      <td></td>
      <td>
        <div class="alert alert-info span5"  id="info_tabla_vacia" style="text-align:center">
        <?php echo $sf_user->getFlash('registro_exitoso') ?>
        </div>
      </td>
    </tr>
  <?php endif ?>
      <?php echo $form ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php if ($proyecto_dado == 1) : ?>
            <input type="hidden" name="pid" value="<?php echo $proyecto_id?>"/>
          <?php endif; ?>
          <input type="submit" value="<?php echo __('Ingresar', null, 'sf_guard') ?>" />
          
          <?php $routes = $sf_context->getRouting()->getRoutes() ?>
          <?php if (isset($routes['sf_guard_forgot_password'])): ?>
            <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
          <?php endif; ?>
          <p><a href="<?php echo url_for("usuario/recuperarPassword")?>">&iquest;Olvidaste tu contrase&ntilde;a?</a></p>
          <p><a href="<?php echo url_for('usuario/new').'?pid='.$proyecto_id; ?>" >&iquest;Quieres registrarte?</a></p>
        </td>
      </tr>
    </tfoot>
  </table>
</form>