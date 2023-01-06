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

use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\Explainer;
use Guanguans\SoarPHP\PDOConnector;

trait Factory
{
    public function createExplainerFromOptions(array $options): Explainer
    {
        return $this->createExplainer($this->createPDOFromOptions($options));
    }

    public function createExplainer(\PDO $pdo): Explainer
    {
        return new Explainer($pdo);
    }

    public function createPDOFromOptions(array $options): \PDO
    {
        return $this->createPDO($this->extractConfigOfPDO($options));
    }

    public function createPDO(array $config): \PDO
    {
        return PDOConnector::connect(
            sprintf('mysql:host=%s;port=%s;dbname=%s', $config['host'], $config['port'], $config['dbname']),
            $config['username'],
            $config['password'],
            $config['options'] ?? []
        );
    }

    /**
     * @return array<string, mixed>
     */
    protected function extractConfigOfPDO(array $options): array
    {
        $disable = $options['-test-dsn']['disable'] ?? false;
        if (isset($options['-test-dsn']) && true !== $disable) {
            return $this->options['-test-dsn'];
        }

        $disable = $options['-online-dsn']['disable'] ?? false;
        if (isset($options['-online-dsn']) && true !== $disable) {
            return $this->options['-online-dsn'];
        }

        throw new InvalidConfigException('The configuration of PDO no found.');
    }
}
