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
    /**
     * @param $carry
     *
     * @return mixed|null
     */
    function array_reduce_with_keys(array $array, callable $callback, $carry = null)
    {
        foreach ($array as $key => $value) {
            $carry = call_user_func($callback, $carry, $value, $key);
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
