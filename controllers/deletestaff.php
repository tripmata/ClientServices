<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Staff->WriteAccess)
    {
        $staff = new Staff($GLOBALS['subscriber']);
        $staff->Initialize($_REQUEST['Staffid']);
        $staff->Delete();

        $ret->status = "success";
        $ret->data = "success";
        $ret->message = "Staff have been deleted";
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