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
    protected $normalizedOptions;

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
        $this->normalizedOptions = $this->normalizeOptions($this->options);

        return $this;
    }

    public function setOption(string $key, $value): self
    {
        $this->setOptions([$key => $value]);

        return $this;
    }

    protected function normalizeOptions(array $options): string
    {
        return array_reduces($options, function ($normalizedOptions, $option, $key) {
            if (is_scalar($option)) {
                $normalizedOptions .= " $key=$option ";
            } elseif (in_array($key, ['-test-dsn', '-online-dsn']) && isset($option['disable']) && true !== $option['disable']) {
                $dsn = sprintf('%s:%s@%s:%s/%s', $option['username'], $option['password'], $option['host'], $option['port'], $option['dbname']);
                $normalizedOptions .= $normalizedOptions .= " $key=$dsn ";
            } elseif (! in_array($key, ['-test-dsn', '-online-dsn'])) {
                $normalizedOptions .= sprintf(' %s=%s ', $key, json_encode($option));
            }

            return $normalizedOptions;
        }, '');
    }

    protected function normalizeSql(string $sql): string
    {
        return str_replace(['`', '"'], ['', "'"], $sql);
    }

    public function score(string $sql): string
    {
        return $this->exec(sprintf('echo "%s" | %s %s', $this->normalizeSql($sql), $this->soarPath, $this->normalizedOptions));
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
            $this->normalizedOptions,
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
        return $this->exec(sprintf('echo "%s" | %s -only-syntax-check=true', $this->normalizeSql($sql), $this->soarPath));
    }

    public function fingerPrint(string $sql): string
    {
        return $this->exec(sprintf('echo "%s" | %s -report-type=fingerprint', $this->normalizeSql($sql), $this->soarPath));
    }

    public function pretty(string $sql): string
    {
        return $this->exec(sprintf('echo "%s" | %s -report-type=pretty', $this->normalizeSql($sql), $this->soarPath));
    }

    public function md2html(string $markdown): string
    {
        return $this->exec(sprintf('echo "%s" | %s -report-type=md2html', $markdown, $this->soarPath));
    }

    public function help(): string
    {
        return $this->exec("$this->soarPath --help");
    }
}
