<?php

declare(strict_types=1);

namespace Dminustin\LaravelPackageInstaller\Utils;

class PromptTypes
{
    public const PROMPT_SELECT = 'select';
    public const PROMPT_TEXT = 'text';
    public const PROMPT_ARRAY = 'array';

    public static function promptSelect(array $choices, $default, string $title, string $replacer): array
    {
        return [
            'type' => self::PROMPT_SELECT,
            'choices' => $choices,
            'default' => $default,
            'title' => $title,
            'value' => $default,
            'replacer' => $replacer,
        ];
    }

    public static function promptText(string $default, string $title, string $replacer): array
    {
        return [
            'type' => self::PROMPT_TEXT,
            'default' => $default,
            'title' => $title,
            'value' => $default,
            'replacer' => $replacer,
        ];
    }

    public static function promptArray(array $default, string $title, string $replacer): array
    {
        return [
            'type' => self::PROMPT_ARRAY,
            'default' => $default,
            'title' => $title,
            'value' => $default,
            'replacer' => $replacer,
        ];
    }
}
