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

class Kajoa_View_Helper_PartialLoop extends Zend_View_Helper_PartialLoop
{
    protected $_params = array();

    public function partialLoop($name = null, $module = null, $model = null, $params = array())
    {
        $this->_params = $params;
        return parent::partialLoop($name, $module, $model);
    }

    public function cloneView()
    {
        $view = clone $this->view;
        $view->clearVars();
        $view->assign($this->_params);
        return $view;
    }
}