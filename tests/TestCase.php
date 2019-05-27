<?php

namespace Pine\BladeFilters\Tests;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Pine\BladeFilters\BladeFiltersServiceProvider;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        View::addNamespace('blade-filters', __DIR__ . '/views');

        Route::get('/blade-filters/{filter}', function ($filter) {
            return view("blade-filters::{$filter}");
        });
    }

    protected function getPackageProviders($app)
    {
        return [BladeFiltersServiceProvider::class];
    }
}
