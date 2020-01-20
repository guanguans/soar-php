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
     * @param $command
     *
     * @return mixed
     */
    public function exec($command);

    /**
     * @param $sql
     *
     * @return mixed
     */
    public function score($sql);

    /**
     * @param $sql
     * @param $format
     *
     * @return mixed
     */
    public function explain($sql, $format);

    /**
     * @param $sql
     *
     * @return mixed
     */
    public function syntaxCheck($sql);

    /**
     * @param $sql
     *
     * @return mixed
     */
    public function fingerPrint($sql);

    /**
     * @param $sql
     *
     * @return mixed
     */
    public function pretty($sql);

    /**
     * @param $markdown
     *
     * @return mixed
     */
    public function md2html($markdown);
}
