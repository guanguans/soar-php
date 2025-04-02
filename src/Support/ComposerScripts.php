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
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

/**
 * @internal
 */
final class ComposerScripts
{
    /**
     * @see \Composer\Util\Silencer
     *
     * @noinspection PhpUnused
     */
    public static function checkSoarBinary(Event $event): int
    {
        self::requireAutoload($event);

        $symfonyStyle = self::makeSymfonyStyle();

        foreach ((array) glob(__DIR__.'/../../bin/soar.*-*') as $file) {
            if (!is_executable($file)) {
                $symfonyStyle->error("The file [$file] is not executable.");

                exit(1);
            }

            $symfonyStyle->comment("<info>OK</info> $file");
        }

        $symfonyStyle->success('No errors');

        return 0;
    }

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

        self::makeSymfonyStyle()->success('No errors');

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

                $option['type'] = collect([$option['type'], \gettype($option['default'])])
                    ->map(static fn (string $type): string => match ($type = strtolower($type)) {
                        'integer' => 'int',
                        'boolean' => 'bool',
                        'double' => 'float',
                        'resource (closed)' => 'resource',
                        'unknown type' => 'mixed',
                        default => $type,
                    })
                    ->unique()
                    ->sort(static function (string $a, string $b): int {
                        if ('null' !== $a && 'null' === $b) {
                            return 1;
                        }

                        if ('null' === $a && 'null' !== $b) {
                            return -1;
                        }

                        return strcasecmp(ltrim($a, '\\'), ltrim($b, '\\'));
                    })
                    ->implode('|');

                return $option;
            })
            ->tap(static function () use (&$rules): void {
                $rules = array_keys(require __DIR__.'/../../examples/soar-options-example.php');
            })
            ->sortKeysUsing(static function (string $a, string $b) use ($rules): int {
                if (!\in_array($a, $rules, true) && \in_array($b, $rules, true)) {
                    return 1;
                }

                if (\in_array($a, $rules, true) && !\in_array($b, $rules, true)) {
                    return -1;
                }

                if (\in_array($a, $rules, true) && \in_array($b, $rules, true)) {
                    return array_search($a, $rules, true) <=> array_search($b, $rules, true);
                }

                return strcmp($a, $b);
            });
    }

    /**
     * @noinspection PhpUnused
     */
    public static function makeRectorConfig(): RectorConfig
    {
        return (new LazyContainerFactory)->create();
    }

    private static function makeSymfonyStyle(): SymfonyStyle
    {
        return new SymfonyStyle(new ArgvInput, new ConsoleOutput);
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
