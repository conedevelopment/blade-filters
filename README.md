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

You can use the filters in any of your blade templates.

#### Regular usage:

```php
{{ 'john' | ucfirst }} // John
```

#### Chained usage:

```php
{{ 'john' | ucfirst | substr:0,1 }} // J

{{ '1999-12-31' | date:'Y/m/d' }} // 1999/12/31
```

#### Passing non-static values:

```php
{{ $name | ucfirst | substr:0,1 }}

{{ $user['name'] | ucfirst | substr:0,1 }}

{{ $currentUser->name | ucfirst | substr:0,1 }}

{{ getName() | ucfirst | substr:0,1 }}
```

#### Passing variables as filter parameters:

```php
$currency = 'HUF'

{{ '12.75' | currency:$currency }} // HUF 12.75
```

#### Built-in Laravel functionality:

```php
{{ 'This is a title' | slug }} // this-is-a-title

{{ 'This is a title' | title }} // This Is A Title

{{ 'foo_bar' | studly }} // FooBar
```

### Limitations

#### Echos

Laravel supports three types of echos. Raw – `{!!  !!}`, regular – `{{ }}` and escaped (legacy) – `{{{ }}}`.
Filters can be used **only with regular** echos. Also, filters **cannot be used in blade directives directly**.

> Why? Raw should be as it is. Forced escaping should be escaped only, without modification.

#### Bitwise operators

Bitwise operators are allowed, but they must be wrapped in parentheses,
since they are using the same "pipe operator".

```php
{{ ('a' | 'b') | upper }} // C
```

## The Filters

### About the filters

Filters are string functions, that are defined in the `Pine\BladeFilters\BladeFilters` facade.
It has several reasons, that are discussed in the [Create custom filters](#create-custom-filters) section.

### The available filters

The package comes with a few built-in filters, also the default Laravel string methods can be used.

#### Currency

```php
{{ '17.99' | currency:'CHF' }} // CHF 17.99

{{ '17.99' | currency:'€',false }} // 17.99 €
```

> Passing `false` as the second parameter will align the symbol to the right.

#### Date

```php
{{ '1999/12/31' | date }} // 1999-12-31

{{ '1999/12/31' | date:'F j, Y' }} // December 31, 1999
```

#### Lcfirst

```php
{{ 'Árpamaláta' | lcfirst }} // árpamaláta
```

> Unlike PHP's default `lcfirst()`, this filter works with multi-byte strings as well.

#### Reverse

```php
{{ 'ABCDEF' | reverse }} //FEDCBA
```

#### Substr

```php
{{ 'My name is' | substr:0,2 }} // My

{{ 'My name is' | substr:3 }} // name is
```

#### Trim

```php
{{ '   trim me    ' | trim }} // trim me
```

#### Ucfirst

```php
{{ 'árpamaláta' | ucfirst }} // Árpamaláta
```

> Unlike PHP's default `ucfirst()`, this filter works with multi-byte strings as well.

### Supported built-in Str functions

- [Str::after()](https://laravel.com/docs/5.8/helpers#method-str-after)
- [Str::before()](https://laravel.com/docs/5.8/helpers#method-str-before)
- [Str::camel()](https://laravel.com/docs/5.8/helpers#method-str-camel)
- [Str::finish()](https://laravel.com/docs/5.8/helpers#method-str-finish)
- [Str::kebab()](https://laravel.com/docs/5.8/helpers#method-str-kebab)
- [Str::limit()](https://laravel.com/docs/5.8/helpers#method-str-limit)
- [Str::plural()](https://laravel.com/docs/5.8/helpers#method-str-plural)
- [Str::singular()](https://laravel.com/docs/5.8/helpers#method-str-singular)
- [Str::slug()](https://laravel.com/docs/5.8/helpers#method-str-slug)
- [Str::snake()](https://laravel.com/docs/5.8/helpers#method-str-snake)
- [Str::start()](https://laravel.com/docs/5.8/helpers#method-str-start)
- [Str::studly()](https://laravel.com/docs/5.8/helpers#method-str-studly)
- [Str::title()](https://laravel.com/docs/5.8/helpers#method-str-title)

## Create custom filters

As it was mentioned before, every filter is a method that can be called through the `Pine\BladeFilters\BladeFilters` facade.
It has several reasons why is this approach better, but let's take the most important ones:

- It's easy to define custom filters by extending the facade with the `BladeFilters::macro()`,
- No extra files, autoloading or class mapping, it's enough to use any service provider to define filters,
- By default Laravel provides a bunch of handy methods that we can use as filters.

### Parameter ordering

PHP is not very strict regarding to function's parameter ordering and this way it's easier to coordiante or override them.
Also, sometimes it happens with Laravel's string functions. It's important that only those functions can be used, that accept the parameters in the following order:

1. The value to be transformed
2. Any other parameter if needed

For example:

```php
BladeFilters::macro('filterName', function ($value, $param1 = 'default', $param2 = null) {
    return ...;
});

{{ 'string' | filterName:1,2 }}
```

### Defining custom filters

Since the filters are only methods that are defined in the `Str` facade and the `BladeFilters` class, to create filters, 
you need to create a macro in a service provider's `boot()` method.

```php
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        BladeFilters::macro('substr', function ($value, $start, $length = null) {
            return mb_substr($value, $start, $length);
        });
    }
}
```

## Contribute

If you found a bug or you have an idea connecting the package, feel free to open an issue.
