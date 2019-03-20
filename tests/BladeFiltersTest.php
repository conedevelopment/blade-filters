<?php

namespace Pine\BladeFilters\Tests;

use Illuminate\Support\Str;

class BladeFiltersTest extends TestCase
{
    /** @test */
    public function a_string_can_be_slug_filtered()
    {
        $this->get('/blade-filters/slug')->assertSee(Str::slug('Slug test'));
    }

    /** @test */
    public function a_string_can_be_kebab_filtered()
    {
        $this->get('/blade-filters/kebab')->assertSee(Str::kebab('KebabTest'));
    }

    /** @test */
    public function a_string_can_be_currency_filtered()
    {
        $this->get('/blade-filters/currency')->assertSee(Str::currency('12.99', 'HUF', 'right'));
    }

    /** @test */
    public function a_string_can_be_date_filtered()
    {
        $this->get('/blade-filters/date')->assertSee(Str::date('1999/12/31', 'F j, Y'));
    }

    /** @test */
    public function a_string_can_be_trim_filtered()
    {
        $this->get('/blade-filters/trim')->assertSee(Str::trim('  trim me   '));
    }

    /** @test */
    public function a_string_can_be_substr_filtered()
    {
        $this->get('/blade-filters/substr')->assertSee(Str::substr('Long time ago...', 0, 5));
    }

    /** @test */
    public function a_string_can_be_ucfirst_filtered()
    {
        $this->get('/blade-filters/ucfirst')->assertSee(Str::ucfirst('árpamaláta'));
    }

    /** @test */
    public function a_string_can_be_lcfirst_filtered()
    {
        $this->get('/blade-filters/lcfirst')->assertSee(Str::lcfirst('Árpamaláta'));
    }

    /** @test */
    public function a_string_can_be_reverse_filtered()
    {
        $this->get('/blade-filters/reverse')->assertSee(Str::reverse('ABCDEF'));
    }
}
