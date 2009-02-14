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
require_once 'Zend/Mail.php';

class Kajoa_Application_Aspect_Mail extends Kajoa_Application_Aspect_Abstract
{
    protected $_transports = array();

    protected $_defaultSettings = array(
        'production'  => array(),
        'testing'     => array(),
        'development' => array(),
    );

    protected function _loadTransport($name, Zend_Config $settings)
    {
        switch ($settings->type) {
            case 'sendmail' :
                require_once 'Zend/Mail/Transport/Sendmail.php';
                $transport = new Zend_Mail_Transport_Sendmail($settings->parameters);
                break;

            case 'smtp' :
                $config = array();
                if (isset($settings->config)) {
                    $config = $settings->config->toArray();
                }

                require_once 'Zend/Mail/Transport/Smtp.php';
                $transport = new Zend_Mail_Transport_Smtp($settings->host, $config);
                break;

            default:
                require_once 'Kajoa/Application/Aspect/Exception.php';
                throw new Kajoa_Application_Aspect_Exception("Unknown transport type ({$settings->type})");
        }

        if ($settings->isDefault) {
            Zend_Mail::setDefaultTransport($transport);
        }

        $this->_transports[$name] = $transport;
    }

    public function getTransport($name = 'default')
    {
        if (!array_key_exists($name, $this->_transports)) {
            throw new Kajoa_Exception("Unknown transport ($name)");
        }

        return $this->_transports[$name];
    }

    public function init()
    {
        $settings = $this->getSettings();

        if (null == $settings->type) {
            foreach ($settings as $transportName => $transportSettings) {
                $this->_loadTransport($transportName, $transportSettings);
            }
        } else {
            $this->_loadTransport('default', $settings);
        }
    }
}