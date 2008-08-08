<?php
function smarty_function_formSelect($parameters, $smarty)
{
    $options = $parameters['options'];
    unset($parameters['options']);    
    $value = $parameters['value'];
    unset($parameters['value']);  
    
    $html  = '<select';
    foreach($parameters as $parameterName => $parameterValue) {
        $html .= ' ' . $parameterName . '="' . $parameterValue . '"';
    }
    $html .= '>';
    
    foreach ($options as $optionValue => $optionName) {
        $selected = $value == $optionValue ? ' selected="selected"' : '';
        $html .= '<option value="' . $optionValue . '"' . $selected . '>' . $optionName . '</option>';
    }
    
    $html .= '</select>';

    return $html;
}