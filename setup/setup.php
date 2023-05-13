<?php

declare(strict_types=1);

use Dminustin\LaravelPackageInstaller\Installer;

chdir(__DIR__);

require_once('./vendor/autoload.php');
$installer = new Installer();
$installer->run();
if (file_exists('composer.lock')) {
    unlink('composer.lock');
}
