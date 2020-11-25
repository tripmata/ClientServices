<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Messaging->ReadAccess)
    {
        $msg = new Message($GLOBALS['subscriber']);
        $msg->Initialize($_REQUEST['Messageid']);
        $msg->Status = Convert::ToBool($_REQUEST['status']);
        $msg->Save();


        $ret->status = "success";
        $ret->message = "Message has been retreived successfully";
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