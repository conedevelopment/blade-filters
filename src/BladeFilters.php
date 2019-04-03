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
     * @param $method
     * @param $parameters
     * @return mixed
     * @throws MissingBladeFilterException
     */
    public static function __callStatic($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return static::__baseCallStatic($method, $parameters);
        }
        if (method_exists(Str::class, $method)) {
            return forward_static_call_array([Str::class, $method], $parameters);
        }
        if(Str::hasMacro($method)){
            return forward_static_call_array([Str::class, $method], $parameters);
        }
        throw new MissingBladeFilterException($method);
    }

    /**
     * @param $value
     * @param string $currency
     * @param string $side
     * @return string
     */
    public static function currency($value, $currency = '$', $side = 'left')
    {
        return $side === 'left' ? "{$currency} {$value}" : "{$value} {$currency}";
    }

    /**
     * @param $value
     * @param string $format
     * @return false|string
     */
    public static function date($value, $format = 'Y-m-d')
    {
        return date($format, strtotime($value));
    }

    /**
     * @param $value
     * @return string
     */
    public static function trim($value)
    {
        return trim($value);
    }

    /**
     * @param $value
     * @param $start
     * @param null $length
     * @return bool|string
     */
    public static function substr($value, $start, $length = null)
    {
        return mb_substr($value, $start, $length);
    }

    /**
     * @param $value
     * @return string
     */
    public static function ucfirst($value)
    {
        return mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }

    /**
     * @param $value
     * @return string
     */
    public static function lcfirst($value)
    {
        return mb_strtolower(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }

    /**
     * @param $value
     * @return string
     */
    public static function reverse($value)
    {
        return strrev($value);
    }
}
