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

test('dump', function (): void {
    $soar = Soar::create([
        'foo' => 'bar',
    ]);

    expect($soar->dump('foo'))->toBeInstanceOf(Soar::class);

    $mockObject = $this->getFunctionMock('\\Guanguans\\SoarPHP', 'class_exists');
    $mockObject->expects($this->any())->willReturn(false);
    expect($soar->dump('foo'))->toBeInstanceOf(Soar::class);
});
