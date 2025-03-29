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

use Guanguans\SoarPHP\Support\ComposerScripts;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\ArrayItem;
use Rector\PhpParser\Node\Value\ValueResolver;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Exception\PoorDocumentationException;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @internal
 */
final class AddSoarOptionsDocCommentRector extends AbstractRector
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
            'Add soar options doc comment',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
                        return [
                            '-allow-charsets' => [
                                0 => 'utf8',
                                1 => 'utf8mb4',
                            ],
                            '-allow-collates' => [
                            ],
                            '-allow-drop-index' => false,
                        ];

                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        return [
                            /**
                             * AllowCharsets (default "utf8,utf8mb4").
                             */
                            '-allow-charsets' => [
                                0 => 'utf8',
                                1 => 'utf8mb4',
                            ],

                            /**
                             * AllowCollates.
                             */
                            '-allow-collates' => [
                            ],

                            /**
                             * AllowDropIndex, 允许输出删除重复索引的建议.
                             */
                            '-allow-drop-index' => false,
                        ];
                        CODE_SAMPLE,
                ),
            ],
        );
    }

    public function getNodeTypes(): array
    {
        return [
            ArrayItem::class,
        ];
    }

    /**
     * @param Node\ArrayItem $node
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function refactor(Node $node): ?Node
    {
        $soarHelp = ComposerScripts::resolveSoarHelp();

        /**
         * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
         *
         * @var array{
         *     name: string,
         *     type: string,
         *     default: string|null,
         *     description: string,
         * }|null $help
         */
        $help = $soarHelp->get($this->valueResolver->getValue($node->key));

        if (!$help) {
            return null;
        }

        $node->setDocComment(new Doc(
            <<<DOC_COMMENT

                /**
                 * {$help['description']}
                 */
                DOC_COMMENT
        ));

        return $node;
    }
}
