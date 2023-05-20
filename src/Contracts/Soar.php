<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Contracts;

interface Soar
{
    /**
     * @param array|string $withOptions
     */
    public function run($withOptions = []): string;

    /**
     * @param array<string>|string $sqls
     */
    public function scores($sqls): string;

    public function help(): string;

    public function version(): string;
}
