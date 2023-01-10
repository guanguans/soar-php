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

class Explainer implements \Guanguans\SoarPHP\Contracts\Explainer
{
    /**
     * @var \PDO
     */
    protected $pdo;

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

    public function getNormalizedExplain(string $sql): string
    {
        $tableOfExplain = Factory::createConsoleTable($this->getFinalExplain($sql))->render();

        return "'explain'\n$tableOfExplain\nexplain";
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
