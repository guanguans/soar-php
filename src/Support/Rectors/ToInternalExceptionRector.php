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

namespace Guanguans\SoarPHP\Support\Rectors;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Exception\PoorDocumentationException;
use Symplify\RuleDocGenerator\Exception\ShouldNotHappenException;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

/**
 * @internal
 */
final class ToInternalExceptionRector extends AbstractRector implements ConfigurableRectorInterface
{
    private array $except = [];

    /**
     * @throws PoorDocumentationException
     * @throws ShouldNotHappenException
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'To internal exception',
            [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
                        throw new \InvalidArgumentException('on_headers must be callable');
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        throw new \Guanguans\SoarPHP\Exceptions\InvalidArgumentException('on_headers must be callable');
                        CODE_SAMPLE,
                    ['exceptionClassPattern' => 'exceptionClassPattern'],
                ),
            ],
        );
    }

    public function configure(array $configuration): void
    {
        Assert::allStringNotEmpty($configuration);
        $this->except = array_merge($this->except, $configuration);
    }

    public function getNodeTypes(): array
    {
        return [
            New_::class,
        ];
    }

    /**
     * @param Node\Expr\New_ $node
     */
    public function refactor(Node $node): ?Node
    {
        $class = $node->class;

        if (
            !$class instanceof Name
            || $this->is($this->except, $class->toString())
            || str_starts_with($class->toString(), 'Guanguans\\SoarPHP\\Exceptions\\')
            || !str_ends_with($class->toString(), 'Exception')
        ) {
            return null;
        }

        $internalExceptionClass = "\\Guanguans\\SoarPHP\\Exceptions\\{$class->getLast()}";

        if (!class_exists($internalExceptionClass)) {
            $this->createInternalException($class);
        }

        $node->class = new Name($internalExceptionClass, $class->getAttributes());

        return $node;
    }

    private function createInternalException(Name $name): void
    {
        /** @var class-string $externalExceptionClass */
        $externalExceptionClass = $name->toString();
        $reflectionClass = new \ReflectionClass($externalExceptionClass);

        if ($reflectionClass->isFinal()) {
            return;
        }

        $file = __DIR__."/../../Exceptions/{$name->getLast()}.php";

        /** @noinspection MkdirRaceConditionInspection */
        is_dir($dir = \dirname($file)) or mkdir($dir, 0755, true);

        file_put_contents(
            $file,
            <<<PHP
                <?php

                declare(strict_types=1);

                namespace Guanguans\\SoarPHP\\Exceptions;

                use Guanguans\\SoarPHP\\Contracts\\ThrowableContract;

                class {$name->getLast()} extends \\$externalExceptionClass implements ThrowableContract {}

                PHP
        );
    }

    /**
     * Determine if a given string matches a given pattern.
     *
     * @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/Str.php
     *
     * @param iterable<string> $patterns
     */
    private function is(iterable $patterns, string $value, bool $ignoreCase = false): bool
    {
        foreach ($patterns as $pattern) {
            $pattern = (string) $pattern;

            // If the given value is an exact match we can of course return true right
            // from the beginning. Otherwise, we will translate asterisks and do an
            // actual pattern match against the two strings to see if they match.
            if ($pattern === $value) {
                return true;
            }

            if ($ignoreCase && mb_strtolower($pattern) === mb_strtolower($value)) {
                return true;
            }

            $pattern = preg_quote($pattern, '#');

            // Asterisks are translated into zero-or-more regular expression wildcards
            // to make it convenient to check if the strings starts with the given
            // pattern such as "library/*", making any string check convenient.
            $pattern = str_replace('\*', '.*', $pattern);

            if (preg_match('#^'.$pattern.'\z#'.($ignoreCase ? 'iu' : 'u'), $value) === 1) {
                return true;
            }
        }

        return false;
    }
}
