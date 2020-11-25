<?php

	$ret = new stdClass();

        if($GLOBALS['user']->Id != "")
        {
            $settings = null;

            if(strtolower($_REQUEST['item_type']) == "bar_item")
            {
                if($GLOBALS['user']->Role->Bar->ReadAccess)
                {
                    $settings = new Barsettings($GLOBALS['subscriber']);
                }
            }
            if(strtolower($_REQUEST['item_type']) == "kitchen_item")
            {
                if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                {
                    $settings = new Kitchensettings($GLOBALS['subscriber']);
                }
            }
            if(strtolower($_REQUEST['item_type']) == "laundry_item")
            {
                if($GLOBALS['user']->Role->Laundry->ReadAccess)
                {
                    $settings = new Laundrysettings($GLOBALS['subscriber']);
                }
            }
            if(strtolower($_REQUEST['item_type']) == "pastry_item")
            {
                if($GLOBALS['user']->Role->Bakery->ReadAccess)
                {
                    $settings = new Pastrysettings($GLOBALS['subscriber']);
                }
            }
            if(strtolower($_REQUEST['item_type']) == "pool_item")
            {
                if($GLOBALS['user']->Role->Pool->ReadAccess)
                {
                    $settings = new Poolsettings($GLOBALS['subscriber']);
                }
            }
            if(strtolower($_REQUEST['item_type']) == "room_item")
            {
                if($GLOBALS['user']->Role->Rooms->ReadAccess)
                {
                    $settings = new Roomsettings($GLOBALS['subscriber']);
                }
            }


            if($settings !== null)
            {
                $ret->data = $settings;

                $ret->status = "success";
                $ret->message = "settings have been saved successfully successfully";
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