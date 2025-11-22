<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
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

use Illuminate\Support\Str;
use function Guanguans\SoarPHP\Support\escape_argument;
use function Guanguans\SoarPHP\Support\str_snake;

it('can escape argument', function (): void {
    expect(escape_argument('foo bar baz'))->toBeString();
})->group(__DIR__, __FILE__);

it('can snake string', function (): void {
    expect(str_snake(__FILE__))->toBe(Str::of(__FILE__)->snake()->toString());
})->group(__DIR__, __FILE__);
