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
 * @package    Kajoa_Controller
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

require_once 'Kajoa/Application.php';

class Kajoa_Controller_Action extends Zend_Controller_Action
{
    protected $_application;

    public function init()
    {
        parent::init();

        $moduleName = $this->getRequest()->getModuleName();
        $this->_helper->layout->setLayout($moduleName . '/views/layouts/main');

        $this->_application = Kajoa_Application::getInstance();
    }
}