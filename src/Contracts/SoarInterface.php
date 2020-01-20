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

interface SoarInterface
{
    /**
     * SoarInterface constructor.
     *
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * @param string $command
     *
     * @return string
     */
    public function exec(string $command): string;

    /**
     * @param string $sql
     *
     * @return string
     */
    public function score(string $sql): string;

    /**
     * @param string $sql
     * @param string $format
     *
     * @return string
     */
    public function explain(string $sql, string $format): string;

    /**
     * @param string $sql
     *
     * @return string
     */
    public function syntaxCheck(string $sql): string;

    /**
     * @param string $sql
     *
     * @return string
     */
    public function fingerPrint(string $sql): string;

    /**
     * @param string $sql
     *
     * @return string
     */
    public function pretty(string $sql): string;

    /**
     * @param string $markdown
     *
     * @return string
     */
    public function md2html(string $markdown): string;
}
