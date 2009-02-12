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
 * @package    Kajoa_Text
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

/**
 * Generate random passwords either pronounceable or not.
 *
 * @category   Kajoa
 * @package    Kajoa_Text
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @license    http://www.kajoa.org/license/new-bsd     New BSD License
 */
class Kajoa_Text_Password
{
    /**
     *
     * @var string
     */
    const PASSWORD_TYPE_PRONOUNCEABLE   = 'prononceable';
    const PASSWORD_TYPE_UNPRONOUNCEABLE = 'unprononceable';

    /**
     * Generate a random password either pronounceable or not depending on the type.
     *
     * @param $length   int     Password length
     * @param $type     string  Password type
     * @return string   Generated password
     */
    public static function generatePassword($length = 8, $type = self::PASSWORD_TYPE_UNPRONOUNCEABLE)
    {
        if (self::PASSWORD_TYPE_UNPRONOUNCEABLE == $type) {
            return self::generateUnpronounceablePassword($length);
        } else {
            return self::generateUnpronounceablePassword($length);
        }
    }

    /**
     * Generate random pronounceable password.
     *
     * @param $length   int Password length
     * @return string   Generated password
     */
    public static function generatePronounceablePassword($length = 8)
    {
        $password = '';

        $vowels = array(
            'a', 'e', 'i', 'o', 'u', 'ae', 'ai', 'ea', 'ei', 'ia', 'io', 'ou'
        );
        $consonants = array(
            'b', 'c', 'd', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'r', 's',
            't', 'u', 'v', 'w', 'ch', 'cl', 'cr', 'fr', 'dr', 'pr', 'sl', 'st',
            'th', 'tr'
        );
        $vowelsCount     = 12;
        $consonantsCount = 27;

        for ($i = 0; $i < $length; $i++) {
            $consonant = $consonants[mt_rand(0, $consonantsCount - 1)];
            $vowel     = $vowels[mt_rand(0, $vowelsCount - 1)];
            $password .=  $consonant . $vowel;
        }

        return substr($password, 0, $length);

    }

    /**
     * Generate random unpronounceable password.
     *
     * @param $length   int Password length
     * @return string   Generated password
     */
    public static function generateUnpronounceablePassword($length = 8)
    {
        $characters  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters .= 'abcdefghijklmnopqrstuvwxyz0123456789';
        $numberOfCharacters = 62;

        $password = '';
         for ($i = 0; $i < $length; $i++) {
             $index     = mt_rand(0, $numberOfCharacters - 1);
             $password .= $characters{$index};
         }

         return $password;
    }

}