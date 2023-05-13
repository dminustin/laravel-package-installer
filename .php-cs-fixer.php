<?php

$dirs = [
    'src', 'migrations', 'tests', 'setup', 'scripts'
];

$finder = PhpCsFixer\Finder::create();
foreach ($dirs as $dir) {
    if (file_exists(__DIR__ . '/' . $dir)) {
        $finder->in(__DIR__ . '/' . $dir);
    }
}

/**
 * @param \PhpCsFixer\Finder $finder
 * @return \PhpCsFixer\ConfigInterface
 */
function extracted(\PhpCsFixer\Finder $finder): \PhpCsFixer\ConfigInterface
{
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
                'statements' => ['break', 'case', 'continue', 'declare', 'default', 'exit', 'goto', 'include',
                    'include_once', 'phpdoc', 'require', 'require_once', 'return', 'switch',
                    'throw', 'try', 'yield', 'yield_from']
            ]
        ]
    )->setFinder($finder);
}

return extracted($finder);
