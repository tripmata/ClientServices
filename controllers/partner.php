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


            $ret->data = array();

            $store = array();

            $ret->Page = $page;
            $ret->Perpage = $perpage;

            if($filter == "sort by")
            {
                $store = Partner::Order($filtervalue);
            }

            if($filter == "search list")
            {
                $store = Partner::Search($filtervalue);
            }

            $field = "";

            if($filter == "filter by salutation")
            {
                $store = Partner::Filter($filtervalue, "salutation");
            }
            if($filter == "filter by name")
            {
                $store = Partner::Filter($filtervalue, "name");
            }
            if($filter == "filter by surname")
            {
                $store = Partner::Filter($filtervalue, "surname");
            }
            if($filter == "filter by phone")
            {
                $store = Partner::Filter($filtervalue, "phone");
            }
            if($filter == "filter by email")
            {
                $store = Partner::Filter($filtervalue, "email");
            }
            if($filter == "filter by password")
            {
                $store = Partner::Filter($filtervalue, "password");
            }
            if($filter == "filter by profilepic")
            {
                $store = Partner::Filter($filtervalue, "profilepic");
            }
            if($filter == "filter by gender")
            {
                $store = Partner::Filter($filtervalue, "gender");
            }
            if($filter == "filter by country")
            {
                $store = Partner::Filter($filtervalue, "country");
            }
            if($filter == "filter by state")
            {
                $store = Partner::Filter($filtervalue, "state");
            }
            if($filter == "filter by city")
            {
                $store = Partner::Filter($filtervalue, "city");
            }
            if($filter == "filter by address")
            {
                $store = Partner::Filter($filtervalue, "address");
            }
            if($filter == "filter by status")
            {
                $store = Partner::Filter($filtervalue, "status");
            }

            $ret->status = "success";
            $ret->Total = count($store);
            $start = (($ret->Page - 1) * $ret->Perpage);
            $stop = (($start + $ret->Perpage) - 1);

            $x = 0;

            for($i = $start; $i < count($store); $i++)
            {
                $ret->data[$x] = $store[$i];
                if($i == $stop){break;}
                $x++;
            }
            $ret->message= "";
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
