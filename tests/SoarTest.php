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
        'Version: 2023-01-21 17:22:53 +0800 0.11.0-146-gfab0463',
        'Branch: dev',
        '2023-07-23 18:37:53 +0800 by go version go1.20.6',
        'GitDirty:        0',
    );
})->group(__DIR__, __FILE__);
