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
 * @package    Kajoa_View
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

require_once 'Zend/View/Helper/Placeholder/Container/Abstract.php';
require_once 'Zend/View/Helper/Placeholder/Container/Standalone.php';

class Kajoa_View_Helper_BodyClass extends Zend_View_Helper_Placeholder_Container_Standalone
{
    protected $_regKey = 'Kajoa_View_Helper_BodyClass';

    public function bodyClass($class = null, $setType = Zend_View_Helper_Placeholder_Container_Abstract::APPEND)
    {
        if ($class) {
            if ($setType == Zend_View_Helper_Placeholder_Container_Abstract::SET) {
                $this->set($class);
            } elseif ($setType == Zend_View_Helper_Placeholder_Container_Abstract::PREPEND) {
                $this->prepend($class);
            } else {
                $this->append($class);
            }
        }

        return $this;
    }

    public function has($class)
    {
        $classes = (array) $this->getValue();
        return in_array($class, $classes);
    }

    public function toString($indent = null)
    {
        $indent = (null !== $indent)
                ? $this->getWhitespace($indent)
                : $this->getIndent();

        $items = array();
        foreach ($this as $item) {
            $items[] = $item;
        }

        if (empty($items)) {
            $result = '';
        } else {
            $result = $indent . ' class="' .  implode(' ', $items) . '"';
        }
        return $result;
    }

    public function __toString()
    {
        return $this->toString();
    }
}