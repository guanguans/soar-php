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

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;

class Explainer
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var string
     */
    protected const EXPLAIN_HEADER = '
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
| id | select_type | table   | partitions | type | possible_keys | key  | key_len | ref  | rows | filtered | Extra |
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
';

    /**
     * @var string
     */
    protected const EXPLAIN_TEMPLATE = '
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
| %d |      %s     |    %s   |     %s     |  %s  |       %s      |  %s  |   %s    |  %s  |  %s  |     %s   |   %s  |
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
';

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    public function setPdo(\PDO $pdo): self
    {
        $this->pdo = $pdo;

        return $this;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function getNormalizedExplain(string $sql): string
    {
        $transform = function ($var) {
            if (null === $var) {
                return 'NULL';
            }

            return $var;
        };

        $normalizedExplain = array_reduce($this->getFinalExplain($sql), function ($normalizedExplain, $explain) use ($transform) {
            return $normalizedExplain.sprintf(
                self::EXPLAIN_TEMPLATE,
                $transform($explain['id']),
                $transform($explain['select_type']),
                $transform($explain['table']),
                $transform($explain['partitions']),
                $transform($explain['type']),
                $transform($explain['possible_keys']),
                $transform($explain['key']),
                $transform($explain['key_len']),
                $transform($explain['ref']),
                $transform($explain['rows']),
                $transform($explain['filtered']),
                $transform($explain['Extra'])
            );
        }, self::EXPLAIN_HEADER);

        return "'explain'{$normalizedExplain}explain";
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function getJsonExplain(string $sql): string
    {
        return json_encode($this->getFinalExplain($sql));
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function getFinalExplain(string $sql): array
    {
        $explains = $this->getExplain($sql);
        if ($explains) {
            return $explains;
        }

        $extendedExplains = $this->getExplain($sql, 'extended');
        if ($extendedExplains) {
            return $extendedExplains;
        }

        return $this->getExplain($sql, 'partitions');
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function getExplain(string $sql, ?string $type = null): array
    {
        if (! in_array($type = strtolower((string) $type), ['partitions', 'extended', ''])) {
            throw new InvalidArgumentException("Invalid type value(partitions/extended): $type");
        }

        $explain = $this->pdo->query("EXPLAIN $type $sql", \PDO::FETCH_ASSOC);
        if (! $explain) {
            return [];
        }

        return $explain->fetchAll();
    }
}
