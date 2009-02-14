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

class Kajoa_Application_Aspect_Debug extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'logPhpErrors' => false,
        ),
        'testing'     => array(),
        'development' => array(
            'logPhpErrors' => true,
        ),
    );

    protected $_phpErrors;

    protected $_phpErrorsStats = array(
        'error'   => 0,
        'warning' => 0,
        'notice'  => 0,
        'strict'  => 0,
    );

    public function init()
    {
        $settings = $this->getSettings();

        if ($settings->logPhpErrors) {
            set_error_handler(array($this, 'logPhpError'), error_reporting());

            require_once 'Zend/Wildfire/Plugin/FirePhp/TableMessage.php';
            $this->_phpErrors = new Zend_Wildfire_Plugin_FirePhp_TableMessage('PHP errors');
            $this->_phpErrors->setBuffered(true);
            $this->_phpErrors->setHeader(array('Code', 'Message', 'File', 'Line'));
            $this->_phpErrors->setDestroy(true);

            require_once 'Zend/Wildfire/Plugin/FirePhp.php';
            Zend_Wildfire_Plugin_FirePhp::getInstance()->send($this->_phpErrors);
        }
    }

    public function logPhpError($code, $message, $file, $line, $context)
    {
        // ignore error if it has been suppressed with an @
        if (error_reporting() == 0) {
            return;
        }

        switch ($code) {
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                $code = 'Error';
                $this->_phpErrorsStats['error']++;
                break;

            case E_WARNING:
            case E_USER_WARNING:
                $code = 'Warning';
                $this->_phpErrorsStats['warning']++;
                break;

            case E_NOTICE:
            case E_USER_NOTICE:
                $code = 'Notice';
                $this->_phpErrorsStats['notice']++;
                break;

            case E_STRICT:
                $code = 'Strict';
                $this->_phpErrorsStats['strict']++;
                break;

            default:
                require_once 'Kajoa/Application/Aspect/Exception.php';
                throw new Kajoa_Application_Aspect_Exception("Unhandled error code '$code'");
        }

        $this->_phpErrors->setDestroy(false);
        $this->_phpErrors->addRow(array($code, $message, $file, $line));

        $label = sprintf(
            'PHP errors (%d errors, %d warnings, %d notices, %d strict)',
            $this->_phpErrorsStats['error'],
            $this->_phpErrorsStats['warning'],
            $this->_phpErrorsStats['notice'],
            $this->_phpErrorsStats['strict']
        );
        $this->_phpErrors->setLabel($label);

        // Let the error continue its way through PHP
        return false;
    }
}