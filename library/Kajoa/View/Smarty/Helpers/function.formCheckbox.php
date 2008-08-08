<?php
function smarty_function_formCheckbox($parameters, $smarty)
{
    $checked = (bool) $parameters['value'] ? ' checked="checked"' : '';
    $parameters['value'] = 1;
    
    $html  = '<input type="checkbox"';
    foreach($parameters as $name => $value) {
        $html .= ' ' . $name . '="' . $value . '"';
    }
    $html .= $checked . ' />';

    return $html;
}