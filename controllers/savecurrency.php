<?php

	$ret = new stdClass();

        if($GLOBALS['user']->Id != "")
        {
            if($GLOBALS['user']->Role->Webconfig->WriteAccess)
            {
                $site = new Site();
                $ret->data = Currency::ByCode($_REQUEST['currency']);
                $site->Currency = $ret->data;
                $site->Save();

                $ret->status = "success";
                $ret->message = "Currency saved successfully";
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