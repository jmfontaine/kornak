<?php
function smarty_function_formButton($parameters, $smarty)
{
    $text = $parameters['value'];
    unset($parameters['value']);    
    
    if (!empty($parameters['type'])) {
        $type = ' type="' . $parameters['type'] . '"';
        unset($parameters['type']);
    } else {
        $type = '';
    }
    
    $html = '<button' . $type;
    foreach($parameters as $name => $value) {
        $html .= ' ' . $name . '="' . $value . '"';
    }
    $html .= '>' . $text . '</button>'; 

    return $html;
}