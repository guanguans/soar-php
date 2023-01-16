<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Concerns;

use Symfony\Component\VarDumper\VarDumper;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait WithDumpable
{
    /**
     * @return never-return
     */
    public function dd(...$args)
    {
        $this->dump(...$args);

        exit(1);
    }

    /**
     * @psalm-suppress ForbiddenCode
     *
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection DebugFunctionUsageInspection
     */
    public function dump(...$args): self
    {
        $args[] = $this;
        $args[] = $this->version();
        $args[] = $this->help();

        if (class_exists(VarDumper::class)) {
            foreach ($args as $arg) {
                VarDumper::dump($arg);
            }

            return $this;
        }

        foreach ($args as $arg) {
            var_dump($arg);
        }

        return $this;
    }
}
