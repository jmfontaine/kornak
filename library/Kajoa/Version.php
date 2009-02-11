<?php
final class Kajoa_Version
{
    const VERSION = '0.2dev';

    /**
     * Compare the specified Kajoa version string $version
     * with the current Kajoa_Version::VERSION of Kajoa.
     *
     * @param  string  $version  A version string (e.g. "0.7.1").
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