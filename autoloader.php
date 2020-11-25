<?php

// load config file
require_once 'config.php';

// autoload classes, and interfaces.
spl_autoload_register(function (string $class_name) {

    if(file_exists("core/Types/".$class_name . '.php'))
    {
        include_once "core/Types/".$class_name . '.php';
    }
    elseif (file_exists("core/interfaces/".$class_name . '.php'))
    {
        include_once "core/interfaces/".$class_name . '.php';
    }
    elseif (file_exists("core/validation/".$class_name . '.php'))
    {
        include_once "core/validation/".$class_name . '.php';
    }
    else
    {
        include_once "core/".$class_name . '.php';
    }
});
