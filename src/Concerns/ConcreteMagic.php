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

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait ConcreteMagic
{
    public function __sleep()
    {
        return ['options', 'soarPath'];
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
    //         'soarPath' => $this->soarPath,
    //     ];
    // }
    //
    // /**
    //  * @since PHP 7.4.0
    //  */
    // public function __unserialize(array $data): void
    // {
    //     $this->setOptions($data['options']);
    //     $this->setSoarPath($data['soarPath']);
    // }

    public function __debugInfo()
    {
        return get_object_vars($this) + ['commandLine' => (string) $this];
    }

    public static function __set_state(array $properties)
    {
        return new static($properties['options'], $properties['soarPath']);
    }

    /**
     * @noinspection MagicMethodsValidityInspection
     */
    public function __toString()
    {
        return $this->createProcess()->getCommandLine();
    }
}
