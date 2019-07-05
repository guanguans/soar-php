<?php

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP;

use Guanguans\SoarPHP\Contracts\SoarInterface;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\Support\Arr;

class Soar implements SoarInterface
{
    /**
     * @var
     */
    protected $config;

    /**
     * @var
     */
    protected $soarPath;

    /**
     * @var
     */
    protected $pdo;

    /**
     * @var
     */
    protected $pdoConfig;

    /**
     * Soar constructor.
     *
     * @param array $config
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function __construct(array $config)
    {
        if (empty($config)) {
            throw new InvalidConfigException('Config cannot be empty');
        }

        if (!file_exists($config['-soar-path']) || !is_executable($config['-soar-path'])) {
            throw new InvalidConfigException(sprintf("File does not exist, or the file is unreadable: '%s'", $config['-soar-path']));
        }

        if (null !== $config['-online-dsn']) {
            $this->setPdo(new PDO('mysql:host='.$config['-online-dsn']['host'].';port='.$config['-online-dsn']['port'].';dbname='.$config['-online-dsn']['dbname'], $config['-online-dsn']['username'], $config['-online-dsn']['password']));
            $this->setPdoConfig($config['-online-dsn']);
        }

        if (null !== $config['-test-dsn']) {
            $this->setPdo(new PDO('mysql:host='.$config['-test-dsn']['host'].';port='.$config['-test-dsn']['port'].';dbname='.$config['-test-dsn']['dbname'], $config['-test-dsn']['username'], $config['-test-dsn']['password']));
            $this->setPdoConfig($config['-test-dsn']);
        }

        $this->setConfig($config);
        $this->setSoarPath($config['-soar-path']);
    }

    /**
     * @return mixed
     */
    public function getSoarPath()
    {
        return $this->soarPath;
    }

    /**
     * @param mixed $soarPath
     */
    public function setSoarPath($soarPath)
    {
        $this->soarPath = $soarPath;
    }

    /**
     * @param array $pdoConfig
     */
    public function setPdoConfig(array $pdoConfig)
    {
        $this->pdoConfig = new Config($pdoConfig);
    }

    /**
     * @return mixed
     */
    public function getPdoConfig()
    {
        return $this->pdoConfig;
    }

    /**
     * @param mixed $pdo
     */
    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return mixed
     */
    public function getPdo()
    {
        if (null !== $this->pdo) {
            return $this->pdo;
        }

        if (null === $this->pdoConfig) {
            throw new InvalidConfigException(sprintf("Config cannot be empty: '%s' or '%s'", '-online-dsn', '-test-dsn'));
        }

        return new PDO('mysql:host='.$this->pdoConfig->host.';port='.$this->pdoConfig->port.';dbname='.$this->pdoConfig->dbname, $this->pdoConfig->username, $this->pdoConfig->password);
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * @param array $configs
     *
     * @return string
     */
    public function getFormatConfig(array $configs)
    {
        Arr::forget($configs, '-soar-path');

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
     * @param $command
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function exec($command)
    {
        if (!is_string($command)) {
            throw new InvalidArgumentException('Command type must be a string');
        }
        if (false === strpos($command, 'soar')) {
            throw new InvalidArgumentException(sprintf("Command error: '%s'", $command));
        }

        return shell_exec($command);
    }

    /**
     * @param $sql
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function score($sql)
    {
        return $this->exec("echo '$sql' | $this->soarPath ".$this->getFormatConfig($this->config->toArray()));
    }

    /**
     * @param $sql
     * @param $format
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function explain($sql, $format)
    {
        if (!\in_array(\strtolower($format), ['md', 'html'])) {
            throw new InvalidArgumentException('Invalid type value(md/html): '.$format);
        }

        $output = $this->exec("$this->soarPath ".$this->getFormatConfig($this->config->toArray()).' -report-type explain-digest << '.$this->getPdo()->getStrExplain($sql));
        if ('html' === \strtolower($format)) {
            return $this->md2html($output);
        }

        return $output;
    }

    /**
     * @param $sql
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function mdExplain($sql)
    {
        return $this->explain($sql, 'md');
    }

    /**
     * @param $sql
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    public function htmlExplain($sql)
    {
        return $this->explain($sql, 'html');
    }

    /**
     * @param $sql
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function syntaxCheck($sql)
    {
        return $this->exec("echo '$sql' | $this->soarPath -only-syntax-check");
    }

    /**
     * @param $sql
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function fingerPrint($sql)
    {
        return $this->exec("echo '$sql' | $this->soarPath -report-type=fingerprint");
    }

    /**
     * @param $sql
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function pretty($sql)
    {
        return $this->exec("echo '$sql' | $this->soarPath -report-type=pretty");
    }

    /**
     * @param $markdown
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function md2html($markdown)
    {
        return $this->exec("echo '$markdown' | $this->soarPath -report-type md2html");
    }
}
