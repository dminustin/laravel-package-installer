<?php

declare(strict_types=1);

namespace Dminustin\LaravelPackageInstaller\Utils;

class NsHelper
{
    public static function toCanonicalName(string $name): string
    {
        $canonName = preg_replace('/[^a-zA-Z0-9]+/', ' ', $name);

        return str_replace(' ', '', ucwords($canonName, ' '));
    }
}
