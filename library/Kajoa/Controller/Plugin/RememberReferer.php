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

require_once 'Zend/Controller/Plugin/Abstract.php';
require_once 'Zend/Session/Namespace.php';

class Kajoa_Controller_Plugin_RememberReferer extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopShutdown()
    {
        $referer = $this->getRequest()->getRequestUri();
        $session = new Zend_Session_Namespace('RememberReferer');

        if (!isset($session->lastReferer)) {
            $session->lastReferer = $referer;
            return;
        }

        // Do not save the referer if it the same as the last saved one
        // (ie : page refresh or form submission)
        if ($referer == $session->lastReferer) {
            return;
        }

        // Save the last 2 referers to make sure to have one referer
        // different from the current one
        $session->nextToLastReferer = $session->lastReferer;
        $session->lastReferer       = $referer;
    }
}