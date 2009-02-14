<?php
/**
 * Kajoa
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.kajoa.org/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@kajoa.org so we can send you a copy immediately.
 *
 * @category   Kajoa
 * @package    Kajoa_View
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

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