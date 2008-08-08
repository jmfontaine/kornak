<?php
function smarty_function_formImage($parameters, $smarty)
{
    $html  = '<input type="image"';
    foreach($parameters as $name => $value) {
        $html .= ' ' . $name . '="' . $value . '"';
    }
    $html .= ' />';

    return $html;
}