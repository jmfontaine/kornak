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

require_once 'Kajoa/Db/Table.php';

class Kajoa_Model_Adapter_Dbtable
{
    protected $_table;

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->_table, $name), $arguments);
    }

    public function __construct($options = array())
    {
        $this->_table = new Kajoa_Db_Table($options);
    }

    public function getTable()
    {
        return $this->_table;
    }

    public function setTable(Kajoa_Db_Table $table)
    {
        $this->_table = $table;
    }
}