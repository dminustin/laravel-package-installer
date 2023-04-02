<?php

declare(strict_types=1);

namespace Dminustin\LaravelPackageInstaller;

use Dminustin\LaravelPackageInstaller\Steps\StepOne;
use Dminustin\LaravelPackageInstaller\Steps\StepTwo;
use Dminustin\LaravelPackageInstaller\Utils\Colorizer;
use Dminustin\LaravelPackageInstaller\Utils\InputPrompt;
use Dminustin\LaravelPackageInstaller\Utils\PackageConfig;

class Installer
{
    public function run(): void
    {
        Colorizer::mainBlock([
            'Welcome to Laravel Boilerplate Installer!',
            'You should to choose any options to create a new package.',
        ]);
        do {
            $stepOne = new StepOne();
            $config = $stepOne->run();
            $this->displayConfig($config);
            Colorizer::newStepBlock('Confirmation');
        } while (InputPrompt::inputSelect(
            'Confirm installation?',
            'your choice',
            ['y', 'n'],
            ''
        ) !== 'y');
        $config = new PackageConfig();

        (new StepTwo())->run($config);
    }

    protected function displayConfig(PackageConfig $config): void
    {
        Colorizer::newStepBlock('Laravel Package Boilerplate: your options');
        foreach ($config->getOptionsList() as $key) {
            $value = $config->getOption($key);
            echo Colorizer::yellow($value['title'] . ': ');
            echo(is_array($value['value']) ? implode(', ', $value['value']) : $value['value']) . PHP_EOL;
        }
    }
}
