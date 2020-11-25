<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Messaging->ReadAccess)
    {
        $ret->data = Mail::ConfirmIntegrity($GLOBALS['subscriber']);
        $ret->status = "success";
        $ret->message = "";
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