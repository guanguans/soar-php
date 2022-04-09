<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Concerns;

use Guanguans\SoarPHP\Support\OsHelper;

trait Executable
{
    public function exec(string $command): ?string
    {
        OsHelper::isWindows() and $command = "powershell $command";

        return shell_exec($command);
    }
}
