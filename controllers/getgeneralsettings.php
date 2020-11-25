<?php

	$ret = new stdClass();

        if($GLOBALS['user']->Id != "")
        {
            if($GLOBALS['user']->Role->Settings->ReadAccess)
            {
                $site = new Site($GLOBALS['subscriber']);

                $ret->data = new stdClass();
                $ret->data->Logo = $GLOBALS['subscriber']->Logo;
                $ret->data->Name = $GLOBALS['subscriber']->BusinessName;
                $ret->data->Email1 = $GLOBALS['subscriber']->Email1;
                $ret->data->Email2 = $GLOBALS['subscriber']->Email2;
                $ret->data->Phone1 = $GLOBALS['subscriber']->Phone1;
                $ret->data->Phone2 = $GLOBALS['subscriber']->Phone2;
                $ret->data->City = $GLOBALS['subscriber']->City;
                $ret->data->State = $GLOBALS['subscriber']->State;
                $ret->data->Country = $GLOBALS['subscriber']->Country;
                $ret->data->Address = $GLOBALS['subscriber']->Address;
                $ret->data->Site = new Site($GLOBALS['subscriber']);
                $ret->status = "success";
                $ret->message = "logo saved";
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