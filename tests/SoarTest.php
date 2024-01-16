<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
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
