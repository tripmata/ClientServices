<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Booking->ReadAccess)
    {
        $event = new Eventlistener($GLOBALS['subscriber']);
        $event->Initialize($_REQUEST['Eventlistenerid']);
        $event->Delete();

        $ret->status = "success";
        $ret->data = null;
        $ret->message = "Event deleted successfully";
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