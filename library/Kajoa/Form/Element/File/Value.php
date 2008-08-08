<?php
class Kajoa_Form_Element_File_Value extends ArrayObject
{
    public function __toString()
    {
        $result = '';
        if(isset($this->name)) {
            $result = $this->name;
        }
        return $result;
    }
}
