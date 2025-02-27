<?php

/** @noinspection DebugFunctionUsageInspection */
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

use Guanguans\SoarPHP\Soar;

it('can serialize and unserialize', function (): void {
    expect(unserialize(serialize(Soar::create(require __DIR__.'/../../examples/soar.options.full.php'))))
        ->toBeInstanceOf(Soar::class)
        ->getSoarBinary()->toBeTruthy()
        ->getOptions()->toBeTruthy();
})->group(__DIR__, __FILE__);

it('can export soar code block and eval it', function (): void {
    expect(
        (static function () {
            $soar = null;
            eval(\sprintf('$soar = %s;', var_export(
                Soar::create(require __DIR__.'/../../examples/soar.options.full.php'),
                true
            )));

            /** @noinspection PhpExpressionAlwaysNullInspection */
            return $soar;
        })()
    )
        ->toBeInstanceOf(Soar::class)
        ->getSoarBinary()->toBeTruthy()
        ->getOptions()->toBeTruthy();
})->group(__DIR__, __FILE__);
