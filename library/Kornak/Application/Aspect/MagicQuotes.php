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
 * @package    Kornak_Application
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

require_once 'Kornak/Application/Aspect/Abstract.php';

/**
 * @deprecated Deprecated since version 0.2
 */
class Kornak_Application_Aspect_MagicQuotes extends Kornak_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'remove_slashes' => true,
        ),
        'testing'     => array(),
        'development' => array(
        ),
    );

    protected function removeSlashes($array) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->removeSlashes($value);
            } else {
                $array[$key] = stripslashes($value);
            }
        }
        return $array;
    }

    public function init()
    {
        if ($this->getSettings()->remove_slashes && get_magic_quotes_gpc()) {
            $_GET    = $this->remove_magic_quotes($_GET);
            $_POST   = $this->remove_magic_quotes($_POST);
            $_COOKIE = $this->remove_magic_quotes($_COOKIE);
        }
    }
}