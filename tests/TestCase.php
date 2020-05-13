<?php

namespace Pine\BladeFilters\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        View::addNamespace('blade-filters', __DIR__.'/views');

        Route::get('/blade-filters/{filter}', function ($filter) {
            return view("blade-filters::{$filter}");
        });
    }
}
