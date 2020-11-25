<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Webfront->WriteAccess)
    {
        $ret->data = new Banner($GLOBALS['subscriber']);
        $ret->data->Initialize($_REQUEST['banner']);

        $ret->status = "success";
        $ret->message = "Banner was returned successfully";
    }
    else
    {
        $ret->status = "access denied";
        $ret->message = "You do not have the required privilage to complete the operation";
    }
}
else
{
    $ret->status = "login";
    $ret->data = "login";
}

echo json_encode($ret);