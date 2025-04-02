<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

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
use Illuminate\Support\Str;
use function Spatie\Snapshots\assertMatchesTextSnapshot;

it('can get help', function (): void {
    expect(Soar::make())->help()->toContain('-version');
})->group(__DIR__, __FILE__)->skip(OS::isWindows(), 'The help option of Soar is not supported on Windows.');

it('can get help snapshot', function (): void {
    assertMatchesTextSnapshot(
        Str::of(Soar::make()->help())->replace(Soar::make()->getSoarBinary(), 'soar-binary')->toString()
    );
})->group(__DIR__, __FILE__)->skip(OS::isWindows());

it('can get version', function (): void {
    expect(Soar::make())->version()->toContain(
        'Version: 2023-12-15 17:13:07 +0800 0.11.0-148-g5ed8574',
        'Branch: dev',
        'Compile: 2024-01-16 15:35:51 +0800 by go version go1.21.5',
        'GitDirty:       12',
    );
})->group(__DIR__, __FILE__);

it('can get version snapshot', function (): void {
    assertMatchesTextSnapshot(Soar::make()->version());
})->group(__DIR__, __FILE__)->skip(OS::isWindows());
