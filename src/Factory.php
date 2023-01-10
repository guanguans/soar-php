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

use Guanguans\SoarPHP\Exceptions\InvalidConfigException;

/**
 * @internal
 */
class Factory
{
    public static function createConsoleTable(array $rows): ConsoleTable
    {
        return new ConsoleTable($rows);
    }

    public static function createExplainerFromOptions(array $options): Explainer
    {
        return static::createExplainer(static::createPDOFromOptions($options));
    }

    public static function createExplainer(\PDO $pdo): Explainer
    {
        return new Explainer($pdo);
    }

    public static function createPDOFromOptions(array $options): \PDO
    {
        return static::createPDO(static::extractConfigOfPDO($options));
    }

    public static function createPDO(array $config): \PDO
    {
        return PDOConnector::connect(
            sprintf('mysql:host=%s;port=%s;dbname=%s;charset=UTF8', $config['host'], $config['port'], $config['dbname']),
            $config['username'],
            $config['password'],
            $config['options'] ?? []
        );
    }

    /**
     * @return array<string, mixed>
     */
    protected static function extractConfigOfPDO(array $options): array
    {
        $disable = $options['-test-dsn']['disable'] ?? false;
        if (isset($options['-test-dsn']) && true !== $disable) {
            return $options['-test-dsn'];
        }

        $disable = $options['-online-dsn']['disable'] ?? false;
        if (isset($options['-online-dsn']) && true !== $disable) {
            return $options['-online-dsn'];
        }

        throw new InvalidConfigException('The configuration of PDO no found.');
    }
}
