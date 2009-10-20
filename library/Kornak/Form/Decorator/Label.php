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
 * @package    Kornak_Form
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

require_once 'Kornak/Form/Decorator/Label.php';

/**
 * @deprecated Deprecated since version 0.2
 */
class Kornak_Form_Decorator_Label extends Zend_Form_Decorator_Label
{
    const WRAP_BEFORE = 'WRAP_BEFORE';
    const WRAP_AFTER  = 'WRAP_AFTER';

    public function getPlacement()
    {
        if (null !== ($placementOpt = $this->getOption('placement'))) {
            $placementOpt = strtoupper($placementOpt);
            switch ($placementOpt) {
                case self::APPEND:
                case self::PREPEND:
                case self::WRAP_BEFORE:
                case self::WRAP_AFTER:
                    $this->_placement = $placementOpt;
                    break;
                case false:
                    $this->_placement = null;
                    break;
                default:
                    break;
            }
            $this->removeOption('placement');
        }

        return $this->_placement;
    }

    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $label     = $this->getLabel();
        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $tag       = $this->getTag();
        $id        = $this->getId();
        $class     = $this->getClass();
        $options   = $this->getOptions();
        $messages  = $this->getElement()->getMessages();

        if (empty($label) && empty($tag) && empty($messages)) {
            return $content;
        }

        if (!empty($options['includeErrors'])) {
            unset($options['includeErrors']);
            if (!empty($messages)) {
                require_once 'Zend/Form/Decorator/HtmlTag.php';
                $decorator = new Zend_Form_Decorator_HtmlTag();
                $decorator->setOptions(array('tag' => 'strong'));
                $label .= $decorator->render(current($messages));
            }
        }

        if (!empty($label)) {
            $options['class']  = $class;
            $label = $view->formLabel($element->getFullyQualifiedName(), trim($label), $options);
        } else {
            $label = '&nbsp;';
        }

        if (null !== $tag && self::WRAP_BEFORE != $placement && self::WRAP_AFTER != $placement) {
            require_once 'Zend/Form/Decorator/HtmlTag.php';
            $decorator = new Zend_Form_Decorator_HtmlTag();
            $decorator->setOptions(array('tag' => $tag));
            $label = $decorator->render($label);
        }

        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $label;

            case self::PREPEND:
                return $label . $separator . $content;

            case self::WRAP_BEFORE:
            case self::WRAP_AFTER:
                $position   = strpos($label, '>');
                $openingTag = substr($label, 0, $position + 1);
                $text       = substr($label, $position + 1, -8);

                if (self::WRAP_BEFORE == $placement) {
                    return $openingTag . $text . $content . '</label>';
                } else {
                    return $openingTag . $content . $text . '</label>';
                }
        }
    }
}