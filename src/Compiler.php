<?php

namespace Pine\BladeFilters;

use Illuminate\View\Compilers\BladeCompiler;

class Compiler extends BladeCompiler
{
    /**
     * Compile the "regular" echo statements.
     *
     * @param  string  $value
     * @return string
     */
    protected function compileRegularEchos($value)
    {
        $pattern = sprintf('/(@)?%s\s*(.+?)\s*%s(\r?\n)?/s', $this->contentTags[0], $this->contentTags[1]);

        $callback = function ($matches) {
            $whitespace = empty($matches[3]) ? '' : $matches[3].$matches[3];

            $wrapped = sprintf($this->echoFormat, $this->parseFilters($matches[2]));

            return $matches[1] ? substr($matches[0], 1) : "<?php echo {$wrapped}; ?>{$whitespace}";
        };

        return preg_replace_callback($pattern, $callback, $value);
    }

    /**
     * Parse the blade filters and pass them to the echo.
     *
     * @param  string  $value
     * @return string
     */
    protected function parseFilters($value)
    {
        if (! preg_match('/(?=[^\'\"(].+?[\'\")])?(\|.*)/iu', $value, $matches)) {
            return $value;
        }

        $expressions = array_values(array_filter(array_map('trim', explode('|', $matches[0]))));

        if (empty($expressions)) {
            return $value;
        }

        foreach ($expressions as $key => $expression) {
            $expression = explode(':', trim($expression));

            $filters = sprintf(
                '\Illuminate\Support\Str::%s(%s%s)',
                $expression[0],
                $key == 0 ? rtrim(str_replace($matches[0], '', $value)) : $filters,
                isset($expression[1]) ? ",{$expression[1]}" : ''
            );
        }

        return $filters;
    }
}
