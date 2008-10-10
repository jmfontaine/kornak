<?php
class Kajoa_View_Helper_FormatCurrency extends Zend_View_Helper_Abstract
{
    public function formatCurrency($amount, $locale = null, $currency = null)
    {
        $currency = new Zend_Currency($currency, $locale);
        return $currency->toCurrency($amount);
    }
}