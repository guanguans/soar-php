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

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait ConcreteListRewriteRules
{
    public function arrayListRewriteRules(int $depth = 512, int $options = 0): array
    {
        return (array) json_decode($this->jsonListRewriteRules(), true, $depth, $options);
    }

    public function jsonListRewriteRules(): string
    {
        return $this->setReportType('json')->listRewriteRules();
    }

    public function mdListRewriteRules(): string
    {
        return $this->setReportType('markdown')->listRewriteRules();
    }
}
