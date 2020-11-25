<?php
/**
 * @package Configuration 
 * @author Amadi Ifeanyi <amadiify.com>
 * 
 * Simple global configuration class
 */
class Configuration
{
    /**
     * @var string $mode 
     * Can either be development or live
     */
    const MODE = 'development';

    /**
     * @method Configuration database
     * @return object
     * 
     * Returns the default database configuration
     */
    public static function database() : object 
    {
        // @var array $config
        $config = [

            // development connection settings
            'development' => [
                'host' => 'localhost',
                'user' => 'root',
                'pass' => 'root',
                'name' => 'esusuttq_tripmata'
            ],

            // live connection settings
            'live' => [
                'host' => '',
                'user' => '',
                'pass' => '',
                'name' => '',
            ]
        ];

        // return config
        return self::getObject($config);
    }

    /**
     * @method Configuration url
     * @return object
     * 
     * Returns the default url configuration
     */
    public static function url() : object 
    {
        // @var array $config
        $config = [
            
            // development url configuration
            'development' => [
                'host'      => 'http://localhost:8888/tripmata/',
            ],

            // live url configuration
            'live' => [
                'host'      => ''
            ]
        ];

        // return config
        return self::getObject(self::getUrlConfigFromRequestHeader($config));
    }

    /**
     * @method Configuration getObject
     * @param array $config
     * @return object
     * 
     * Returns configuration as an object, conditioned to the default MODE
     */
    private static function getObject(array $config) : object 
    {
        // return configuration as an object
        return (object) (isset($config[Configuration::MODE]) ? $config[Configuration::MODE] : $config['development']);
    }

    /**
     * @method Configuration getUrlConfigFromRequestHeader
     * @param array $config
     * @return array
     * 
     * This method would check for configuration settings in the request header, and update the default configuration with it.
     */
    private static function getUrlConfigFromRequestHeader(array $config) : array
    {
        // get url configuration if sent via the request header
        if (function_exists('getallheaders')) :

            // get all headers
            $headers = getallheaders();

            // check for x-url-config
            if (isset($headers['x-url-config'])) :

                // read json data
                $jsonData = json_decode($headers['x-url-config']);

                // continue if it's an object
                if (is_object($jsonData) && isset($config[Configuration::MODE])) :

                    // get current config
                    $currentConfig = $config[Configuration::MODE];

                    // check for host
                    $currentConfig['host'] = isset($jsonData->host) ? $jsonData->host : $currentConfig['host'];

                    // set now
                    $config[Configuration::MODE] = $currentConfig;

                endif;

            endif;

        endif;

        // return array
        return $config;
    }
}