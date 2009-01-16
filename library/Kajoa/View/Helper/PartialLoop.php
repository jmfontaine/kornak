<?php
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