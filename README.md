# Laravel make:class

Artisan command for generating a new custom class in Laravel.

## Installation

Install the package via composer:
```
composer require wawan/laravel-make-class:dev-master
```

If you're using Laravel < 5.5, you'll need to add the service provider to `config/app.php` file:

```php
'providers' => [
    ...

    Wawan\MakeClass\MakeClassServiceProvider::class,

    ...
]
```

## Usage
To create a new class, call the `make:class` command from Artisan. Class will be created under the `app` folder.
```
php artisan make:class ClassName
```
You can add the `-c` or `--constructor` option to generate new class with constructor.
```
php artisan make:class ClassName -c
```
```
php artisan make:class ClassName --constructor


To create a new interface, call the `make:interface` command from Artisan. Interface will be created under the `app` folder.
```
php artisan make:interface InterfaceName
```
