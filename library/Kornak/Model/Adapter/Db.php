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
 * @package    Kornak_Model
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

/**
 * @deprecated Deprecated since version 0.2
 */class Kornak_Model_Adapter_Db
{
    protected $_db;

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->_db, $name), $arguments);
    }

    public function __construct($options = array())
    {
        if (isset($options['adapter'])) {
            $adapter = $options['adapter'];
            unset($options['adapter']);
            require_once 'Zend/Db.php';
            $this->_db = Zend_Db::factory($adapter, $options);
        } else {
            $connectionName = 'default';
            if (!empty($options['connection'])) {
                $connectionName = $options['connection'];
            }

            require_once 'Kornak/Application.php';
            $this->_db = Kornak_Application::getInstance()
                                          ->getAspect('db')
                                          ->getConnection($connectionName);
        }
    }
}