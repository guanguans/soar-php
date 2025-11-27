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
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;

/**
 * @internal
 *
 * @method void configureIO(InputInterface $input, OutputInterface $output)
 */
final class ComposerScripts
{
    /**
     * @see \Composer\Util\Silencer
     *
     * @noinspection PhpUnused
     */
    public static function checkSoarBinary(): int
    {
        // self::requireAutoload($event);

        foreach ((array) glob(__DIR__.'/../../bin/soar.*-*') as $file) {
            if (!is_executable($file)) {
                self::makeSymfonyStyle()->error("The file [$file] is not executable.");

                exit(1);
            }

            self::makeSymfonyStyle()->comment("<info>OK</info> $file");
        }

        self::makeSymfonyStyle()->success('No errors');

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
            Yaml::dump(self::resolveSoarConfig()->all(), 3, 2, Yaml::DUMP_EMPTY_ARRAY_AS_SEQUENCE)
        );

        self::makeSymfonyStyle()->success('No errors');

        return 0;
    }

    /**
     * @noinspection PhpUnused
     * @noinspection DebugFunctionUsageInspection
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public static function dumpSoarPHPConfig(Event $event): int
    {
        self::requireAutoload($event);

        file_put_contents(
            __DIR__.'/../../examples/soar-options.php',
            \sprintf(
                <<<'PHP'
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

                    return %s;
                    PHP,
                var_export(self::resolveSoarHelp()->map(static fn (array $help): mixed => $help['default'])->all(), true),
            )
        );

        self::makeSymfonyStyle()->success('No errors');

        return 0;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public static function resolveSoarHelp(): Collection
    {
        return str(self::resolveSoarHelpContent())
            ->explode(\PHP_EOL)
            ->filter(static fn (string $option): bool => str_starts_with($option, ' '))
            ->map(static fn (string $option): string => trim($option))
            ->chunk(2)
            ->reduce(
                static function (Collection $options, Collection $option): Collection {
                    [$name, $type] = (array) str($option->firstOrFail())
                        ->explode(' ')
                        ->pad(2, 'bool')
                        ->pipe(static function (Collection $collection): array {
                            [$name, $type] = $collection->all();

                            return [$name, match ($type) {
                                'uint' => 'int',
                                default => $type,
                            }];
                        });

                    $default = str($option->last())
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
                'description' => str($help)->headline()->toString(),
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

                $option['default'] = $config->has($snakedName = str($name)->ltrim('-')->snake('-')->toString())
                    ? $config->get($snakedName)
                    : $config->get(str($name)->ltrim('-')->snake()->toString(), $option['default']);

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
        static $rectorConfig;

        return $rectorConfig ??= (new LazyContainerFactory)->create();
    }

    /**
     * @see \Rector\Console\Style\SymfonyStyleFactory
     */
    private static function makeSymfonyStyle(): SymfonyStyle
    {
        static $symfonyStyle;

        if ($symfonyStyle instanceof SymfonyStyle) {
            return $symfonyStyle;
        }

        // to prevent missing argv indexes
        if (!isset($_SERVER['argv'])) {
            $_SERVER['argv'] = [];
        }

        $argvInput = new ArgvInput;
        $consoleOutput = new ConsoleOutput;

        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        (fn () => $this->configureIO($argvInput, $consoleOutput))->call(new Application);

        // --debug is called
        if ($argvInput->hasParameterOption(['--debug', '--xdebug'])) {
            $consoleOutput->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
        }

        return $symfonyStyle = new SymfonyStyle($argvInput, $consoleOutput);
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

        return $config ??= collect(Yaml::parse(Soar::make()->setPrintConfig(true)->run()));
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private static function resolveSoarHelpContent(): string
    {
        static $help;

        return $help ??= Soar::make()->help();
    }
}
