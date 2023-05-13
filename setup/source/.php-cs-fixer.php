<?php

$finder = PhpCsFixer\Finder::create()->exclude('storage')->in(__DIR__ . '/src');

return extracted($finder);
