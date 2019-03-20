<?php

namespace Pine\BladeFilters\Test;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Pine\BladeFilters\BladeFiltersServiceProvider;

abstract class TestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        View::addNamespace('blade-filters', __DIR__.'/views');

        Route::get('blade-filters', function () {
            return view('blade-filters::filters');
        });
    }

    protected function getPackageProviders($app)
    {
        return [BladeFiltersServiceProvider::class];
    }
}
