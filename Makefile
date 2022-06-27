.SILENT:
.PHONY:

include .env

#======================================
# Variables

php_container = ${APP_NAME}__php-fpm
db_container = ${APP_NAME}__db
redis_container = ${APP_NAME}__redis

#======================================
# Docker Command

init: down-clear up_docker app-init ps info

up: up_docker info

info: ps info_domen

rebuild: down build up_docker info

up_docker:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

# флаг -v удаляет все volume (очищает все данные)
down-clear:
	docker-compose down -v --remove-orphans

build:
	docker-compose build

ps:
	docker-compose ps

php_bash:
	docker exec -it $(php_container) bash

redis_bash:
	docker exec -it $(redis_container) sh

db_bash:
	docker exec -it $(db_container) sh

#======================================
# Command app

app-init: composer-install project-init perm
#
#cp-env:
#	cp .env.example .env

composer-install:
	docker-compose run --rm php-fpm composer install

project-init:
	docker-compose run --rm php-fpm php artisan key:generate
	docker-compose run --rm php-fpm php artisan migrate
	docker-compose run --rm php-fpm php artisan db:seed
	#docker-compose run --rm php-fpm php artisan passport:keys
	docker-compose run --rm php-fpm php artisan app:init
#	docker-compose run --rm php-fpm composer ide

perm:
	sudo chmod 777 -R storage

#======================================
# Test Command

test: test_init test_run

test_init:
	docker-compose run --rm php-fpm php artisan key:generate --env=testing
	docker-compose run --rm php-fpm php artisan migrate -n --env=testing
	docker-compose run --rm php-fpm php artisan app:init -n --env=testing
	#docker-compose run --rm php-fpm php artisan db:seed --class="Database\Seeders\DatabaseTestSeeder" --env=testing -n

test_refresh_db:
	docker-compose run --rm php-fpm php artisan migrate:fresh --seed -n --env=testing -n
	#docker-compose run --rm php-fpm php artisan am:create-admin -n --env=testing -n

test_run:
	docker-compose run --rm php-fpm ./vendor/bin/phpunit

#======================================
# Info

info_domen:
	echo '------------------------------';
	echo '[x] DEV-----------------------';
	echo ${APP_URL};
	echo '------------------------------';

.DEFAULT_GOAL := init

