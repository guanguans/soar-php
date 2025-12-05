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

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

return (new Configuration)
    ->addPathsToScan(
        [
            // __DIR__.'/src/',
        ],
        false
    )
    ->addPathsToExclude([
        __DIR__.'/src/Support/ComposerScripts.php',
        __DIR__.'/src/Support/Rectors/',
        __DIR__.'/tests/',
    ])
    ->ignoreUnknownClasses([
        \SensitiveParameter::class,
    ])
    /** @see \ShipMonk\ComposerDependencyAnalyser\Analyser::CORE_EXTENSIONS */
    ->ignoreErrorsOnExtensions(
        [
            'ext-ctype',
            'ext-mbstring',
        ],
        [ErrorType::SHADOW_DEPENDENCY],
    )
    ->ignoreErrorsOnPackageAndPath(
        'illuminate/collections',
        __DIR__.'/src/Support/helpers.php',
        [ErrorType::SHADOW_DEPENDENCY]
    )
    ->ignoreErrorsOnPackageAndPath(
        'symfony/var-dumper',
        __DIR__.'/src/Concerns/WithDumpable.php',
        [ErrorType::DEV_DEPENDENCY_IN_PROD]
    );
