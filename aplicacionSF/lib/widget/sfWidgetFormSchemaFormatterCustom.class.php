<?php

class sfWidgetFormSchemaFormatterCustom extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<tr class ='normal control-group'> \n    <th class='control-label'>%label%</th>\n  <td class='controls'>%error%%field%%help%%hidden_fields%</td>\n</tr>\n",
    $errorRowFormat  = "<tr class ='error'><td colspan=\"2\">\n%errors%</td></tr>\n",
    $errorListFormatInARow = '%errors%',
    $errorRowFormatInARow = ' <div class="control-group error">
            <label class="control-label" for="inputError"></label>
            <div class="controls">
              <span class="help-inline">%error%</span>
            </div>
          </div>',
    $helpFormat      = '<br />%help%',
    $decoratorFormat = '<table class="embedded">  %content%</table>';
}
