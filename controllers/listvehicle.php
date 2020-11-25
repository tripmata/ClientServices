<?php

    $ret = new stdClass();

    if(isset($_SESSION['user_token']))
    {
        $sess = Session::Get($_SESSION['user_token']);

        $customer = new Customer($GLOBALS['subscriber']);
        $customer->Initialize($sess->User);

        if ($customer->Id != "")
        {
            $vehicle = new Vehicle();

            $images = explode(",", $_REQUEST['images']);

            $vehicle->Image1 = count($images) > 0 ? $images[0] : "";
            $vehicle->Image2 = count($images) > 1 ? $images[1] : "";
            $vehicle->Image3 = count($images) > 2 ? $images[2] : "";
            $vehicle->Image4 = count($images) > 3 ? $images[3] : "";
            $vehicle->Type = $_REQUEST['type'];
            $vehicle->Model = $_REQUEST['model'];
            $vehicle->Color = $_REQUEST['color'];
            $vehicle->Seats = Convert::ToInt($_REQUEST['seats']);
            $vehicle->Description = $_REQUEST['description'];
            $vehicle->Features = [];

            $f = explode(",", $_REQUEST['feature']);
            for ($i = 0; $i < count($f); $i++) {
                if ($f[$i] != "") {
                    array_push($vehicle->Features, $f[$i]);
                }
            }

            $vehicle->Status = true;
            //$vehicle->Driver = new Driver($_REQUEST['Driver']);
            $vehicle->Milagecap = Convert::ToInt($_REQUEST['mileage']);
            $vehicle->Price = doubleval($_REQUEST['price']);
            $vehicle->Extramilage = doubleval($_REQUEST['extramile']);
            $vehicle->Statename = $_REQUEST['statename'];
            $vehicle->Cityname = $_REQUEST['cityname'];
            $vehicle->State = ucwords(strtolower($_REQUEST['state']));
            $vehicle->City = ucwords(strtolower($_REQUEST['city']));
            $vehicle->Owner = $customer;

            $vehicle->Save();
            $ret->status = "success";
            $ret->data = $vehicle;
            $ret->message = "Vehicle added";
        }
    }
    echo json_encode($ret);
