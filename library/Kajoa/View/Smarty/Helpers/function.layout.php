<?php
function smarty_function_layout($parameters, $smarty)
{
    $key = 'content';
    if (!empty($parameters['key'])) {
         $key = $parameters['key'];
    }
    return $smarty->get_template_vars('this')->layout()->$key;
}