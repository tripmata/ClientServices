<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Messaging->WriteAccess)
    {
        $contact = new Contact($GLOBALS['subscriber']);
        $contact->Initialize($_REQUEST['Contactid']);
        $contact->Delete();

        $ret->status = "success";
        $ret->message = "Contact deleted successfully";
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