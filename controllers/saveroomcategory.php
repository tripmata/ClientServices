<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Rooms->WriteAccess)
        {
            $p = new Property($_REQUEST['property']);

            $roomcat = new Roomcategory(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
            $roomcat->Initialize($_REQUEST['roomcatid']);

            $roomcat->Sort = Convert::ToInt($_REQUEST['sort']);
            $roomcat->Description = $_REQUEST['description'];
            $roomcat->Name = $_REQUEST['name'];
            $roomcat->Compareat = floatval($_REQUEST['compare']);
            $roomcat->Features = explode(",", $_REQUEST['features']);
            $roomcat->Images = array();
            $images = explode(",", $_REQUEST['images']);
            for($i = 0; $i < count($images); $i++)
            {
                if($images[$i] != "")
                {
                    array_push($roomcat->Images, $images[$i]);
                }
            }
            $roomcat->Onsite = Convert::ToBool($_REQUEST['showonsite']);
            $roomcat->Price = floatval($_REQUEST['price']);
            $roomcat->Promotext = $_REQUEST['promotext'];
            $roomcat->Reservable = Convert::ToBool($_REQUEST['reservable']);
            $roomcat->Services = explode(",", $_REQUEST['services']);
            $roomcat->Showpromotion = Convert::ToBool($_REQUEST['showpromo']);
            $roomcat->Extraguestprice = floatval($_REQUEST['extrapersonprice']);
            $roomcat->Baseoccupancy = Convert::ToInt($_REQUEST['baseoccupancy']);
            $roomcat->Maxoccupancy = Convert::ToInt($_REQUEST['maxoccupancy']);
            $roomcat->Smokingpolicy = Convert::ToBool($_REQUEST['smoking']);
            $roomcat->Childrenpolicy = Convert::ToBool($_REQUEST['children']);
            $roomcat->Pets = Convert::ToBool($_REQUEST['pets']);
            $roomcat->Status = true;


            $roomcat->Save();


            $ret->status = "success";
            $ret->message = "Gallery item have been deleted";
            $ret->data = "success";
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