<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Booking->ReadAccess)
    {
        $property = new Property($_REQUEST['property']);

        $ret->data = Reservation::get($property, $_REQUEST['reservation']);
        $ret->status = "success";
        $ret->message = "Reservation has been deleted";
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