<?php
function smarty_function_formHidden($parameters, $smarty)
{
    $html  = '<input type="hidden"';
    foreach($parameters as $name => $value) {
        $html .= ' ' . $name . '="' . $value . '"';
    }
    $html .= ' />';

    return $html;
}