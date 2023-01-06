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

use PDO;

class PDOConnector
{
    /**
     * @var \PDO|null
     */
    protected static $connection;

    public static function connect(
        string $dsn,
        ?string $username = null,
        ?string $password = null,
        array $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
    ): PDO {
        if (! self::$connection instanceof PDO) {
            self::$connection = new PDO($dsn, $username, $password, $options);
        }

        return self::$connection;
    }

    public function __destruct()
    {
        self::close();
    }

    public static function close(): void
    {
        self::$connection = null;
    }

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    protected function __wakeup()
    {
    }
}
