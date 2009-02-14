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
 * @package    Kajoa_Loader
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

require_once "Zend/Loader.php";

class Kajoa_Loader extends Zend_Loader
{
    public static function loadForm($name, $module = null)
    {
        $frontController = Zend_Controller_Front::getInstance();
        if (null === $module) {
            $module = $frontController->getDefaultModule();
        }

        $applicationPath = Kajoa_Application::getInstance()->getApplicationPath();
        $formPath        = $applicationPath . '/modules/' . $module . '/forms';

        self::loadClass($name . 'Form', $formPath);
    }

    public static function loadModel($name, $module = null)
    {
        $frontController = Zend_Controller_Front::getInstance();
        if (null === $module) {
            $module = $frontController->getDefaultModule();
        }

        $applicationPath = Kajoa_Application::getInstance()->getApplicationPath();
        $modelPath       = $applicationPath . '/modules/' . $module . '/models';

        self::loadClass($name . 'Model', $modelPath);
    }
}