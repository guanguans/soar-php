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

use Guanguans\SoarPHP\Support\EscapeArg;
use Guanguans\SoarPHP\Support\OS;

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

    protected function getEscapedSudoPassword(): string
    {
        return EscapeArg::escape((string) $this->sudoPassword);
    }

    protected function shouldApplySudoPassword(): bool
    {
        return $this->sudoPassword && OS::isUnix() && ! \in_array(\PHP_SAPI, ['cli', 'cli-server', 'phpdbg'], true);
    }
}
