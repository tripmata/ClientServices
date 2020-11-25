<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Messaging->ReadAccess)
    {
        $list = new Contactcollection($GLOBALS['subscriber']);
        $list->Initialize($_REQUEST['Contactcollectionid']);
        $list->Delete();

        $ret->status = "success";
        $ret->message = "Custom contact list deleted successfully";
        $ret->data = null;
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