<?php

/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpMultipleClassDeclarationsInspection */
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

use Composer\Autoload\ClassLoader;
use Ergebnis\Rector\Rules\Arrays\SortAssociativeArrayByKeyRector;
use Guanguans\SoarPHP\Support\Rectors\AddHasOptionsDocCommentRector;
use Guanguans\SoarPHP\Support\Rectors\TransformToInternalExceptionRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector;
use Rector\DowngradePhp81\Rector\Array_\DowngradeArraySpreadStringKeyRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use Rector\Php80\ValueObject\AnnotationToAttribute;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\ValueObject\PhpVersion;

function classes(): array
{
    static $classes;

    foreach (spl_autoload_functions() as $loader) {
        if (\is_array($loader) && $loader[0] instanceof ClassLoader) {
            return $classes ??= array_keys($loader[0]->getClassMap());
        }
    }

    return $classes ??= [];
}

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/benchmarks',
        __DIR__.'/examples',
        __DIR__.'/src',
        __DIR__.'/tests',
        ...glob(__DIR__.'/{*,.*}.php', \GLOB_BRACE),
        __DIR__.'/composer-updater',
    ])
    ->withRootFiles()
    // ->withSkipPath(__DIR__.'/tests.php')
    ->withSkip([
        '**/__snapshots__/*',
        '**/Fixtures/*',
        // __FILE__,
    ])
    ->withCache(__DIR__.'/.build/rector/')
    ->withParallel()
    ->withoutParallel()
    // ->withImportNames(importNames: false)
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    ->withFluentCallNewLine()
    ->withAttributesSets(phpunit: true, all: true)
    ->withComposerBased(phpunit: true)
    ->withPhpVersion(PhpVersion::PHP_80)
    ->withDowngradeSets(php80: true)
    ->withPhpSets(php80: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        carbon: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
    )
    ->withSets([
        PHPUnitSetList::PHPUNIT_90,
    ])
    ->withRules([
        ArraySpreadInsteadOfArrayMergeRector::class,
        JsonThrowOnErrorRector::class,
        SortAssociativeArrayByKeyRector::class,
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
        AddHasOptionsDocCommentRector::class,
        TransformToInternalExceptionRector::class,
    ])
    ->withConfiguredRule(RemoveAnnotationRector::class, [
        'codeCoverageIgnore',
        'phpstan-ignore',
        'phpstan-ignore-next-line',
        'psalm-suppress',
    ])
    ->withConfiguredRule(
        RenameFunctionRector::class,
        [
            'Pest\Faker\fake' => 'fake',
            'Pest\Faker\faker' => 'faker',
            'faker' => 'fake',
            'test' => 'it',
        ] + array_reduce(
            [
                'escape_argument',
                'str_snake',
            ],
            static function (array $carry, string $func): array {
                /** @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/functions.php */
                $carry[$func] = "Guanguans\\SoarPHP\\Support\\$func";

                return $carry;
            },
            []
        )
    )
    ->withConfiguredRule(
        AnnotationToAttributeRector::class,
        array_map(
            static fn (string $class): AnnotationToAttribute => new AnnotationToAttribute(
                (new ReflectionClass($class))->getShortName(),
                $class,
                [],
                true
            ),
            array_filter(
                classes(),
                static fn (string $class): bool => str_starts_with($class, 'PhpBench\Attributes')
                    && (new ReflectionClass($class))->isInstantiable()
            )
        )
    )
    ->withSkip([
        DowngradeArraySpreadStringKeyRector::class,
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        StaticArrowFunctionRector::class => $staticClosureSkipPaths = [
            __DIR__.'/tests',
        ],
        StaticClosureRector::class => $staticClosureSkipPaths,
        SortAssociativeArrayByKeyRector::class => [
            __DIR__.'/benchmarks',
            __DIR__.'/examples',
            __DIR__.'/src',
            __DIR__.'/tests',
        ],
    ]);
