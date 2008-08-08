<?php
class Kajoa_Controller_Plugin_RouterDebug extends Zend_Controller_Plugin_Abstract
{
    const WRITE_MODE_OVERWRITE = 0;
    const WRITE_MODE_APPEND    = 1;
    
    const DELIMITER_REQUEST = '++++++++++++++++++++++++++++++++++++++++';
    const DELIMITER_STAGE   = '==============================';
    
    protected $_filename;

    protected function _dumpVariable($name, $value)
    {
        ob_start();
        print_r($value);
        $dump = ob_get_clean();
        $this->_writeText("$name : $dump\n\n");    
    }

    protected function _writeStageFooter()
    {
        $this->_writeText(self::DELIMITER_STAGE . "\n\n");    
    }
    
    protected function _writeStageHeader($stage)
    {
        $this->_writeText(self::DELIMITER_STAGE . "\n");    
        $this->_writeText("$stage\n");
        $this->_writeText(self::DELIMITER_STAGE . "\n\n");    
    }

    protected function _writeRequestFooter()
    {
        $this->_writeText(self::DELIMITER_REQUEST . "\n\n");    
    }
    
    protected function _writeRequestHeader()
    {
        $this->_writeText("\n" . self::DELIMITER_REQUEST . "\n");    
        $this->_writeText('Request : ' . date('y/m/d H:i:s') . "\n");
        $this->_writeText(self::DELIMITER_REQUEST . "\n\n");    
    }
    
    protected function _writeText($text)
    {
        file_put_contents($this->_filename, $text, FILE_APPEND);    
    }
    
    public function __construct($filename, $writeMode = self::WRITE_MODE_OVERWRITE)
    {
        $this->setFilename($filename, $writeMode);
    }

    public function dispatchLoopShutdown()
    {
        $this->_writeStageHeader('Dispatch loop shutdown');
        $this->_writeStageFooter();
    }
    
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->_writeStageHeader('Dispatch loop startup');
        $this->_writeStageFooter();
    }
    
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->_writeStageHeader('Post dispatch');
        $this->_dumpVariable('module'    , $request->getModuleName());        
        $this->_dumpVariable('controller', $request->getControllerName());        
        $this->_dumpVariable('action'    , $request->getActionName());
        $this->_writeStageFooter();
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->_writeStageHeader('Pre dispatch');
        $this->_dumpVariable('module'    , $request->getModuleName());        
        $this->_dumpVariable('controller', $request->getControllerName());        
        $this->_dumpVariable('action'    , $request->getActionName());
        $this->_writeStageFooter();
    }
    
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $this->_writeStageHeader('Route shutdown');
        $this->_dumpVariable('$request', $request);        
        $this->_writeStageFooter();
    }
    
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->_writeRequestHeader();        

        $this->_writeStageHeader('Route startup');
        $this->_dumpVariable('$request', $request);        
        $this->_writeStageFooter();
    }

    public function setFilename($filename, $writeMode)
    {
        $this->_filename = $filename;
        if (self::WRITE_MODE_OVERWRITE == $writeMode && file_exists($filename)) {
            unlink($filename);
        }
    }
}