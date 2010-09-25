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
 * @package    Kornak_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2007-2010 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @version    $Id$
 */

/** @see Zend_Loader */
require_once 'Zend/Loader.php';

/**
 * Helper for loading, instantiating and returning a model
 *
 * @category   Kornak
 * @package    Kornak_View
 * @subpackage Helper
 */
class Kornak_View_Helper_Model extends Zend_View_Helper_Abstract
{
	/**
	 * Loads, instantiate and returns the model
	 *
	 * @param string $class Class of the model to return
	 */
    public function model($class)
    {
        Zend_Loader::loadClass($class);
        return new $class();
    }
}