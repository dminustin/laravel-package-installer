<?php

declare(strict_types=1);

namespace Dminustin\Scripts;

use Dminustin\Scripts\BaseClasses\BaseCommand;
use Dminustin\Scripts\Utils\Colorizer;

class Console
{
    public function run(): void
    {
        $commands = [];
        $glob = glob(__DIR__  . '/Commands/*.php');
        foreach ($glob as $file) {
            /**@var BaseCommand $class */
            $class = 'Dminustin\\Scripts\\Commands\\' . str_replace('.php', '', basename($file));
            $commands[$class::$command] = $class;
        }
        $args = $_SERVER['argv'];
        array_shift($args);
        $command = array_shift($args);
        if (empty($command)) {
            echo Colorizer::red('Usage php ./scripts/console.php %command%');
            foreach ($commands as $command) {
                echo Colorizer::yellow($command::$command . ' <' . implode(',', $command::$arguments) . '>');
                echo Colorizer::cyan($command::$description);
                echo PHP_EOL;
            }
        } else {
            (new $commands[$command]($args))->execute();
        }
    }
}
