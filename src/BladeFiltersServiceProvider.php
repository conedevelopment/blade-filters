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
            return new BladeFiltersCompiler(
                $this->app['files'], $this->app['config']['view.compiled']
            );
        });

        $resolver->register('blade', function () {
            return new CompilerEngine($this->app['blade.compiler']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Currency
        Str::macro('currency', function ($value, $currency = '$', $side = 'left') {
            return $side === 'left' ? "{$currency} {$value}" : "{$value} {$currency}";
        });

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
            return mb_substr($value, $start, $length);
        });

        // Ucfirst
        Str::macro('ucfirst', function ($value) {
            return mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
        });

        // Lcfirst
        Str::macro('lcfirst', function ($value) {
            return mb_strtolower(mb_substr($value, 0, 1)) . mb_substr($value, 1);
        });

        // Reverse
        Str::macro('reverse', function ($value) {
            return strrev($value);
        });
    }
}
