<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Messaging->WriteAccess)
        {
            $customlist = new Contactcollection($GLOBALS['subscriber']);
            $customlist->Initialize($_REQUEST['id']);
            $customlist->Name = ucwords(strtolower($_REQUEST['name']));
            $customlist->Save();

            $ret->status = "success";
            $ret->message = "";
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