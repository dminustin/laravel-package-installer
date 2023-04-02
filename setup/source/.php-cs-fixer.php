<?php

$finder = PhpCsFixer\Finder::create()->exclude('storage')->in(__DIR__ . '/src');

$config = new PhpCsFixer\Config();

return $config->setRules(
    [
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@PHP80Migration:risky' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
        'no_unused_imports' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'break', 'case', 'continue', 'declare', 'default', 'exit', 'goto',
                'include', 'include_once', 'phpdoc', 'require', 'require_once',
                'return', 'switch', 'throw', 'try', 'yield', 'yield_from'
            ]
        ]
    ]
)->setFinder($finder);
