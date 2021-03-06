<?php
/**
 * Kornak
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to jm@jmfontaine.net so we can send you a copy immediately.
 *
 * @category   Kornak
 * @package    Kornak_Filter
 * @copyright  Copyright (c) 2007-2010 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @version    $Id$
 */

/**
 * @see Zend_Filter_Interface
 */
require_once 'Zend/Filter/Interface.php';

/**
 * Cut a string at a specified length if the string exceeds this length.
 *
 * @category   Kornak
 * @package    Kornak_Filter
 * @copyright  Copyright (c) 2007-2010 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @version    $Id$
 */
class Kornak_Filter_MaxLength implements Zend_Filter_Interface
{
    /**
     * String maximum length
     *
     * @var int
     */
    protected $_maxLength;

    /**
     * Class constructor
     *
     * @param $maxLength    int String maximum length
     * @return string
     */
    public function __construct($maxLength = null)
    {
        $this->setMaxLength($maxLength);
    }

    /**
     * Return the string cut at the specified length.
     *
     * @param $value    string  Value to filter
     * @return string
     */
    public function filter($value)
    {
        return substr($value, 0, $this->_maxLength);
    }

    /**
     * Return maximum string length.
     *
     * @return int
     */
    public function getMaxLength()
    {
        return $this->_maxLength;
    }

    /**
     * Define maximum string length.
     *
     * @param $length   int Maximum length
     * @return unknown_type
     */
    public function setMaxLength($length)
    {
        $this->_maxLength = (int) $length;
        return $this;
    }
}