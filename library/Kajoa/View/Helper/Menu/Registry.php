<?php
require_once 'Zend/View/Helper/Placeholder/Registry.php';

class Kajoa_View_Helper_Menu_Registry extends Zend_View_Helper_Placeholder_Registry
{
    /**
     * Zend_Registry key under which menu registry exists
     * @const string
     */
    const REGISTRY_KEY = 'Kajoa_View_Helper_Menu_Registry';

    /**
     * Default container class
     * @var string
     */
    protected $_containerClass = 'Kajoa_View_Helper_Menu_Container';

    /**
     * Retrieve or create registry instance
     *
     * @return void
     */
    public static function getRegistry()
    {
        if (Zend_Registry::isRegistered(self::REGISTRY_KEY)) {
            $registry = Zend_Registry::get(self::REGISTRY_KEY);
        } else {
            $registry = new self();
            Zend_Registry::set(self::REGISTRY_KEY, $registry);
        }

        return $registry;
    }
}