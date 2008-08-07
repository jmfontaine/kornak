<?php
class Kajoa_Crypt
{
    const PASSWORD_TYPE_PRONOUNCEABLE   = 'prononceable';
    const PASSWORD_TYPE_UNPRONOUNCEABLE = 'unprononceable';
    
    public static function generatePassword($length = 8, $type = self::PASSWORD_TYPE_UNPRONOUNCEABLE)
    {
        if (self::PASSWORD_TYPE_UNPRONOUNCEABLE == $type) {
            return self::generateUnpronounceablePassword($length);
        } else {
            return self::generateUnpronounceablePassword($length);
        }
    }
    
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
            $password .= $consonants[mt_rand(0, $consonantsCount - 1)] . $vowels[mt_rand(0, $vowelsCount - 1)];
        }

        return substr($password, 0, $length);
        
    }
    
    public static function generateUnpronounceablePassword($length = 8)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $numberOfCharacters = 62;
        
        $password = '';
         for ($i = 0; $i < $length; $i++) {
             $index     = mt_rand(0, $numberOfCharacters - 1);
             $password .= $characters{$index};
         }
        
         return $password;
    }
    
    public static function hash($value)
    {
        $authSalt = Zend_Registry::get('settings')->misc->auth_salt;
        return sha1($authSalt . md5($authSalt . $value) . $value);
    }
}