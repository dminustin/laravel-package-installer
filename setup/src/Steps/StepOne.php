<?php

declare(strict_types=1);

namespace Dminustin\LaravelPackageInstaller\Steps;

use Dminustin\LaravelPackageInstaller\Utils\Colorizer;
use Dminustin\LaravelPackageInstaller\Utils\InputPrompt;
use Dminustin\LaravelPackageInstaller\Utils\PackageConfig;

class StepOne
{
    protected function showTitle(): void
    {
        Colorizer::newStepBlock('Laravel Package Boilerplate: setup');
    }

    public function run(): PackageConfig
    {
        $this->showTitle();
        $config = new PackageConfig();
        foreach ($config->getOptionsList() as $key) {
            $config->setOption($key, InputPrompt::input($key, $config->getOption($key)));
        }

        return $config;
    }
}
