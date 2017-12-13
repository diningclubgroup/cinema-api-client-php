test:
	docker-compose run --rm --workdir /app web vendor/bin/phpunit -c tests/phpunit.xml --color=always tests
