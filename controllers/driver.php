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
            $store = Driver::Order($filtervalue);
        }

        if($filter == "search list")
        {
            $store = Driver::Search($filtervalue);
        }

        $field = "";

        if($filter == "filter by name")
        {
            $store = Driver::Filter($filtervalue, "name");
        }
        if($filter == "filter by surname")
        {
            $store = Driver::Filter($filtervalue, "surname");
        }
        if($filter == "filter by phone")
        {
            $store = Driver::Filter($filtervalue, "phone");
        }
        if($filter == "filter by email")
        {
            $store = Driver::Filter($filtervalue, "email");
        }
        if($filter == "filter by password")
        {
            $store = Driver::Filter($filtervalue, "password");
        }
        if($filter == "filter by profilepic")
        {
            $store = Driver::Filter($filtervalue, "profilepic");
        }
        if($filter == "filter by gender")
        {
            $store = Driver::Filter($filtervalue, "gender");
        }
        if($filter == "filter by dob")
        {
            $store = Driver::Filter($filtervalue, "dob");
        }
        if($filter == "filter by address")
        {
            $store = Driver::Filter($filtervalue, "address");
        }
        if($filter == "filter by city")
        {
            $store = Driver::Filter($filtervalue, "city");
        }
        if($filter == "filter by state")
        {
            $store = Driver::Filter($filtervalue, "state");
        }
        if($filter == "filter by available")
        {
            $store = Driver::Filter($filtervalue, "available");
        }
        if($filter == "filter by status")
        {
            $store = Driver::Filter($filtervalue, "status");
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
	
