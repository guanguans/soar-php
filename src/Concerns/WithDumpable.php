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

namespace Guanguans\SoarPHP\Concerns;

use Symfony\Component\VarDumper\VarDumper;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait WithDumpable
{
    /**
     * @noinspection PhpNoReturnAttributeCanBeAddedInspection
     */
    public function dd(mixed ...$args): void
    {
        $this->dump(...$args);

        exit(1);
    }

    /**
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection DebugFunctionUsageInspection
     */
    public function dump(mixed ...$args): self
    {
        $args[] = $this;
        $varDumperExists = class_exists(VarDumper::class);

        foreach ($args as $arg) {
            $varDumperExists ? VarDumper::dump($arg) : var_dump($arg);
        }

        return $this;
    }

    protected function mergeDebugInfo(array $debugInfo): array
    {
        return class_exists(VarDumper::class) ? $debugInfo : get_object_vars($this) + $debugInfo;
    }
}
