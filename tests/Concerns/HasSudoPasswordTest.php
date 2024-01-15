<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\SoarPHP\Soar;

uses(Guanguans\SoarPHPTests\TestCase::class);

test('set sudo password', function (): void {
    $soar = Soar::create();
    $soar->setSudoPassword($sudoPassword = 'foo');

    expect($soar->getSudoPassword())->toBe($sudoPassword);
});

test('get escaped sudo password', function (): void {
    $soar = Soar::create();
    $escapedSudoPassword = (function (Soar $soar): string {
        return $soar->getEscapedSudoPassword();
    })->call($soar, $soar);

    expect($escapedSudoPassword)->toBeString();
});
