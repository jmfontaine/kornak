<?php
require_once 'Zend/View/Helper/Url.php';

class Kajoa_View_Helper_Url extends Zend_View_Helper_Url
{
    public function url(array $urlOptions = array(), $name = null, $reset = false, $encode = true, $autoConvertToRelative = true)
    {
        $url = parent::url($urlOptions, $name, $reset, $encode);

        // Convert to relative URL if hostname is the same as current one
        if ($autoConvertToRelative && $_SERVER['HTTP_HOST'] == parse_url($url, PHP_URL_HOST)) {
            $position = strpos($url, $_SERVER['HTTP_HOST']) + strlen($_SERVER['HTTP_HOST']);
            $url = substr($url, $position);
        }

        return $url;
    }
}