<?php

declare(strict_types=1);

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP;

use Guanguans\SoarPHP\Concerns\ConcreteScore;
use Guanguans\SoarPHP\Concerns\Executable;
use Guanguans\SoarPHP\Concerns\Factory;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
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

    public function __construct(array $options = [])
    {
        $this->setSoarPath($this->getDefaultSoarPath());
        $this->setOptions($options);
    }

    public function getSoarPath(): string
    {
        return $this->soarPath;
    }

    public function setSoarPath(string $soarPath): self
    {
        if (!file_exists($soarPath) || !is_executable($soarPath)) {
            throw new InvalidConfigException("File does not exist, or the file is un executable: '$soarPath'");
        }

        $this->soarPath = realpath($soarPath);

        return $this;
    }

    public function getDefaultSoarPath()
    {
        return OsHelper::isWindows()
            ? __DIR__.'/../bin/soar.windows-amd64'
            : (
                OsHelper::isMacOS()
                ? __DIR__.'/../bin/soar.darwin-amd64'
                : __DIR__.'/../bin/soar.linux-amd64'
            );
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
        $this->options = array_merge($this->options, [$key => $value]);
        $this->normalizedOptions = $this->normalizeOptions($this->options);

        return $this;
    }

    public function normalizeOptions(array $options): string
    {
        return array_reduces($options, function ($normalizedOptions, $option, $key) {
            if (is_scalar($option)) {
                $normalizedOptions .= " $key=$option ";
            } elseif (in_array($key, ['-test-dsn', '-online-dsn']) && isset($option['disable']) && true !== $option['disable']) {
                $dsn = sprintf('%s:%s@%s:%s/%s', $option['username'], $option['password'], $option['host'], $option['port'], $option['dbname']);
                $normalizedOptions .= $normalizedOptions .= " $key=$dsn ";
            } elseif (!in_array($key, ['-test-dsn', '-online-dsn'])) {
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

    public function explain(string $sql, string $format): string
    {
        if (!in_array($format = strtolower($format), ['md', 'html'])) {
            throw new InvalidArgumentException("Invalid type value(md/html): $format");
        }

        $config = $this->options['-test-dsn'] ?? $this->options['-online-dsn'] ?? null;
        if (empty($config)) {
            throw new InvalidConfigException('No PDO configuration found.');
        }
        $explainer = $this->createExplainer($this->createPdo($config));

        $explain = $this->exec(sprintf(
            '%s %s -report-type=explain-digest << %s',
            $this->soarPath,
            $this->normalizedOptions,
            $explainer->getNormalizedExplain($sql)
        ));

        'html' === $format and $explain = $this->md2html($explain);

        return $explain;
    }

    public function mdExplain(string $sql): string
    {
        return $this->explain($sql, 'md');
    }

    public function htmlExplain(string $sql): string
    {
        return $this->explain($sql, 'html');
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
        return $this->exec(sprintf('%s --help', $this->soarPath));
    }
}
