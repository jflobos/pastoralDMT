<?php

class sfWidgetFormSchemaFormatterEmbedded extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<tr class ='normal'>\n  <th>%label%</th>\n  <td>%error%%field%%help%%hidden_fields%</td>\n</tr>\n",
    $errorRowFormat  = "<tr class ='error'><td colspan=\"2\">\n%errors%</td></tr>\n",
    $errorListFormatInARow = '%errors%',
    
    $errorRowFormatInARow = ' <div class="control-group error">
            <label class="control-label" for="inputError"></label>
            <div class="controls">
              <span class="help-inline">%error%</span>
            </div>
          </div>', //antes del span <input type="text" id="inputError">

    $helpFormat      = '<br />%help%',
    $decoratorFormat = '%content%';
}
