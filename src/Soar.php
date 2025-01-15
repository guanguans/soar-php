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

namespace Guanguans\SoarPHP;

use Guanguans\SoarPHP\Concerns\ConcreteMagic;
use Guanguans\SoarPHP\Concerns\ConcreteScores;
use Guanguans\SoarPHP\Concerns\HasOptions;
use Guanguans\SoarPHP\Concerns\HasSoarBinary;
use Guanguans\SoarPHP\Concerns\HasSudoPassword;
use Guanguans\SoarPHP\Concerns\WithDumpable;
use Guanguans\SoarPHP\Concerns\WithRunable;
use Guanguans\SoarPHP\Exceptions\InvalidOptionException;

class Soar implements Contracts\Soar
{
    use ConcreteMagic;
    use ConcreteScores;
    use HasOptions;
    use HasSoarBinary;
    use HasSudoPassword;
    use WithDumpable;
    use WithRunable;

    public function __construct(array $options = [], ?string $soarBinary = null)
    {
        $this->setOptions($options);
        $this->setSoarBinary($soarBinary ?? $this->defaultSoarBinary());
    }

    public static function create(array $options = [], ?string $soarBinary = null): self
    {
        return new static($options, $soarBinary);
    }

    /**
     * @throws InvalidOptionException
     */
    public function help(): string
    {
        return $this->clone()->setHelp(true)->onlyHelp()->run();
    }

    /**
     * @throws InvalidOptionException
     */
    public function version(): string
    {
        return $this->clone()->setVersion(true)->onlyVersion()->run();
    }

    public function clone(): self
    {
        return clone $this;
    }
}
