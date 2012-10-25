<?php
class sfWidgetCustomForm extends sfWidgetForm
{
  public function configure($options = array(), $attributes = array())
  {
 
    $this->addOption('choices', array(
      0 => 'No',
      1 => 'Yes',
      'null' => 'Null'
    ));
  }
 
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $value = $value === null ? 'null' : $value;
 
    $options = array();
    foreach ($this->getOption('choices') as $key => $option)
    {
      $attributes = array('value' => self::escapeOnce($key));
      if ($key == $value)
      {
        $attributes['selected'] = 'selected';
      }
 
      $options[] = $this->renderContentTag(
        'option',
        self::escapeOnce($option),
        $attributes
      );
    }
 
    return $this->renderContentTag(
      'select',
      "\n".implode("\n", $options)."\n",
      array_merge(array('name' => $name), $attributes
    ));
  }
}