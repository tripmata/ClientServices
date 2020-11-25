<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Webfront->WriteAccess)
    {
        $facility = new Facilities($GLOBALS['subscriber']);
        $facility->Initialize($_REQUEST['facilityId']);
        $facility->Delete();

        $ret->status = "success";
        $ret->message = "Facility item have been deleted";
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