<?php
class Kajoa_View_Helper_FormLink extends Zend_View_Helper_FormElement
{
    public function formLink($name, $value = null, array $attribs = array())
    {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable, escape

        if (isset($attribs['label'])) {
            $label = $attribs['label'];
            unset($attribs['label']);
        } else {
            $label = '';
        }

        $html = sprintf(
            '<a%s>%s</a>',
            $this->_htmlAttribs($attribs),
            $label
        );
        
        return $html;
    }
}