<?php

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Services;

use Guanguans\SoarPHP\Config;
use Guanguans\SoarPHP\Contracts\SoarInterface;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\PDO;
use Guanguans\SoarPHP\Support\Arr;
use Guanguans\SoarPHP\Traits\Exec;

class SoarService implements SoarInterface
{
    use Exec;

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
    public function __construct(array $config = [])
    {
        if (empty($config = soar_config()->merge($config)->all())) {
            throw new InvalidConfigException('Config is empty or .soar|.soar.dist config file not exist');
        }

        if (!file_exists($config['-soar-path']) || !is_executable($config['-soar-path'])) {
            throw new InvalidConfigException(sprintf("File does not exist, or the file is unreadable: '%s'", $config['-soar-path']));
        }

        if (!array_key_exists('-test-dsn', $config) || (array_key_exists('disable', $config['-test-dsn']) && true === $config['-test-dsn']['disable'])) {
            throw new InvalidConfigException(sprintf("Config not exist, or config disable: '%s'", '-test-dsn'));
        }

        $this->setConfig($config);
        $this->setPdoConfig($config['-test-dsn']);
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
     * @return mixed
     */
    public function getPdoConfig()
    {
        return $this->pdoConfig;
    }

    /**
     * @param array $pdoConfig
     */
    public function setPdoConfig(array $pdoConfig)
    {
        $this->pdoConfig = $pdoConfig;
    }

    /**
     * @return \Guanguans\SoarPHP\PDO
     */
    public function getPdo()
    {
        if (null !== $this->pdo) {
            return $this->pdo;
        }

        return $this->pdo = new PDO(
            'mysql:host='.$this->pdoConfig['host'].';port='.$this->pdoConfig['port'].';dbname='.$this->pdoConfig['dbname'],
            $this->pdoConfig['username'],
            $this->pdoConfig['password']
        );
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
        $this->config = $config;
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
     * @param $sql
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function score($sql)
    {
        return $this->exec("echo '$sql;' | $this->soarPath ".$this->getFormatConfig($this->config));
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

        $output = $this->exec("$this->soarPath ".$this->getFormatConfig($this->config).' -report-type explain-digest << '.$this->getPdo()->getStrExplain($sql));
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
        return $this->exec("echo '$sql;' | $this->soarPath -only-syntax-check");
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
        return $this->exec("echo '$sql;' | $this->soarPath -report-type=fingerprint");
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
        return $this->exec("echo '$sql;' | $this->soarPath -report-type=pretty");
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

    /**
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function help()
    {
        return $this->exec("$this->soarPath --help");
    }
}
