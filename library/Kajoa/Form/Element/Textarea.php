<?php
require_once 'Kajoa/Form/Element/Xhtml.php';

class Kajoa_Form_Element_Textarea extends Kajoa_Form_Element_Xhtml
{
    /**
     * Use formTextarea view helper by default
     * @var string
     */
    public $helper = 'formTextarea';
}