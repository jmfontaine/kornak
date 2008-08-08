<?php
function smarty_function_formLabel($parameters, $smarty)
{
    $required = '';

    if (!empty($parameters['required'])) {
        $required = '<span class="required">*</span>';
        unset($parameters['required']);
    }
    
    $text = $parameters['value'];
    unset($parameters['value']);

    $html  = '<label';
    foreach($parameters as $name => $value) {
        $html .= ' ' . $name . '="' . $value . '"';
    }
    $html .= '>' . $text . $required . '</label>';

    return $html;
}