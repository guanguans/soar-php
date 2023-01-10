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

class PDOConnector extends \PDO
{
    /**
     * @var self|null
     */
    protected static $connection;

    public static function connect(
        string $dsn,
        ?string $username = null,
        ?string $passwd = null,
        ?array $options = null
    ): self {
        if (! self::$connection instanceof self) {
            self::$connection = new self($dsn, $username, $passwd, $options);
        }

        return self::$connection;
    }

    protected function __construct(
        string $dsn,
        ?string $username = null,
        ?string $passwd = null,
        ?array $options = null
    ) {
        parent::__construct($dsn, $username, $passwd, $options);
    }

    public function __destruct()
    {
        self::close();
    }

    public static function close(): void
    {
        self::$connection = null;
    }

    protected function __clone()
    {
    }
}
