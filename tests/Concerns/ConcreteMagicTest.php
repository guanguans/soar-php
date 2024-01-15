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

test('sleep', function (): void {
    $soar = Soar::create(require __DIR__.'/../../examples/soar.options.full.php');
    $serializedSoar = serialize($soar);
    $unserializedSoar = unserialize($serializedSoar);

    expect($unserializedSoar)->toBeInstanceOf(Soar::class);
    expect($unserializedSoar->getSoarBinary())->not->toBeEmpty();
    expect($unserializedSoar->getOptions())->not->toBeEmpty();
});

test('set state', function (): void {
    $soar = Soar::create(require __DIR__.'/../../examples/soar.options.full.php');
    $exportedSoarStr = var_export($soar, true);
    $exportedSoar = null;
    eval("\$exportedSoar = $exportedSoarStr;");

    expect($exportedSoar)->toBeInstanceOf(Soar::class);
    expect($exportedSoar->getSoarBinary())->not->toBeEmpty();
    expect($exportedSoar->getOptions())->not->toBeEmpty();
});
