<?php

$ret = new stdClass();

$ret->data = array();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Customers->ReadAccess)
    {
        $property = new Property($_REQUEST['property']);

        $ret->data = new Guest(new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword));
        $ret->data->Initialize($_REQUEST['customerid']);
        $ret->status = "success";
        $ret->message = "Customers data retrieved successfully";
    }
    else
    {
        $ret->status = "access denied";
        $ret->message = "You do not have the required privilage to complete the operation";
    }
}
else
{
    $ret->status = "login";
    $ret->data = "login";
}

echo json_encode($ret);