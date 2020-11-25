<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Webfront->ReadAccess)
        {
            $ret->data = new stdClass();
            $ret->data->List = Theme::All();
            $ret->data->Current = new Theme($GLOBALS['subscriber']->ClientTheme);
            $ret->data->Current->Name = ucwords($ret->data->Current->Name);
            $ret->status = "success";
            $ret->message = "Themes successfully retrieved";
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