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

use Guanguans\SoarPHP\Traits\PDOExplainAttributes;
use PDO as BasePDO;
use PDOException;

class PDO extends BasePDO
{
    use PDOExplainAttributes;

    /**
     * @var \PDO
     */
    private $conn;

    /**
     * PDO constructor.
     *
     * @param $dsn
     * @param null  $username
     * @param null  $password
     * @param array $options
     */
    public function __construct(
        $dsn,
        $username = null,
        $password = null,
        array $options = [self::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
    ) {
        try {
            parent::__construct($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
        $this->conn = new BasePDO($dsn, $username, $password, $options);
    }

    /**
     * close PDO.
     */
    public function closeConnection()
    {
        $this->conn = null;
    }
}
