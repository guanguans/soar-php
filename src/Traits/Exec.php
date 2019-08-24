<?php

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Traits;

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;

/**
 * Trait Exec.
 */
trait Exec
{
    /**
     * @param $command
     *
     * @return string|null
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function exec($command)
    {
        if (!is_string($command)) {
            throw new InvalidArgumentException('Command type must be a string');
        }

        if (false === strpos(strtolower($command), 'soar')) {
            throw new InvalidArgumentException(sprintf("Command error: '%s'", $command));
        }

        if (true === isWinOs()) {
            $command = 'powershell '.$command;
        }

        return shell_exec($command);
    }
}
