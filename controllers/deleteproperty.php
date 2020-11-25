<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Webfront->ReadAccess)
    {
        $property = new Property($_REQUEST['Propertyid']);
        $property->Delete();

        $ret->status = "success";
        $ret->data = null;
        $ret->message= "DONE";
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