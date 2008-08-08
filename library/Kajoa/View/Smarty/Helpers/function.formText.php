<?php
function smarty_function_formText($parameters, $smarty)
{
    $html  = '<input type="text"';
    foreach($parameters as $name => $value) {
        $html .= ' ' . $name . '="' . $value . '"';
    }
    $html .= ' />';

    return $html;
}