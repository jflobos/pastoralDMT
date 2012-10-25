<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardAuthActions.class.php 23800 2009-11-11 23:30:50Z Kris.Wallsmith $
 */
class BasesfGuardAuthActions extends sfActions
{
  public function executeSignin($request)
  {
    
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      return $this->redirect('@homepage');
    }
    //Vemos si se recibio el id del proyecto para poder incluirlo en el form de sign in.
    $this->proyecto_dado = 0;
    $this->proyecto_id = $request->getParameter("pid");
    if($request->getParameter("pid")!=null)
    {
      $this->proyecto_dado = 1;
    }
    
    $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin'); 
    $this->form = new $class();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('signin'));
      if ($this->form->isValid())
      {
        $values = $this->form->getValues(); 
        $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);

        // always redirect to a URL set in app.yml
        // or to the referer
        // or to the homepage
        $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer($request->getReferer()));
        
        
        //Revisamos si se mando el id del proyecto en el form, si no se mando se carga desde la DB.
        $proyecto_id = -1;
        if($request->getParameter('pid')!= null)
        {
          $proyecto_id = $request->getParameter('pid');
        }
        else
        {
          $proyecto_id = $this->getUser()->getGuardUser()->getProfile()->getUltimoProyectoAccedidoId();
        }
        $this->getUser() ->setAttribute('proyecto_id', $proyecto_id);
        
        //Se escribe en la DB el ultimo proyecto accesado.
        $this->getUser()->getGuardUser()->getProfile()->setUltimoProyectoAccedidoId($proyecto_id)->save();
        
        //Si el usuario tiene un cargo, se le pone el ultimo cargo como cargo actual.. 
        $uc = $this->getUser()->getGuardUser()->getProfile()->getCargoActual();
        if($uc!=null)
        {
            $this->getUser()->setAttribute('usuario_cargo', $uc);
        }else
        {
            $this->getUser()->getAttributeHolder()->remove('usuario_cargo');
        }

        return $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');
      }
    }
    else
    {
      if ($request->isXmlHttpRequest())
      {
        $this->getResponse()->setHeaderOnly(true);
        $this->getResponse()->setStatusCode(401);

        return sfView::NONE;
      }

      // if we have been forwarded, then the referer is the current URL
      // if not, this is the referer of the current request
      $user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

      $module = sfConfig::get('sf_login_module');
      if ($this->getModuleName() != $module)
      {
        return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
      }

      $this->getResponse()->setStatusCode(401);
    }
  }

  public function executeSignout($request)
  {
    $this->getUser()->signOut();

    $signoutUrl = sfConfig::get('app_sf_guard_plugin_success_signout_url', $request->getReferer());

    $this->redirect('' != $signoutUrl ? $signoutUrl : '@homepage');
  }

  public function executeSecure($request)
  {
    $this->getResponse()->setStatusCode(403);
  }

  public function executePassword($request)
  {
    throw new sfException('This method is not yet implemented.');
  }
}
