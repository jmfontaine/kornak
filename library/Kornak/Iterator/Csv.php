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
 * @package    Kornak_Iterator
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id: $
 */

class Kornak_Iterator_Csv implements Iterator
{
    const ROW_SIZE = 4096;

    protected $_currentRow;
    protected $_delimiter;
    protected $_fileHandle;
    protected $_rowCounter = 0;

    public function __construct($path, $delimiter = ',')
    {
        $this->_fileHandle = fopen($path, 'r');
        $this->_delimiter  = $delimiter;
    }

    public function rewind()
    {
        $this->_rowCounter = 0;
        rewind($this->_fileHandle);
    }

    public function current()
    {
        $this->_currentRow = fgetcsv($this->_fileHandle, self::ROW_SIZE, $this->_delimiter);
        $this->_rowCounter++;
        return $this->_currentRow;
    }

    public function key()
    {
        return $this->_rowCounter;
    }

    public function next()
    {
        return !feof($this->_fileHandle);
    }

    public function valid()
    {
        if(!$this->next()) {
            fclose($this->_fileHandle);
            return false;
        }
        return true;
    }
}