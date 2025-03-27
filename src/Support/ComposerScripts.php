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

namespace Guanguans\SoarPHP\Support;

use Composer\Script\Event;
use Guanguans\SoarPHP\Soar;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Symfony\Component\Yaml\Yaml;

/**
 * @internal
 */
final class ComposerScripts
{
    /**
     * @noinspection PhpUnused
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public static function dumpSoarConfig(Event $event): int
    {
        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';

        $prefix = <<<'PHP'
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

            // +----------------------------------------------------------------------+//
            // |              请参考 @see https://github.com/XiaoMi/soar               |//
            // +----------------------------------------------------------------------+//

            return [
            PHP;

        $suffix = '];'.\PHP_EOL;

        $code = array_reduce(self::resolveSoarOptions(), static function (string $code, array $options): string {
            null === $options['default'] and $options['default'] = 'null';
            $options['default'] = \is_string($options['default']) ? $options['default'] : json_encode($options['default'], \JSON_THROW_ON_ERROR);

            $item = <<<PHP
                    /**
                     * {$options['description']}.
                     */
                    '{$options['name']}' => {$options['default']},

                PHP;

            return $code.\PHP_EOL.$item;
        }, '');

        file_put_contents(__DIR__.'/../../examples/soar.options.full.php', $prefix.$code.$suffix);
        $event->getIO()->write('<info>操作成功</info>');

        return 0;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     *
     * @return array<string, array{
     *     name: string,
     *     type: string,
     *     default: string|null,
     *     description: string,
     * }>
     */
    public static function resolveSoarOptions(): array
    {
        // collect(Yaml::parse(Soar::create()->setPrintConfig(true)->run()))
        //     ->tap(function (Collection $collection): void {
        //         file_put_contents(__DIR__.'/../../examples/soar.options.example.yaml', Yaml::dump($collection->all(), indent: 2));
        //     })
        //     ->dd();

        return Str::of(Soar::create()->help())
            ->explode(\PHP_EOL)
            ->filter(static fn (string $option): bool => str_starts_with($option, ' '))
            ->map(static fn (string $option): string => trim($option))
            ->chunk(2)
            ->reduce(
                static function (Collection $options, Collection $option): Collection {
                    [$name, $type] = Str::of($option->firstOrFail())
                        ->explode(' ')
                        ->pad(2, 'bool')
                        ->pipe(static function (Collection $collection): array {
                            [$name, $type] = $collection->all();

                            return [$name, match ($type) {
                                'uint' => 'int',
                                default => $type,
                            }];
                        });

                    $default = Str::of($option->last())
                        /** @lang PhpRegExp */
                        ->match('/\\(default .*\\)/')
                        ->pipe(
                            static fn (Stringable $stringable): Stringable => $stringable
                                ->replaceFirst('(default ', '')
                                ->replaceLast(')', '')
                        )
                        ->toString() ?: null;

                    return $options->put($name, [
                        'name' => $name,
                        'type' => $type,
                        'default' => $default,
                        'description' => $option->last(),
                    ]);
                },
                collect()
            )
            ->put('help', [
                'name' => 'help',
                'type' => 'bool',
                'default' => null,
                'description' => 'Help',
            ])
            ->all();
    }
}
