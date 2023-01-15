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
use Guanguans\SoarPHP\Support\Args;
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

        if (is_array($sqls)) {
            $sqls = implode($this->getOption('-delimiter', ';'), $sqls);
        }

        return $this->clone()->setQuery($sqls)->run();
    }

    public function help(): string
    {
        return $this->clone()->onlyOptions()->setHelp(true)->run();
    }

    public function version(): string
    {
        return $this->clone()->onlyOptions()->setVersion(true)->run();
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

    public function clone(): Soar
    {
        return clone $this;
    }

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
        $args[] = $this->__toString();
        $args[] = $this;

        if (function_exists('dump')) {
            dump(...$args);

            return $this;
        }

        foreach ($args as $arg) {
            var_dump($arg);
        }

        return $this;
    }

    public function __toString()
    {
        $escapeOptions = Args::escapeCommand($this->normalizedOptions);

        return "{$this->soarPath} {$escapeOptions}";
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
