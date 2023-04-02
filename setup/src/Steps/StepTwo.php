<?php

declare(strict_types=1);

namespace Dminustin\LaravelPackageInstaller\Steps;

use Dminustin\LaravelPackageInstaller\Utils\Colorizer;
use Dminustin\LaravelPackageInstaller\Utils\PackageConfig;

class StepTwo
{
    public function run(PackageConfig $config): void
    {
        Colorizer::newStepBlock('Installing package');
        $dir = __DIR__ . '/../../source';
        $files = array_merge(glob($dir . '/*'), glob($dir . '/*/*'));
        foreach ($files as $fileName) {
            $fileName = realpath($fileName);
            if (is_dir($fileName)) {
                continue;
            }
            echo Colorizer::light_blue("Processing $fileName", true);
            $newName = str_replace('/setup/source/', '/', $fileName);
            $newDir = dirname($newName);
            if (!file_exists($newDir)) {
                if (!mkdir($newDir, 0644, true)) {
                    throw new \RuntimeException('Could not create directory ' . $newDir);
                }
            }
            $file = file_get_contents($fileName);
            foreach ($config->getOptionsList() as $key) {
                $data = $config->getOption($key);
                $replaceKey = $data['replacer'];
                if (is_array($data['value'])) {
                    $file = str_replace(
                        $replaceKey,
                        '["' . implode('", ', $data['value']) . '"]',
                        $file
                    );
                } else {
                    $file = str_replace($replaceKey, $data['value'], $file);
                }
                file_put_contents($newName, $file);
            }
        }
        echo Colorizer::light_blue(Colorizer::LINE_DIVIDER, true);
        echo Colorizer::light_blue("Done", true);
        echo Colorizer::light_red("Do not forget to delete setup directory", true);
    }
}
