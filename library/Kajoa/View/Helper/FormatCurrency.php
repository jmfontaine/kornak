<?php
/**
 * Kajoa
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.kajoa.org/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@kajoa.org so we can send you a copy immediately.
 *
 * @category   Kajoa
 * @package    Kajoa_View
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

class Kajoa_View_Helper_FormatCurrency extends Zend_View_Helper_Abstract
{
    public function formatCurrency($amount, $locale = null, $currency = null)
    {
        $currency = new Zend_Currency($currency, $locale);
        return $currency->toCurrency($amount);
    }
}