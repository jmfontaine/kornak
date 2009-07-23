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
 * @package    Kornak_Application
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

require_once 'Kornak/Application/Aspect/Abstract.php';
require_once 'Zend/Db.php';
require_once 'Zend/Db/Table/Abstract.php';

/**
 * @deprecated
 */
class Kornak_Application_Aspect_Db extends Kornak_Application_Aspect_Abstract
{
    protected $_connections = array();

    protected $_defaultSettings = array(
        'production'  => array(),
        'testing'     => array(),
        'development' => array(),
    );

    protected function _loadConnection($name, Zend_Config $settings)
    {
        $connection = Zend_Db::factory($settings->adapter, $settings);

        if ($settings->profiler) {
            if (!empty($settings->profilerClass)) {
                $profilerClass = $settings->profilerClass;
            } else {
                $profilerClass = 'Zend_Db_Profiler_Firebug';
            }
            Zend_Loader::loadClass($profilerClass);
            $profiler = new $profilerClass('Database queries');
            $profiler->setEnabled(true);
            $connection->setProfiler($profiler);
        }

        if (!empty($settings->connectionCharset)) {
            $connection->query("SET NAMES '$settings->connectionCharset'");
        }

        if ($settings->isDefault) {
            Zend_Db_Table_Abstract::setDefaultAdapter($connection);
        }

        $this->_connections[$name] = $connection;
    }

    public function getConnection($name = 'default')
    {
        if (!array_key_exists($name, $this->_connections)) {
            throw new Kornak_Exception("Unknown connection ($name)");
        }

        return $this->_connections[$name];
    }

    public function init()
    {
        $settings = $this->getSettings();

        if (null == $settings->adapter) {
            foreach ($settings as $connectionName => $connectionSettings) {
                $this->_loadConnection($connectionName, $connectionSettings);
            }
        } else {
            $this->_loadConnection('default', $settings);
        }
    }
}