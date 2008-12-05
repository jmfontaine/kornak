<?php
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