<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SqlResolve */
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

it('can get help', function (): void {
    expect(Soar::make())->help()->toContain('-version');
})->group(__DIR__, __FILE__);

it('can get help snapshot', function (): void {
    expect(str(Soar::make()->help())->replace(Soar::make()->getBinary(), 'soar-binary'))->toMatchSnapshot();
})->group(__DIR__, __FILE__)->skipOnWindows();

it('can get version', function (): void {
    expect(Soar::make())->version()->toContain(
        'Version: 2023-12-15 17:13:07 +0800 0.11.0-148-g5ed8574',
        'Branch: dev',
        'Compile: 2025-04-03 21:22:31 +0800 by go version go1.24.1 darwin/arm64',
        'GitDirty:        0',
    );
})->group(__DIR__, __FILE__);

it('can get version snapshot', function (): void {
    expect(Soar::make()->version())->toMatchSnapshot();
})->group(__DIR__, __FILE__)->skipOnWindows();
