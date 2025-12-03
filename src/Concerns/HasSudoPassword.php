<?php

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

namespace Guanguans\SoarPHP\Concerns;

use Guanguans\SoarPHP\Support\OsHelper;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait HasSudoPassword
{
    protected ?string $sudoPassword = null;

    public function getSudoPassword(): ?string
    {
        return $this->sudoPassword;
    }

    public function withoutSudoPassword(): self
    {
        return $this->withSudoPassword(null);
    }

    public function withSudoPassword(
        #[\SensitiveParameter]
        ?string $sudoPassword
    ): self {
        $this->sudoPassword = $sudoPassword;

        return $this;
    }

    protected function shouldApplySudoPassword(): bool
    {
        return $this->sudoPassword && OsHelper::isUnix() && !\in_array(
            \PHP_SAPI,
            [
                'cli',
                // 'cli-server',
                'embed',
                'phpdbg',
            ],
            true
        );
    }
}
