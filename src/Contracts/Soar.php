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

namespace Guanguans\SoarPHP\Contracts;

interface Soar
{
    /**
     * @param null|callable(string, string): void $callback
     */
    public function run(?callable $callback = null): string;

    /**
     * @param list<string>|string $sqls
     */
    public function scores(array|string $sqls): string;

    public function help(): string;

    public function version(): string;
}
