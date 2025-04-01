<?php

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

namespace Guanguans\PackageSkeletonTests\Datasets;

dataset('SQL statements', [
    [
        <<<'SQLS'
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
            SQLS,
    ],
    [
        [
            // <<<'SQLS'
            //     SELECT * FROM `post` WHERE `name`='so"a`r';
            //     SQLS,
            // <<<'SQLS'
            //     SELECT DATE_FORMAT(t.last_update,'%Y-%m-%d'), COUNT(DISTINCT(t.city)) FROM city t WHERE t.last_update> '2018-10-22 00:00:00' AND t.city LIKE '%Chrome%' AND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d');
            //     SQLS,
            // <<<'SQLS'
            //     DELETE city FROM city LEFT JOIN country ON city.country_id=country.country_id WHERE country.country IS NULL;
            //     SQLS,
            // <<<'SQLS'
            //     UPDATE city INNER JOIN country ON city.country_id=country.country_id INNER JOIN address ON city.city_id=address.city_id SET city.city='Abha',city.last_update='2006-02-15 04:45:25',country.country='Afghanistan' WHERE city.city_id=10;
            //     SQLS,
            <<<'SQLS'
                INSERT INTO city (country_id) SELECT country_id FROM country;
                SQLS,
            <<<'SQLS'
                REPLACE INTO city (country_id) SELECT country_id FROM country;
                SQLS,
            <<<'SQLS'
                ALTER TABLE inventory ADD INDEX `idx_store_film` (`store_id`,`film_id`),ADD INDEX `idx_store_film` (`store_id`,`film_id`),ADD INDEX `idx_store_film` (`store_id`,`film_id`);
                SQLS,
            <<<'SQLS'
                DROP TABLE `users`;
                SQLS,
            <<<'SQLS'
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
                SQLS,
        ],
    ],
]);
