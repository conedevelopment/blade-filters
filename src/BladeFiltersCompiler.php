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

        $filters = array_values(array_filter(array_map('trim', explode('|', $matches[0]))));

        if (empty($filters)) {
            return $value;
        }

        foreach ($filters as $key => $filter) {
            $filter = explode(':', trim($filter));

            $wrapped = sprintf(
                '\Illuminate\Support\Str::%s(%s%s)',
                $filter[0],
                $key === 0 ? rtrim(str_replace($matches[0], '', $value)) : $wrapped,
                isset($filter[1]) ? ",{$filter[1]}" : ''
            );
        }

        return $wrapped;
    }
}
