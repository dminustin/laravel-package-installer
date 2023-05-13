fix:
	./vendor/bin/php-cs-fixer --allow-risky=yes --config=.php-cs-fixer.php fix
test:
	./vendor/bin/phpstan analyse -c phpstan.neon
	./vendor/bin/phpunit tests
build:
	make fix
	make test
	php ./build.php
