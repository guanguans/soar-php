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
trait HasSudoPassword
{
    /**
     * @var null|string
     */
    protected $sudoPassword;

    public function getSudoPassword(): ?string
    {
        return $this->sudoPassword;
    }

    public function setSudoPassword(?string $sudoPassword): self
    {
        $this->sudoPassword = $sudoPassword;

        return $this;
    }
}
