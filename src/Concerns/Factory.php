<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Concerns;

use Guanguans\SoarPHP\Explainer;
use Guanguans\SoarPHP\PDOConnector;

trait Factory
{
    /**
     * @var Explainer
     */
    protected static $explainer;

    public function createPdo(array $config): \PDO
    {
        return PDOConnector::connect(
            sprintf('mysql:host=%s;port=%s;dbname=%s', $config['host'], $config['port'], $config['dbname']),
            $config['username'],
            $config['password'],
            $config['options'] ?? []
        );
    }

    public function createExplainer(\PDO $pdo): Explainer
    {
        if (! self::$explainer instanceof Explainer) {
            self::$explainer = new Explainer($pdo);
        }

        return self::$explainer;
    }
}
