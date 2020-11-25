<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    

    if($GLOBALS['user']->Role->Pool->WriteAccess)
    {
        $pool = new Pool($GLOBALS['subscriber']);
        $pool->Initialize($_REQUEST['id']);
        $pool->Status = Convert::ToBool($_REQUEST['status']);
        $pool->Save();

        $ret->status = "success";
        $ret->data = null;
        $ret->message = "Pool session status successfully";
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