cs:
	./vendor/bin/php-cs-fixer fix --verbose

cs_dry_run:
	./vendor/bin/php-cs-fixer fix --verbose --dry-run

test:
	./vendor/bin/phpunit

phpstan:
	./vendor/bin/phpstan analyse -c phpstan.neon -l 5 src tests
