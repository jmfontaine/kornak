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
 * @package    Kajoa_Form
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

class Kajoa_Form_Element_Html extends Kajoa_Form_Element_Xhtml
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