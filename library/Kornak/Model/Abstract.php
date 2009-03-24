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

require_once 'Kornak/Loader.php';

abstract class Kornak_Model_Abstract
{
    protected $_adapters     = array();
    protected $_itemClass    = 'Kornak_Model_Item';
    protected $_itemsetClass = 'Kornak_Model_Itemset';

    protected function _createItem($data)
    {
        if (empty($data)) {
            return false;
        }

        $config = array('data' => $data);
        Kornak_Loader::loadClass($this->_itemClass);
        return new $this->_itemClass($this, $config);
    }

    protected function _createItemset($data)
    {
        $config = array('data' => $data);
        Kornak_Loader::loadClass($this->_itemsetClass);
        return new $this->_itemsetClass($this, $config);
    }

    public function __construct()
    {
        $this->init();
    }

    public function getAdapter($name = 'default')
    {
        if (array_key_exists($name, $this->_adapters)) {
            return $this->_adapters[$name];
        } else {
            return false;
        }
    }

    public function init()
    {
    }

    public function setAdapter($adapter, $name = 'default')
    {
        $this->_adapters[$name] = $adapter;
    }
}