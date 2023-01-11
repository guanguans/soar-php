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

use Guanguans\SoarPHP\Exceptions\InvalidConfigException;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait HasOptions
{
    /**
     * @var array<array-key, scalar|array>
     */
    protected $options = [];

    /**
     * @var array<string, string>
     */
    protected $normalizedOptions = [];

    public function getOptions(): array
    {
        return $this->getOption();
    }

    public function getOption(?string $key = null, $value = null)
    {
        if (null === $key) {
            return $this->options;
        }

        return $this->options[$key] ?? $value;
    }

    public function setOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);
        $this->normalizedOptions = $this->normalizeOptions($this->options);

        return $this;
    }

    public function setOption(string $key, $value): self
    {
        $this->setOptions([$key => $value]);

        return $this;
    }

    /**
     * @param array<string>|null $keys
     */
    public function getNormalizedOptions(?array $keys = null): array
    {
        if (null === $keys) {
            return $this->getNormalizedOption();
        }

        return array_reduce($keys, function (array $normalizedOptions, string $key): array {
            $normalizedOptions[$key] = $this->getNormalizedOption($key);

            return $normalizedOptions;
        }, []);
    }

    public function getNormalizedOption(?string $key = null, $value = null)
    {
        if (null === $key) {
            return $this->normalizedOptions;
        }

        return $this->normalizedOptions[$key] ?? $value;
    }

    protected function getNormalizedStrOptions(): string
    {
        return implode(' ', $this->normalizedOptions);
    }

    /**
     * @psalm-suppress UnnecessaryVarAnnotation
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    protected function normalizeOptions(array $options): array
    {
        return array_reduce_with_keys($options, static function (array $normalizedOptions, $option, $key): array {
            if (! is_scalar($option) && ! is_array($option)) {
                throw new InvalidConfigException(sprintf('Invalid configuration type(%s).', gettype($option)));
            }

            if (is_scalar($option)) {
                is_int($key) ? $normalizedOptions[(string) $option] = "$option" : $normalizedOptions[$key] = "$key=$option";

                return $normalizedOptions;
            }

            /** @var array $option */
            if (in_array($key, ['-test-dsn', '-online-dsn']) && isset($option['disable']) && true !== $option['disable']) {
                /** @var array $option */
                $dsn = "{$option['username']}:{$option['password']}@{$option['host']}:{$option['port']}/{$option['dbname']}";
                $normalizedOptions[$key] = "$key=$dsn";

                return $normalizedOptions;
            }

            $normalizedOptions[$key] = sprintf("$key=%s", implode(',', $option));

            return $normalizedOptions;
        }, []);
    }
}
