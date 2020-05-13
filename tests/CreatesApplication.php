<?php

namespace Pine\BladeFilters\Tests;

use Illuminate\Contracts\Console\Kernel;
use Pine\BladeFilters\BladeFiltersServiceProvider;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->booting(function () use ($app) {
            $app->register(BladeFiltersServiceProvider::class);
        });

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
