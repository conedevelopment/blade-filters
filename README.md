# Blade Filters

Use string filters easily in Laravel Blade.

If you have any question how the package works, we suggest to read this post:
[Using Laravel’s Localization in JS](https://pineco.de/using-laravels-localization-js/).

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



## Contact

If you found a bug or you have an idea connecting the package, feel free to open an issue.
