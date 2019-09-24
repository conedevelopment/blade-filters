<?php

namespace Pine\BladeFilters;

class BladeFiltersCompiler
{
    /**
     * Compile the echo statements.
     *
     * @param  string  $value
     * @return string
     */
    public function compile($value)
    {
        return preg_replace_callback('/(?<=([^@]{{))(.*?)(?=}})/mu', function ($matches) {
            return $this->parseFilters($matches[0]);
        }, $value);
    }

    /**
     * Parse the blade filters.
     *
     * @param  string  $value
     * @return string
     */
    protected function parseFilters($value)
    {
        if (! preg_match('/(?=(?:[^\'\"\`)]*([\'\"\`])[^\'\"\`]*\1)*[^\'\"\`)]*$)(\|.*)/u', $value, $matches)) {
            return $value;
        }

        $filters = preg_split('/\|(?=(?:[^\'\"\`]*([\'\"\`])[^\'\"\`]*\1)*[^\'\"\`]*$)/u', $matches[0]);

        if (empty($filters = array_values(array_filter(array_map('trim', $filters))))) {
            return $value;
        }

        $wrapped = '';

        foreach ($filters as $key => $filter) {
            $filter = preg_split('/:(?=(?:[^\'\"\`]*([\'\"\`])[^\'\"\`]*\1)*[^\'\"\`]*$)/u', trim($filter));

            $wrapped = sprintf(
                '\Pine\BladeFilters\BladeFilters::%s(%s%s)',
                $filter[0],
                $key === 0 ? trim(str_replace($matches[0], '', $value)) : $wrapped,
                isset($filter[1]) ? ",{$filter[1]}" : ''
            );
        }

        return $wrapped;
    }
}
