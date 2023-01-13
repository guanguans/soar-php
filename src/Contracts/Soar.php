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
     * @param array|string|null $options
     */
    public function run($options = null): string;

    public function scores(string $sql): string;

    public function help(): string;

    public function version(): string;
}
