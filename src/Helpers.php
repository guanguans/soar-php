<?php

/*
 * *This file is part of the guanguans/soar-php.
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
        $config = new Config(require __DIR__.'/../config/soar.php');
        if (null === $key) {
            return $config;
        }

        return $config->get($key);
    }
}
