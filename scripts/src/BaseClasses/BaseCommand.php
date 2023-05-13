<?php

declare(strict_types=1);

namespace Dminustin\Scripts\BaseClasses;

use Dminustin\Scripts\Utils\Colorizer;

abstract class BaseCommand
{
    public static string $command = '';
    public static string $description = '';
    public static array $arguments = [];

    abstract public function execute();

    protected array $data = [];

    public function __construct($args)
    {
        Colorizer::mainBlock([static::$command]);
        foreach(static::$arguments as $i=>$name) {
            if (isset($args[$i]) && !empty($args[$i])) {
                $this->data[$name] = $args[$i];
            } else {
                echo PHP_EOL . Colorizer::red('Param '. $name .' must be specified') . PHP_EOL;

                die();
            }
        }
    }
}
