<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';

class Kajoa_Application_Aspect_Php extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'defaultCharset' => 'UTF-8',
            'displayErrors'  => false,
            'errorReporting' => 8191, // E_ALL|E_STRICT
            'timezone'       => 'Europe/London',
        ),
        'testing'     => array(),
        'development' => array(
            'displayErrors'  => true,
        ),
    );
    
    public function init()
    {
        $settings = $this->getSettings();

        // PHP core
        ini_set('default_charset', $settings->defaultCharset);
        ini_set('display_errors', $settings->displayErrors);
        ini_set('error_reporting', $settings->errorReporting);
        
        // Date extension
        ini_set('date.timezone', $settings->timezone);
    }
}