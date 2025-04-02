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

use Guanguans\SoarPHP\Concerns\HasOptions;
use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\ComposerScripts;
use Illuminate\Support\Str;
use PhpParser\Node;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Comments\NodeDocBlock\DocBlockUpdater;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Exception\PoorDocumentationException;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @internal
 */
final class AddHasOptionsDocCommentRector extends AbstractRector
{
    public function __construct(
        private DocBlockUpdater $docBlockUpdater,
        private PhpDocInfoFactory $phpDocInfoFactory
    ) {}

    /**
     * @throws PoorDocumentationException
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Add has options doc comment',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
                        trait HasOptions
                        {
                        }
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        /**
                         * @method \Guanguans\SoarPHP\Soar exceptVerbose() // Verbose
                         * @method \Guanguans\SoarPHP\Soar exceptVersion() // Print version info
                         * @method \Guanguans\SoarPHP\Soar exceptHelp() // Help
                         *
                         * @mixin \Guanguans\SoarPHP\Soar
                         */
                        trait HasOptions
                        {
                        }
                        CODE_SAMPLE,
                ),
            ],
        );
    }

    public function getNodeTypes(): array
    {
        return [Trait_::class];
    }

    /**
     * @param Trait_ $node
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node, HasOptions::class)) {
            return null;
        }

        /**
         * @var array<string, array{
         *     name: string,
         *     type: string,
         *     default: string|null,
         *     description: string,
         * }> $options
         */
        $options = ComposerScripts::resolveSoarHelp()->all();
        $phpDocInfo = $this->phpDocInfoFactory->createEmpty($node);

        foreach (
            [
                'set' => '\Guanguans\SoarPHP\Soar set{method}({type} ${name}) // {description}',
                'with' => '\Guanguans\SoarPHP\Soar with{method}({type} ${name}) // {description}',
                'only' => '\Guanguans\SoarPHP\Soar only{method}() // {description}',
                'except' => '\Guanguans\SoarPHP\Soar except{method}() // {description}',
            ] as $template
        ) {
            foreach ($options as $option) {
                $replacer = [
                    '{method}' => Str::studly($option['name']),
                    '{type}' => $option['type'],
                    '{name}' => Str::camel($option['name']),
                    '{description}' => $option['description'],
                ];

                $phpDocInfo->addPhpDocTagNode(new PhpDocTagNode(
                    '@method',
                    new GenericTagValueNode(str_replace(array_keys($replacer), array_values($replacer), $template))
                ));
            }
        }

        $phpDocInfo->addPhpDocTagNode(new PhpDocTagNode('', new GenericTagValueNode('')));
        $phpDocInfo->addPhpDocTagNode(new PhpDocTagNode('@mixin', new GenericTagValueNode('\\'.Soar::class)));

        $this->docBlockUpdater->updateRefactoredNodeWithPhpDocInfo($node);

        return $node;
    }
}
