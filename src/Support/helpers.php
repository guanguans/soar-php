<?php

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

namespace Guanguans\SoarPHP\Support;

use Symfony\Component\Process\Process;

if (!\function_exists('Guanguans\SoarPHP\Support\array_reduce_with_keys')) {
    function array_reduce_with_keys(array $array, callable $callback, $carry = null)
    {
        foreach ($array as $key => $value) {
            $carry = $callback($carry, $value, $key);
        }

        return $carry;
    }
}

if (!\function_exists('Guanguans\SoarPHP\Support\escape_argument')) {
    /**
     * Escapes a string to be used as a shell argument.
     *
     * @see https://github.com/johnstevenson/winbox-args
     * @see https://github.com/composer/composer/blob/main/src/Composer/Util/ProcessExecutor.php
     */
    function escape_argument(?string $argument): string
    {
        return (fn (?string $argument): string => $this->escapeArgument($argument))->call(new Process([]), $argument);
    }
}

if (!\function_exists('Guanguans\SoarPHP\Support\str_camel')) {
    function str_camel(string $str): string
    {
        $str = ucwords(str_replace(['-', '_'], ' ', $str));

        return lcfirst(str_replace(' ', '', $str));
    }
}

if (!\function_exists('Guanguans\SoarPHP\Support\str_snake')) {
    function str_snake(string $str, string $delimiter = '_'): string
    {
        $str = preg_replace('/\s+/u', '', ucwords($str));

        return strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $str));
    }
}
