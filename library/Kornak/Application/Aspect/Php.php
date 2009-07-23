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

/**
 * @deprecated Deprecated since version 0.2
 */
class Kornak_Application_Aspect_Php extends Kornak_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'defaultCharset' => 'UTF-8',
            'displayErrors'  => false,
            'errorReporting' => 8191, // E_ALL|E_STRICT
            'timezone'       => 'Europe/London',
        ),
        'testing'     => array(),
        'development' => array(
            'displayErrors'  => true,
        ),
    );

    public function init()
    {
        $settings = $this->getSettings();

        // PHP core
        ini_set('default_charset', $settings->defaultCharset);
        ini_set('display_errors', $settings->displayErrors);
        ini_set('error_reporting', $settings->errorReporting);

        // Date extension
        ini_set('date.timezone', $settings->timezone);
    }
}