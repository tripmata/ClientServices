<?php

    $search = new Search();

    $search->City = $_REQUEST['city'];
    $search->Checkin = $_REQUEST['checkin'];
    $search->Checkout = $_REQUEST['checkout'];

    $search->Minprice = $_REQUEST['minprice'];
    $search->Maxprice = $_REQUEST['maxprice'];

    $search->Types = [];

    if(Convert::ToBool($_REQUEST['hotel']))
    {
        array_push($search->Types, "hotel");
    }
    if(Convert::ToBool($_REQUEST['bandb']))
    {
        array_push($search->Types, "bandb");
    }
    if(Convert::ToBool($_REQUEST['apartment']))
    {
        array_push($search->Types, "apartment");
    }
    if(Convert::ToBool($_REQUEST['condor']))
    {
        array_push($search->Types, "condor");
    }
    if(Convert::ToBool($_REQUEST['studio']))
    {
        array_push($search->Types, "studio");
    }
    if(Convert::ToBool($_REQUEST['boutique']))
    {
        array_push($search->Types, "boutique");
    }

    $search->Partialpay = Convert::ToBool($_REQUEST['partialpay']);
    $search->Cancellation = Convert::ToBool($_REQUEST['cancellation']);
    $search->Earlycheckout = Convert::ToBool($_REQUEST['earlycheckout']);
    $search->Cashonly = Convert::ToBool($_REQUEST['cashonly']);
    $search->Damagedeposit = Convert::ToBool($_REQUEST['damagedeposit']);

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

    $search->Star_1 = Convert::ToBool($_REQUEST['star1']);
    $search->Star_2 = Convert::ToBool($_REQUEST['star2']);
    $search->Star_3 = Convert::ToBool($_REQUEST['star3']);
    $search->Star_4 = Convert::ToBool($_REQUEST['star4']);
    $search->Star_5 = Convert::ToBool($_REQUEST['star5']);


    $search->Rate1 = Convert::ToBool($_REQUEST['rating1']);
    $search->Rate2 = Convert::ToBool($_REQUEST['rating2']);
    $search->Rate3 = Convert::ToBool($_REQUEST['rating3']);
    $search->Rate4 = Convert::ToBool($_REQUEST['rating4']);
    $search->Rate5 = Convert::ToBool($_REQUEST['rating5']);

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "hotel list retrieved";
    $ret->data = $search->Filter();

    echo json_encode($ret);