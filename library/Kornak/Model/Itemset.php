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

class Kornak_Model_Itemset implements SeekableIterator, Countable
{
    protected $_count;
    protected $_data      = array();
    protected $_itemClass = 'Kornak_Model_Item';
    protected $_items     = array();
    protected $_model;
    protected $_pointer   = 0;

    public function __construct($model, array $config)
    {
        $this->_model = $model;

        if (isset($config['itemClass'])) {
            $this->_itemClass = $config['itemClass'];
        }
        @Kornak_Loader::loadClass($this->_itemClass);
        if (isset($config['data'])) {
            $this->_data = $config['data'];
        }

        $this->_count = count($this->_data);
    }

    public function count()
    {
        return $this->_count;
    }

    public function current()
    {
        if ($this->valid() === false) {
            return null;
        }

        if (empty($this->_items[$this->_pointer])) {
            $config = array('data' => $this->_data[$this->_pointer]);
            $item   = new $this->_itemClass($this->_model, $config);
            $this->_items[$this->_pointer] = $item;
        }

        return $this->_items[$this->_pointer];
    }

    public function key()
    {
        return $this->_pointer;
    }

    public function next()
    {
        ++$this->_pointer;
    }

    public function rewind()
    {
        $this->_pointer = 0;
        return $this;
    }

    public function seek($position)
    {
        $position = (int) $position;
        if ($position < 0 || $position > $this->_count) {
            require_once 'Kornak/Model/Itemset/Exception.php';
            throw new Kornak_Model_Itemset_Exception("Illegal index $position");
        }
        $this->_pointer = $position;
        return $this;
    }

    public function toArray()
    {
        foreach ($this->_items as $i => $item) {
            $this->_data[$i] = $item->toArray();
        }
        return $this->_data;
    }

    public function valid()
    {
        return $this->_pointer < $this->_count;
    }
}