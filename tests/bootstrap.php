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

use AspectMock\Kernel;

require_once __DIR__.'/../vendor/autoload.php';

// Fix broken OpenSSL lib on Travis CI
if (getenv('TRAVIS') && ! \defined('CURL_SSLVERSION_TLSv1_2')) {
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
