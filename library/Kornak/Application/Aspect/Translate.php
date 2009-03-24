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
require_once 'Zend/Registry.php';
require_once 'Zend/Translate.php';

class Kornak_Application_Aspect_Translate extends Kornak_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'adapter'  => 'gettext',
            'scanMode' => Zend_Translate::LOCALE_FILENAME,
        ),
        'testing'     => array(),
        'development' => array(),
    );

    public function init()
    {
        $dataPath         = $this->getApplication()->getDataPath();
        $translationsPath = realpath($dataPath . '/translations');

        $adapter   = $this->getSetting('adapter');
        $options   = array('scan' => $this->getSetting('scanMode'));
        $translate = new Zend_Translate($adapter, $translationsPath, null, $options);
        Zend_Registry::set('Zend_Translate', $translate);
    }
}