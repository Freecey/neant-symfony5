# neant-symfony5 <br />Simple Symfony 5.2 Blog Application

## Description
Lightweight and easy-to-use Blog solution for PHP using Symfony 5.2 framework & Tailwind CSS 2.0.3.

## Live version
[https://blog.neant.be](https://blog.neant.be)

## Requirements
* PHP 8.0 or higher;
* MariaDB 10.3.25
* composer 2.0 or higher;
* NPM 7.6.3
* and the [usual Symfony application requirements](https://symfony.com/doc/current/setup.html#technical-requirements).

## Quickstart - Installation
Download and install the blog application using Git, Composer and NPM:

```bash
$ git clone https://github.com/Freecey/neant-symfony5.git
$ cd neant-symfony5/
$ composer install
$ npm install --force
$ npm run build
```
> **NOTE**
>
> You may need to give cache, logs and session folders write permissions
>
>     neant-symfony5$ chmod -R 777 var/cache var/logs var/sessions

## Create and Update database
```bash
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
```

Usage
-----

There is no need to configure a virtual host in your web server to access the application.
Just use the built-in web server:

```bash
neant-symfony5$ php bin/console server:run
```

Contributor
----

![alt text](docs/onepanda.jpg?raw=true "Cey Pictures" )

* Cedric AUDRIT     [@freecey](https://github.com/freecey/)

___
License
----

Please see [LICENSE](https://raw.githubusercontent.com/Freecey/neant-symfony5/master/LICENSE) file for more details.
