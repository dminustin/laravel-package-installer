<?php

declare(strict_types=1);

namespace Dminustin\Scripts\BaseClasses;

use Dminustin\Scripts\Commands\MakeMigrationCommand;

abstract class BaseTableCommand extends BaseCommand
{
    /**
     * @throws \Exception
     */
    public function execute(): void
    {
        $config = require($this->data['config']);
        $namespace = $config['models_namespace'];
        if ($this instanceof MakeMigrationCommand) {
            $path = $config['migration_path'];
        } else {
            $path = $config['models_path'];
        }
        $tables = $config['tables'];
        foreach ($tables as $class => $table) {
            $tableName = $table['name'];
            $tableConnection = $table['connection'] ?? '';

            $this->writeFile($table, $tableName, $class, $path, $namespace, $tableConnection);
        }
    }

    abstract protected function writeFile(
        array $table,
        string $tableName,
        string $className,
        string $path,
        string $modelNamespace,
        string $tableConnection = ''
    );


    /**
     * @throws \Exception
     */
    protected function getColumnType(array $column): string
    {
        $ai = array_intersect($column, ['uuid', 'text', 'boolean']);
        if (empty($ai)) {
            throw new \Exception('Could not understand column type:' . implode(', ', $column));
        }

        return $ai[0];
    }
}
