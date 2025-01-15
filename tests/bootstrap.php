<?php

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

namespace Guanguans\Tests;

use AspectMock\Kernel;

require_once __DIR__.'/../vendor/autoload.php';

// Fix broken OpenSSL lib on Travis CI
if (getenv('TRAVIS') && !\defined('CURL_SSLVERSION_TLSv1_2')) {
    \define('CURL_SSLVERSION_TLSv1_2', 6);
}

// $kernel = Kernel::getInstance();
// $kernel->init([
//     'debug' => false,
//     'cacheDir' => __DIR__.'/AspectMock',
//     'includePaths' => [__DIR__.'/../src/Support'],
//     'excludePaths' => [
//         __DIR__.'/../vendor',
//     ],
// ]);
