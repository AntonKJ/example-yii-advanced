Ссылки в http://backend.localhost/checkstatus/
в http://backend.localhost/checkstatus/result-is-compared отсортированый список url, status 
формат зависит от заголовков если указан Json то ответ json 

```
 curl -i -H "Accept:application/json" "http://backend.localhost/checkstatus"
HTTP/1.1 200 OK
Server: nginx/1.13.12
Date: Thu, 24 Jun 2021 08:41:54 GMT
Content-Type: application/json; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.4.20
Vary: Accept

{"url":["https://www.google.com/","https://www.yiiframework.com/doc/api/2.0/yii-web-request","https://example.com/page/test","https://www.md5hashgenerator.com/","https://github.com/AntonKJ/"]}
```

Добавить 
```
http://backend.localhost/checkstatus/rest-check-urls
```

или обновить данные по урлу 
```
http://backend.localhost/checkstatus/rest-check-urls?aurl=https://github.com/AntonKJ/
```
Дабы не создавать БД она в проекте

Пользователи в RBAC
user: Webmaster pass: Webmaster (admin)
user: Webmaster1 pass: Webmaster1 (user)

Докер в папке Docker 
оттуда выполнять docker-compose up -d

#==================#END#==================#

#if not PDO Driver
```
docker exec -it php su
docker-php-ext-install pdo_mysql
```
#or
```
docker-compose exec php docker-php-ext-install pdo_mysql
docker-compose exec php docker-php-ext-install intl
```
#docker-compose reload 

#if exception Message format 'date' is not supported. You have to install PHP intl extension to use this feature.
```
docker exec -it php su
apt-get -y update \
    && apt-get install -y libicu-dev\
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl
```
#or 
```
docker exec -it php su
docker-php-ext-install intl
```
#if gd not available 
```
docker exec -it php su

apt-get update && \
    apt-get install -y \
        zlib1g-dev libpng-dev\
    && docker-php-ext-install gd
```

<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
