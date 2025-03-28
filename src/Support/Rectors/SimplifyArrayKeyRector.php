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
use PhpParser\Node\ArrayItem;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Scalar\Int_;
use Rector\PhpParser\Node\Value\ValueResolver;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Exception\PoorDocumentationException;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @internal
 */
final class SimplifyArrayKeyRector extends AbstractRector
{
    public function __construct(
        private ValueResolver $valueResolver
    ) {}

    /**
     * @throws PoorDocumentationException
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Simplify array key',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
                        [
                            0 => 'delimiter',
                            1 => 'orderbynull',
                            2 => 'groupbyconst',
                        ]
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        [
                            'delimiter',
                            'orderbynull',
                            'groupbyconst',
                        ]
                        CODE_SAMPLE,
                ),
            ],
        );
    }

    public function getNodeTypes(): array
    {
        return [
            Array_::class,
        ];
    }

    /**
     * @param Array_ $node
     */
    public function refactor(Node $node): ?Node
    {
        $keys = collect($node->items)->pluck('key');

        if (
            $keys
                ->filter(static fn (?Expr $expr): bool => !$expr instanceof Int_)
                ->isNotEmpty()
        ) {
            return null;
        }

        $keyValues = $keys->mapWithKeys(fn (?Expr $expr): array => [
            $key = $this->valueResolver->getValue($expr, true) => $key,
        ]);

        $arrayIsListFunction = static function (array $array): bool {
            if (\function_exists('array_is_list')) {
                return array_is_list($array);
            }

            if ([] === $array) {
                return true;
            }

            $current_key = 0;

            foreach (array_keys($array) as $key) {
                if ($key !== $current_key) {
                    return false;
                }

                ++$current_key;
            }

            return true;
        };

        if ($keyValues->count() !== $keys->count() || !$arrayIsListFunction($keyValues->all())) {
            return null;
        }

        collect($node->items)->each(static fn (ArrayItem $arrayItem): mixed => $arrayItem->key = null);

        return $node;
    }
}
