<?php
require_once 'function.formButton.php';

function smarty_function_formSubmit($parameters, $smarty)
{
    $parameters['type'] = 'submit';
    return smarty_function_formButton($parameters, $smarty); 
}