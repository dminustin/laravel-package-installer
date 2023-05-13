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
        $files = array_merge(
            glob($dir . '/*'),
            glob($dir . '/*/*'),
            glob($dir . '/*/*/*')
        );

        $fileNameReplacer = $config->getOption('class-name-prefix');

        foreach ($files as $fileName) {
            $fileName = realpath($fileName);
            if (is_dir($fileName)) {
                continue;
            }
            echo Colorizer::light_blue("Processing $fileName", true);
            $newName = str_replace('/setup/source/', '/', $fileName);
            $newName = str_replace($fileNameReplacer['replacer'], $fileNameReplacer['value'], $newName);
            $newDir = dirname($newName);
            if (!file_exists($newDir)) {
                if (!mkdir($newDir, 0766, true)) {
                    throw new \RuntimeException('Could not create directory ' . $newDir);
                }
            }
            $file = file_get_contents($fileName);
            foreach ($config->getOptionsList() as $key) {
                $data = $config->getOption($key);
                $replaceKey = $data['replacer'];
                $replaceTo = '';
                if (is_array($data['value'])) {
                    if (empty($data['value'])) {
                        $replaceTo = '[]';
                    } else {
                        $replaceTo = '["' . implode('", "', $data['value']) . '"]';
                    }
                } else {
                    $replaceTo = $data['value'];
                }

                //Hack to composer.json
                if (str_contains($fileName, 'composer.json')) {
                    $replaceTo = str_replace('\\', '\\\\', $replaceTo);
                }

                $file = str_replace($replaceKey, $replaceTo, $file);

                if (!file_put_contents($newName, $file)) {
                    throw new \RuntimeException('Could not write file '. $newName);
                }
            }
        }
        echo Colorizer::light_blue(Colorizer::LINE_DIVIDER, true);
        echo Colorizer::light_blue("Done", true);
        echo Colorizer::light_red("Do not forget to delete setup directory", true);
    }
}
