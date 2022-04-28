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

use Guanguans\SoarPHP\Concerns\ConcreteScore;
use Guanguans\SoarPHP\Concerns\Executable;
use Guanguans\SoarPHP\Concerns\Factory;
use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\Support\OsHelper;
use Symfony\Component\Process\Process;

class Soar implements \Guanguans\SoarPHP\Contracts\Soar
{
    use Executable;
    use ConcreteScore;
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
     * @var string
     */
    protected $normalizedStrOptions;

    /**
     * @var array
     */
    protected $normalizedArrOptions = [];

    public function __construct(array $options = [], ?string $soarPath = null)
    {
        $this->setSoarPath($soarPath ?: $this->getDefaultSoarPath());
        $this->setOptions($options);
    }

    public static function create(array $options = [], ?string $soarPath = null): self
    {
        return new self($options, $soarPath);
    }

    public function getSoarPath(): string
    {
        return $this->soarPath;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function setSoarPath(string $soarPath): self
    {
        if (! file_exists($soarPath) || ! is_executable($soarPath)) {
            throw new InvalidConfigException("File does not exist, or the file is un executable: '$soarPath'");
        }

        $this->soarPath = realpath($soarPath);

        return $this;
    }

    protected function getDefaultSoarPath(): string
    {
        return OsHelper::isWindows()
            ? __DIR__.'/../bin/soar.windows-amd64'
            : (
                OsHelper::isMacOS()
                ? __DIR__.'/../bin/soar.darwin-amd64'
                : __DIR__.'/../bin/soar.linux-amd64'
            );
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    protected function getPdoConfig(): array
    {
        if (isset($this->options['-test-dsn']) && isset($this->options['-test-dsn']['disable']) && true !== $this->options['-test-dsn']['disable']) {
            return $this->options['-test-dsn'];
        }

        if (isset($this->options['-online-dsn']) && isset($this->options['-online-dsn']['disable']) && true !== $this->options['-online-dsn']['disable']) {
            return $this->options['-online-dsn'];
        }

        throw new InvalidConfigException('No PDO configuration found.');
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);
        $this->normalizedStrOptions = $this->normalizeToStrOptions($this->options);
        $this->normalizedArrOptions = $this->normalizeToArrOptions($this->options);

        return $this;
    }

    public function setOption(string $key, $value): self
    {
        $this->setOptions([$key => $value]);

        return $this;
    }

    protected function normalizeToStrOptions(array $options): string
    {
        return array_reduces($options, function ($normalizedOptions, $option, $key) {
            if (is_scalar($option)) {
                $normalizedOptions .= " $key=$option ";
            } elseif (in_array($key, ['-test-dsn', '-online-dsn']) && isset($option['disable']) && true !== $option['disable']) {
                $dsn = sprintf('%s:%s@%s:%s/%s', $option['username'], $option['password'], $option['host'], $option['port'], $option['dbname']);
                $normalizedOptions .= $normalizedOptions .= " $key=$dsn ";
            } elseif (! in_array($key, ['-test-dsn', '-online-dsn'])) {
                $normalizedOptions .= sprintf(' %s=%s ', $key, implode(',', $option));
            }

            return $normalizedOptions;
        }, '');
    }

    protected function normalizeToArrOptions(array $options): array
    {
        return array_reduces($options, function ($normalizedOptions, $option, $key) {
            if (is_scalar($option)) {
                $normalizedOptions[] = "$key=$option";
            } elseif (in_array($key, ['-test-dsn', '-online-dsn']) && isset($option['disable']) && true !== $option['disable']) {
                $dsn = sprintf('%s:%s@%s:%s/%s', $option['username'], $option['password'], $option['host'], $option['port'], $option['dbname']);
                $normalizedOptions[] = "$key=$dsn";
            } elseif (! in_array($key, ['-test-dsn', '-online-dsn'])) {
                $normalizedOptions[] = sprintf('%s=%s', $key, implode(',', $option));
            }

            return $normalizedOptions;
        }, []);
    }

    public function score(string $sql): string
    {
        $process = new Process(array_merge([$this->soarPath], $this->normalizedArrOptions, ["-query=$sql"]));
        $process->run();

        return $process->getOutput();
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function explain(string $sql): string
    {
        $explainer = $this->createExplainer($this->createPdo($this->getPdoConfig()));

        return $this->exec(sprintf(
            '%s %s -report-type=explain-digest << %s',
            $this->soarPath,
            $this->normalizedStrOptions,
            $explainer->getNormalizedExplain($sql)
        ));
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function mdExplain(string $sql): string
    {
        return $this->explain($sql);
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function htmlExplain(string $sql): string
    {
        return $this->md2html($this->explain($sql));
    }

    public function syntaxCheck(string $sql): ?string
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
}
