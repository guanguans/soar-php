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
trait ConcreteListHeuristicRules
{
    public function jsonListHeuristicRules(): string
    {
        return $this->setOption('-report-type', 'json')->listHeuristicRules();
    }

    public function arrayListHeuristicRules(int $depth = 512, int $options = 0): array
    {
        return (array) json_decode($this->jsonListHeuristicRules(), true, $depth, $options);
    }

    public function mdListHeuristicRules(): string
    {
        return $this->setOption('-report-type', 'markdown')->listHeuristicRules();
    }
}
