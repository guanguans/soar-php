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

use Guanguans\SoarPHP\Concerns\ConcreteExplain;
use Guanguans\SoarPHP\Concerns\ConcreteScore;
use Guanguans\SoarPHP\Concerns\Executable;
use Guanguans\SoarPHP\Concerns\Factory;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Support\OsHelper;
use Symfony\Component\Process\Process;

class Soar implements \Guanguans\SoarPHP\Contracts\Soar
{
    use ConcreteExplain;
    use ConcreteScore;
    use Executable;
    use Factory;

    /**
     * @var string
     */
    protected $soarPath;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $normalizedOptions = [];

    public function __construct(array $options = [], ?string $soarPath = null)
    {
        $this->setSoarPath($soarPath ?: $this->getDefaultSoarPath());
        $this->setOptions($options);
    }

    public static function create(array $options = [], ?string $soarPath = null): self
    {
        return new self($options, $soarPath);
    }

    public function score(string $sql): string
    {
        $process = new Process(array_merge([$this->soarPath], $this->normalizedOptions, ["-query=$sql"]));
        $process->run();

        return $process->getOutput();
    }

    public function explain(string $sql): string
    {
        $explainer = $this->createExplainerFromOptions($this->options);

        return $this->exec(
            sprintf(
                '%s %s -report-type=explain-digest << %s',
                $this->soarPath,
                implode(' ', $this->normalizedOptions),
                $explainer->getNormalizedExplain($sql)
            )
        );
    }

    public function syntaxCheck(string $sql): string
    {
        $process = new Process([$this->soarPath, "-query=$sql", '-only-syntax-check=true']);
        $process->run();

        return $process->getOutput();
    }

    public function fingerPrint(string $sql): string
    {
        $process = new Process([$this->soarPath, "-query=$sql", '-report-type=fingerprint']);
        $process->run();

        return $process->getOutput();
    }

    public function pretty(string $sql): string
    {
        $process = new Process([$this->soarPath, "-query=$sql", '-report-type=pretty']);
        $process->run();

        return $process->getOutput();
    }

    public function md2html(string $markdown): string
    {
        $process = new Process([$this->soarPath, "-query=$markdown", '-report-type=md2html']);
        $process->run();

        return $process->getOutput();
    }

    public function help(): string
    {
        $process = new Process([$this->soarPath, '--help']);
        $process->run();

        return $process->getOutput();
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

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);
        $this->normalizedOptions = $this->normalizeOptions($this->options);

        return $this;
    }

    public function setOption(string $key, $value): self
    {
        $this->setOptions([$key => $value]);

        return $this;
    }

    protected function getDefaultSoarPath(): string
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

    /**
     * @psalm-suppress NullableReturnStatement
     */
    protected function normalizeOptions(array $options): array
    {
        return array_reduce_with_keys($options, static function ($normalizedOptions, $option, $key): array {
            if (is_scalar($option)) {
                $normalizedOptions[] = "$key=$option";
            } elseif (in_array($key, ['-test-dsn', '-online-dsn']) && isset($option['disable']) && true !== $option['disable']) {
                $dsn = sprintf(
                    '%s:%s@%s:%s/%s',
                    $option['username'],
                    $option['password'],
                    $option['host'],
                    $option['port'],
                    $option['dbname']
                );
                $normalizedOptions[] = "$key=$dsn";
            } elseif (! in_array($key, ['-test-dsn', '-online-dsn'])) {
                $normalizedOptions[] = sprintf('%s=%s', $key, implode(',', $option));
            }

            return $normalizedOptions;
        }, []);
    }
}
