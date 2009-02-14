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
 * @package    Kajoa_Model
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

class Kajoa_Model_Adapter_Db
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

            require_once 'Kajoa/Application.php';
            $this->_db = Kajoa_Application::getInstance()
                                          ->getAspect('db')
                                          ->getConnection($connectionName);
        }
    }
}