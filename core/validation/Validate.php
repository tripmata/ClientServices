<?php 
/**
 * @package Validate
 * @author Amadi Ifeanyi
 * 
 * A simple class to keep all inputs validated
 */
class Validate
{
    /**
     * @method Validate isInt
     * @param mixed $value
     * @return bool
     * 
     * Value passed cannot be null and must be an integer
     */
    public static function isInt($value) : bool 
    {
        // @var bool $passed
        $passed = false;

        // not null and an integer
        if ($value !== null && preg_match('/^[\d]+$/', $value)) $passed = true;

        // is passed
        return $passed;
    }

    /**
     * @method Validate isString
     * @param mixed $value
     * @return bool
     * 
     * Value passed cannot be null and must be a string
     */
    public static function isString($value) : bool 
    {
        // @var bool $passed
        $passed = false;

        // not null and a string
        if ($value !== null && filter_var($value, FILTER_SANITIZE_STRING)) $passed = true;

        // is passed
        return $passed;
    }
}