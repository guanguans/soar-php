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

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait ConcreteMagic
{
    // public function __sleep(): array
    // {
    //     return ['options', 'soarBinary'];
    // }
    //
    // public function __wakeup(): void
    // {
    //     $this->setOptions($this->options);
    //     $this->setSoarBinary($this->soarBinary);
    // }

    /**
     * @since PHP 7.4.0
     */
    public function __serialize(): array
    {
        return [
            'options' => $this->options,
            'soarBinary' => $this->soarBinary,
        ];
    }

    /**
     * @since PHP 7.4.0
     */
    public function __unserialize(array $data): void
    {
        $this->setOptions($data['options']);
        $this->setSoarBinary($data['soarBinary']);
    }

    public function __debugInfo(): array
    {
        return $this->mergeDebugInfo(['commandLine' => (string) $this]);
    }

    /**
     * @noinspection MagicMethodsValidityInspection
     */
    public static function __set_state(array $properties): self
    {
        return new static($properties['options'], $properties['soarBinary']);
    }

    /**
     * @noinspection MagicMethodsValidityInspection
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function __toString(): string
    {
        return $this->toProcess()->getCommandLine();
    }
}
