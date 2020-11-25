<?php 
/**
 * @package Sanitize
 * @author Amadi Ifeanyi
 * 
 * A simple class to keep all inputs sanitized
 */
class Sanitize
{
    /**
     * @method Sanitize noHTML
     * @param mixed $value
     * @return mixed
     * 
     * Value passed cannot be null and would return a clean data
     */
    public static function noHTML($value) 
    {
        // not null? Remove HTML tags
        if ($value !== null) return strip_tags($value);

        // is value
        return $value;
    }

    /**
     * @method Sanitize encodeHTML
     * @param mixed $value
     * @return mixed
     * 
     * Value passed cannot be null and would return an encoded data
     */
    public static function encodeHTML($value) 
    {
        // not null? Encode HTML
        if ($value !== null) return htmlentities($value, ENT_QUOTES, 'UTF8');

        // is value
        return $value;
    }

    /**
     * @method Sanitize removeHTMLFromRequests
     * @return void
     * 
     * Remove HTML from user inputs
     */
    public static function removeHTMLFromRequests() : void
    {
        // clean data
        foreach ($_REQUEST as $key => $value) $_REQUEST[$key] = self::noHTML($value);
    }
}