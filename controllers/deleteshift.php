<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    

    if ($GLOBALS['user']->Role->Staff->WriteAccess)
    {
        $shift = new Shift($GLOBALS['subscriber']);
        $shift->Initialize($_REQUEST['Shiftid']);
        $shift->Delete();

        $ret->status = "success";
        $ret->data = "success";
        $ret->message = "Shift have been deleted";
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