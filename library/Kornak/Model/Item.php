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
 */
class Kornak_Model_Item
{
    protected $_data = array();

    protected $_model;

    protected $_readOnly = false;

    public function __construct($model, array $config = array())
    {
        $this->_model = $model;

        if (isset($config['data'])) {
            if (!is_array($config['data'])) {
                require_once 'Kornak/Model/Item/Exception.php';
                throw new Kornak_Model_Item_Exception('Data must be an array');
            }
            $this->_data = $config['data'];
        }

        if (isset($config['readOnly'])) {
            $this->_readOnly = (bool) $config['readOnly'];
        }
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->_data)) {
            require_once 'Kornak/Model/Item/Exception.php';
            throw new Kornak_Model_Item_Exception("Specified property \"$name\" is not in the item");
        }
        return $this->_data[$name];
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->_data);
    }

    public function __set($name, $value)
    {
        if (!array_key_exists($name, $this->_data)) {
            require_once 'Kornak/Model/Item/Exception.php';
            throw new Kornak_Model_Item_Exception("Specified property \"$name\" is not in the item");
        }

        if ($this->_readOnly) {
            require_once 'Kornak/Model/Item/Exception.php';
            throw new Kornak_Model_Item_Exception('This item is read only');
        }

        $this->_data[$name] = $value;
    }

    public function toArray()
    {
        return (array)$this->_data;
    }

    public function remove()
    {
        if ($this->_readOnly) {
            require_once 'Kornak/Model/Item/Exception.php';
            throw new Kornak_Model_Item_Exception('This item is read only');
        }
        return $this->_model->removeById($this->id);
    }

    public function save()
    {
        if ($this->_readOnly) {
            require_once 'Kornak/Model/Item/Exception.php';
            throw new Kornak_Model_Item_Exception('This item is read only');
        }

        if (!isset($this->id)) {
            return $this->_model->add($this->toArray());
        } else {
            return $this->_model->updateById($this->id, $this->toArray());
        }
    }
}