<?php

declare(strict_types=1);

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Services;

use Guanguans\SoarPHP\PDO;
use Guanguans\SoarPHP\Traits\HasExecAble;
use Guanguans\SoarPHP\Contracts\SoarInterface;
use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;

class SoarService implements SoarInterface
{
    use HasExecAble;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $soarPath;

    /**
     * @var
     */
    protected $pdo;

    /**
     * @var array
     */
    protected $pdoConfig;

    /**
     * Soar constructor.
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function __construct(array $config = [])
    {
        if (empty($config = soar_config()->merge($config)->all())) {
            throw new InvalidConfigException('Config is empty or .soar|.soar.dist config file not exist');
        }

        if (!file_exists($config['-soar-path']) || !is_executable($config['-soar-path'])) {
            throw new InvalidConfigException(sprintf("File does not exist, or the file is unexecuteable: '%s'", $config['-soar-path']));
        }

        if (!array_key_exists('-test-dsn', $config) || (array_key_exists('disable', $config['-test-dsn']) && true === $config['-test-dsn']['disable'])) {
            throw new InvalidConfigException(sprintf("Config not exist, or config disable: '%s'", '-test-dsn'));
        }

        $this->setConfig($config);
        $this->setPdoConfig($config['-test-dsn']);
        $this->setSoarPath($config['-soar-path']);
    }

    public function getSoarPath(): string
    {
        return $this->soarPath;
    }

    public function setSoarPath(string $soarPath)
    {
        $this->soarPath = $soarPath;
    }

    public function getPdoConfig(): array
    {
        return $this->pdoConfig;
    }

    public function setPdoConfig(array $pdoConfig)
    {
        $this->pdoConfig = $pdoConfig;
    }

    public function getPdo(): \PDO
    {
        return PDO::getInstance(
            'mysql:host='.$this->pdoConfig['host'].';port='.$this->pdoConfig['port'].';dbname='.$this->pdoConfig['dbname'],
            $this->pdoConfig['username'],
            $this->pdoConfig['password']
        );
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getFormatConfig(array $configs)
    {
        unset($configs['-soar-path']);
        $configStr = '';
        foreach ($configs as $key => $config) {
            if (!is_array($config)) {
                $configStr .= " $key=$config ";
            }
            if (is_array($config) && ('-test-dsn' !== $key && '-online-dsn' !== $key)) {
                $configStr .= " $key=".json_encode($config).' ';
            }
            if (('-test-dsn' === $key || '-online-dsn' === $key) && isset($config['disable']) && true !== $config['disable']) {
                $formatStr = "{$config['username']}:{$config['password']}@{$config['host']}:{$config['port']}/{$config['dbname']}";
                $configStr .= " $key=$formatStr ";
            }
        }

        return $configStr;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function score(string $sql): string
    {
        return $this->exec("echo \" $sql \" | $this->soarPath ".$this->getFormatConfig($this->config));
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function explain(string $sql, string $format): string
    {
        if (!\in_array(\strtolower($format), ['md', 'html'])) {
            throw new InvalidArgumentException('Invalid type value(md/html): '.$format);
        }

        $output = $this->exec("$this->soarPath ".$this->getFormatConfig($this->config).' -report-type explain-digest << '.$this->getPdo()->getStrExplain($sql));
        if ('html' === \strtolower($format)) {
            return $this->md2html($output);
        }

        return $output;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function mdExplain(string $sql): string
    {
        return $this->explain($sql, 'md');
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function htmlExplain(string $sql): string
    {
        return $this->explain($sql, 'html');
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function syntaxCheck(string $sql): string
    {
        return $this->exec("echo \" $sql \" | $this->soarPath -only-syntax-check");
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function fingerPrint(string $sql): string
    {
        return $this->exec("echo \" $sql \" | $this->soarPath -report-type=fingerprint");
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function pretty(string $sql): string
    {
        return $this->exec("echo \" $sql \" | $this->soarPath -report-type=pretty");
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function md2html(string $markdown): string
    {
        return $this->exec("echo '$markdown' | $this->soarPath -report-type md2html");
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function help(): string
    {
        return $this->exec("$this->soarPath --help");
    }
}
