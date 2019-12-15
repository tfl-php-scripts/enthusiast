container=enthusiast-php7.3-apache

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