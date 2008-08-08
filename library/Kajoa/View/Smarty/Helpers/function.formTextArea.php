<?php
function smarty_function_formTextArea($parameters, $smarty)
{
    $text = $parameters['value'];
    unset($parameters['value']);

    $html  = '<textarea';
    foreach($parameters as $name => $value) {
        $html .= ' ' . $name . '="' . $value . '"';
    }
    $html .= '>' . $text . '</textarea>';

    return $html;
}