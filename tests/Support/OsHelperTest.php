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
 * Copyright (c) 2019-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

use Guanguans\SoarPHP\Support\OsHelper;

it('can check OsHelper', function (): void {
    expect(OsHelper::isUnix())->toBeBool()
        ->and(OsHelper::isWindows())->toBeBool()
        ->and(OsHelper::isMacOS())->toBeBool();
})->group(__DIR__, __FILE__);

it('can check arch', function (): void {
    expect(OsHelper::isArm())->toBeBool()
        ->and(OsHelper::isPPC())->toBeBool()
        ->and(OsHelper::isX86())->toBeBool();
})->group(__DIR__, __FILE__);

it('can get arch enum(', function (): void {
    expect(OsHelper::getArchEnum())->toBeString();
})->group(__DIR__, __FILE__)->skipOnWindows();
