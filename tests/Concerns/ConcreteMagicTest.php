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
    expect(unserialize(serialize($soar)))->toBeInstanceOf(Soar::class)
        ->getSoarBinary()->not->toBeEmpty()
        ->getOptions()->not->toBeEmpty();
})->group(__DIR__, __FILE__);

it('can export code block and eval it', function (): void {
    expect(
        (static function () {
            $soar = null;
            /** @noinspection DebugFunctionUsageInspection */
            $exportedSoarCodeBlock = var_export(
                Soar::create(require __DIR__.'/../../examples/soar.options.full.php'),
                true
            );
            eval("\$soar = $exportedSoarCodeBlock;");

            /** @noinspection PhpExpressionAlwaysNullInspection */
            return $soar;
        })()
    )
        ->toBeInstanceOf(Soar::class)
        ->getSoarBinary()->not->toBeEmpty()
        ->getOptions()->not->toBeEmpty();
})->group(__DIR__, __FILE__);
