<?php

declare(strict_types=1);

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Services;

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use PDO;
use PDOException;

class ExplainService
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $explainHeader = '
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
| id | select_type | table   | partitions | type | possible_keys | key  | key_len | ref  | rows | filtered | Extra |
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
';

    /**
     * @var string
     */
    private $explainContentSkeleton = '
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
| %s |      %s     |    %s   |     %s     |  %s  |       %s      |  %s  |   %s    |  %s  |  %s  |     %s   |   %s  |
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
';

    /**
     * ExplainService constructor.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function getStrExplain(string $sql): string
    {
        $explains = $this->getAllExplain($sql);

        $explainSkeleton = array_reduce($explains, function ($carry, $explain) {
            $explainContentSkeleton = sprintf(
                $this->explainContentSkeleton,
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

            return $carry.$explainContentSkeleton;
        }, $this->explainHeader);

        return $this->normalizeExplainSkeleton($explainSkeleton);
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function getAllExplain(string $sql): array
    {
        if (empty($sql)) {
            throw new PDOException('Sql statement cannot be empty.');
        }

        $partitionsExplains = $this->getExplain($sql, 'partitions');

        $extendedExplains = $this->getExplain($sql, 'extended');

        return array_map(function ($partitionsExplain, $extendedExplain) {
            return array_merge($partitionsExplain, $extendedExplain);
        }, $partitionsExplains, $extendedExplains);
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function getExplain(string $sql, string $type = null): array
    {
        if (null !== $type && !\in_array(\strtolower($type), ['partitions', 'extended'])) {
            throw new InvalidArgumentException('Invalid type value(partitions/extended): '.$type);
        }

        $explain = $this->pdo->query('EXPLAIN '.$type.' '.$sql, PDO::FETCH_ASSOC);
        if ($explain) {
            return $explain->fetchAll();
        }

        $explain = $this->pdo->query('EXPLAIN '.$sql, PDO::FETCH_ASSOC);
        if ($explain) {
            return $explain->fetchAll();
        }

        throw new PDOException(sprintf('Sql statement error: %s', $sql));
    }

    public function getExplainHeader(): string
    {
        return $this->explainHeader;
    }

    protected function normalizeExplainSkeleton(string $explainSkeleton): string
    {
        return <<<"skeleton"
EOF
$explainSkeleton
EOF
skeleton;
    }

    public function setExplainHeader(string $explainHeader): self
    {
        $this->explainHeader = $explainHeader;

        return $this;
    }

    public function getExplainContentSkeleton(): string
    {
        return $this->explainContentSkeleton;
    }

    public function setExplainContentSkeleton(string $explainContentSkeleton): self
    {
        $this->explainContentSkeleton = $explainContentSkeleton;

        return $this;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function setPdo(PDO $pdo): self
    {
        $this->pdo = $pdo;

        return $this;
    }
}
