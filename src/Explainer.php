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

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use PDO;

class Explainer
{
    /**
     * @var PDO
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
| %s |      %s     |    %s   |     %s     |  %s  |       %s      |  %s  |   %s    |  %s  |  %s  |     %s   |   %s  |
+----+-------------+---------+------------+------+---------------+------+---------+------+------+----------+-------+
';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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

    public function getNormalizedExplain(string $sql): string
    {
        $strExplains = array_reduce($this->getFinalExplain($sql), function ($strExplains, $explain) {
            return $strExplains.sprintf(
                self::EXPLAIN_TEMPLATE,
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
        }, self::EXPLAIN_HEADER);

        return "EOF{$strExplains}EOF";
    }

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

    public function getExplain(string $sql, string $type = null): array
    {
        if (!in_array($type = strtolower((string) $type), ['partitions', 'extended', ''])) {
            throw new InvalidArgumentException("Invalid type value(partitions/extended): $type");
        }

        $explain = $this->pdo->query("EXPLAIN $type $sql", PDO::FETCH_ASSOC);
        if (!$explain) {
            return [];
        }

        return $explain->fetchAll();
    }
}
