<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Webfront->ReadAccess)
    {
        $driver = new Driver($_REQUEST['Driverid']);
        $driver->Status = Convert::ToBool($_REQUEST['status']);
        $driver->Save();

        $ret->status = "success";
        $ret->data = null;
        $ret->message = "driver status changed";
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