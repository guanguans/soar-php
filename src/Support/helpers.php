<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\SoarPHP\Support\EscapeArg;
use Symfony\Component\Process\Process;

if (! function_exists('escape_argument')) {
    /**
     * Escapes a string to be used as a shell argument.
     */
    function escape_argument(?string $argument): string
    {
        return method_exists(Process::class, 'escapeArgument')
            ? (function (?string $argument): string {
                return $this->escapeArgument($argument);
            })->call(new Process([]), $argument)
            : EscapeArg::escape((string) $argument);
    }
}

if (! function_exists('array_reduce_with_keys')) {
    function array_reduce_with_keys(array $array, callable $callback, $carry = null)
    {
        foreach ($array as $key => $value) {
            $carry = $callback($carry, $value, $key);
        }

        return $carry;
    }
}

if (! function_exists('normalize_sql')) {
    function normalize_sql(string $sql): string
    {
        return str_replace(['`', '"'], ['\`', ''], $sql);
    }
}

if (! function_exists('str_starts_with')) {
    function str_starts_with(?string $haystack, ?string $needle): bool
    {
        return 0 === strncmp($haystack, $needle, strlen($needle));
    }
}

if (! function_exists('str_camel')) {
    function str_camel(string $str): string
    {
        $str = ucwords(str_replace(['-', '_'], ' ', $str));

        return lcfirst(str_replace(' ', '', $str));
    }
}

if (! function_exists('str_snake')) {
    function str_snake(string $str, string $delimiter = '_'): string
    {
        $str = preg_replace('/\s+/u', '', ucwords($str));

        return strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $str));
    }
}

if (! function_exists('trigger_deprecation')) {
    /**
     * Triggers a silenced deprecation notice.
     *
     * @param string $package The name of the Composer package that is triggering the deprecation
     * @param string $version The version of the package that introduced the deprecation
     * @param string $message The message of the deprecation
     * @param mixed  ...$args Values to insert in the message using printf() formatting
     *
     * @see https://github.com/symfony/deprecation-contracts
     */
    function trigger_deprecation(string $package, string $version, string $message, ...$args): void
    {
        /** @noinspection FunctionErrorSilencedInspection */
        @trigger_error(
            ($package || $version ? "Since $package $version: " : '').($args ? vsprintf($message, $args) : $message),
            \E_USER_DEPRECATED
        );
    }
}
