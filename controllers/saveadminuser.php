<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Id == "adxc0")
        {
            $nuser = new User($GLOBALS['subscriber']);
            $GLOBALS['user']->Initialize($_REQUEST['userid']);

            if(!$GLOBALS['user']->Exist($_REQUEST['username']) || ($GLOBALS['user']->Id != ""))
            {
                $names = explode(" ", trim($_REQUEST['name']));
                $nuser->Role = $_REQUEST['role'];
                $nuser->Staffid = $_REQUEST['staffid'];
                if($nuser->Id === "")
                {
                    $nuser->setPassword($_REQUEST['password']);
                }
                $nuser->Status = true;
                $nuser->Username = $_REQUEST['username'];
                $nuser->Name = trim($names[0]);
                if(count($names) > 1)
                {
                    $nuser->Surname = trim($names[(count($names) - 1)]);
                }

                if($GLOBALS['property'] != null)
                {
                    $nuser->Property = $GLOBALS['property'];
                }
                $nuser->Save();

                $ret->status = "success";
                $ret->message = "Username exist already";
                $ret->data = "success";
            }
            else
            {
                $ret->status = "failed";
                $ret->message = "Username exist already";
            }


            $ret->status = "success";
            $ret->data = "success";
            $ret->message = "admin user saved";
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