<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Id == "adxc0")
        {
            $user = new User($GLOBALS['subscriber']);
            $GLOBALS['user']->Initialize($_REQUEST['userid']);
            $GLOBALS['user']->Status = Convert::ToBool($_REQUEST['status']);
            $GLOBALS['user']->Save();

            $ret->status = "success";
            $ret->message = "Admin user's status changed successfully";
            $ret->data = null;
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