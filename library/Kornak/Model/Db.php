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

require_once 'Kornak/Model/Abstract.php';

/**
 * @deprecated Deprecated since version 0.2
 */
class Kornak_Model_Db extends Kornak_Model_Abstract
{
    protected $_options = array();

    protected function _createItem($data)
    {
        if (is_object($data)) {
            $data = $data->toArray();
        }
        return parent::_createItem($data);
    }

    protected function _createItemset($data)
    {
        if (is_object($data)) {
            $data = $data->toArray();
        }
        return parent::_createItemset($data);
    }

    public function __construct()
    {
        $adapter = Kornak_Model_Adapter::factory('db-table', $this->_options);
        $this->setAdapter($adapter);

        parent::__construct();
    }

    public function add(array $data)
    {
        return $this->getAdapter()->insert($data);
    }

    public function getAll(Kornak_Model_Conditions $conditions = null,
        $fields = '*', $orderBy = null, $limit = null)
    {
        $select = $this->getAdapter()->select();

        if (null !== $conditions) {
            $select->where($conditions);
        }

        if (null !== $orderBy) {
            $select->order($orderBy);
        }

        if (null !== $limit) {
            $select->limit($limit);
        }


        $data = $this->getAdapter()->fetchAll($select);
        if (false !== $data) {
            $data = $this->_createItemset($data);
        }
        return $data;
    }

    public function getById($id)
    {
        $data = $this->getAdapter()->find($id)->current();
        if (false !== $data) {
            $data = $this->_createItem($data);
        }
        return $data;
    }

    public function getOne(Kornak_Model_Conditions $conditions = null,
        $fields = '*', $orderBy = null)
    {
        $select = $this->getAdapter()->select();
        $select->limit(1);

        if (null !== $conditions) {
            $select->where($conditions);
        }

        if (null !== $orderBy) {
            $select->order($orderBy);
        }

        $data = $this->getAdapter()->fetchRow($select);
        if (null !== $data) {
            $data = $this->_createItem($data);
        }
        return $data;
    }

    public function getOption($name)
    {
        if (array_key_exists($name, $this->_options)) {
            return $this->_options[$name];
        }

        return false;
    }

    public function getTable()
    {
        return $this->getAdapter()->getAdapter();
    }

    public function getTableName()
    {
        $this->getOption('name');
    }

    public function remove(Kornak_Model_Conditions $conditions)
    {
        return $this->getAdapter()->delete($conditions->toSql());
    }

    public function removeById($id)
    {
        $conditions = new Kornak_Model_Conditions('id', $id);
        return $this->remove($conditions);
    }

    public function select()
    {
        require_once 'Zend/Db/Select.php';
        return $this->getAdapter()->getTable()->select();
    }

    public function update(array $data, Kornak_Model_Conditions $conditions)
    {
        return $this->getAdapter()->update($data, $conditions->toSql());
    }

    public function updateById($id, array $data)
    {
        $conditions = new Kornak_Model_Conditions('id', $id);
        return $this->update($data, $conditions);
    }
}