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

use Guanguans\SoarPHP\Exceptions\RuntimeException;

/**
 * This file was modified from https://github.com/jolicode/JoliNotif.
 * This file was modified from https://github.com/utopia-php/system.
 */
class OS
{
    public const X86 = 'x86';

    public const PPC = 'ppc';

    public const ARM = 'arm';

    private const RegExX86 = '/(x86*|i386|i686)/';

    private const RegExARM = '/(aarch*|arm*)/';

    private const RegExPPC = '/(ppc*)/';

    /** @var null|string */
    private static $os;

    /** @var null|string */
    private static $oSVersion;

    /** @var null|string */
    private static $arch;

    /** @var null|string */
    private static $hostname;

    public static function isUnix(): bool
    {
        return '/' === \DIRECTORY_SEPARATOR;
    }

    public static function isWindowsSubsystemForLinux(): bool
    {
        return self::isUnix() && false !== mb_stripos(php_uname(), 'microsoft');
    }

    public static function isWindows(): bool
    {
        return '\\' === \DIRECTORY_SEPARATOR;
    }

    public static function isWindowsSeven(): bool
    {
        return '6.1' === self::getOsVersion();
    }

    public static function isWindowsEightOrHigher(): bool
    {
        return version_compare(self::getOsVersion(), '6.2', '>=');
    }

    public static function isMacOS(): bool
    {
        return false !== strpos(self::getOs(), 'Darwin');
    }

    /**
     * Checks if the system is running on an ARM architecture.
     */
    public static function isArm(): bool
    {
        return (bool) preg_match(self::RegExARM, self::getArch());
    }

    /**
     * Checks if the system is running on an X86 architecture.
     */
    public static function isX86(): bool
    {
        return (bool) preg_match(self::RegExX86, self::getArch());
    }

    /**
     * Checks if the system is running on an PowerPC architecture.
     */
    public static function isPPC(): bool
    {
        return (bool) preg_match(self::RegExPPC, self::getArch());
    }

    /**
     * Checks if the system is the passed architecture.
     * You should pass `self::X86`, `self::PPC`, `self::ARM` or an equivalent string.
     *
     * @throws \Guanguans\SoarPHP\Exceptions\RuntimeException
     */
    public static function isArch(string $arch): bool
    {
        if (self::X86 === $arch) {
            return self::isX86();
        }

        if (self::PPC === $arch) {
            return self::isPPC();
        }

        if (self::ARM === $arch) {
            return self::isArm();
        }

        throw new RuntimeException("`$arch` not found.");
    }

    /**
     * Returns the architecture's Enum of the system's processor.
     *
     * @throws \Guanguans\SoarPHP\Exceptions\RuntimeException
     */
    public static function getArchEnum(): string
    {
        $arch = self::getArch();

        if (preg_match(self::RegExX86, $arch)) {
            return self::X86;
        }

        if (preg_match(self::RegExPPC, $arch)) {
            return self::PPC;
        }

        if (preg_match(self::RegExARM, $arch)) {
            return self::ARM;
        }

        throw new RuntimeException("`$arch` enum not found.");
    }

    /**
     * Returns the system's OS.
     */
    public static function getOs(): string
    {
        if (null === self::$os) {
            self::$os = php_uname('s');
        }

        return self::$os;
    }

    /**
     * Returns the system's OS version.
     */
    public static function getOsVersion(): string
    {
        if (null === self::$oSVersion) {
            self::$oSVersion = php_uname('r');
        }

        return self::$oSVersion;
    }

    /**
     * Returns the architecture of the system's processor.
     */
    public static function getArch(): string
    {
        if (null === self::$arch) {
            self::$arch = php_uname('m');
        }

        return self::$arch;
    }

    /**
     * Returns the system's hostname.
     */
    public static function getHostname(): string
    {
        if (null === self::$hostname) {
            self::$hostname = php_uname('n');
        }

        return self::$hostname;
    }
}
