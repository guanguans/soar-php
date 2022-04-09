<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Support;

class OsHelper
{
    /**
     * @var string
     */
    protected static $kernelName;

    /**
     * @var string
     */
    protected static $kernelVersion;

    public static function isUnix(): bool
    {
        return '/' === \DIRECTORY_SEPARATOR;
    }

    public static function isWindowsSubsystemForLinux(): bool
    {
        return self::isUnix() && false !== mb_strpos(strtolower(php_uname()), 'microsoft');
    }

    public static function isWindows(): bool
    {
        return '\\' === \DIRECTORY_SEPARATOR;
    }

    public static function isWindowsSeven(): bool
    {
        if (null === self::$kernelVersion) {
            self::$kernelVersion = php_uname('r');
        }

        return '6.1' === self::$kernelVersion;
    }

    public static function isWindowsEightOrHigher(): bool
    {
        if (null === self::$kernelVersion) {
            self::$kernelVersion = php_uname('r');
        }

        return version_compare(self::$kernelVersion, '6.2', '>=');
    }

    public static function isMacOS(): bool
    {
        if (null === self::$kernelName) {
            self::$kernelName = php_uname('s');
        }

        return false !== strpos(self::$kernelName, 'Darwin');
    }
}
