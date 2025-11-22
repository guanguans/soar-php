<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection DebugFunctionUsageInspection */
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
    expect(unserialize(serialize(Soar::make(soar_options()))))
        ->toBeInstanceOf(Soar::class)
        ->getSoarBinary()->toBeTruthy()
        ->getOptions()->toBeTruthy();
})->group(__DIR__, __FILE__);

it('can export soar code block and eval it', function (): void {
    $varExport = var_export(Soar::make(soar_options()), true);
    file_put_contents(
        $path = fixtures_path('Soar.php'),
        <<<PHP
            <?php

            /** @noinspection all */

            return $varExport;

            PHP
    );
    expect(require $path)->toBeInstanceOf(Soar::class)
        ->getSoarBinary()->toBeTruthy()
        ->getOptions()->toBeTruthy();
})->group(__DIR__, __FILE__);
