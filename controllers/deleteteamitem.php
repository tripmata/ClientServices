<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Webfront->WriteAccess)
    {
        $team = new Team($GLOBALS['subscriber']);
        $team->Initialize($_REQUEST['teamId']);

        $team->Delete();

        $ret->status = "success";
        $ret->message = "Team item have been deleted";
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