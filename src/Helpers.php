<?php

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\SoarPHP\Config;

if (!function_exists('soar_config')) {
    /**
     * @param null $key
     *
     * @return \Guanguans\SoarPHP\Config|mixed
     */
    function soar_config($key = null)
    {
        foreach ([
                     __DIR__.'/../../../../.soar',
                     __DIR__.'/../.soar',
                     __DIR__.'/../../../../.soar.dist',
                     __DIR__.'/../.soar.dist',
                 ] as $file) {
            if (file_exists($file)) {
                $config = require $file;

                break;
            }
        }

        $config = new Config(isset($config) ? $config : []);

        if (null === $key) {
            return $config;
        }

        return $config->get($key);
    }
}

if (!function_exists('isWinOs')) {
    /**
     * @return bool
     */
    function isWinOs()
    {
        return PATH_SEPARATOR !== ':';
    }
}
