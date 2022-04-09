<?php

declare(strict_types=1);

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Contracts;

interface Soar
{
    public function exec(string $command): ?string;

    public function score(string $sql): string;

    public function explain(string $sql, string $format): string;

    public function syntaxCheck(string $sql): ?string;

    public function fingerPrint(string $sql): string;

    public function pretty(string $sql): string;

    public function md2html(string $markdown): string;
}
