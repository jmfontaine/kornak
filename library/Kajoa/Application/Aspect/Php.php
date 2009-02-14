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

class Kajoa_Application_Aspect_Php extends Kajoa_Application_Aspect_Abstract
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