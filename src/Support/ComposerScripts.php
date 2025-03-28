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
use Rector\Config\RectorConfig;
use Rector\DependencyInjection\LazyContainerFactory;
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
    public static function dumpSoarYamlConfig(Event $event): int
    {
        self::requireAutoload($event);

        file_put_contents(
            __DIR__.'/../../examples/soar-options.yaml',
            Yaml::dump(input: self::resolveSoarConfig()->all(), indent: 2)
        );

        $event->getIO()->write('<info>操作成功</info>');

        return 0;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public static function resolveSoarHelp(): Collection
    {
        return Str::of(self::resolveSoarHelpContent())
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
            ->put($help = '-help', [
                'name' => $help,
                'type' => 'bool',
                'default' => null,
                'description' => Str::of($help)->headline()->toString(),
            ])
            ->tap(static function (Collection $collection): void {
                $asserter = static function (Collection $collection): void {
                    // throw new \LogicException(
                    //     \sprintf('The soar options [%s] are different.', $collection->keys()->implode('、'))
                    // );
                };

                $config = self::resolveSoarConfig()->mapWithKeys(static fn (mixed $value, string $key): array => [
                    Str::start($key, '-') => $value,
                ]);

                $collection->diffKeys($config)->whenNotEmpty($asserter);
                $config->diffKeys($collection)->whenNotEmpty($asserter);
            })
            ->map(static function (array $option, string $name): array {
                $config = self::resolveSoarConfig();

                $option['default'] = $config->has($snakedName = Str::of($name)->ltrim('-')->snake('-')->toString())
                    ? $config->get($snakedName)
                    : $config->get(Str::of($name)->ltrim('-')->snake()->toString(), $option['default']);

                return $option;
            });
    }

    public static function makeRectorConfig(): RectorConfig
    {
        return (new LazyContainerFactory)->create();
    }

    private static function requireAutoload(Event $event): void
    {
        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private static function resolveSoarConfig(): Collection
    {
        static $config;

        return $config ??= collect(Yaml::parse(Soar::create()->setPrintConfig(true)->run()));
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private static function resolveSoarHelpContent(): string
    {
        static $help;

        return $help ??= Soar::create()->help();
    }
}
