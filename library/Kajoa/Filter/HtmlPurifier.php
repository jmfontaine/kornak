<?php
require_once 'HTMLPurifier.auto.php';

class Kajoa_Filter_HtmlPurifier implements Zend_Filter_Interface
{
    protected $_htmlPurifier = null;
   
    public function __construct($options = array())
    {
        // Set cache path if not defined yet
        $cachePathFound = false;
        foreach ($options as $name => $value) {
            if ('Cache.SerializerPath' == $name) {
                $cachePathFound = true;
                break;
            }
        }
        if (!$cachePathFound) {
            $options['Cache.SerializerPath'] = Application_Bootstrap::getInstance()->getTempPath() . '/htmlpurifier';
        }
        
        // Define HTMLPurifier config
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray($options);

        $this->_htmlPurifier = new HTMLPurifier($config);
    }

    public function filter($value)
    {
        return $this->_htmlPurifier->purify($value);
    }
}