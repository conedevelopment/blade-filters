<?php

namespace Pine\BladeFilters;

use Illuminate\View\Compilers\BladeCompiler;

class BladeFiltersCompiler extends BladeCompiler
{
    /**
     * Compile the "regular" echo statements.
     *
     * @param  string  $value
     * @return string
     */
    protected function compileRegularEchos($value)
    {
        $value = parent::compileRegularEchos($value);

        return preg_replace_callback('/(?<=<\?php\secho\se\()(.*)(?=\);\s\?>)/u', function ($matches) {
            return $this->parseFilters($matches[0]);
        }, $value);
    }

    /**
     * Parse the blade filters and pass them to the echo.
     *
     * @param  string  $value
     * @return string
     */
    protected function parseFilters($value)
    {
        if (! preg_match('/(?![^\"\'(].*[\"\')])(\|.*)/u', $value, $matches)) {
            return $value;
        }

        $expressions = array_values(array_filter(array_map('trim', explode('|', $matches[0]))));

        if (empty($expressions)) {
            return $value;
        }

        foreach ($expressions as $key => $expression) {
            $expression = explode(':', trim($expression));

            $wrapped = sprintf(
                '\Illuminate\Support\Str::%s(%s%s)',
                $expression[0],
                $key === 0 ? rtrim(str_replace($matches[0], '', $value)) : $wrapped,
                isset($expression[1]) ? ",{$expression[1]}" : ''
            );
        }

        return $wrapped;
    }
}
