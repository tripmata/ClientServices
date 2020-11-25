<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Id == "adxc0")
        {
            $user = new User($GLOBALS['subscriber']);
            $user->Initialize($_REQUEST['Userid']);
            $user->Delete();

            $ret->status = "success";
            $ret->message = "Admin user deleted";
            $ret->data = "success";
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