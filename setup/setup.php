<?php

use Dminustin\LaravelPackageInstaller\Installer;
use Dminustin\LaravelPackageInstaller\Utils\Colorizer;
use Dminustin\LaravelPackageInstaller\Utils\PackageConfig;

chdir(__DIR__);
require_once('./vendor/autoload.php');
$installer = new Installer();
$installer->run();

