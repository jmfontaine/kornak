<?php
class Kajoa_Controller_Action_Helper_Redirector extends Zend_Controller_Action_Helper_Redirector
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