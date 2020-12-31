<?php

$ret = new stdClass();


$ret->data = array();

if ($GLOBALS['user']->Id != "")
{
    
    if ($GLOBALS['user']->Role->Staff->ReadAccess)
    {
        $staff = new Staff($GLOBALS['subscriber']);
        $staff->Initialize($_REQUEST['staffid']);
        $ret->data = $staff;
        $ret->status = "success";
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