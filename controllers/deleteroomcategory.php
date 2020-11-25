<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Rooms->WriteAccess)
    {
        $roomcat = new Roomcategory($GLOBALS['subscriber']);
        $roomcat->Initialize($_REQUEST['Roomcategoryid']);
        $roomcat->Delete();

        $ret->status = "success";
        $ret->message = "room category has been deleted";
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