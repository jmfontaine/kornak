<?php
function smarty_function_button($parameters, $smarty)
{
    if (!empty($parameters['icon'])) {
        $icon = '<img src="/gui/admin/images/icons/' . $parameters['icon'] . '" alt="">';
        unset($parameters['icon']);
    } else {
       $icon = '';   
    }

    $label = $parameters['label'];
    unset($parameters['label']);    
    
    $linkUrl = smarty_function_url($parameters, $smarty);     

    $html = '<a href="' . $linkUrl . '" class="button">' . $icon . $label . '</a>'; 
    return $html;
}