<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';

class Kajoa_Application_Aspect_MagicQuotes extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'remove_slashes' => true,
        ),
        'testing'     => array(),
        'development' => array(
        ),
    );

    protected function removeSlashes($array) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->removeSlashes($value);
            } else {
                $array[$key] = stripslashes($value);
            }
        }
        return $array;
    }

    public function init()
    {
        if ($this->getSettings()->remove_slashes && get_magic_quotes_gpc()) {
            $_GET    = $this->remove_magic_quotes($_GET);
            $_POST   = $this->remove_magic_quotes($_POST);
            $_COOKIE = $this->remove_magic_quotes($_COOKIE);
        }
    }
}