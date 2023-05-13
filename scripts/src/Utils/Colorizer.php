<?php

declare(strict_types=1);

namespace Dminustin\Scripts\Utils;

/**
 * @method static nc(string $text, bool $new_line = true): string;
 * @method static black(string $text, bool $new_line = true): string;
 * @method static gray(string $text, bool $new_line = true): string;
 * @method static red(string $text, bool $new_line = true): string;
 * @method static light_red(string $text, bool $new_line = true): string;
 * @method static green(string $text, bool $new_line = true): string;
 * @method static light_green(string $text, bool $new_line = true): string;
 * @method static brown(string $text, bool $new_line = true): string;
 * @method static yellow(string $text, bool $new_line = true): string;
 * @method static blue(string $text, bool $new_line = true): string;
 * @method static light_blue(string $text, bool $new_line = true): string;
 * @method static purple(string $text, bool $new_line = true): string;
 * @method static light_purple(string $text, bool $new_line = true): string;
 * @method static cyan(string $text, bool $new_line = true): string;
 * @method static light_cyan(string $text, bool $new_line = true): string;
 * @method static light_gray(string $text, bool $new_line = true): string;
 * @method static white(string $text, bool $new_line = true): string;
 */
class Colorizer
{
    protected static $colors = [
    'nc'=>"\e[0m", # No Colol
    'black'=>"\e[0;30m",
    'gray'=>"\e[1;30m",
    'red'=>"\e[0;31m",
    'light_red'=>"\e[1;31m",
    'green'=>"\e[0;32m",
    'light_green'=>"\e[1;32m",
    'brown'=>"\e[0;33m",
    'yellow'=>"\e[1;33m",
    'blue'=>"\e[0;34m",
    'light_blue'=>"\e[1;34m",
    'purple'=>"\e[0;35m",
    'light_purple'=>"\e[1;35m",
    'cyan'=>"\e[0;36m",
    'light_cyan'=>"\e[1;36m",
    'light_gray'=>"\e[0;37m",
    'white'=>"\e[1;37m",
];
    public const LINE_DIVIDER = '==================================================';

    public static function colorize($text, $color = null)
    {
        return $color . $text . "\033[0m";
    }

    public static function __callStatic(string $name, array $arguments)
    {
        if (isset(static::$colors[$name])) {
            $nl = $arguments[1] ?? true;

            return static::colorize($arguments[0], static::$colors[$name]) . ($nl ? "\n" : '');
        }
    }

    public static function newInputBlock(string $blockTitle): void
    {
        echo PHP_EOL;
        echo static::yellow('[' . $blockTitle . ']', true);
    }

    public static function newStepBlock(string $blockTitle): void
    {
        echo PHP_EOL;
        echo PHP_EOL;
        echo static::light_green($blockTitle, true);
        echo static::light_green(static::LINE_DIVIDER, true);
    }

    public static function mainBlock(array $text): void
    {
        echo PHP_EOL;
        echo PHP_EOL;
        echo static::light_red(static::LINE_DIVIDER, true);
        foreach ($text as $row) {
            echo static::light_red($row, true);
        }
        echo static::light_red(static::LINE_DIVIDER, true);
        echo PHP_EOL;
        echo PHP_EOL;
    }
}
