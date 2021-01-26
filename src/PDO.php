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

use PDO as BasePDO;
use Guanguans\SoarPHP\Traits\PDOExplainAttributes;

class PDO
{
    use PDOExplainAttributes;

    /**
     * @var \PDO
     */
    private static $conn;

    /**
     * PDO constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param $dsn
     * @param null           $username
     * @param null           $password
     * @param array|string[] $options
     */
    public static function getInstance(
        $dsn,
        $username = null,
        $password = null,
        array $options = [BasePDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
    ): BasePDO {
        if (null === static::$conn) {
            static::$conn = new BasePDO($dsn, $username, $password, $options);
        }

        return static::$conn;
    }

    /**
     * close PDO.
     */
    public function closeConnection()
    {
        $this->conn = null;
    }

    private function __clone()
    {
    }
}
