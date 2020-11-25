<?php


class System
{
    /**
     * @method System getURL
     * @return string
     */
    public static function getURL() : string
    {
        // return host
        return Configuration::url()->host;
    }
}