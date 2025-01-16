<?php

/** @noinspection PhpUnhandledExceptionInspection */
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

use Guanguans\SoarPHP\Support\Rectors\ToInternalExceptionRector;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\ClassMethod\ExplicitReturnNullRector;
use Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\RemoveExpectAnyFromMockRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/benchmarks',
        __DIR__.'/examples',
        __DIR__.'/src',
        __DIR__.'/tests',
        __DIR__.'/.*.php',
        __DIR__.'/*.php',
        __DIR__.'/composer-updater',
    ])
    ->withParallel()
    // ->withoutParallel()
    ->withImportNames(false)
    ->withAttributesSets()
    ->withDeadCodeLevel(42)
    ->withTypeCoverageLevel(37)
    ->withFluentCallNewLine()
    // ->withPhpSets()
    // ->withPreparedSets()
    ->withDowngradeSets(false, false, false, true)
    ->withSets([
        LevelSetList::UP_TO_PHP_74,
    ])
    ->withSets([
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        // SetList::DEAD_CODE,
        // SetList::STRICT_BOOLEANS,
        // SetList::GMAGICK_TO_IMAGICK,
        SetList::NAMING,
        // SetList::PRIVATIZATION,
        // SetList::TYPE_DECLARATION,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
    ])
    ->withSets([
        PHPUnitSetList::PHPUNIT_90,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
    ])
    ->withRules([
        InlineConstructorDefaultToPropertyRector::class,
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
        ToInternalExceptionRector::class,
    ])
    ->withConfiguredRule(
        RenameFunctionRector::class,
        [
            'test' => 'it',
        ] + array_reduce(
            [
                // 'make',
                // 'env_explode',
            ],
            static function (array $carry, string $func): array {
                /** @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/functions.php */
                $carry[$func] = "Guanguans\\SoarPHP\\Support\\$func";

                return $carry;
            },
            []
        )
    )
    ->withSkip([
        '**/__aspect_mock__/*',
        '**/__snapshots__/*',
        '**/fixtures/*',
        '**/Fixtures/*',
        __DIR__.'/tests/Concerns/WithRunableTest.php',
    ])
    ->withSkip([
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        ExplicitReturnNullRector::class,
        InlineIfToExplicitIfRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        RenameParamToMatchTypeRector::class,
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        ReturnEarlyIfVariableRector::class => [
            __DIR__.'/src/Support/EscapeArg.php',
        ],
        RemoveExpectAnyFromMockRector::class => [
            __DIR__.'/tests/Concerns/WithDumpableTest.php',
        ],
        RenameFunctionRector::class => [
            // __DIR__.'/src/Support/helpers.php',
        ],
        ToInternalExceptionRector::class => [
            __DIR__.'/tests',
        ],
        StaticArrowFunctionRector::class => $staticClosureSkipPaths = [
            __DIR__.'/tests',
        ],
        StaticClosureRector::class => $staticClosureSkipPaths,
    ]);
