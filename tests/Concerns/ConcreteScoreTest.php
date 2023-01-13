<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests\Concerns;

use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\OsHelper;
use Guanguans\Tests\TestCase;

class ConcreteScoreTest extends TestCase
{
    public function testArrayScore(): void
    {
        $soar = Soar::create();
        $sql = 'select * from foo';
        $scores = $soar->arrayScore($sql);

        $this->assertIsArray($scores);
        $this->assertNotEmpty($scores);

        /** @noinspection ForgottenDebugOutputInspection */
        /** @noinspection DebugFunctionUsageInspection */
        OsHelper::isWindows() and dump($scores);
        OsHelper::isWindows() or $this->assertMatchesYamlSnapshot($scores);
    }

    public function testJsonScore(): void
    {
        $soar = Soar::create();
        $sql = <<<sql
SELECT * FROM `post` WHERE `name`='so"a`r';
SELECT DATE_FORMAT (t.last_update,'%Y-%m-%d'),COUNT (DISTINCT (t.city)) FROM city t WHERE t.last_update> '2018-10-22 00:00:00' AND t.city LIKE '%Chrome%' AND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d');

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
sql;
        $jsonScore = $soar->jsonScore($sql);

        $this->assertJson($jsonScore);
        $this->assertNotEmpty($jsonScore);

        $this->assertMatchesJsonSnapshot($jsonScore);
    }

    public function testHtmlScore(): void
    {
        $soar = Soar::create();
        $htmlScore = $soar->htmlScore('select * from foo');

        $this->assertIsString($htmlScore);
        $this->assertNotEmpty($htmlScore);

        $this->assertStringContainsString('foo', $htmlScore);
        $this->assertStringContainsString('<h1>', $htmlScore);
        $this->assertStringContainsString('<p>', $htmlScore);
        $this->assertStringContainsString('<pre>', $htmlScore);
        $this->assertStringContainsString('<h2>', $htmlScore);
        $this->assertStringContainsString('<ul>', $htmlScore);
        $this->assertStringContainsString('<li>', $htmlScore);

        OsHelper::isWindows() or $this->assertMatchesSnapshot($htmlScore);
    }

    public function testMarkdownScore(): void
    {
        $soar = Soar::create();
        $markdownScore = $soar->markdownScore('select * from foo');

        $this->assertIsString($markdownScore);
        $this->assertNotEmpty($markdownScore);

        $this->assertStringContainsString('foo', $markdownScore);
        $this->assertStringContainsString('#', $markdownScore);
        $this->assertStringContainsString('```sql', $markdownScore);
        $this->assertStringContainsString('##', $markdownScore);
        $this->assertStringContainsString('*', $markdownScore);
        $this->assertStringContainsString('分', $markdownScore);

        OsHelper::isWindows() or $this->assertMatchesSnapshot($markdownScore);
    }
}
