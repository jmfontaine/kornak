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
 * @package    Kajoa_Version
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

/**
 * Class to store and retrieve the version of Kajoa.
 *
 * @category   Kajoa
 * @package    Kajoa_Version
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 */
final class Kajoa_Version
{
    const VERSION = '0.2dev';

    /**
     * Compare the specified Kajoa version string $version
     * with the current Kajoa_Version::VERSION of Kajoa.
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