<?php

namespace Pine\BladeFilters\Tests;

use Pine\BladeFilters\BladeFilters;
use Pine\BladeFilters\Exceptions\MissingBladeFilterException;

class BladeFiltersTest extends TestCase
{
    /** @test */
    public function a_string_can_be_filtered()
    {
        $this->get('/blade-filters/string')->assertSee(BladeFilters::slug('string test'));
    }

    /** @test */
    public function a_variable_can_be_filtered()
    {
        $this->get('/blade-filters/variable')->assertSee(BladeFilters::slug('variable test'));
    }

    /** @test */
    public function a_function_can_be_filtered()
    {
        $this->get('/blade-filters/function')->assertSee(BladeFilters::slug('function test'));
    }

    /** @test */
    public function a_risky_string_can_be_filtered()
    {
        $this->get('/blade-filters/risky-string')->assertSee(
            BladeFilters::start(BladeFilters::finish('risky|string:test', '|'), ':')
        );
    }

    /** @test */
    public function a_bitwise_operator_string_can_be_filtered()
    {
        $result = BladeFilters::upper('a' | 'b');

        $this->get('/blade-filters/bitwise')->assertSee($result);
    }

    /** @test */
    public function a_string_can_be_chain_filtered()
    {
        $text = '   long and Badly Formatted text....way too long';

        $this->get('/blade-filters/chain')->assertSee(
            BladeFilters::limit(BladeFilters::title(BladeFilters::trim($text)), 10)
        );
    }

    /** @test */
    public function a_string_can_be_wrapped_and_multiline()
    {
        $this->get('/blade-filters/wrapped')
            ->assertSee(
                '<h1>' . BladeFilters::title('this is a title') . '</h1>'
            )->assertSee(
                '<a href="' . BladeFilters::slug('this is a link') . '">Link</a>'
            );
    }

    /** @test */
    public function it_throws_exception_when_missing_filter()
    {
        $result = $this->get('/blade-filters/missing-filter');

        $this->assertInstanceOf(MissingBladeFilterException::class, $result->exception->getPrevious());

        $this->assertEquals($result->exception->getPrevious()->getMessage(), 'this_filter_does_not_exist');
    }

    /** @test */
    public function at_curly_brace_js_syntax_ignored()
    {
        $result = $this->get('/blade-filters/ignore-js')
            ->assertSee('<h1>{{ val.title | title }}</h1>');
    }
}
