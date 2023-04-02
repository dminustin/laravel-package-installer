<?php

declare(strict_types=1);

namespace Dminustin\LaravelPackageInstaller\Utils;

class PackageConfig
{
    protected $options = [
        'vendor' => null,
        'name' => null,
        'description' => null,
        'keywords' => null,
        'license' => null,
        'author.name' => null,
        'author.email' => null,
        'homepage' => null,
        'minimum-stability' => null,
    ];

    public function __construct()
    {
        $dirname = realpath(dirname(__DIR__ . '/../../../../'));
        $dirname = explode(DIRECTORY_SEPARATOR, $dirname);
        $projectName = end($dirname);
        
        $this->options = [
            'vendor' => PromptTypes::promptText('Acme INC', 'Vendor name', 'AMFVendorName'),
            'name' => PromptTypes::promptText($projectName, 'Package name', 'AMFName'),
            'description' => PromptTypes::promptText('Package description', 'Package description', 'AMFDescription'),
            'keywords' => PromptTypes::promptArray([], 'Package keywords', '["AMFKeywords"]'),
            'license' => PromptTypes::promptText('MIT', 'License', 'AMFLicense'),
            'author.name' => PromptTypes::promptText('John Doe', 'Author name', 'AMFAuthorName'),
            'author.email' => PromptTypes::promptText('somebody@somewhere.com', 'Author email', 'AMFAuthorEmail'),
            'homepage' => PromptTypes::promptText(
                'https://home.sweet.home',
                'Homepage URL (Github, web etc)',
                'AMFHomepage'
            ),
            'minimum-stability' => PromptTypes::promptSelect(
                ['dev', 'beta', 'stable'],
                'dev',
                'Minimum stability',
                'AMFMinimumStability'
            ),
            'class-name-prefix' => PromptTypes::promptText('NewPackageName', 'Class name prefix', 'AMFClassNamePrefix'),
            'namespace' => PromptTypes::promptText('AcmeINC', 'Namespace', 'AMFNamespace'),
        ];
    }

    public function getOptionsList(): array
    {
        return array_keys($this->options);
    }

    public function setOption(string $name, $value): PackageConfig
    {
        $this->options[$name]['value'] = $value;
        if ($name === 'vendor' || $name === 'name') {
            $classPrefix = NsHelper::toCanonicalName($this->options['name']['value']);
            $vendorPrefix = NsHelper::toCanonicalName($this->options['vendor']['value']);
            $nameSpace = $vendorPrefix . '\\' . $classPrefix;
            $this->options['class-name-prefix']['default'] = $classPrefix;
            $this->options['namespace']['default'] = $nameSpace;
        }

        return $this;
    }

    public function getOption(string $name)
    {
        return $this->options[$name];
    }
}
