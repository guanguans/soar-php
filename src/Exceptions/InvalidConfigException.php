<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Exceptions;

use Exception;
use Guanguans\SoarPHP\Contracts\Throwable;

class InvalidConfigException extends Exception implements Throwable
{
}
