<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests;

use Guanguans\SoarPHP\ConsoleTable;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;

class ConsoleTableTest extends TestCase
{
    public function testInvalidArgumentExceptionForRows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The rows cannot be empty.');
        new ConsoleTable([]);
    }

    /**
     * @dataProvider rowsProvider
     */
    public function testRows(array $rows): void
    {
        $consoleTable = new ConsoleTable($rows);

        $this->assertInstanceOf(ConsoleTable::class, $consoleTable->rows($rows));
    }

    /**
     * @dataProvider rowsProvider
     */
    public function testInvalidArgumentExceptionForCharset(array $rows): void
    {
        $consoleTable = new ConsoleTable($rows);
        $charset = 'foo';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The charset($charset) is not supported by mb-string.");
        $consoleTable->charset($charset);
    }

    /**
     * @dataProvider rowsProvider
     */
    public function testCharset(array $rows): void
    {
        $consoleTable = new ConsoleTable($rows);

        $this->assertInstanceOf(ConsoleTable::class, $consoleTable->charset('UTF-16'));
    }

    /**
     * @dataProvider rowsProvider
     */
    public function testIsRenderHeadert(array $rows): void
    {
        $consoleTable = new ConsoleTable($rows);

        $render = (clone $consoleTable)->isRenderHeader(true)->render();
        $this->assertEquals(
            <<<str
+----+-----------------+----------------+
| id | name            | role           |
+----+-----------------+----------------+
| 1  | Denis Koronets  | php developer  |
| 2  | Maxim Ambroskin | java developer |
| 3  | Andrew Sikorsky | php developer  |
+----+-----------------+----------------+
str
            ,
            $render
        );
        $this->assertMatchesSnapshot($render);

        $render = (clone $consoleTable)->isRenderHeader(false)->render();
        $this->assertEquals(
            <<<str
+----+-----------------+----------------+
| 1  | Denis Koronets  | php developer  |
| 2  | Maxim Ambroskin | java developer |
| 3  | Andrew Sikorsky | php developer  |
+----+-----------------+----------------+
str
            ,
            $render
        );
        $this->assertMatchesSnapshot($render);
    }

    public function rowsProvider(): array
    {
        return [
            [
                [
                    [
                        'id' => 1,
                        'name' => 'Denis Koronets',
                        'role' => 'php developer',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Maxim Ambroskin',
                        'role' => 'java developer',
                    ],
                    [
                        'id' => 3,
                        'name' => 'Andrew Sikorsky',
                        'role' => 'php developer',
                    ],
                ],
            ],
        ];
    }
}
