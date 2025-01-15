<?php

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

it('can get help', function (): void {
    expect(Soar::create())->help()->toContain('-version');
})
    ->group(__DIR__, __FILE__)
    ->skip(OS::isWindows(), 'This test is skipped. Because is not supported in windows.');

it('can get version', function (): void {
    expect(Soar::create())->version()->toContain(
        'Version: 2023-12-15 17:13:07 +0800 0.11.0-148-g5ed8574',
        'Branch: dev',
        'Compile: 2024-01-16 15:35:51 +0800 by go version go1.21.5',
        'GitDirty:       12',
    );
})->group(__DIR__, __FILE__);
