<?php

/** @noinspection DebugFunctionUsageInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

use Guanguans\SoarPHP\Support\ComposerScripts;
use Guanguans\SoarPHP\Support\Rectors\AddSoarOptionsDocCommentRector;
use Guanguans\SoarPHP\Support\Rectors\SimplifyListIndexRector;
use Nette\PhpGenerator\Dumper;
use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;

file_put_contents(
    $path = __DIR__.'/examples/soar-options.php',
    $code = \sprintf(
        <<<'PHP'
            <?php

            declare(strict_types=1);

            /**
             * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
             *
             * For the full copyright and license information, please view
             * the LICENSE file that was distributed with this source code.
             *
             * @see https://github.com/guanguans/soar-php
             */

            // +----------------------------------------------------------------------+//
            // |              请参考 @see https://github.com/XiaoMi/soar               |//
            // +----------------------------------------------------------------------+//

            return %s;
            PHP,
        var_export(ComposerScripts::resolveSoarHelp()->map(static fn (array $help): mixed => $help['default'])->all(), true),
        // (new Dumper)->dump(ComposerScripts::resolveSoarHelp()->map(static fn (array $help): mixed => $help['default'])->all()),
    )
);

return RectorConfig::configure()
    ->withPaths([
        $path,
    ])
    ->withPhpVersion(PhpVersion::PHP_80)
    ->withoutParallel()
    // ->withImportNames(importNames: false)
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    ->withRules([
        AddSoarOptionsDocCommentRector::class,
        // SimplifyListIndexRector::class,
    ]);
