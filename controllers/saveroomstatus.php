<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Rooms->WriteAccess)
        {
            $p = new Property($_REQUEST['property']);

            $room = new Room(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
            $room->Initialize($_REQUEST['Roomid']);

            $room->Status = Convert::ToBool($_REQUEST['Status']);
            $room->Save();

            $ret->status = "success";
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