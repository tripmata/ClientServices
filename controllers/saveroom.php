<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Rooms->WriteAccess)
        {
            $p = new Property($_REQUEST['property']);

            $room = new Room(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
            $room->Initialize($_REQUEST['roomid']);

            $room->Number = $_REQUEST['number'];
            $room->Category = $_REQUEST['category'];
            $room->Status = Convert::ToBool($_REQUEST['status']);

            $room->Features = [];

            $fs = explode(",", $_REQUEST['features']);

            for($i = 0; $i < count($fs); $i++)
            {
                if($fs[$i] != "")
                {
                    array_push($room->Features, $fs[$i]);
                }
            }

            if(($room->Id == "") && (Room::Exist($GLOBALS['subscriber'], $_REQUEST['number'], $_REQUEST['category'], $_REQUEST['property'])))
            {
                $ret->status = "failed";
                $ret->message = "Room exist already";
            }
            else
            {
                $room->Save();

                $ret->status = "success";
                $ret->data = "success";
                $ret->message = "Room has been saved";
            }
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