<?php

    $ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Webfront->ReadAccess)
        {
                $vehicle = new Vehicle($_REQUEST['Vehicleid']);
                $vehicle->Image1 = $_REQUEST['Image1'];
                $vehicle->Image2 = $_REQUEST['Image2'];
                $vehicle->Image3 = $_REQUEST['Image3'];
                $vehicle->Image4 = $_REQUEST['Image4'];
                $vehicle->Type = $_REQUEST['Type'];
                $vehicle->Model = $_REQUEST['Model'];
                $vehicle->Color = $_REQUEST['Color'];
                $vehicle->Seats = Convert::ToInt($_REQUEST['Seats']);
                $vehicle->Description = $_REQUEST['Description'];
                $vehicle->Ac = Convert::ToBool($_REQUEST['Ac']);
                $vehicle->Automatic = Convert::ToBool($_REQUEST['Automatic']);
                $vehicle->Tv = Convert::ToBool($_REQUEST['Tv']);
                $vehicle->Fridge = Convert::ToBool($_REQUEST['Fridge']);
                $vehicle->Seatwarmer = Convert::ToBool($_REQUEST['Seatwarmer']);
                $vehicle->Cupholder = Convert::ToBool($_REQUEST['Cupholder']);
                $vehicle->Status = Convert::ToBool($_REQUEST['Status']);
                //$vehicle->Driver = new Driver($_REQUEST['Driver']);
                $vehicle->Milagecap = Convert::ToInt($_REQUEST['Milagecap']);
                $vehicle->Price = doubleval($_REQUEST['Price']);
                $vehicle->Extramilage = doubleval($_REQUEST['Extramilage']);
                $vehicle->State = ucwords(strtolower($_REQUEST['State']));
                $vehicle->City = ucwords(strtolower($_REQUEST['City']));

                $vehicle->Save();
                $ret->status = "success";
                $ret->data = $vehicle;
                $ret->message= "Vehicle added";
        }
        else
        {
            $ret->status = "access denied";
            $ret->message = "You do not have the required privilege to complete the operation";
        }
    }
    else
    {
        $ret->status = "login";
        $ret->data = "login";
    }
    echo json_encode($ret);
