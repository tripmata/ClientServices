<?php

    $ret = new stdClass();

    if ($GLOBALS['user']->Id != "")
    {
        if ($GLOBALS['user']->Role->Webfront->ReadAccess)
        {
            $page = $_REQUEST['Page'];
            $perpage = $_REQUEST['Perpage'];
            $filter = $_REQUEST['Filter'];
            $filtervalue = $_REQUEST['Filtervalue'];

            $store = array();

            $ret->data = [];

            $ret->Page = $page;
            $ret->Perpage = $perpage;

            if($filter == "sort by")
            {
                $store = Vehicle::Order($filtervalue);
            }

            if($filter == "search list")
            {
                $store = Vehicle::Search($filtervalue);
            }

            $field = "";


            if($filter == "filter by type")
            {
                $store = Vehicle::Filter($filtervalue, "type");
            }
            if($filter == "filter by model")
            {
                $store = Vehicle::Filter($filtervalue, "model");
            }
            if($filter == "filter by color")
            {
                $store = Vehicle::Filter($filtervalue, "color");
            }
            if($filter == "filter by seats")
            {
                $store = Vehicle::Filter($filtervalue, "seats");
            }
            if($filter == "filter by description")
            {
                $store = Vehicle::Filter($filtervalue, "description");
            }
            if($filter == "filter by ac")
            {
                $store = Vehicle::Filter($filtervalue, "ac");
            }
            if($filter == "filter by automatic")
            {
                $store = Vehicle::Filter($filtervalue, "automatic");
            }
            if($filter == "filter by tv")
            {
                $store = Vehicle::Filter($filtervalue, "tv");
            }
            if($filter == "filter by fridge")
            {
                $store = Vehicle::Filter($filtervalue, "fridge");
            }
            if($filter == "filter by seatwarmer")
            {
                $store = Vehicle::Filter($filtervalue, "seatwarmer");
            }
            if($filter == "filter by cupholder")
            {
                $store = Vehicle::Filter($filtervalue, "cupholder");
            }
            if($filter == "filter by status")
            {
                $store = Vehicle::Filter($filtervalue, "status");
            }
            if($filter == "filter by driver")
            {
                $store = Vehicle::Filter($filtervalue, "driver");
            }
            if($filter == "filter by price")
            {
                $store = Vehicle::Filter($filtervalue, "price");
            }
            if($filter == "filter by extramilage")
            {
                $store = Vehicle::Filter($filtervalue, "extramilage");
            }
            if($filter == "filter by milagecap")
            {
                $store = Vehicle::Filter($filtervalue, "milagecap");
            }

            $ret->status = "success";
            $ret->Total = count($store);
            $start = (($ret->Page - 1) * $ret->Perpage);
            $stop = (($start + $ret->Perpage) - 1);

            $x = 0;

            for($i = $start; $i < count($store); $i++)
            {
                $r = new stdClass();
                $r->Vehicle = $store[$i];

                $ret->data[$x] = $r;
                if($i == $stop){break;}
                $x++;
            }
            $ret->Message= "DONE";
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
