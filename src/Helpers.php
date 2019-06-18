<?php

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

/**
 * @param string $key
 *
 * @return mixed|void|null
 */
function soar_config($key = '')
{
    $config = require __DIR__.'/../config/SoarPHP.php';

    if (empty($key)) {
        return $config;
    }

    if (!strpos($key, '.')) {
        return isset($config[$key]) ? $config[$key] : null;
    }

    $key = explode('.', $key);

    return isset($config[$key[0]][$key[1]]) ? $config[$key[0]][$key[1]] : null;
}
