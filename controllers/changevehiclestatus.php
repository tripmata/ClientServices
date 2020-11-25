<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Webfront->ReadAccess)
    {
        $vehicle = new Vehicle($_REQUEST['Vehicleid']);
        $vehicle->Status = Convert::ToBool($_REQUEST['status']);
        $vehicle->Save();

        $ret->status = "success";
        $ret->data = null;
        $ret->message = "vehicle status changed";
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