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

it('can serialize and unserialize', function (): void {
    $soar = Soar::create(require __DIR__.'/../../examples/soar.options.full.php');
    $serializedSoar = serialize($soar);
    $unserializedSoar = unserialize($serializedSoar);

    expect($unserializedSoar)->toBeInstanceOf(Soar::class)
        ->getSoarBinary()->not->toBeEmpty()
        ->getOptions()->not->toBeEmpty();
});

it('can export', function (): void {
    $soar = Soar::create(require __DIR__.'/../../examples/soar.options.full.php');
    /** @noinspection DebugFunctionUsageInspection */
    $exportedSoarStr = var_export($soar, true);
    $exportedSoar = null;
    eval("\$exportedSoar = $exportedSoarStr;");

    expect($exportedSoar)->toBeInstanceOf(Soar::class)
        ->getSoarBinary()->not->toBeEmpty()
        ->getOptions()->not->toBeEmpty();
});
