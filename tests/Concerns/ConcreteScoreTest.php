<?php

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests\Concerns;

use Guanguans\SoarPHP\Soar;
use Guanguans\Tests\TestCase;

class ConcreteScoreTest extends TestCase
{
    protected $soar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->soar = Soar::create();
    }

    public function testJsonScore()
    {
        $this->assertJson($jsonScore = $this->soar->jsonScore($sql = 'select * from foo'));
        $this->assertStringContainsString('Score', $jsonScore);
        $this->assertStringContainsString($sql, strtolower($jsonScore));
    }

    public function testArrayScore()
    {
        $sql = <<<sql
select * from `post` where `name` = 'so"a`r';
select * from `post` where `id` = '1' order by `id` asc limit 1;
select * from `post` where `id` = '2' limit 1;
select * from `users`;
select * from `post` where `post`.`user_id` = '1' and `post`.`user_id` is not null; select 1;
select * from `users` inner join `post` on `users`.`id` = `post`.`user_id`;

select * from `personal_access_tokens` where `personal_access_tokens`.`id` = "32" limit 1;
select * from `admin_users` where `admin_users`.`id` = '1' limit 1;
update `personal_access_tokens` set `last_used_at` = '2022-04-28 22:04:48', `personal_access_tokens`.`updated_at` = '2022-04-28 22:04:48' where `id` = '32';
select count(*) as aggregate from `goods` inner join `product` on `product`.`id` = `goods`.`product_id` where exists (select * from `product` where `goods`.`product_id` = `product`.`id` and not exists (select * from `product_dont_ship_address` where `product`.`id` = `product_dont_ship_address`.`product_id` and `province_id` = '6' and `city_id` = '303' and `product_dont_ship_address`.`deleted_at` is null) and `product`.`deleted_at` is null) and LOWER(`goods`.`name`) LIKE '%商%' and LOWER(`goods`.`encoding`) LIKE '%654327%' and exists (select * from `product` where `goods`.`product_id` = `product`.`id` and LOWER(`product`.`supplier_id`) LIKE '%15%' and `product`.`deleted_at` is null) and exists (select * from `product` where `goods`.`product_id` = `product`.`id` and LOWER(`product`.`encoding`) LIKE '%654321%' and `product`.`deleted_at` is null) and exists (select * from `product` where `goods`.`product_id` = `product`.`id` and LOWER(`product`.`operator_id`) LIKE '%1%' and `product`.`deleted_at` is null) and exists (select * from `product` where `goods`.`product_id` = `product`.`id` and LOWER(`product`.`province_id`) LIKE '%1%' and `product`.`deleted_at` is null) and exists (select * from `product` where `goods`.`product_id` = `product`.`id` and LOWER(`product`.`city_id`) LIKE '%5%' and `product`.`deleted_at` is null) and `goods`.`deleted_at` is null;
select `goods`.* from `goods` inner join `product` on `product`.`id` = `goods`.`product_id` where exists (select * from `product` where `goods`.`product_id` = `product`.`id` and not exists (select * from `product_dont_ship_address` where `product`.`id` = `product_dont_ship_address`.`product_id` and `province_id` = '6' and `city_id` = '303' and `product_dont_ship_address`.`deleted_at` is null) and `product`.`deleted_at` is null) and LOWER(`goods`.`name`) LIKE '%商%' and LOWER(`goods`.`encoding`) LIKE '%654327%' and exists (select * from `product` where `goods`.`product_id` = `product`.`id` and LOWER(`product`.`supplier_id`) LIKE '%15%' and `product`.`deleted_at` is null) and exists (select * from `product` where `goods`.`product_id` = `product`.`id` and LOWER(`product`.`encoding`) LIKE '%654321%' and `product`.`deleted_at` is null) and exists (select * from `product` where `goods`.`product_id` = `product`.`id` and LOWER(`product`.`operator_id`) LIKE '%1%' and `product`.`deleted_at` is null) and exists (select * from `product` where `goods`.`product_id` = `product`.`id` and LOWER(`product`.`province_id`) LIKE '%1%' and `product`.`deleted_at` is null) and exists (select * from `product` where `goods`.`product_id` = `product`.`id` and LOWER(`product`.`city_id`) LIKE '%5%' and `product`.`deleted_at` is null) and `goods`.`deleted_at` is null order by `goods`.`id` desc limit 15 offset 0;

DROP table `users`;

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

        $arrayScore = $this->soar->arrayScore($sql);
        var_export($arrayScore);
        $this->assertIsArray($arrayScore);
        $this->assertGreaterThanOrEqual(1, $arrayScore);

        $this->assertArrayHasKey('ID', $score = $arrayScore[0]);
        $this->assertArrayHasKey('Fingerprint', $score);
        $this->assertArrayHasKey('Score', $score);
        $this->assertArrayHasKey('Sample', $score);
        $this->assertArrayHasKey('Explain', $score);
        $this->assertArrayHasKey('HeuristicRules', $score);
        $this->assertArrayHasKey('IndexRules', $score);
        $this->assertArrayHasKey('Tables', $score);

        $this->assertIsInt($score['Score']);
        foreach ($arrayScore as $item) {
            $this->assertGreaterThanOrEqual(0, $item['Score']);
        }

        $this->assertStringContainsString('select', $score['Sample']);
        $this->assertEmpty($score['Explain']);
        $this->assertEmpty($score['IndexRules']);

        $this->assertIsArray($heuristicRules = $score['HeuristicRules']);
        $this->assertNotEmpty($heuristicRules);
        $this->assertIsArray($heuristicRule = $heuristicRules[0]);
        $this->assertArrayHasKey('Item', $heuristicRule);
        $this->assertArrayHasKey('Severity', $heuristicRule);
        $this->assertArrayHasKey('Summary', $heuristicRule);
        $this->assertArrayHasKey('Content', $heuristicRule);
        $this->assertArrayHasKey('Case', $heuristicRule);
        $this->assertArrayHasKey('Position', $heuristicRule);
    }

    public function testHtmlScore()
    {
        $this->assertStringContainsString('<p>', $htmlScore = $this->soar->htmlScore('select * from foo'));
        $this->assertStringContainsString('分', $htmlScore);
        $this->assertStringContainsString('foo', $htmlScore);
    }

    public function testMdScore()
    {
        $this->assertStringContainsString('##', $mdScore = $this->soar->mdScore('select * from foo'));
        $this->assertStringContainsString('分', $mdScore);
        $this->assertStringContainsString('foo', $mdScore);
    }
}
