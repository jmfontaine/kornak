<?php
class Kajoa_View_Helper_CopyrightYear extends Zend_View_Helper_Abstract
{
    public function CopyrightYear($year)
    {
        $currentYear = date('Y');
        
        if ($year == $currentYear) {
            $result = $year;
        } else {
            $result = $year . ' - ' . $currentYear;
        }
        
        return $result;
    }
}