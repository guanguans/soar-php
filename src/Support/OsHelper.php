<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

/**
 * Copyright (c) 2019-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

namespace Guanguans\SoarPHP\Support;

use Guanguans\SoarPHP\Exceptions\RuntimeException;

/**
 * @see https://github.com/jolicode/php-os-helper
 * @see https://github.com/loophp/phposinfo
 * @see https://github.com/utopia-php/system
 */
class OsHelper
{
    private const ARM = 'arm';
    private const PPC = 'ppc';
    private const X86 = 'x86';
    private const PATTERN_ARM = '/(aarch*|arm*)/';
    private const PATTERN_PPC = '/(ppc*)/';
    private const PATTERN_X86 = '/(x86*|i386|i686)/';

    public static function isUnix(): bool
    {
        return '/' === \DIRECTORY_SEPARATOR;
    }

    public static function isWindows(): bool
    {
        return '\\' === \DIRECTORY_SEPARATOR;
    }

    public static function isMacOS(): bool
    {
        return str_contains(php_uname('s'), 'Darwin');
    }

    public static function isArm(): bool
    {
        return (bool) preg_match(self::PATTERN_ARM, self::getArch());
    }

    public static function isPPC(): bool
    {
        return (bool) preg_match(self::PATTERN_PPC, self::getArch());
    }

    public static function isX86(): bool
    {
        return (bool) preg_match(self::PATTERN_X86, self::getArch());
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\RuntimeException
     */
    public static function getArchEnum(): string
    {
        $arch = self::getArch();

        return match (1) {
            preg_match(self::PATTERN_X86, $arch) => self::X86,
            preg_match(self::PATTERN_PPC, $arch) => self::PPC,
            preg_match(self::PATTERN_ARM, $arch) => self::ARM,
            default => throw new RuntimeException("The [$arch] enum not found."),
        };
    }

    public static function getArch(): string
    {
        return php_uname('m');
    }
}
