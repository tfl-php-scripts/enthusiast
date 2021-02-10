container=enthusiast-php7-apache

up:
	docker-compose up -d

down:
	docker-compose rm -vsf
	docker-compose down -v --remove-orphans

build:
	docker-compose rm -vsf
	docker-compose down -v --remove-orphans
	docker-compose build
	docker-compose up -d

jumpin:
	docker exec -ti ${container} bash

logs:
	docker-compose logs -f

codecept:
	docker exec -ti ${container} composer install
	docker exec -ti ${container} php vendor/bin/codecept generate:scenarios acceptance
	docker exec -ti ${container} php vendor/bin/codecept run tests/acceptance/simpleui --steps --html --env localdocker

rector:
	docker exec -ti ${container} composer update
	docker exec -ti ${container} composer require rector/rector
	docker exec -ti ${container} php vendor/bin/rector process --dry-run --debug

rector-update:
	docker exec -ti ${container} composer update
	docker exec -ti ${container} composer require rector/rector
	docker exec -ti ${container} php vendor/bin/rector process --debug
