<?php

namespace Pine\BladeFilters\Tests;

use Illuminate\Support\Str;

class BladeFiltersTest extends TestCase
{
    /** @test */
    public function a_string_can_be_filtered()
    {
        $this->get('/blade-filters/string')->assertSee(Str::slug('string test'));
    }

    /** @test */
    public function a_variable_can_be_filtered()
    {
        $this->get('/blade-filters/variable')->assertSee(Str::slug('variable test'));
    }

    /** @test */
    public function a_function_can_be_filtered()
    {
        $this->get('/blade-filters/function')->assertSee(Str::slug('function test'));
    }

    /** @test */
    public function a_risky_string_can_be_filtered()
    {
        $this->get('/blade-filters/risky-string')->assertSee(Str::slug('|risky:string:test|'));
    }

    /** @test */
    public function a_string_can_be_chain_filtered()
    {
        $text = '   long and Badly Formatted text....way too long';

        $this->get('/blade-filters/chain')->assertSee(
            Str::limit(Str::title(Str::trim($text)), 10)
        );
    }
}
