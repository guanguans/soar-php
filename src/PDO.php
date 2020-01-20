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
use PDOException;

class PDO extends BasePDO
{
    /**
     * @var \PDO
     */
    private $conn;

    /**
     * @var string
     */
    private $explainSkeleton = 'EOF
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
| id | select_type | table   | partitions | type | possible_keys | key  | key_len | ref  | rows | filtered | Extra |
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
| %s |      %s     |    %s   |     %s     |  %s  |       %s      |  %s  |   %s    |  %s  |  %s  |     %s   |   %s  |
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
EOF';

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
     * @param $sql
     *
     * @return string
     */
    public function getStrExplain(string $sql): string
    {
        $explain = $this->getAllExplain($sql);

        return sprintf(
            $this->getExplainSkeleton(),
            $explain['id'],
            $explain['select_type'],
            $explain['table'],
            $explain['partitions'],
            $explain['type'],
            $explain['possible_keys'],
            $explain['key'],
            $explain['key_len'],
            $explain['ref'],
            $explain['rows'],
            $explain['filtered'],
            $explain['Extra']
        );
    }

    /**
     * @param $sql
     *
     * @return array|mixed
     */
    public function getAllExplain($sql)
    {
        if (empty($sql)) {
            throw new PDOException('Sql statement cannot be empty.');
        }

        if ($this->getMysqlVersion() >= 5.7) {
            return $this->getExplain($sql);
        }

        return array_merge($this->getPartitionsExplain($sql), $this->getFilteredExplain($sql));
    }

    /**
     * @param $sql
     *
     * @return mixed
     */
    public function getExplain($sql)
    {
        if (false === ($explain = $this->conn->query('EXPLAIN '.$sql, self::FETCH_ASSOC))) {
            throw new PDOException(sprintf('Sql statement error: %s', $sql));
        }

        foreach ($explain as $row) {
            return $row;
        }
    }

    /**
     * @param $sql
     *
     * @return mixed
     */
    public function getPartitionsExplain($sql)
    {
        if (false === ($explainPartitions = $this->conn->query('EXPLAIN partitions '.$sql,
                self::FETCH_ASSOC))) {
            throw new PDOException(sprintf('Sql statement error: %s', $sql));
        }

        foreach ($explainPartitions as $row) {
            return $row;
        }
    }

    /**
     * @param $sql
     *
     * @return mixed
     */
    public function getFilteredExplain($sql)
    {
        if (false === ($explainFiltered = $this->conn->query('EXPLAIN extended '.$sql,
                self::FETCH_ASSOC))) {
            throw new PDOException(sprintf('Sql statement error: %s', $sql));
        }

        foreach ($explainFiltered as $row) {
            return $row;
        }
    }

    /**
     * @return mixed
     */
    public function getMysqlVersion()
    {
        foreach ($this->conn->query('SELECT version();', self::FETCH_ASSOC) as $row) {
            return $row['version()'];
        }
    }

    /**
     * @return string
     */
    public function getExplainSkeleton()
    {
        return $this->explainSkeleton;
    }

    /**
     * @param $explainSkeleton
     */
    public function setExplainSkeleton($explainSkeleton)
    {
        $this->explainSkeleton = $explainSkeleton;
    }

    /**
     * close PDO.
     */
    public function closeConnection()
    {
        $this->conn = null;
    }
}
