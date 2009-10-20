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
require_once 'Zend/Filter/Word/DashToCamelCase.php';

/**
 * @deprecated Deprecated since version 0.2
 */
class Kornak_Model_Adapter
{
    public static function factory($name, $options = array())
    {
        $filter = new Zend_Filter_Word_DashToCamelCase();
        $class  = 'Kornak_Model_Adapter_' . $filter->filter($name);
        Kornak_Loader::loadClass($class);
        return new $class($options);
    }
}