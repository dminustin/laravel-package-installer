<?php

declare(strict_types=1);

namespace Dminustin\LaravelPackageInstaller\Utils;

class InputPrompt
{
    public static function input(string $question, array $options = [])
    {
        switch ($options['type']) {
            case PromptTypes::PROMPT_TEXT:
                return static::inputText(
                    $options['title'] ?? '',
                    $question,
                    $options['default'] ?? ''
                );

            case PromptTypes::PROMPT_SELECT:
                return static::inputSelect(
                    $options['title'] ?? '',
                    $question,
                    $options['choices'],
                    $options['default'] ?? ''
                );

            case PromptTypes::PROMPT_ARRAY:
                return static::inputArray(
                    $options['title'] ?? '',
                    $question,
                    $options['default'] ?? []
                );
        }
    }

    public static function inputText(string $blockTitle, string $question, string $default = null): string
    {
        if ($blockTitle) {
            Colorizer::newInputBlock($blockTitle);
        }
        $question .= '(default: ' . $default . '): ';
        echo Colorizer::purple($question, false);
        $answer = trim(fgets(STDIN));
        if (empty($answer)) {
            return $default;
        }

        return $answer;
    }

    public static function inputArray(string $blockTitle, string $question, array $default = []): array
    {
        if ($blockTitle) {
            Colorizer::newInputBlock($blockTitle);
        }
        $question .= '(multiple): ';
        echo Colorizer::purple($question, true);
        $answers = $default;
        for (; ;) {
            $answer = static::inputText('', 'option ' . (count($answers) + 1), '');
            if (empty($answer)) {
                if (static::inputSelect('', 'Finish selection', ['y', 'n'], 'y')) {
                    return $answers;

                    break;
                }

                continue;
            }
            $answers[] = $answer;
        }
    }

    public static function inputSelect(
        string $blockTitle,
        string $question,
        array  $choices,
        string $default = null
    ): string {
        if ($blockTitle) {
            Colorizer::newInputBlock($blockTitle);
        }
        $question .= '[' . implode('|', $choices) . '] (default: ' . $default . '): ';
        echo Colorizer::purple($question, false);
        for (; ;) {
            $answer = trim(fgets(STDIN));
            if (in_array($answer, $choices, false)) {
                return $answer;
            }
            if (empty($answer) && !empty($default) && in_array($default, $choices, true)) {
                return $default;
            }
            echo Colorizer::purple($question, false);
        }
    }
}
