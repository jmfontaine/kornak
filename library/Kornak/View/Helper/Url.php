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
 * @subpackage Helper
 * @copyright  Copyright (c) 2007-2010 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @version    $Id$
 */

require_once 'Zend/View/Helper/Url.php';

class Kornak_View_Helper_Url extends Zend_View_Helper_Url
{
    public function url(array $urlOptions = array(), $name = null,
        $reset = false, $encode = true, $autoConvertToRelative = true)
    {
        $url = parent::url($urlOptions, $name, $reset, $encode);

        // Convert to relative URL if hostname is the same as current one
        if ($autoConvertToRelative && $_SERVER['HTTP_HOST'] == parse_url($url, PHP_URL_HOST)) {
            $position = strpos($url, $_SERVER['HTTP_HOST']) + strlen($_SERVER['HTTP_HOST']);
            $url = substr($url, $position);
        }

        return $url;
    }
}