<?php

namespace Pine\BladeFilters\Tests;

use Illuminate\Support\Str;

class StrMacrosTest extends TestCase
{
    /** @test */
    public function currency_test()
    {
        $left = Str::currency('12.99', 'HUF');
        $right = Str::currency('12.99', 'HUF', 'right');

        $this->assertEquals('HUF 12.99', $left);
        $this->assertEquals('12.99 HUF', $right);
    }

    /** @test */
    public function date_test()
    {
        $date = Str::date('1999/12/31', 'F j, Y');

        $this->assertEquals('December 31, 1999', $date);
    }

    /** @test */
    public function trim_test()
    {
        $trimmed = Str::trim('   trim me     ');

        $this->assertEquals('trim me', $trimmed);
    }

    /** @test */
    public function substr_test()
    {
        $substr = Str::substr('Get the first 5 char', 0, 5);

        $this->assertEquals('Get t', $substr);
    }

    /** @test */
    public function ucfirst_test()
    {
        $ucfirst = Str::ucfirst('árpamaláta');

        $this->assertEquals('Árpamaláta', $ucfirst);
    }

    /** @test */
    public function lcfirst_test()
    {
        $lcfirst = Str::lcfirst('Árpamaláta');

        $this->assertEquals('árpamaláta', $lcfirst);
    }

    /** @test */
    public function reverse_test()
    {
        $reversed = Str::reverse('ABCDEF');

        $this->assertEquals('FEDCBA', $reversed);
    }
}
