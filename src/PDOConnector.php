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

use PDO;

class PDOConnector
{
    /**
     * @var PDO
     */
    private static $conn;

    /**
     * PDOConnector constructor.
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
        array $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
    ): PDO {
        if (!self::$conn instanceof PDO) {
            self::$conn = new PDO($dsn, $username, $password, $options);
        }

        return self::$conn;
    }

    /**
     * close PDOConnector.
     */
    public function closeConnection()
    {
        $this->conn = null;
    }

    private function __clone()
    {
    }
}
