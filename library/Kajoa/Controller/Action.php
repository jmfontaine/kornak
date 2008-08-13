<?php
class Kajoa_Controller_Action extends Zend_Controller_Action
{
    protected $_errorMessages = array();
    protected $_logger;

    protected function _addErrorMessage($message)
    {
        $this->_errorMessages[] = $message;
    }

    protected function _addErrorMessages($rules)
    {
        foreach ($rules as $rule) {
            foreach ($rule as $message) {
                $this->_addErrorMessage($message);
            }
        }
    }
    
    protected function _addMessage($message, $namespace = 'default')
    {
        $this->_helper->_flashMessenger->setNamespace($namespace);
        $this->_helper->_flashMessenger->addMessage($message);    
        $this->_helper->_flashMessenger->resetNamespace();
    }
    
    protected function _assignErrorMessagesToView()
    {
        $this->view->errorMessages = $this->_errorMessages;
    }
    
    /**
     * Class constructor
     *
     * The request and response objects should be registered with the
     * controller, as should be any additional optional arguments; these will be
     * available via {@link getRequest()}, {@link getResponse()}, and
     * {@link getInvokeArgs()}, respectively.
     *
     * When overriding the constructor, please consider this usage as a best
     * practice and ensure that each is registered appropriately; the easiest
     * way to do so is to simply call parent::__construct($request, $response,
     * $invokeArgs).
     *
     * After the request, response, and invokeArgs are set, the
     * {@link $_helper helper broker} is initialized.
     *
     * Finally, {@link init()} is called as the final action of
     * instantiation, and may be safely overridden to perform initialization
     * tasks; as a general rule, override {@link init()} instead of the
     * constructor to customize an action controller's instantiation.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param Zend_Controller_Response_Abstract $response
     * @param array $invokeArgs Any additional invocation arguments
     * @return void
     */
    public function __construct(Zend_Controller_Request_Abstract $request,
        Zend_Controller_Response_Abstract $response,
        array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);

        $this->_logger = Zend_Registry::get('logger');
    }    
    
    public function init()
    {
        $this->getResponse()->setHeader('X-Powered-By', 'Kajoa', true);
        
        $this->_helper->layout->setLayout('site/main');

        $this->view->headMeta()->appendName('Author', 'Kanopée');
        $this->view->headMeta()->appendName('Content-Type', 'text/html; charset=UTF-8');
        $this->view->headMeta()->appendName('Generator', 'Kajoa');
        $this->view->headMeta()->appendName('MSSmartTagsPreventParsing', 'true');
        
        $this->view->headLink()->appendStylesheet('/gui/site/css/reset.css');  
        $this->view->headLink()->appendStylesheet('/gui/site/css/screen.css');  
    }
    
    public function postDispatch()
    {
        $this->_assignErrorMessagesToView();
    }
}