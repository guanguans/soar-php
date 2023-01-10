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
use Guanguans\SoarPHP\Concerns\WithExecutable;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Support\OsHelper;

class Soar implements \Guanguans\SoarPHP\Contracts\Soar
{
    use ConcreteExplain;
    use ConcreteScore;
    use WithExecutable;

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

    /**
     * @var \Guanguans\SoarPHP\Contracts\Explainer|null
     */
    protected $explainer;

    public function __construct(array $options = [], ?string $soarPath = null, ?Contracts\Explainer $explainer = null)
    {
        $this->setSoarPath($soarPath ?: $this->getDefaultSoarPath());
        $this->setOptions($options);
        $this->explainer = $explainer;
    }

    public static function create(array $options = [], ?string $soarPath = null, ?Contracts\Explainer $explainer = null): self
    {
        return new self($options, $soarPath, $explainer);
    }

    public function score(string $sql): string
    {
        return $this->mustRun(array_merge([$this->soarPath], $this->normalizedOptions, ["-query=$sql"]));
    }

    public function explain(string $sql): string
    {
        return $this->exec(sprintf(
            '%s %s -report-type=explain-digest << %s',
            $this->soarPath,
            implode(' ', $this->normalizedOptions),
            $this->getExplainer()->getNormalizedExplain($sql)
        ));
    }

    public function syntaxCheck(string $sql): string
    {
        return $this->run([$this->soarPath, "-query=$sql", '-only-syntax-check=true']);
    }

    public function fingerPrint(string $sql): string
    {
        return $this->mustRun([$this->soarPath, "-query=$sql", '-report-type=fingerprint']);
    }

    public function pretty(string $sql): string
    {
        return $this->mustRun([$this->soarPath, "-query=$sql", '-report-type=pretty']);
    }

    public function md2html(string $markdown): string
    {
        return $this->mustRun([$this->soarPath, "-query=$markdown", '-report-type=md2html']);
    }

    public function help(): string
    {
        return $this->mustRun([$this->soarPath, '--help']);
    }

    public function version(): string
    {
        return $this->mustRun([$this->soarPath, '-version']);
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
        return $this->getOption();
    }

    public function getOption(?string $key = null, $value = null)
    {
        if (null === $key) {
            return $this->options;
        }

        return $this->options[$key] ?? $value;
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

    public function getExplainer(): Contracts\Explainer
    {
        return $this->explainer ?? Factory::createExplainerFromOptions($this->options);
    }

    public function setExplainer(Contracts\Explainer $explainer): self
    {
        $this->explainer = $explainer;

        return $this;
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
