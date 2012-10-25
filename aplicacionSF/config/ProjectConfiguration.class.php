<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();


class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfJQueryUIPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
    sfValidatorBase::setDefaultMessage('required', 'Requerido.');
    sfValidatorBase::setDefaultMessage('invalid', 'Inv&aacute;lido.');
    //sfValidatorDoctrineUnique::setMessage('invalid', 'asdasd "%column%" already exist.');
    $this->enablePlugins('sfPhpExcelPlugin');
  }
}
