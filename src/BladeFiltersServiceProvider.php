<?php

namespace Pine\BladeFilters;

use Illuminate\Support\ServiceProvider;

class BladeFiltersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['blade.compiler']->extend(function ($view) {
            return $this->app[BladeFiltersCompiler::class]->compile($view);
        });
    }
}
