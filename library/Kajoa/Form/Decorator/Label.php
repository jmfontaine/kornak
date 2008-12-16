<?php
require_once 'Kajoa/Form/Decorator/Label.php';

class Kajoa_Form_Decorator_Label extends Zend_Form_Decorator_Label
{
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

        $includeErrors = !empty($options['includeErrors']);
        if ($includeErrors && !empty($messages)) {
            unset($options['includeErrors']);
            require_once 'Zend/Form/Decorator/HtmlTag.php';
            $decorator = new Zend_Form_Decorator_HtmlTag();
            $decorator->setOptions(array('tag' => 'strong'));
            $label .= $decorator->render(current($messages));
        }

        if (!empty($label)) {
            $options['class']  = $class;
            $label = $view->formLabel($element->getFullyQualifiedName(), trim($label), $options);
        } else {
            $label = '&nbsp;';
        }

        if (null !== $tag && '' != $placement) {
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
            default:
                $label = substr($label, 0, -8);
                return $label . $content . '</label>';
        }
    }
}