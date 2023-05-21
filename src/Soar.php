<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP;

use Guanguans\SoarPHP\Concerns\ConcreteMagic;
use Guanguans\SoarPHP\Concerns\ConcreteScores;
use Guanguans\SoarPHP\Concerns\HasOptions;
use Guanguans\SoarPHP\Concerns\HasSoarPath;
use Guanguans\SoarPHP\Concerns\WithDumpable;
use Guanguans\SoarPHP\Concerns\WithRunable;

class Soar implements Contracts\Soar
{
    use ConcreteMagic;
    use ConcreteScores;
    use HasOptions;
    use HasSoarPath;
    use WithDumpable;
    use WithRunable;

    /**
     * @noinspection MissingParentCallInspection
     */
    public function __construct(array $options = [], ?string $soarPath = null)
    {
        $this->setOptions($options);
        $this->setSoarPath($soarPath ?? $this->getDefaultSoarPath());
    }

    public static function create(array $options = [], ?string $soarPath = null): self
    {
        return new static($options, $soarPath);
    }

    public function help(): string
    {
        return $this->clone()->onlyOptions()->setHelp(true)->run();
    }

    public function version(): string
    {
        return $this->clone()->onlyOptions()->setVersion(true)->run();
    }

    public function clone(): self
    {
        return clone $this;
    }
}
