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
 * @package    Kornak_Filter
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id: MaxLength.php 158 2009-03-24 16:41:24Z jmf@durcommefaire.net $
 */

/**
 * @see Zend_Filter_Interface
 */
require_once 'Zend/Filter/Interface.php';

/**
 * Format a string so that it can be used in an URL.
 *
 * @category   Kornak
 * @package    Kornak_Filter
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id: $
 */
class Kornak_Filter_UrlString implements Zend_Filter_Interface
{
    /**
     * Return the string formated for URL inclusion.
     *
     * @param $value    string  Value to filter
     * @return string
     */
    public function filter($value)
    {
        $value = strtolower($value);

        $previousLocale = setlocale(LC_CTYPE, 0);
        setlocale(LC_CTYPE, 'en_US.UTF8');
        $value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        setlocale(LC_CTYPE, $previousLocale);

        $value = preg_replace('/[^a-z0-9]/', '-', $value);
        $value = trim($value, '-');
        return $value;
    }
}