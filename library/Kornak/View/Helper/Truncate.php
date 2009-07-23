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
 * @package    Kornak_View
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

require_once 'Kornak/Loader.php';

class Kornak_View_Helper_Truncate extends Zend_View_Helper_Abstract
{
    public function truncate($text, $length = 30)
    {
        if (strlen($text) > $length) {
            $filter = new Kornak_Filter_MaxLength($length - 1);
            $text = $filter->filter($text) . '…';
        }

        return $text;
    }
}