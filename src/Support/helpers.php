<?php

declare(strict_types=1);

/**
 * Copyright (c) 2019-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

namespace Guanguans\SoarPHP\Support;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Collection;

if (!\function_exists('Guanguans\SoarPHP\Support\classes')) {
    /**
     * @see https://github.com/illuminate/collections
     * @see https://github.com/alekitto/class-finder
     * @see https://github.com/ergebnis/classy
     * @see https://gitlab.com/hpierce1102/ClassFinder
     * @see https://packagist.org/packages/haydenpierce/class-finder
     * @see \get_declared_classes()
     * @see \get_declared_interfaces()
     * @see \get_declared_traits()
     * @see \DG\BypassFinals::enable()
     * @see \Composer\Util\ErrorHandler
     * @see \Monolog\ErrorHandler
     * @see \PhpCsFixer\ExecutorWithoutErrorHandler
     * @see \Phrity\Util\ErrorHandler
     *
     * @template TObject of object
     *
     * @internal
     *
     * @param null|(callable(class-string<TObject>, string): bool) $filter
     *
     * @return \Illuminate\Support\Collection<class-string<TObject>, \ReflectionClass<TObject>|\Throwable>
     *
     * @noinspection PhpUndefinedNamespaceInspection
     */
    function classes(?callable $filter = null): Collection
    {
        $filter ??= static fn (string $class, string $file): bool => true;

        /** @var null|\Illuminate\Support\Collection $classes */
        static $classes;
        $classes ??= collect(spl_autoload_functions())->flatMap(
            static fn (callable $loader): array => \is_array($loader) && $loader[0] instanceof ClassLoader
                ? $loader[0]->getClassMap()
                : []
        );

        return $classes
            ->filter(static fn (string $file, string $class): bool => $filter($class, $file))
            ->mapWithKeys(static function (string $file, string $class): array {
                try {
                    return [$class => new \ReflectionClass($class)];
                } catch (\Throwable $throwable) {
                    return [$class => $throwable];
                }
            });
    }
}

if (!\function_exists('Guanguans\SoarPHP\Support\str_snake')) {
    function str_snake(string $value, string $delimiter = '-'): string
    {
        /** @var array<string, array<string, string>> $snakeCache */
        static $snakeCache = [];
        $key = $value;

        if (isset($snakeCache[$key][$delimiter])) {
            return $snakeCache[$key][$delimiter];
        }

        if (!ctype_lower($value)) {
            $value = (string) preg_replace('/\s+/u', '', ucwords($value));
            $value = mb_strtolower((string) preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value), 'UTF-8');
        }

        return $snakeCache[$key][$delimiter] = $value;
    }
}
