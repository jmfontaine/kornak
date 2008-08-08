<?php
function smarty_function_widget($parameters, $smarty)
{
    if (empty($parameters['name'])) {
         throw new Kajoa_Exception('Missing "name" attribute');
    } else {
        $name = $parameters['name'];
         unset($parameters['name']);
    }
    
    $module = null;
    $params = array();
    if (!empty($parameters['module'])) {
         $module = $parameters['module'];
         unset($parameters['module']);
    }
    if (!empty($parameters['params']) && is_array($parameters['params'])) {
         $params = $parameters['params'];
         unset($parameters['params']);
    }
    if (!empty($parameters)) {
         $params = array_merge_recursive($params, $parameters);
    }
    
    $view = &$smarty->get_template_vars('this');
    
    $helper = new Zend_View_Helper_Action;
    $helper->setView($view);
    return $helper->action($name, 'widget', $module, $params);
}