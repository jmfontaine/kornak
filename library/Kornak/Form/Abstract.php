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

require_once 'Zend/Form.php';

/**
 * @deprecated Deprecated since version 0.2
 */
class Kornak_Form_Abstract extends Zend_Form
{
    protected $_formErrors = array();

    public function __construct ($options = null)
    {
        $this->addPrefixPath('Kornak_Form_', 'Kornak/Form/');

        $this->setMethod('post')
             ->setAttrib('accept-charset', 'UTF-8');

        parent::__construct($options);
    }

    public function addFormError($error)
    {
        if (!is_string($error)) {
            throw new Kornak_Form_Exception('$error must be a string');
        }

        $this->_formErrors[] = $error;
    }

    public function getFormErrors()
    {
        return $this->_formErrors;
    }

    public function hasFormErrors()
    {
        return !empty($this->_formErrors);
    }

    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('FormElements')
                 ->addDecorator('HtmlTag', array('tag' => 'dl'))
                 ->addDecorator('FormErrors', array('class' => 'form-errors'))
                 ->addDecorator('Form');
        }
    }

    public function setFormErrors($errors)
    {
        if (is_array($errors)) {
            $this->_formErrors = $errors;
        } else if (is_string($errors)) {
            $this->_formErrors = array($errors);
        } else {
            throw new Kornak_Form_Exception('$error must be a string or an array');
        }
    }
}