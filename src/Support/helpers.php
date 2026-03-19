<?php

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

if (!\function_exists('Guanguans\SoarPHP\Support\str_snake')) {
    function str_snake(string $value, string $delimiter = '-'): string
    {
        /** @var array<string, array<string, string>> $snakeCache */
        static $snakeCache = [];
        $key = $value;

        if (isset($snakeCache[$key][$delimiter])) {
            return $snakeCache[$key][$delimiter];
        }

        if (!ctype_lower($value)) {
            $value = (string) preg_replace('/\s+/u', '', ucwords($value));
            $value = mb_strtolower((string) preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value), 'UTF-8');
        }

        return $snakeCache[$key][$delimiter] = $value;
    }
}
