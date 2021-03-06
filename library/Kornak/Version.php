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
 * @package    Kornak_Version
 * @copyright  Copyright (c) 2007-2010 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @version    $Id$
 */

/**
 * Class to store and retrieve the version of Kornak.
 *
 * @category   Kornak
 * @package    Kornak_Version
 */
final class Kornak_Version
{
    const VERSION = '0.3dev';

    /**
     * Compare the specified Kornak version string $version
     * with the current Kornak_Version::VERSION of Kornak.
     *
     * @param  string  $version  A version string (e.g. '0.7.1').
     * @return boolean           -1 if the $version is older,
     *                           0 if they are the same,
     *                           and +1 if $version is newer.
     *
     */
    public static function compareVersion($version)
    {
        return version_compare($version, self::VERSION);
    }
}