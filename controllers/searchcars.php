<?php

    $search = new Carsearch();

    $search->City = $_REQUEST['city'];
    $search->Checkin = $_REQUEST['pickup'];
    $search->Checkout = $_REQUEST['dropoff'];

    $search->Minprice = $_REQUEST['minprice'];
    $search->Maxprice = $_REQUEST['maxprice'];

    $search->Types = [];

    if(Convert::ToBool($_REQUEST['sedan']))
    {
        array_push($search->Types, "sedan");
    }
    if(Convert::ToBool($_REQUEST['suv']))
    {
        array_push($search->Types, "suv");
    }
    if(Convert::ToBool($_REQUEST['station_wagon']))
    {
        array_push($search->Types, "station_wagon");
    }
    if(Convert::ToBool($_REQUEST['hatch_back']))
    {
        array_push($search->Types, "hatch_back");
    }
    if(Convert::ToBool($_REQUEST['truck']))
    {
        array_push($search->Types, "truck");
    }
    if(Convert::ToBool($_REQUEST['van']))
    {
        array_push($search->Types, "van");
    }
    if(Convert::ToBool($_REQUEST['small']))
    {
        array_push($search->Types, "small");
    }
    if(Convert::ToBool($_REQUEST['sports']))
    {
        array_push($search->Types, "sports");
    }
    if(Convert::ToBool($_REQUEST['electric']))
    {
        array_push($search->Types, "electric");
    }
    if(Convert::ToBool($_REQUEST['motocycle']))
    {
        array_push($search->Types, "motocycle");
    }
    if(Convert::ToBool($_REQUEST['convertible']))
    {
        array_push($search->Types, "convertible");
    }

    /*
    $search->Partialpay = Convert::ToBool($_REQUEST['partialpay']);
    $search->Cancellation = Convert::ToBool($_REQUEST['cancellation']);
    $search->Earlycheckout = Convert::ToBool($_REQUEST['earlycheckout']);
    $search->Cashonly = Convert::ToBool($_REQUEST['cashonly']);
    $search->Damagedeposit = Convert::ToBool($_REQUEST['damagedeposit']);
    */

    $search->Policies = [];

    $p = explode(",", $_REQUEST['policies']);
    for($i = 0; $i < count($p); $i++)
    {
        if($p[$i] != "")
        {
            array_push($search->Policies, $p[$i]);
        }
    }

    $search->Facilities = [];
    $f = explode(",", $_REQUEST['facilities']);

    for($i = 0; $i < count($f); $i++)
    {
        if($f[$i] != "")
        {
            array_push($search->Facilities, $f[$i]);
        }
    }


    /*
    $search->Rate1 = Convert::ToBool($_REQUEST['rating1']);
    $search->Rate2 = Convert::ToBool($_REQUEST['rating2']);
    $search->Rate3 = Convert::ToBool($_REQUEST['rating3']);
    $search->Rate4 = Convert::ToBool($_REQUEST['rating4']);
    $search->Rate5 = Convert::ToBool($_REQUEST['rating5']);
    */

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "vehicle list retrieved";
    $ret->data = $search->Filter();

    echo json_encode($ret);