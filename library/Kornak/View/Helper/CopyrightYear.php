<?php
/**
 * Kornak
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to jm@jmfontaine.net so we can send you a copy immediately.
 *
 * @category   Kornak
 * @package    Kornak_View
 * @copyright  Copyright (c) 2007-2010 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @version    $Id$
 */

class Kornak_View_Helper_CopyrightYear extends Zend_View_Helper_Abstract
{
    public function copyrightYear($year)
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