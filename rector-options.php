<?php

/** @noinspection PhpInternalEntityUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

use Guanguans\SoarPHP\Support\Rectors\AddDocCommentForSoarOptionsRector;
use Guanguans\SoarPHP\Support\Rectors\SimplifyListIndexRector;
use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/examples/options.php',
    ])
    ->withPhpVersion(PhpVersion::PHP_81)
    ->withoutParallel()
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    ->withRules([
        AddDocCommentForSoarOptionsRector::class,
        SimplifyListIndexRector::class,
    ]);
