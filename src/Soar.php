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

    public function analysis($sql)
    {
        return shell_exec("echo '$sql' | $this->soarPath -report-type html");
    }

    public function syntaxCheck($sql)
    {
        return shell_exec("echo '$sql' | $this->soarPath -only-syntax-check");
    }

    public function fingerPrint($sql)
    {
        return shell_exec("echo '$sql' | $this->soarPath -report-type=fingerprint");
    }

    public function pretty($sql)
    {
        return shell_exec("echo '$sql' | $this->soarPath -report-type=pretty");
    }

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

    public function md2html($markdown)
    {
        return shell_exec("echo '$markdown' | $this->soarPath -report-type md2html");
    }
}
