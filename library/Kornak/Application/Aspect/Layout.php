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
 * @package    Kornak_Application
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

require_once 'Kornak/Application/Aspect/Abstract.php';
require_once 'Zend/Layout.php';

/**
 * @deprecated Deprecated since version 0.2
 */
class Kornak_Application_Aspect_Layout extends Kornak_Application_Aspect_Abstract
{
    public function init()
    {
        $layout = Zend_Layout::startMvc();

        $applicationPath = $this->getApplication()->getApplicationPath();
        $layout->setLayoutPath($applicationPath . '/modules');
    }
}