<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

/** @noinspection DebugFunctionUsageInspection */
/** @noinspection ForgottenDebugOutputInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection SqlResolve */

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\OS;
use Pest\Expectation;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;
use function Spatie\Snapshots\assertMatchesTextSnapshot;

it('can get array scores', function (array|string $sqls): void {
    expect(Soar::create())
        ->withOptions(array_filter(
            soar_options(),
            fn (mixed $value): bool => null !== $value
        ))
        // ->withOptions(soar_options())
        ->arrayScores($sqls)
        ->toBeArray()
        ->toBeTruthy()
        ->when(OS::isWindows(), function (Expectation $expectation): void {
            dump($expectation->value);
        })
        ->when(!OS::isWindows(), function (Expectation $expectation): void {
            $scores = json_encode(
                $expectation->value,
                \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR,
            );
            assertMatchesJsonSnapshot($scores);
            assertMatchesTextSnapshot($scores);
        });
})->group(__DIR__, __FILE__)->with('SQL statements');

it('can get json scores', function (): void {
    expect(Soar::create())
        ->jsonScores('select * from foo')
        ->toBeJson()
        ->toBeTruthy()
        ->when(!OS::isWindows(), function (Expectation $expectation): void {
            assertMatchesJsonSnapshot($expectation->value);
            assertMatchesTextSnapshot($expectation->value);
        });
})->group(__DIR__, __FILE__);

it('can get html scores', function (): void {
    expect(Soar::create())
        ->htmlScores('select * from foo')
        ->toBeString()
        ->toBeTruthy()
        ->toContain('foo', '<h1>', '<p>', '<pre>', '<h2>', '<ul>', '<li>')
        ->when(!OS::isWindows(), function (Expectation $expectation): void {
            assertMatchesTextSnapshot($expectation->value);
        });
})->group(__DIR__, __FILE__);

it('can get markdown scores', function (): void {
    expect(Soar::create())
        ->markdownScores('select * from foo')
        ->toBeString()
        ->toBeTruthy()
        ->toContain('foo', '#', '```sql', '##', '*')
        ->when(!OS::isWindows(), function (Expectation $expectation): void {
            assertMatchesTextSnapshot($expectation->value);
        });
});
