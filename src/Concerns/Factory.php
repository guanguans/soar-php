<?php

declare(strict_types=1);

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Concerns;

use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\Explainer;
use Guanguans\SoarPHP\PDOConnector;
use PDO;

trait Factory
{
    /**
     * @var Explainer
     */
    protected static $explainer;

    public function createPdo(): PDO
    {
        $config = $this->options['-test-dsn'] ?? $this->options['-online-dsn'] ?? null;
        if (empty($config)) {
            throw new InvalidConfigException('No PDO configuration found.');
        }

        return PDOConnector::create(
            sprintf('mysql:host=%s;port=%s;dbname=%s', $config['host'], $config['port'], $config['dbname']),
            $config['username'],
            $config['password']
        );
    }

    public function createExplainer(): Explainer
    {
        if (!self::$explainer instanceof Explainer) {
            self::$explainer = new Explainer($this->createPdo());
        }

        return self::$explainer;
    }
}
