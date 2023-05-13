<?php

declare(strict_types=1);

namespace Dminustin\Scripts\Commands;

use Dminustin\Scripts\BaseClasses\BaseTableCommand;
use Dminustin\Scripts\Utils\Colorizer;

class MakeModelCommand extends BaseTableCommand
{
    public static string $command = 'make:models';
    public static string $description = 'Create models from config filee';
    public static array $arguments = ['config'];

    protected function writeFile(
        array  $table,
        string $tableName,
        string $className,
        string $path,
        string $modelNamespace,
        string $tableConnection = ''
    ): void {
        $filename = $path . '/' . $className . '.php';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        if (file_exists($filename)) {
            echo Colorizer::yellow('Skipping exists ' . $filename);

            return;
        }

        $stub = file_get_contents(__DIR__ . '/../../stubs/model.stub');
        $stub = str_replace('/*CLASS*/', $className, $stub);

        $use = '';
        $props = [];
        foreach ($table['columns'] as $columnName => $columnData) {
            if ($columnName === 'timestamps') {
                continue;
            }
            $columnType = $this->getColumnType($columnData);
            $i = array_search($columnType, $columnData, true);
            unset($columnData[$i]);

            if ($columnType === 'uuid') {
                $use = 'use \Illuminate\\Database\\Eloquent\\Concerns\\HasUuids;' . PHP_EOL;
            }
            $props[] = ' * @property ' . $this->cast($columnType) . ' $' . $columnName;
        }
        $stub = str_replace('/*USE*/', $use, $stub);
        $stub = str_replace('/*TABLE*/', $tableName, $stub);
        $stub = str_replace('/*PROPERTIES*/', implode("\n", $props), $stub);
        $stub = str_replace('/*NAMESPACE*/', $modelNamespace, $stub);
        if (!empty($tableConnection)) {
            $stub = str_replace('/*CONNECTION*/', 'protected $connection=\'' . $tableConnection . '\';' . PHP_EOL, $stub);
        } else {
            $stub = str_replace('/*CONNECTION*/', '', $stub);
        }
        file_put_contents($filename, $stub);

    }

    protected function cast($type)
    {
        $cast = ['uuid' => 'string', 'text' => 'string'];

        return (isset($cast[$type])) ? $cast[$type] : $type;
    }

}
