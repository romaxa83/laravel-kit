# Стартовый пакет для Laravel (заточенно под серверное API)

[![PHP](https://img.shields.io/badge/php-%5E8.1-blue)](https://www.php.net/)
[![Framework](https://img.shields.io/badge/laravel-9-red)](https://laravel.com/docs/8.x)
[![Database](https://img.shields.io/badge/mysql-8-green)](https://dev.mysql.com/doc/refman/8.0/en/)
[![Cache](https://img.shields.io/badge/cache-redis-yellow)](https://redis.io/)

<!-- Deployment -->
### Разворачивание проекта
<div id="deploy"></div>

1. Используя docker 

```sh
$ cp .env.example .env
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
```
