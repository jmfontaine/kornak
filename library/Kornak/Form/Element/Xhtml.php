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
 * @package    Kornak_Form
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

require_once 'Zend/Form/Element/Xhtml.php';

class Kornak_Form_Element_Xhtml extends Zend_Form_Element_Xhtml
{
    protected $_includeErrors = true;

    protected $_requiredSuffix = 'required';

    public function __construct($spec, $options = null)
    {
        $this->addPrefixPath('Kornak_Form_', 'Kornak/Form/');
        parent::__construct($spec, $options = null);
    }

    public function getRequiredSuffix()
    {
        return $this->_requiredSuffix;
    }

    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                 ->addDecorator('HtmlTag', array('tag' => 'dd'))
                 ->addDecorator('Label', array(
                        'tag'            => 'dt',
                        'requiredSuffix' => $this->_requiredSuffix,
                        'includeErrors'  => $this->_includeErrors,
                 ));
        }
    }

    public function setRequiredSuffix($value, $escape = true)
    {
        $this->_requiredSuffix = $value;

        // Update default "Label" decorator because it is loaded
        // before this method is called
        if (!$this->loadDefaultDecoratorsIsDisabled()) {
              $decorator = $this->getDecorator('Label');
              $decorator->setOption('requiredSuffix', $this->_requiredSuffix);
              $decorator->setOption('escape', $escape);
        }

        return $this;
    }
}