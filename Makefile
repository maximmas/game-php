install:
	composer install

lint:
	composer exec --verbose phpstan -- --level=6 analyse src tests

run:
	php src/main.php

test:
	./vendor/bin/phpunit --verbose tests

docs:
	doxygen doxygen.conf

read-docs:
	open doc/html/index.html