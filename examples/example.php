<?php

/** @noinspection DebugFunctionUsageInspection */
/** @noinspection ForgottenDebugOutputInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection SqlResolve */

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

require __DIR__.'/../vendor/autoload.php';

use Guanguans\SoarPHP\Soar;

$queries = [
    <<<'QUERY'
        SELECT
            DATE_FORMAT (t.last_update, '%Y-%m-%d'),
            COUNT(DISTINCT (t.city))
        FROM
            city t
        WHERE
            t.last_update > '2018-10-22 00:00:00'
            AND t.city LIKE '%Chrome%'
            AND t.city = 'eip'
        GROUP BY
            DATE_FORMAT(t.last_update, '%Y-%m-%d')
        ORDER BY
            DATE_FORMAT(t.last_update, '%Y-%m-%d');
        QUERY,
    'SELECT * FROM `foo`;',
];

/**
 * Examples of scoring.
 */
$scores = Soar::make()->arrayScores($queries); // Basic scoring
dump($scores);

$scores = Soar::make() // Advanced scoring
    ->withTestDsn([
        'user' => 'you_user',
        'password' => 'you_password',
        'addr' => 'you_host:you_port',
        // 'host' => 'you_host',
        // 'port' => 'you_port',
        'schema' => 'you_dbname',
        // 'disable' => false,
    ])
    ->withOnlineDsn([
        'user' => 'you_user',
        'password' => 'you_password',
        // 'addr' => 'you_host:you_port',
        'host' => 'you_host',
        'port' => 'you_port',
        'schema' => 'you_dbname',
        'disable' => true,
    ])
    ->withExplain(true) // Enable EXPLAIN
    ->withAllowOnlineAsTest(true) // Enable index suggestions
    ->arrayScores($queries);

/**
 * Examples of running any soar command.
 */
// Final run: '/.../bin/soar.darwin-arm64' '-report-type=fingerprint' '-query=SELECT * FROM `foo`;'
$fingerprint = Soar::make()->withReportType('fingerprint')->withQuery($queries[1])->run();

// Final run: '/.../bin/soar.darwin-arm64' '-report-type=pretty' '-query=SELECT * FROM `foo`;'
$pretty = Soar::make()->withReportType('pretty')->withQuery($queries[1])->run();

// Final run: '/.../bin/soar.darwin-arm64' '-version=true'
$version = Soar::make()->withHelp(true)->setVersion(true)->run();

// Final run: '/.../bin/soar.darwin-arm64' '-only-syntax-check=true' '-query=SELECT * FROM `foo`;'
// $syntaxCheck = Soar::make()->withOnlySyntaxCheck(true)->withQuery('SELECT * FRO `foo`;')->run();
$syntaxCheck = Soar::make()->withOnlySyntaxCheck(true)->withQuery('SELECT * FROM `foo`;')->run();

dump(
    // $scores,
    // $fingerprint,
    // $pretty,
    // $version,
    // $syntaxCheck
);
