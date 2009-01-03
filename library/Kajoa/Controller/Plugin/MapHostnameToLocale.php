<?php
require_once 'Zend/Controller/Plugin/Abstract.php';

class Kajoa_Controller_Plugin_MapHostnameToLocale extends Zend_Controller_Plugin_Abstract
{
    protected $_options;

    public function __construct($options = null)
    {
        if (null !== $options) {
            $this->setOptions($options);
        }
    }

    public function getOptions()
    {
        return $this->_options;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $host = $_SERVER['HTTP_HOST'];

        // KLUDGE : Temporary workaround for problem with dots in INI config files
        $host = str_replace('.', '-', $host);

        if (array_key_exists($host, $this->_options)) {
            $locale = $this->_options[$host];
        } else {
            $locale = 'auto';
        }

        $locale = new Zend_Locale($locale);
        Zend_Registry::set('Zend_Locale', $locale);

        Zend_Registry::get('Zend_Translate')->setLocale($locale);
    }

    public function setOptions(array $options)
    {
        $this->_options = $options;
    }
}