<?php
function smarty_function_append($parameters, $smarty)
{
    if (empty($parameters['var'])) {
        throw new Kajoa_Exception('Missing array name');
    }
    if (empty($parameters['value'])) {
        throw new Kajoa_Exception('Missing value');
    }
    
    $smarty->append($parameters['var'], $parameters['value']);
}