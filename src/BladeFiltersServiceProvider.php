<?php

namespace Pine\BladeFilters;

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
}
