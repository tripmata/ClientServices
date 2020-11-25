<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Laundry->WriteAccess)
    {
        $laundry = new Laundry($GLOBALS['subscriber']);
        $laundry->Initialize($_REQUEST['Laundryid']);
        $laundry->Delete();

        $ret->status = "success";
        $ret->data = null;
        $ret->message = "Laundry item has been deleted";
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