<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    

    if ($GLOBALS['user']->Role->Booking->ReadAccess)
    {
        $event = new Messageschedule($GLOBALS['subscriber']);
        $event->Initialize($_REQUEST['Messagescheduleid']);
        $event->Delete();

        $ret->status = "success";
        $ret->data = null;
        $ret->message = "Message schedule deleted successfully";
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