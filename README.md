# Blade Filters

Use string filters easily in Laravel Blade.

If you have any question how the package works, we suggest to read this post:
[Laravel Blade Filters](https://pineco.de/laravel-blade-filters/).

## Getting started

You can install the package with composer, running the `composer require thepinecode/blade-filters` command.

### Laravel 5.5 and up

If you are using version 5.5 and up, there is nothing else to do.
Since the package supports autodiscovery, Laravel will register the service provider automatically behind the scenes.

#### Disable the autodiscovery for the package

In some cases you may disable autodiscovery for this package.
You can add the provider class to the `dont-discover` array to disable it.

Then you need to register it manually again.

### Laravel 5.4 and below

You have to register the service provider manually.
Go to the `config/app.php` file and add the `Pine\BladeFilters\BladeFiltersServiceProvider::class` to the providers array.

## Using the filters

The basic concept is very similar what you can find in django or Symfony.
Given a value and in the views the output can be modified via filters.

You can use the filters in any of your blade templates.

***Regular usage***:
```php
{{ 'john' | ucfirst }} // John
```

***Chained usage***:
```php
{{ 'john' | ucfirst | substr:0,1 }} // J

{{ '1999-12-31' | date:'Y/m/d' }} // 1999/12/31
```

***Passing non-static values***:
```php
{{ $name | ucfirst | substr:0,1 }}

{{ $user['name] | ucfirst | substr:0,1 }}

{{ $currentUser->name | ucfirst | substr:0,1 }}

{{ getName() | ucfirst | substr:0,1 }}
```

***Passing variables as filter parameters***:
```php
$currency = 'HUF'

{{ '12.75' | currency:$currency }} // HUF 12.75
```

***Important Note***: Laravel supports three types of echos. Raw (`{{{  }}}`), regular (`{{}}`) and escaped (`{!! !!}`).
Filters can be used ***only with regular*** echos. Also, filters cannot be used in blade directices directly.

> Why? Raw should be as it is. Escaped should be escaped only, without modification.

## The available filters

Every filter is called from the `Illuminate\Support\Facades\Str` facade.

## Create custom filters

## Contact

If you found a bug or you have an idea connecting the package, feel free to open an issue.
