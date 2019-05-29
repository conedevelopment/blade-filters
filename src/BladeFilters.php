<?php

namespace Pine\BladeFilters;

use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Pine\BladeFilters\Exceptions\MissingBladeFilterException;

class BladeFilters
{
    use Macroable {
        __callStatic as __baseCallStatic;
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \Pine\BladeFilters\Exceptions\MissingBladeFilterException
     */
    public static function __callStatic($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return static::__baseCallStatic($method, $parameters);
        } elseif (method_exists(Str::class, $method)) {
            return forward_static_call_array([Str::class, $method], $parameters);
        } elseif (Str::hasMacro($method)) {
            return forward_static_call_array([Str::class, $method], $parameters);
        }

        throw new MissingBladeFilterException($method);
    }

    /**
     * Format the string as currency.
     *
     * @param  string  $value
     * @param  string  $currency
     * @param  bool  $left
     * @return string
     */
    public static function currency($value, $currency = '$', $left = true)
    {
        return $left ? "{$currency} {$value}" : "{$value} {$currency}";
    }

    /**
     * Format the string as date.
     *
     * @param  string  $value
     * @param  string  $format
     * @return string
     */
    public static function date($value, $format = 'Y-m-d')
    {
        return date($format, strtotime($value));
    }

    /**
     * Trim the string.
     *
     * @param  string  $value
     * @return string
     */
    public static function trim($value)
    {
        return trim($value);
    }

    /**
     * Slice the string.
     *
     * @param  string  $value
     * @param  int  $start
     * @param  int|null  $length
     * @return string
     */
    public static function substr($value, $start, $length = null)
    {
        return mb_substr($value, $start, $length);
    }

    /**
     * Transform the first letter to uppercase.
     *
     * @param  string  $value
     * @return string
     */
    public static function ucfirst($value)
    {
        return mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }

    /**
     * Transform the first letter to lowercase.
     *
     * @param  string  $value
     * @return string
     */
    public static function lcfirst($value)
    {
        return mb_strtolower(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }

    /**
     * Reverse the string.
     *
     * @param  string  $value
     * @return string
     */
    public static function reverse($value)
    {
        return strrev($value);
    }
}
