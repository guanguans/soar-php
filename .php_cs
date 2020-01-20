<?php
$header = <<<EOF
This file is part of the guanguans/soar-php.

(c) 琯琯 <yzmguanguan@gmail.com>

This source file is subject to the MIT license that is bundled.
EOF;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(array(
        '@Symfony' => true,
        'header_comment' => array(
            // 'commentType' => 'PHPDoc',
            'header' => $header
        ),
        'array_syntax' => array('syntax' => 'short'),
        'ordered_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
        'single_quote' => true,
        'class_attributes_separation' => true,
        'no_unused_imports' => true,
        'standardize_not_equals' => true,
        'declare_strict_types' => true,
    ))
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->exclude('config')
            ->notPath('src/Traits/PDOExplainAttributes.php')
            ->in(__DIR__)
    )
;