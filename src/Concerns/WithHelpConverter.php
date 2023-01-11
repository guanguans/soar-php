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
 * @internal
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait WithHelpConverter
{
    public function convertHelpToDocblockOfSetter(): string
    {
        return '/**'.array_reduce($this->extractOptionsFromHelp(), static function (string $docblock, array $options): string {
            'uint' === $options['type'] and $options['type'] = 'int';

            return $docblock.PHP_EOL.sprintf(
                '* @method self %s(%s$%s)',
                'set'.ucfirst(str_camel($options['name'])),
                $options['type'] ? $options['type'].' ' : '',
                str_camel($options['name'])
            );
        }, '').PHP_EOL.'*/';
    }

    /**
     * @psalm-suppress RedundantCast
     *
     * @return array<string, array<string, string|null>>
     */
    public function extractOptionsFromHelp(): array
    {
        $arrayMap = array_map(static function (string $option): ?string {
            if (! str_starts_with($option, ' ')) {
                return null;
            }

            return ltrim($option);
        }, explode(PHP_EOL, $this->help()));

        return array_reduce(array_chunk(array_filter($arrayMap), 2), static function (array $options, array $option): array {
            $names = (array) explode(' ', $option[0]);
            preg_match("/\(default .*\)/", $option[1], $defaults);

            $options[$names[0]] = [
                'name' => $names[0],
                'desc' => $option[1],
                'type' => $names[1] ?? null,
                'default' => $defaults[0] ?? null,
            ];

            return $options;
        }, []);
    }
}
