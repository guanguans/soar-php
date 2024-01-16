<?php

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

it('can set sudo password', function (): void {
    /** @noinspection NullPointerExceptionInspection */
    expect(Soar::create())
        ->setSudoPassword($sudoPassword = 'foo')
        ->getSudoPassword()->toBe($sudoPassword);
})->group(__DIR__, __FILE__);

it('can get escaped sudo password', function (): void {
    $soar = Soar::create();

    expect(function (Soar $soar): string {
        return $soar->getEscapedSudoPassword();
    })->call($soar, $soar)->toBeString();
})->group(__DIR__, __FILE__);
