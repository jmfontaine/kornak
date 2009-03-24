<?php
/**
 * Kornak
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.kornak-framework.org/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@kornak-framework.org so we can send you a copy immediately.
 *
 * @category   Kornak
 * @package    Kornak_Controller
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

require_once 'Zend/Controller/Plugin/Abstract.php';

class Kornak_Controller_Plugin_MapHostnameToLocale extends Zend_Controller_Plugin_Abstract
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