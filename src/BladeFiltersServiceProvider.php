<?php

namespace Pine\BladeFilters;

use Illuminate\Support\Str;
use Illuminate\View\ViewServiceProvider;
use Illuminate\View\Engines\CompilerEngine;

class BladeFiltersServiceProvider extends ViewServiceProvider
{
    /**
     * Register the Blade engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerBladeEngine($resolver)
    {
        $this->app->singleton('blade.compiler', function () {
            return new Compiler(
                $this->app['files'], $this->app['config']['view.compiled']
            );
        });

        $resolver->register('blade', function () {
            return new CompilerEngine($this->app['blade.compiler']);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        // Date
        Str::macro('date', function ($value, $format = 'Y-m-d') {
            return date($format, strtotime($value));
        });

        // Trim
        Str::macro('trim', function ($value) {
            return trim($value);
        });

        // Substr
        Str::macro('substr', function ($value, $start, $length = null) {
            return substr($value, $start, $length);
        });
    }
}
