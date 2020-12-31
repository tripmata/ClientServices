<?php
    session_start();

    // set the default time zone
    date_default_timezone_set('Africa/Lagos');

    // set the default content type
    header('Content-Type: application/json');

    // start autoloader
    require_once ("autoloader.php");

    // clean $_REQUEST array
    Sanitize::removeHTMLFromRequests();

    // set session
    if (isset($_REQUEST['user_token'])) {

        $_SESSION['user_token'] = $_REQUEST['user_token'];

        // check for $_REQUEST['usersess']
        if (!isset($_REQUEST['usersess']))
        {
            $_REQUEST['usersess'] = '';
        }
    }

    $subscriber = new Subscriber();

    $sess = isset($_REQUEST['token']) ? Session::Get($_REQUEST['token']) : Session::Get("");

    $user = new User($sess->User);

    $customer = new Customer(new Subscriber());

    $property = null;

    if($user->Id == "")
    {
        $customer->Initialize($sess->User);

        if($sess->Itemname == "property")
        {
            $property = new Property($sess->Currentitem);

            if($property->Owner->Id === $customer->Id)
            {
                $user = new User("adxc0");
                $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);
            }
        }
    }
    else
    {
        $customer->Initialize($sess->User);
    }

    $router = new Router();
    $router->ErrorPage = true;

    $router->AddHome("controllers/default.json");

    if($router->Page != "")
    {
        $router->AddRoute($router->Page, "controllers/".$router->Page.".php");
    }
    
    $router->MapRoutes();