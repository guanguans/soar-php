<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection DebugFunctionUsageInspection */
/** @noinspection ForgottenDebugOutputInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection SqlResolve */
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
use Guanguans\SoarPHP\Support\OS;
use Pest\Expectation;

it('can get array scores', function (): void {
    $sqls = <<<'sqls'
        SELECT * FROM `post` WHERE `name`='so"a`r';
        SELECT DATE_FORMAT(t.last_update,'%Y-%m-%d'), COUNT(DISTINCT(t.city)) FROM city t WHERE t.last_update> '2018-10-22 00:00:00' AND t.city LIKE '%Chrome%' AND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d');

        DELETE city FROM city LEFT JOIN country ON city.country_id=country.country_id WHERE country.country IS NULL;

        UPDATE city INNER JOIN country ON city.country_id=country.country_id INNER JOIN address ON city.city_id=address.city_id SET city.city='Abha',city.last_update='2006-02-15 04:45:25',country.country='Afghanistan' WHERE city.city_id=10;

        INSERT INTO city (country_id) SELECT country_id FROM country;

        REPLACE INTO city (country_id) SELECT country_id FROM country;

        ALTER TABLE inventory ADD INDEX `idx_store_film` (`store_id`,`film_id`),ADD INDEX `idx_store_film` (`store_id`,`film_id`),ADD INDEX `idx_store_film` (`store_id`,`film_id`);

        DROP TABLE `users`;

        CREATE TABLE `users` (
          `id` bigint unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `email_verified_at` timestamp NULL DEFAULT NULL,
          `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `users_email_unique` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        sqls;

    expect(Soar::create())
        ->arrayScores($sqls)
        ->toBeArray()
        ->toBeTruthy()
        ->each(function (Expectation $expectation): void {
            $expectation->toBeArray()->toHaveKeys([
                'ID',
                'Fingerprint',
                'Score',
                'Sample',
                'Explain',
                'HeuristicRules',
                'IndexRules',
                'Tables',
            ]);
        })
        ->when(OS::isWindows(), function (Expectation $expectation): void {
            dump($expectation->value);
        })
        ->when(!OS::isWindows(), function (Expectation $expectation): void {
            $this->assertMatchesJsonSnapshot($expectation->value);
        });
})->group(__DIR__, __FILE__);

it('can get json scores', function (): void {
    expect(Soar::create())
        ->jsonScores('select * from foo')
        ->toBeJson()
        ->toBeTruthy()
        ->toAssert(function (string $jsonScores): void {
            $this->assertMatchesJsonSnapshot($jsonScores);
        });
})->group(__DIR__, __FILE__);

it('can get html scores', function (): void {
    expect(Soar::create())
        ->htmlScores('select * from foo')
        ->toBeString()
        ->toBeTruthy()
        ->toContain('foo', '<h1>', '<p>', '<pre>', '<h2>', '<ul>', '<li>')
        ->when(!OS::isWindows(), function (Expectation $expectation): void {
            $this->assertMatchesSnapshot($expectation->value);
        });
})->group(__DIR__, __FILE__);

it('can get markdown scores', function (): void {
    expect(Soar::create())
        ->markdownScores('select * from foo')
        ->toBeString()
        ->toBeTruthy()
        ->toContain('foo', '#', '```sql', '##', '*')
        ->when(!OS::isWindows(), function (Expectation $expectation): void {
            $this->assertMatchesSnapshot($expectation->value);
        });
});

it('can get scores', function (): void {
    expect(Soar::create())
        ->scores('select * from users;')
        ->toBeString()
        ->toBeTruthy()
        ->scores([
            'select * from a; select * from b',
            'select * from c',
            'select * from d',
        ])
        ->toBeString()
        ->toBeTruthy()
        ->mergeOptions(require __DIR__.'/../../examples/soar.options.full.php')->scores('select * from users;')
        ->toBeString()
        ->toBeTruthy();
})->group(__DIR__, __FILE__);
