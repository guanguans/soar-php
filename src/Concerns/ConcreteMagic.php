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

use Guanguans\SoarPHP\Exceptions\InvalidOptionException;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait ConcreteMagic
{
    public function __sleep(): array
    {
        return ['options', 'soarBinary'];
    }

    public function __wakeup(): void
    {
        // $this->setOptions($this->options);
    }

    // /**
    //  * @since PHP 7.4.0
    //  */
    // public function __serialize(): array
    // {
    //     return [
    //         'options' => $this->options,
    //         'soarBinary' => $this->soarBinary,
    //     ];
    // }
    //
    // /**
    //  * @since PHP 7.4.0
    //  */
    // public function __unserialize(array $data): void
    // {
    //     $this->setOptions($data['options']);
    //     $this->setSoarBinary($data['soarBinary']);
    // }

    public function __debugInfo(): array
    {
        return get_object_vars($this) + ['commandLine' => (string) $this];
    }

    /**
     * @noinspection MagicMethodsValidityInspection
     */
    public static function __set_state(array $properties): self
    {
        return new static($properties['options'], $properties['soarBinary']);
    }

    /**
     * @throws InvalidOptionException
     *
     * @noinspection MagicMethodsValidityInspection
     */
    public function __toString(): string
    {
        return $this->createProcess()->getCommandLine();
    }
}
