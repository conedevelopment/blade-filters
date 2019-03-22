<?php

namespace Pine\BladeFilters\Tests;

use Illuminate\Support\Str;

class BladeFiltersTest extends TestCase
{
    /** @test */
    public function a_string_can_be_filtered()
    {
        // $this->get('/blade-filters/string')->assertSee(Str::slug('Slug test'));
    }
}
