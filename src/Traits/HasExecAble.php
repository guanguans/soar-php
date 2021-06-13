<?php

declare(strict_types=1);

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Traits;

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Support\OsHelper;

/**
 * Trait HasExecAble.
 */
trait HasExecAble
{
    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     */
    public function exec(string $command): ?string
    {
        if (false === strpos(strtolower($command), 'soar')) {
            throw new InvalidArgumentException(sprintf("Command error: '%s'", $command));
        }

        if (true === OsHelper::isWindows()) {
            $command = 'powershell '.$command;
        }

        return shell_exec($command);
    }
}
