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
 * @package    Kajoa_Application
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Layout.php';

class Kajoa_Application_Aspect_Layout extends Kajoa_Application_Aspect_Abstract
{
    public function init()
    {
        $layout = Zend_Layout::startMvc();

        $applicationPath = $this->getApplication()->getApplicationPath();
        $layout->setLayoutPath($applicationPath . '/modules');
    }
}