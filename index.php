<?php
    session_start();

    // set the default content type
    header('Content-Type: application/json');

    // start autoloader
    require_once ("autoloader.php");

    // clean $_REQUEST array
    Sanitize::removeHTMLFromRequests();

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