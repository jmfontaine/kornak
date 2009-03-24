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

require_once 'Kornak/Db/Table.php';

class Kornak_Model_Adapter_Dbtable
{
    protected $_table;

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->_table, $name), $arguments);
    }

    public function __construct($options = array())
    {
        $this->_table = new Kornak_Db_Table($options);
    }

    public function getTable()
    {
        return $this->_table;
    }

    public function setTable(Kornak_Db_Table $table)
    {
        $this->_table = $table;
    }
}