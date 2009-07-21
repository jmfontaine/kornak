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
 * @package    Kornak_View
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

class Kornak_View_Helper_Menu_Container extends Zend_View_Helper_Placeholder_Container_Abstract
{
    protected $_attribs = array();

    protected function _buildUrl(array $data)
    {
        if (isset($data['route'])) {
            $route = $data['route'];
            unset($data['route']);
        } else {
            $route = 'default';
        }
        if (isset($data['reset'])) {
            $reset = (bool) $data['reset'];
            unset($data['reset']);
        } else {
            $reset = true;
        }

        $urlHelper = new Zend_View_Helper_Url();
        return $urlHelper->url($data, $route, $reset);
    }

    protected function _createData($value)
    {
        $data           = new stdClass();
        $data->id       = $value['id'];
        $data->label    = $value['label'];
        $data->selected = false;
        $data->url      = $value['url'];
        return $data;
    }

    public function append($value)
    {
        if (is_array($value['url'])) {
            $value['url'] = $this->_buildUrl($value['url']);
        }
        $data = $this->_createData($value);

        parent::append($data);
    }

    public function getItem($id)
    {
        foreach ($this as $item) {
            if ($id == $item->id) {
                return $item;
            }
        }

        throw new Kornak_Exception("Could not find item with id '$id'");
    }

    public function prepend($value)
    {
        if (is_array($value['url'])) {
            $value['url'] = $this->_buildUrl($value['url']);
        }
        $data = $this->_createData($value);

        parent::prepend($data);
    }

    public function reset()
    {
        $this->resetAttribs();

        $keys = array_keys((array) $this);
        foreach ($keys as $key) {
            unset($this->$key);
        }
    }

    public function resetAttribs()
    {
        $this->_attribs = array();
    }

    public function setAttrib($name, $value, $append = true)
    {
        if (array_key_exists($name, $this->_attribs) && $append) {
            $this->_attribs[$name] .= $value;
        } else {
            $this->_attribs[$name] = $value;
        }
    }

    public function setAttribs($attribs, $append = true)
    {
        foreach ($attribs as $name => $value) {
            $this->setAttrib($name, $value, $append);
        }
    }

    public function setSelectedItem($id) {
        foreach ($this as $item) {
            $item->selected = false;
        }

        $this->getItem($id)->selected = true;
    }

    public function toString($indent = null)
    {
        $t = (array) $this;

        if (empty($t)) {
            return '';
        }

        $indent = ($indent !== null)
                ? $this->getWhitespace($indent)
                : $this->getIndent();

        $result = '<ul';
        foreach ($this->_attribs as $name => $value) {
            $result .= ' ' . $name . '="' . $value . '"';
        }
        $result .= '>';

        foreach ($this as $item) {
                if ($item->selected) {
                    $result .= '<li class="selected"><span>' . $item->label . '</span></li>';
                } else {
                    $result .= '<li><a href="' . $item->url . '">' . $item->label . '</a></li>';
                }
        }
        $result .= '</ul>';

        return $indent . $result;
    }
}
