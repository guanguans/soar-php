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

use Guanguans\SoarPHP\Support\OS;

it('can check OS', function (): void {
    expect(OS::isUnix())->toBeBool()
        ->and(OS::isWindows())->toBeBool()
        ->and(OS::isMacOS())->toBeBool();
})->group(__DIR__, __FILE__);

it('can check arch', function (): void {
    expect(OS::isArm())->toBeBool()
        ->and(OS::isPPC())->toBeBool()
        ->and(OS::isX86())->toBeBool();
})->group(__DIR__, __FILE__);

it('can get arch enum(', function (): void {
    expect(OS::getArchEnum())->toBeString();
})->group(__DIR__, __FILE__)->skip(OS::isWindows());
