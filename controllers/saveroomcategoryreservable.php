<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Rooms->WriteAccess)
        {
            $p = new Property($_REQUEST['property']);

            $roomcat = new Roomcategory(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));

            $roomcat->Initialize($_REQUEST['Roomcategoryid']);
            $roomcat->Reservable = Convert::ToBool($_REQUEST['Reservable']);
            $roomcat->Save();

            $ret->status = "success";
            $ret->message = "room category status has been changed";
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