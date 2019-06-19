<?php

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP;

use Guanguans\SoarPHP\Contracts\SoarInterface;
use Guanguans\SoarPHP\Exceptions\Exception;

class Soar implements SoarInterface
{
    protected $config = [];

    protected $soarPath;

    public function __construct($config)
    {
        if (empty($config['soar_path'])) {
            throw new Exception('config error');
        }
        if (!file_exists($config['soar_path'])) {
            throw new Exception($config['soar_path'].'not exists');
        }
        $this->config = $config;
        $this->soarPath = $config['soar_path'];
    }

    public static function soar($command)
    {
        if (false === strpos($command, 'soar')) {
            throw new Exception('command error');
        }

        return shell_exec($command);
    }

    public function assemblyCommand($type, $sql)
    {
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param $sql
     *
     * @return string|null
     */
    public function analysis($sql)
    {
        return shell_exec("echo '$sql' | $this->soarPath -report-type html");
    }

    /**
     * @param $sql
     *
     * @return string|null
     */
    public function syntaxCheck($sql)
    {
        return shell_exec("echo '$sql' | $this->soarPath -only-syntax-check");
    }

    /**
     * @param $sql
     *
     * @return string|null
     */
    public function fingerPrint($sql)
    {
        return shell_exec("echo '$sql' | $this->soarPath -report-type=fingerprint");
    }

    /**
     * @param $sql
     *
     * @return string|null
     */
    public function pretty($sql)
    {
        return shell_exec("echo '$sql' | $this->soarPath -report-type=pretty");
    }

    /**
     * @param $explain
     *
     * @return string|null
     */
    public function analysisExplain($explain)
    {
        $explain = 'EOF
+----+-------------+-------+------+---------------+------+---------+------+------+-------+
| id | select_type | table | type | possible_keys | key  | key_len | ref  | rows | Extra |
+----+-------------+-------+------+---------------+------+---------+------+------+-------+
|  1 | SIMPLE      | film  | ALL  | NULL          | NULL | NULL    | NULL | 1131 |       |
+----+-------------+-------+------+---------------+------+---------+------+------+-------+
EOF';

        return shell_exec("$this->soarPath -report-type explain-digest << $explain");
    }

    /**
     * @param $markdown
     *
     * @return string|null
     */
    public function md2html($markdown)
    {
        return shell_exec("echo '$markdown' | $this->soarPath -report-type md2html");
    }
}
