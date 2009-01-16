<?php
class Kajoa_View_Helper_Partial extends Zend_View_Helper_Partial
{
    protected $_params = array();

    public function partial($name = null, $module = null, $model = null, $params = array())
    {
        $this->_params = $params;
        return parent::partial($name, $module, $model);
    }

    public function cloneView()
    {
        $view = clone $this->view;
        $view->clearVars();
        $view->assign($this->_params);
        return $view;
    }
}