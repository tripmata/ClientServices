<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Webfront->ReadAccess)
    {
        $property = new Property($_REQUEST['Propertyid']);
        $property->Status = Convert::ToBool($_REQUEST['status']);
        $property->Save();

        $ret->status = "success";
        $ret->data = null;
        $ret->message = "property status changed";
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