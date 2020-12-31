<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Messaging->ReadAccess)
    {
        $ret->data = array();

        $page = $_REQUEST['Page'];
        $perpage = $_REQUEST['Perpage'];
        $filter = $_REQUEST['Filter'];
        $filtervalue = $_REQUEST['Filtervalue'];

        $store = array();

        $ret->Page = $page;
        $ret->Perpage = $perpage;
        


        if($_REQUEST['tab'] == "all")
        {
            $store = Customer::Search($GLOBALS['subscriber'], $filtervalue);
            $store = array_merge($store, Staff::Search($GLOBALS['subscriber'], $filtervalue));
            $store = array_merge($store, Contact::Search($GLOBALS['subscriber'], $filtervalue));
            $store = array_merge($store, Message::Search($GLOBALS['subscriber'], $filtervalue));
            $store = array_merge($store, Guest::Search($GLOBALS['subscriber'], $filtervalue));
            $store = array_merge($store, Subguest::Search($GLOBALS['subscriber'], $filtervalue));
        }
        if($_REQUEST['tab'] == "customer")
        {
            $store = Customer::Search($GLOBALS['subscriber'], $filtervalue);
        }
        if($_REQUEST['tab'] == "guest")
        {
            $store = Guest::Search($GLOBALS['subscriber'], $filtervalue);
            $store = array_merge($store, Subguest::Search($GLOBALS['subscriber'], $filtervalue));
        }
        if($_REQUEST['tab'] == "staff")
        {
            $store = Staff::Search($GLOBALS['subscriber'], $filtervalue);
        }
        if($_REQUEST['tab'] == "subscribers")
        {
            $store = Contact::Search($GLOBALS['subscriber'], $filtervalue);
        }
        if($_REQUEST['tab'] == "messaging")
        {
            $store = Message::Search($GLOBALS['subscriber'], $filtervalue);
        }
        if($_REQUEST['tab'] == "custom")
        {
            $list = new Contactcollection($GLOBALS['subscriber']);
            $list->Initialize($_REQUEST['list']);
            $store = $list->Getitems();
        }
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

        $ret->status = "success";
        $ret->message = "Contact list retrieved successfully";
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