<?php

    $ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Rooms->WriteAccess)
        {
            $p = new Property($_REQUEST['property']);
            $p->Taghandling = Convert::ToInt($_REQUEST['status']);
            $p->Save();

            $ret->status = "success";
            $ret->message = "settings saved";
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