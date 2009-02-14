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

class Kajoa_Form_Decorator_FormErrors extends Zend_Form_Decorator_Abstract
{
    protected $_placement = 'PREPEND';

    public function render($content)
    {
        $form    = $this->getElement();
        $view    = $form->getView();
        if (null === $view) {
            return $content;
        }

        // KLUDGE: Workaround bug #ZF-3477 (http://framework.zend.com/issues/browse/ZF-3477)
        $view->getHelper('formErrors')->setElementStart('<ul%s><li>');

        $errors = $form->getFormErrors();
        if (empty($errors)) {
            return $content;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $errors    = $view->formErrors($errors, $this->getOptions());

        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $errors;
                break;
            case self::PREPEND:
                return $errors . $separator . $content;
                break;
        }
    }
}
