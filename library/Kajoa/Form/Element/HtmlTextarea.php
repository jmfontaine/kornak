<?php
class Kajoa_Form_Element_HtmlTextarea extends Zend_Form_Element_Textarea
{
    protected $_htmlEditorOptions = array(
        'cleanup'                           => false,
        'editor_selector'                   => 'editor',
        'language'                          => 'en',
        'mode'                              => 'textareas',
        'plugins'                           => 'nonbreaking,paste',
        'theme'                             => 'advanced',
        'theme_advanced_buttons1'           => 'bold,italic,formatselect,' .
                                               'removeformat,link,unlink,|,' .
                                               'justifyleft,justifycenter,' .
                                               'justifyright,justifyfull,|,' .
                                               'bullist,numlist,outdent,indent',
        'theme_advanced_buttons2'           => 'cut,copy,paste,pastetext,' .
                                               'pasteword,|,undo,redo,|,' .
                                               'blockquote,hr,sub,sup,' .
                                               'nonbreaking,charmap',
        'theme_advanced_buttons3'           => '',
        'theme_advanced_buttons4'           => '',
        'theme_advanced_resize_horizontal'  => false,
        'theme_advanced_resizing'           => true,
        'theme_advanced_statusbar_location' => 'bottom',
        'theme_advanced_toolbar_align'      => 'left',
        'theme_advanced_toolbar_location'   => 'top',
    );
    
    protected function _initHtmlEditor()
    {
        $inlineScript = $this->getView()->inlineScript();
        $inlineScript->appendFile('/data/javascript/tiny_mce/tiny_mce.js');

        // Set the doctype
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $doctype      = (string) $viewRenderer->view->doctype();    
        $this->_htmlEditorOptions['doctype'] = $doctype;
        
        $script = 'tinyMCE.init(' . Zend_Json::encode($this->getHtmlEditorOptions()) . ');';
        $inlineScript->appendScript($script);
    }    
    
    public function getHtmlEditorOptions()
    {
        return $this->_htmlEditorOptions;        
    }
    
    public function init()
    {
        parent::init();

        $this->_initHtmlEditor();
        
        $this->setAttrib('rows', 15)
             ->setAttrib('class', 'editor')
             ->addFilter(new Kajoa_Filter_HtmlBody());        
    }
    
    public function setHtmlEditorOptions(array $options, $replace = false)
    {
        if ($replace) {
            $this->_htmlEditorOptions = $options;
        } else {
            $this->_htmlEditorOptions = array_merge($this->_htmlEditorOptions, $options);
        }
    }
}