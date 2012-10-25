<?php
class sfValidatorCustomForm extends sfValidatorBase
{
  protected function configure($options = array(), $messages = array())
  {
    $this->addOption('true_values', array('true', 't', 'yes', 'y', 'on', '1'));
    $this->addOption('false_values', array('false', 'f', 'no', 'n', 'off', '0'));
    $this->addOption('null_values', array('null', null));
  }
 
  protected function doClean($value)
  {
    if (in_array($value, $this->getOption('true_values')))
    {
      return true;
    }
 
    if (in_array($value, $this->getOption('false_values')))
    {
      return false;
    }
 
    if (in_array($value, $this->getOption('null_values')))
    {
      return null;
    }
 
    throw new sfValidatorError($this, 'invalid', array('value' => $value));
  }
 
  public function isEmpty($value)
  {
    return false;
  }
}