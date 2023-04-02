# Laravel command-line prompted package creator

This helper generates an empty Laravel package from the command line

## Included packages
```
"doctrine/lexer": "^1.0.1",
"egulias/email-validator": "^2.1",
"friendsofphp/php-cs-fixer": "*",
"laravel/framework": "^8.83",
"nunomaduro/larastan": "^1.0",
"phpunit/phpunit": "^9.0"
```

## Available composer commands

### composer test
runs PHPUnit tests

### composer analyze
runs PHPStan analyzer

### composer cs
runs php-cs-fixer

### composer public
runs fixer, analyzer, tests, then if no errors adds changed code to git and pushes to the remote repository


## Usage

```php
php ./setup/setup.php
```

!! Do not forget to delete setup directory after installation

## Credits

Author: Danila Minustin (https://github.com/dminustin)

Based on code generated from [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Changelog

The MIT License (MIT). Please see [Changelog File](CHANGELOG.md) for more information.