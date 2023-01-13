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

use Guanguans\SoarPHP\Concerns\ConcreteScores;
use Guanguans\SoarPHP\Concerns\HasOptions;
use Guanguans\SoarPHP\Concerns\WithRunable;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Support\OsHelper;

class Soar implements Contracts\Soar
{
    use ConcreteScores;
    use HasOptions;
    use WithRunable;

    /**
     * @var string
     */
    protected $soarPath;

    public function __construct(array $options = [], ?string $soarPath = null)
    {
        $this->setSoarPath($soarPath ?? $this->getDefaultSoarPath());
        $this->setOptions($options);
    }

    public static function create(array $options = [], ?string $soarPath = null): self
    {
        return new self($options, $soarPath);
    }

    /**
     * @param string|array<string> $sqls
     */
    public function scores($sqls): string
    {
        if (! is_string($sqls) && ! is_array($sqls)) {
            throw new InvalidArgumentException(sprintf('Invalid argument type(%s).', gettype($sqls)));
        }

        $delimiter = $this->getOption('-delimiter', ';');
        is_array($sqls) and $sqls = implode(str_repeat($delimiter, 2), $sqls);

        return $this->setQuery($sqls)->run();
    }

    public function help(): string
    {
        return $this->run(['--help']);
    }

    public function version(): string
    {
        return $this->run(['-version']);
    }

    public function getSoarPath(): string
    {
        return $this->soarPath;
    }

    public function setSoarPath(string $soarPath): self
    {
        if (! file_exists($soarPath) || ! is_executable($soarPath)) {
            throw new InvalidArgumentException("The file($soarPath) does not exist or cannot executable.");
        }

        $this->soarPath = realpath($soarPath);

        return $this;
    }

    private function getDefaultSoarPath(): string
    {
        /** @noinspection NestedTernaryOperatorInspection */
        return OsHelper::isWindows()
            ? __DIR__.'/../bin/soar.windows-amd64'
            : (
                OsHelper::isMacOS()
                ? __DIR__.'/../bin/soar.darwin-amd64'
                : __DIR__.'/../bin/soar.linux-amd64'
            );
    }
}
