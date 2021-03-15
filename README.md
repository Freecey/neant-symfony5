# neant-symfony5 <br />Simple Symfony5 Blog Application

## Description
Lightweight and easy-to-use Blog solution for PHP using Symfony5 framework.

## Live version
[https://www.neant.be](https://www.neant.be)

## Requirements
* PHP 8.0 or higher;
* MariaDB
* composer 2.0 or higher;
* and the [usual Symfony application requirements](http://symfony.com/doc/current/reference/requirements.html).

## Quickstart - Installation
Download and install the blog application using Git and Composer:

```bash
$ git clone https://github.com/Freecey/neant-symfony5.git
$ cd neant-symfony5/
$ composer install
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
symfony-blog$ php bin/console server:run
```

___
License
----

Please see [LICENSE](https://raw.githubusercontent.com/Freecey/neant-symfony5/master/LICENSE) file for more details.