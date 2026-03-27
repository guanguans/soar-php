<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpInconsistentReturnPointsInspection */
/** @noinspection PhpMultipleClassDeclarationsInspection */
/** @noinspection PhpUndefinedNamespaceInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2019-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

use Faker\Factory;
use Faker\Generator;
use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHPTests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Pest\Expectation;

// pest()
//     ->browser()
//     // ->headed()
//     // ->inFirefox()
//     // ->inSafari()
//     ->timeout(10000);
// pest()->only();
// pest()->printer()->compact();
pest()->project()->github('guanguans/notify');
pest()
    ->extend(TestCase::class)
    ->beforeAll(function (): void {})
    ->beforeEach(function (): void {})
    ->afterEach(function (): void {})
    ->afterAll(function (): void {})
    ->group(__DIR__)
    ->in(
        __DIR__,
        // __DIR__.'/Arch/',
        // __DIR__.'/Feature/',
        // __DIR__.'/Integration/',
        // __DIR__.'/Unit/'
    );

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

/**
 * @see Expectation::toBeBetween()
 */
expect()->extend(
    'toAssert',
    function (Closure $assertions): Expectation {
        $assertions($this->value);

        return $this;
    }
);

/**
 * @see Expectation::toBeBetween()
 */
expect()->extend(
    'toBetween',
    fn (int $min, int $max): Expectation => expect($this->value)
        ->toBeGreaterThanOrEqual($min)
        ->toBeLessThanOrEqual($max)
);

expect()->intercept('toBe', Model::class, function (Model $expected): void {
    expect($this->value->id)->toBe($expected->id);
});

expect()->pipe('toBe', function (Closure $next, mixed $expected): ?Expectation {
    if ($this->value instanceof Model) {
        return expect($this->value->id)->toBe($expected->id);
    }

    return $next();
});

/**
 * @see Expectation::toMatchSnapshot()
 */
expect()->pipe('toMatchSnapshot', function (Closure $next): void {
    $flags = \JSON_INVALID_UTF8_IGNORE |
        \JSON_INVALID_UTF8_SUBSTITUTE |
        \JSON_PARTIAL_OUTPUT_ON_ERROR |
        \JSON_PRESERVE_ZERO_FRACTION |
        \JSON_PRETTY_PRINT |
        \JSON_THROW_ON_ERROR |
        \JSON_UNESCAPED_SLASHES |
        \JSON_UNESCAPED_UNICODE;
    $this->value = match (true) {
        \is_string($this->value) => str($this->value)->replace(Soar::make()->getBinary(), 'soar-binary')->toString(),
        // \is_object($this->value) && method_exists($this->value, '__toString') => (string) $this->value,
        \is_array($this->value) => json_encode($this->value, $flags),
        $this->value instanceof Traversable => json_encode(iterator_to_array($this->value), $flags),
        $this->value instanceof JsonSerializable => json_encode($this->value->jsonSerialize(), $flags),
        \is_object($this->value) && method_exists($this->value, 'toArray') => json_encode($this->value->toArray(), $flags),
        default => $this->value,
    };

    $next();
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * @throws ReflectionException
 */
function class_namespace(object|string $class): string
{
    $class = \is_object($class) ? $class::class : $class;

    return (new ReflectionClass($class))->getNamespaceName();
}

if (!\function_exists('fake')) {
    /**
     * @see https://github.com/laravel/framework/blob/12.x/src/Illuminate/Foundation/helpers.php#L515
     */
    function fake(string $locale = Factory::DEFAULT_LOCALE): Generator
    {
        return Factory::create($locale);
    }
}

function fixtures_path(string $path = ''): string
{
    return __DIR__.\DIRECTORY_SEPARATOR.'Fixtures'.($path ? \DIRECTORY_SEPARATOR.$path : $path);
}

function running_in_github_action(): bool
{
    return 'true' === getenv('GITHUB_ACTIONS');
}

function soar_options(): array
{
    static $options;

    return $options ??= array_filter(
        require __DIR__.'/../examples/options.php',
        fn (mixed $value): bool => null !== $value
    );
}

function soar_options_example(): array
{
    static $options;

    return $options ??= require __DIR__.'/../examples/options-example.php';
}
