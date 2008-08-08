<?php
function smarty_function_formPassword($parameters, $smarty)
{
    $html  = '<input type="password"';
    foreach($parameters as $name => $value) {
        $html .= ' ' . $name . '="' . $value . '"';
    }
    $html .= ' />';

    return $html;
}