<?php

namespace Pine\BladeFilters\Tests;

use Illuminate\Support\Str;
use Pine\BladeFilters\BladeFilters;

class BladeFiltersMacrosTest extends TestCase
{
    /** @test */
    public function currency_test()
    {
        $left = BladeFilters::currency('12.99', 'HUF');
        $right = BladeFilters::currency('12.99', 'HUF', false);

        $this->assertEquals('HUF 12.99', $left);
        $this->assertEquals('12.99 HUF', $right);
    }

    /** @test */
    public function date_test()
    {
        $date = BladeFilters::date('1999/12/31', 'F j, Y');

        $this->assertEquals('December 31, 1999', $date);
    }

    /** @test */
    public function trim_test()
    {
        $trimmed = BladeFilters::trim('   trim me     ');

        $this->assertEquals('trim me', $trimmed);
    }

    /** @test */
    public function substr_test()
    {
        $substr = BladeFilters::substr('Get the first 5 char', 0, 5);

        $this->assertEquals('Get t', $substr);
    }

    /** @test */
    public function ucfirst_test()
    {
        $ucfirst = BladeFilters::ucfirst('árpamaláta');

        $this->assertEquals('Árpamaláta', $ucfirst);
    }

    /** @test */
    public function lcfirst_test()
    {
        $lcfirst = BladeFilters::lcfirst('Árpamaláta');

        $this->assertEquals('árpamaláta', $lcfirst);
    }

    /** @test */
    public function reverse_test()
    {
        $reversed = BladeFilters::reverse('ABCDEF');

        $this->assertEquals('FEDCBA', $reversed);
    }
}
