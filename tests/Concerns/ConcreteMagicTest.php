<?php

/** @noinspection DebugFunctionUsageInspection */
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
    expect(unserialize(serialize(Soar::create(require __DIR__.'/../../examples/soar.options.full.php'))))
        ->toBeInstanceOf(Soar::class)
        ->getSoarBinary()->not->toBeEmpty()
        ->getOptions()->not->toBeEmpty();
})->group(__DIR__, __FILE__);

it('can export soar code block and eval it', function (): void {
    expect(
        (static function () {
            $soar = null;
            eval(sprintf('$soar = %s;', var_export(
                Soar::create(require __DIR__.'/../../examples/soar.options.full.php'),
                true
            )));

            /** @noinspection PhpExpressionAlwaysNullInspection */
            return $soar;
        })()
    )
        ->toBeInstanceOf(Soar::class)
        ->getSoarBinary()->not->toBeEmpty()
        ->getOptions()->not->toBeEmpty();
})->group(__DIR__, __FILE__);
