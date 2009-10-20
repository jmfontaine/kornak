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
 * @package    Kornak_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
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
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @license    http://www.kornak-framework.org/license/new-bsd     New BSD License
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