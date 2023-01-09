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

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Explainer;
use Guanguans\SoarPHP\Support\OsHelper;

class ExplainerTest extends TestCase
{
    public function testGetPdo(): void
    {
        $mockPDO = \Mockery::mock(\PDO::class);
        $explainer = new Explainer($mockPDO);

        $this->assertInstanceOf(\PDO::class, $explainer->getPdo());
    }

    public function testSetPdo(): void
    {
        $pdo = new \PDO('sqlite::memory:');
        $explainer = new Explainer($pdo);
        $explainer->setPdo($pdo);

        $this->assertEquals($pdo, $explainer->getPdo());
    }

    public function testGetNormalizedExplain(): void
    {
        OsHelper::isWindows() and $this->markTestSkipped(__METHOD__);

        $mockPDOStatement = \Mockery::mock(\PDOStatement::class);
        $mockPDOStatement->shouldReceive('fetchAll')->andReturn(
            [
                [
                    'id' => '1',
                    'select_type' => 'SIMPLE',
                    'table' => 'admin_users',
                    'partitions' => null,
                    'type' => 'ALL',
                    'possible_keys' => 'PRIMARY',
                    'key' => null,
                    'key_len' => null,
                    'ref' => null,
                    'rows' => '1',
                    'filtered' => '100.00',
                    'Extra' => null,
                ],
                [
                    'id' => '1',
                    'select_type' => 'SIMPLE',
                    'table' => 'admin_role_users',
                    'partitions' => null,
                    'type' => 'ALL',
                    'possible_keys' => 'admin_role_users_role_id_user_id_unique',
                    'key' => null,
                    'key_len' => null,
                    'ref' => null,
                    'rows' => '1',
                    'filtered' => '100.00',
                    'Extra' => 'Using where; Using join buffer (Block Nested Loop)',
                ],
            ]
        );

        $mockPDO = \Mockery::mock(\PDO::class);
        $mockPDO->shouldReceive('query')->andReturns($mockPDOStatement);
        $explainer = new Explainer($mockPDO);

        $normalizedExplain = $explainer->getNormalizedExplain('select * from user;');
        $this->assertEquals(
            <<<'str'
'explain'
+----+-------------+------------------+------------+------+-----------------------------------------+-----+---------+-----+------+----------+----------------------------------------------------+
| id | select_type | table            | partitions | type | possible_keys                           | key | key_len | ref | rows | filtered | Extra                                              |
+----+-------------+------------------+------------+------+-----------------------------------------+-----+---------+-----+------+----------+----------------------------------------------------+
| 1  | SIMPLE      | admin_users      |            | ALL  | PRIMARY                                 |     |         |     | 1    | 100.00   |                                                    |
| 1  | SIMPLE      | admin_role_users |            | ALL  | admin_role_users_role_id_user_id_unique |     |         |     | 1    | 100.00   | Using where; Using join buffer (Block Nested Loop) |
+----+-------------+------------------+------------+------+-----------------------------------------+-----+---------+-----+------+----------+----------------------------------------------------+
explain
str
            ,
            $normalizedExplain
        );
        $this->assertMatchesSnapshot($normalizedExplain);
    }

    public function testGetFinalExplainExplain(): void
    {
        // 第一次
        $mockPDOStatement = \Mockery::mock(\PDOStatement::class);
        $mockPDOStatement->shouldReceive('fetchAll')->times(2)->andReturns(
            [],
            [
                [
                    'id' => '1',
                    'select_type' => 'SIMPLE',
                    'table' => 'admin_users',
                    'partitions' => null,
                    'type' => 'ALL',
                    'possible_keys' => 'PRIMARY',
                    'key' => null,
                    'key_len' => null,
                    'ref' => null,
                    'rows' => '1',
                    'filtered' => '100.00',
                    'Extra' => null,
                ],
            ]
        );

        $mockPDO = \Mockery::mock(\PDO::class);
        $mockPDO->shouldReceive('query')->andReturns($mockPDOStatement);
        $explainer = new Explainer($mockPDO);

        $finalExplain = $explainer->getFinalExplain('select * from user;');
        $this->assertIsArray($finalExplain);
        $this->assertNotEmpty($finalExplain);
        OsHelper::isWindows() or $this->assertMatchesSnapshot($finalExplain);

        // 第二次
        $mockPDOStatement = \Mockery::mock(\PDOStatement::class);
        $mockPDOStatement->shouldReceive('fetchAll')->times(3)->andReturns(
            [],
            [],
            [
                [
                    'id' => '1',
                    'select_type' => 'SIMPLE',
                    'table' => 'admin_users',
                    'partitions' => null,
                    'type' => 'ALL',
                    'possible_keys' => 'PRIMARY',
                    'key' => null,
                    'key_len' => null,
                    'ref' => null,
                    'rows' => '1',
                    'filtered' => '100.00',
                    'Extra' => null,
                ],
            ]
        );

        $mockPDO = \Mockery::mock(\PDO::class);
        $mockPDO->shouldReceive('query')->andReturns($mockPDOStatement);
        $explainer = new Explainer($mockPDO);

        $finalExplain = $explainer->getFinalExplain('select * from user;');
        $this->assertIsArray($finalExplain);
        $this->assertNotEmpty($finalExplain);
        OsHelper::isWindows() or $this->assertMatchesSnapshot($finalExplain);
    }

    public function testInvalidArgumentExceptionForGetExplain(): void
    {
        $pdo = new \PDO('sqlite::memory:');
        $explainer = new Explainer($pdo);

        $this->expectException(InvalidArgumentException::class);
        $type = 'foo';
        $this->expectExceptionMessage("Invalid type value(partitions/extended): $type");
        $explainer->getExplain('select * from user;', $type);
    }

    public function testGetExplain(): void
    {
        $mockPDO = \Mockery::mock(\PDO::class);
        $mockPDO->shouldReceive('query')->andReturnFalse();
        $explainer = new Explainer($mockPDO);

        $explain = $explainer->getExplain('select * from user;');
        $this->assertEquals([], $explain);
    }
}
