<?php
require_once 'function.formButton.php';

function smarty_function_formReset($parameters, $smarty)
{
    $parameters['type'] = 'reset';
    return smarty_function_formButton($parameters, $smarty); 
}