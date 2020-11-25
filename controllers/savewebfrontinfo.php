<?php

	$ret = new stdClass();

        if($GLOBALS['user']->Id != "")
        {
            if($GLOBALS['user']->Role->Settings->WriteAccess)
            {
                $site = new Site();
                $site->Phone1 = $_REQUEST['phone1'];
                $site->Phone2 = $_REQUEST['phone2'];
                $site->Email1 = $_REQUEST['email1'];
                $site->Email2 = $_REQUEST['email2'];
                $site->Save();

                $ret->status = "success";
                $ret->message = "Settings saved successfully";
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