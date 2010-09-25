<?php
/**
 * Kornak
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to jm@jmfontaine.net so we can send you a copy immediately.
 *
 * @category   Kornak
 * @package    Kornak_Controller
 * @copyright  Copyright (c) 2007-2010 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @version    $Id$
 */

class Kornak_Controller_Action_Helper_Redirector extends Zend_Controller_Action_Helper_Redirector
{
    public function getReferer()
    {
        $session = new Zend_Session_Namespace('RememberReferer');

        if (!isset($session->lastReferer)) {
            $url = '/';
        } elseif ($session->lastReferer == $this->getRequest()->getRequestUri()) {
            if (isset($session->nextToLastReferer)) {
                $url = $session->nextToLastReferer;
            } else {
                $url = '/';
            }
        } else {
            $url = $session->lastReferer;
        }

        return $url;
    }

    public function gotoReferer()
    {
        $this->gotoUrlAndExit($this->getReferer(), array('prependBase' => false));
    }
}