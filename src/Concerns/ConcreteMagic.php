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

namespace Guanguans\SoarPHP\Concerns;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait ConcreteMagic
{
    /**
     * @since PHP 7.4.0
     *
     * @return array<string, mixed>
     */
    public function __serialize(): array
    {
        return [
            'options' => $this->options,
            'binary' => $this->binary,
        ];
    }

    /**
     * @since PHP 7.4.0
     *
     * @param array<string, mixed> $data
     */
    public function __unserialize(array $data): void
    {
        $this->setOptions($data['options']);
        $this->withBinary($data['binary']);
    }

    public function __debugInfo(): array
    {
        return $this->mergeDebugInfo(['commandLine' => (string) $this]);
    }

    /**
     * @param array<string, mixed> $properties
     *
     * @noinspection MagicMethodsValidityInspection
     */
    public static function __set_state(array $properties): self
    {
        return new self($properties['options'], $properties['binary']);
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     *
     * @noinspection MagicMethodsValidityInspection
     */
    public function __toString(): string
    {
        return $this->toProcess()->getCommandLine();
    }
}
