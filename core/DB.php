<?php


    class DB
    {
        public static function Query($query)
        {
            // get database configuration
            $config = Configuration::database();

            // connect to db
            $db = new mysqli($config->host, $config->user, $config->pass, $config->name);
            $row = $db->query($query);
            $db->Close();
            
            return $row;
        }

        public static function GetDB()
        {
            // get database configuration
            $config = Configuration::database();

            // connect to db
            return new mysqli($config->host, $config->user, $config->pass, $config->name);
        }
    }