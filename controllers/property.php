<?php

        $ret = new stdClass();

        if($GLOBALS['user']->Id != "")
        {
            if($GLOBALS['user']->Role->Webfront->ReadAccess)
            {

            $page = $_REQUEST['Page'];
            $perpage = $_REQUEST['Perpage'];
            $filter = $_REQUEST['Filter'];
            $filtervalue = $_REQUEST['Filtervalue'];


            $ret->data = array();


            $store = array();

            $ret->Page = $page;
            $ret->Perpage = $perpage;

            if($filter == "sort by")
            {
                $store = Property::Order($filtervalue);
            }

            if($filter == "search list")
            {
                $store = Property::Search($filtervalue, true);
            }

            $field = "";

            if($filter == "filter by name")
            {
                $store = Property::Filter($filtervalue, "name");
            }
            if($filter == "filter by phone1")
            {
                $store = Property::Filter($filtervalue, "phone1");
            }
            if($filter == "filter by phone2")
            {
                $store = Property::Filter($filtervalue, "phone2");
            }
            if($filter == "filter by email1")
            {
                $store = Property::Filter($filtervalue, "email1");
            }
            if($filter == "filter by email2")
            {
                $store = Property::Filter($filtervalue, "email2");
            }
            if($filter == "filter by type")
            {
                $store = Property::Filter($filtervalue, "type");
            }
            if($filter == "filter by state")
            {
                $store = Property::Filter($filtervalue, "state");
            }
            if($filter == "filter by city")
            {
                $store = Property::Filter($filtervalue, "city");
            }
            if($filter == "filter by owner")
            {
                $store = Property::Filter($filtervalue, "owner");
            }
            if($filter == "filter by description")
            {
                $store = Property::Filter($filtervalue, "description");
            }
            if($filter == "filter by address")
            {
                $store = Property::Filter($filtervalue, "address");
            }
            if($filter == "filter by tandc")
            {
                $store = Property::Filter($filtervalue, "tandc");
            }
            if($filter == "filter by images")
            {
                $store = Property::Filter($filtervalue, "images");
            }
            if($filter == "filter by wifi")
            {
                $store = Property::Filter($filtervalue, "wifi");
            }
            if($filter == "filter by parking")
            {
                $store = Property::Filter($filtervalue, "parking");
            }
            if($filter == "filter by gym")
            {
                $store = Property::Filter($filtervalue, "gym");
            }
            if($filter == "filter by restaurant")
            {
                $store = Property::Filter($filtervalue, "restaurant");
            }
            if($filter == "filter by bar")
            {
                $store = Property::Filter($filtervalue, "bar");
            }
            if($filter == "filter by security")
            {
                $store = Property::Filter($filtervalue, "security");
            }
            if($filter == "filter by status")
            {
                $store = Property::Filter($filtervalue, "status");
            }

            $ret->status = "success";
            $ret->Total = count($store);
            $start = (($ret->Page - 1) * $ret->Perpage);
            $stop = (($start + $ret->Perpage) - 1);

            $x = 0;

            for($i = $start; $i < count($store); $i++)
            {
                $r = new stdClass();
                $r->Property = $store[$i];
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

