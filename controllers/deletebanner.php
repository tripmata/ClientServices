<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    
    if($GLOBALS['user']->Role->Webfront->WriteAccess)
    {
        $banner = new Banner($GLOBALS['subscriber']);
        $banner->Initialize($_REQUEST['Bannerid']);
        $banner->Delete();

        $ret->status = "success";
        $ret->message = "Banner was successfully deleted";
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