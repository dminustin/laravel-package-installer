<?php

declare(strict_types=1);

namespace Dminustin\Scripts\Commands;

use Dminustin\Scripts\BaseClasses\BaseTableCommand;
use Dminustin\Scripts\Utils\Colorizer;

class MakeMigrationCommand extends BaseTableCommand
{
    public static string $command = 'make:migrations';
    public static string $description = 'Create migration files from config filee';
    public static array $arguments = ['config'];

    protected function writeFile(
        array  $table,
        string $tableName,
        string $className,
        string $path,
        string $modelNamespace,
        string $tableConnection = ''
    ): void {
        foreach ($table['columns'] as $columnName => $columnData) {
            if ($columnName === 'timestamps') {
                $bp = '            $table->timestamps();';
                $blueprint[] = $bp;

                continue;
            } else {
                $columnType = $this->getColumnType($columnData);
                $i = array_search($columnType, $columnData, true);
                unset($columnData[$i]);
            }
            $bp = '            $table->' . $columnType . '(\'' . $columnName . '\')';
            foreach ($columnData as $key => $value) {
                if (is_string($key)) {
                    if (is_bool($value)) {
                        $bp .= '->' . $key . '(' . ($value ? 'true' : 'false') . ')';
                    } else {
                        $bp .= '->' . $key . '(\'' . $value . '\')';
                    }
                } else {
                    $bp .= '->' . $value . '()';
                }
            }
            $blueprint[] = $bp . ';';
        }
        $schema = 'Schema::/*CONNECTION*/';

        $schema .= 'create(\'' . $tableName . '\', function (Blueprint $table) {' . PHP_EOL;
        $schema .= implode(PHP_EOL, $blueprint) . PHP_EOL;
        $schema .= '        });' . PHP_EOL;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $filename = $path . '/' . '2023_01_01_000001_create_' . $tableName . '_table.php';
        if (file_exists($filename)) {
            echo Colorizer::yellow('Skipping exists ' . $filename);

            return;
        }
        $stub = file_get_contents(__DIR__ . '/../../stubs/migration.stub');
        $tn = ucwords($tableName, '_');
        $tn = str_replace('_', '', $tn);
        $stub = str_replace('/*UCTABLENAME*/', $tn, $stub);
        $stub = str_replace('/*UP*/', $schema, $stub);
        $stub = str_replace('/*TABLENAME*/', $tableName, $stub);

        if (!empty($tableConnection)) {
            $stub = str_replace('/*CONNECTION*/', 'connection(\'' . $tableConnection . '\')->', $stub);
        } else {
            $stub = str_replace('/*CONNECTION*/', '', $stub);
        }

        file_put_contents($filename, $stub);
    }


}
