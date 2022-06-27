# Стартовый пакет для Laravel (заточено под серверное API)

[![PHP](https://img.shields.io/badge/php-%5E8.1-blue)](https://www.php.net/)
[![Framework](https://img.shields.io/badge/laravel-9-red)](https://laravel.com/docs/8.x)
[![Database](https://img.shields.io/badge/mysql-8-green)](https://dev.mysql.com/doc/refman/8.0/en/)
[![Cache](https://img.shields.io/badge/cache-redis-yellow)](https://redis.io/)
[![Auth](https://img.shields.io/badge/auth-sanctum-brown)](https://github.com/romaxa83/lara-docs/blob/9.x/docs/sanctum.md)
[![Api docs](https://img.shields.io/badge/api_docs-swagger_3-green)](https://github.com/DarkaOnLine/L5-Swagger)

<!-- Deployment -->
### Разворачивание проекта
<div id="deploy"></div>

1. Используя docker 

```sh
$ cp .env.example .env
$ cp .env.testing.example .env.testing
$ make init
```
<!-- Commands -->
### Команды
<div id="commands"></div>

```sh
// поднять проект
$ make up

// остановить проект
$ make down

// информаци по контейнерам и проекту
$ make info

// генерация api документации
$ make generate

// настраивает тестовое окружение и запускает тесты
$ make test
// настраивает тестовое окружение
$ make test_init
// запустить тесты
$ make test_run
// обновляет тестовую бд
$ make test_refresh_db
```
