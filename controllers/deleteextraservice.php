<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Discount->ReadAccess)
    {
        $serv = new Extraservice($GLOBALS['subscriber']);
        $serv->Initialize($_REQUEST['Extraserviceid']);
        $serv->Delete();

        $ret->status = "success";
        $ret->message = "Extra service deleted successfully";
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
    $ret->data = "login & try again";
}

echo json_encode($ret);