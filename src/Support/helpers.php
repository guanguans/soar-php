<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

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
