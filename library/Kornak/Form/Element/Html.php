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
 * @package    Kornak_Form
 * @copyright  Copyright (c) 2007-2010 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @version    $Id$
 */

class Kornak_Form_Element_Html extends Kornak_Form_Element_Xhtml
{
    protected $_html;

    public $helper = 'formHtml';

    public function getHtml()
    {
        return $this->_html;
    }

    public function render(Zend_View_Interface $view = null)
    {
        $this->setValue($this->getHtml());
        return parent::render($view);
    }

    public function setHtml($html)
    {
        $this->_html = $html;
        return $this;
    }
}