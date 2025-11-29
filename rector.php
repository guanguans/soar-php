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

use Ergebnis\Rector\Rules\Arrays\SortAssociativeArrayByKeyRector;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\AddNoinspectionsDocCommentToDeclareRector;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\NewExceptionToNewAnonymousExtendsExceptionImplementsRector;
use Guanguans\MonorepoBuilderWorker\Support\Rectors\RemoveNamespaceRector;
use Guanguans\SoarPHP\Contracts\Throwable;
use Guanguans\SoarPHP\Support\Rectors\AddDocCommentForHasOptionsRector;
use Illuminate\Support\Str;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\ClassLike\NewlineBetweenClassLikeStmtsRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\CodingStyle\Rector\FunctionLike\FunctionLikeToFirstClassCallableRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use Rector\Php80\ValueObject\AnnotationToAttribute;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use Rector\Transform\ValueObject\StaticCallToFuncCall;
use Rector\ValueObject\PhpVersion;
use Rector\ValueObject\Visibility;
use Rector\Visibility\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Visibility\ValueObject\ChangeMethodVisibility;
use function Guanguans\SoarPHP\Support\classes;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/benchmarks/',
        __DIR__.'/examples/',
        __DIR__.'/src/',
        __DIR__.'/tests/',
        __DIR__.'/composer-bump',
    ])
    ->withRootFiles()
    ->withAutoloadPaths([
        // (new ReflectionClass(Throwable::class))->getFileName(),
    ])
    ->withBootstrapFiles([
        // __DIR__.'/vendor/symplify/monorepo-builder/vendor/autoload.php',
        // __DIR__.'/vendor/symplify/monorepo-builder/vendor/scoper-autoload.php',
    ])
    ->withSkip([
        '**/__snapshots__/*',
        '**/Fixtures/*',
        __DIR__.'/_ide_helper.php',
        __DIR__.'/tests.php',
        // __FILE__,
    ])
    ->withCache(__DIR__.'/.build/rector/')
    // ->withoutParallel()
    ->withParallel()
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    // ->withImportNames(importNames: false)
    // ->withEditorUrl()
    ->withFluentCallNewLine()
    ->withTreatClassesAsFinal()
    ->withAttributesSets(phpunit: true, all: true)
    ->withComposerBased(phpunit: true/* , laravel: true */)
    ->withPhpVersion(PhpVersion::PHP_81)
    ->withDowngradeSets(php81: true)
    ->withPhpSets(php81: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        typeDeclarationDocblocks: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        // carbon: true,
    )
    ->withSets([
        PHPUnitSetList::PHPUNIT_100,
    ])
    ->withRules([
        AddDocCommentForHasOptionsRector::class,
        SortAssociativeArrayByKeyRector::class,

        ArraySpreadInsteadOfArrayMergeRector::class,
        JsonThrowOnErrorRector::class,
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
    ])
    ->withConfiguredRule(AddNoinspectionsDocCommentToDeclareRector::class, [
        'AnonymousFunctionStaticInspection',
        'NullPointerExceptionInspection',
        'PhpPossiblePolymorphicInvocationInspection',
        'PhpUndefinedClassInspection',
        'PhpUnhandledExceptionInspection',
        'PhpVoidFunctionResultUsedInspection',
        'SqlResolve',
        'StaticClosureCanBeUsedInspection',
    ])
    ->withConfiguredRule(NewExceptionToNewAnonymousExtendsExceptionImplementsRector::class, [
        Throwable::class,
    ])
    ->withConfiguredRule(RemoveNamespaceRector::class, [
        'Guanguans\SoarPHPTests',
    ])
    ->withConfiguredRule(RemoveAnnotationRector::class, [
        'codeCoverageIgnore',
        'inheritDoc',
        'phpstan-ignore',
        'phpstan-ignore-next-line',
        'psalm-suppress',
    ])
    ->withConfiguredRule(StaticCallToFuncCallRector::class, [
        new StaticCallToFuncCall(Str::class, 'of', 'str'),
    ])
    ->withConfiguredRule(
        AnnotationToAttributeRector::class,
        classes(static fn (string $class): bool => str_starts_with($class, 'PhpBench\Attributes'))
            ->filter(static fn (ReflectionClass $reflectionClass): bool => $reflectionClass->isInstantiable())
            ->map(static fn (ReflectionClass $reflectionClass): AnnotationToAttribute => new AnnotationToAttribute(
                $reflectionClass->getShortName(),
                $reflectionClass->getName(),
                [],
                true
            ))
            ->all(),
    )
    ->withConfiguredRule(
        ChangeMethodVisibilityRector::class,
        classes(static fn (string $class, string $file): bool => str_starts_with($class, 'Guanguans\SoarPHP'))
            ->filter(static fn (ReflectionClass $reflectionClass): bool => $reflectionClass->isTrait())
            ->map(
                static fn (ReflectionClass $reflectionClass): array => collect($reflectionClass->getMethods(ReflectionMethod::IS_PRIVATE))
                    ->reject(static fn (ReflectionMethod $reflectionMethod): bool => $reflectionMethod->isFinal() || $reflectionMethod->isInternal())
                    ->map(static fn (ReflectionMethod $reflectionMethod): ChangeMethodVisibility => new ChangeMethodVisibility(
                        $reflectionClass->getName(),
                        $reflectionMethod->getName(),
                        Visibility::PROTECTED
                    ))
                    ->all()
            )
            ->flatten()
            // ->dd()
            ->all(),
    )
    ->withConfiguredRule(
        RenameFunctionRector::class,
        [
            'Pest\Faker\fake' => 'fake',
            'Pest\Faker\faker' => 'fake',
            'test' => 'it',
        ] + array_reduce(
            [
                'classes',
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
    ->withSkip([
        ChangeOrIfContinueToMultiContinueRector::class,
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        NewlineBetweenClassLikeStmtsRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        FunctionLikeToFirstClassCallableRector::class => [
            __DIR__.'/src/Support/helpers.php',
            __DIR__.'/tests/Concerns/HasOptionsTest.php',
        ],
        StaticArrowFunctionRector::class => $staticClosureSkipPaths = [
            __DIR__.'/tests/',
        ],
        StaticClosureRector::class => $staticClosureSkipPaths,
        SortAssociativeArrayByKeyRector::class => [
            __DIR__.'/benchmarks/',
            __DIR__.'/examples/',
            __DIR__.'/src/',
            __DIR__.'/tests/',
        ],
        AddNoinspectionsDocCommentToDeclareRector::class => [
            __DIR__.'/benchmarks/',
            __DIR__.'/examples/',
            __DIR__.'/src/',
            // __DIR__.'/tests/',
            ...$rootFiles = array_filter(
                glob(__DIR__.'/{*,.*}.php', \GLOB_BRACE),
                static fn (string $filename): bool => !\in_array(
                    $filename,
                    [
                        __DIR__.'/_ide_helper.php',
                        __DIR__.'/tests.php',
                    ],
                    true
                )
            ),
            __DIR__.'/composer-bump',
        ],
        NewExceptionToNewAnonymousExtendsExceptionImplementsRector::class => [
            __DIR__.'/src/Support/Rectors/',
        ],
        RemoveNamespaceRector::class => [
            __DIR__.'/benchmarks/',
            __DIR__.'/examples/',
            __DIR__.'/src/',
            // __DIR__.'/tests/',
            ...$rootFiles,
            __DIR__.'/composer-bump',
            __DIR__.'/tests/TestCase.php',
        ],
    ]);
