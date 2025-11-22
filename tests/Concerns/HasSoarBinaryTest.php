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

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Soar;

it('can get soar binary', function (): void {
    expect(Soar::make())->getSoarBinary()->toBeFile();
})->group(__DIR__, __FILE__);

it('will throw InvalidArgumentException when set not a file', function (): void {
    Soar::make()->setSoarBinary('soar-binary');
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class, 'The [soar-binary] is not a file.');

it('will throw InvalidArgumentException when set not a executable file', function (): void {
    Soar::make()->setSoarBinary(__FILE__);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class, \sprintf('The file [%s] is not executable.', __FILE__));
