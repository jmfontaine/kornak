<?php
require_once 'Kajoa/Loader.php';

class Kajoa_View_Helper_Truncate extends Zend_View_Helper_Abstract
{
    public function truncate($text, $length = 30)
    {
        return substr($text, 0, $length) . '…';
    }
}