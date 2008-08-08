<?php
function smarty_function_formFile($parameters, $smarty)
{
    $html  = '<input type="file"';
    foreach($parameters as $name => $value) {
        $html .= ' ' . $name . '="' . $value . '"';
    }
    $html .= ' />';

    return $html;
}