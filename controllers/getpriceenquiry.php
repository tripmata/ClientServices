<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        $quotation = null;

        if(strtolower($_REQUEST['item_type']) == "bar_item")
        {
            if($GLOBALS['user']->Role->Bar->WriteAccess)
            {
                $quotation = new Barquotation($GLOBALS['subscriber']);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
        {
            if($GLOBALS['user']->Role->Kitchen->WriteAccess)
            {
                $quotation = new Kitchenquotation($GLOBALS['subscriber']);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "laundry_item")
        {
            if($GLOBALS['user']->Role->Laundry->WriteAccess)
            {
                $quotation = new Laundryquotation($GLOBALS['subscriber']);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "pastry_item")
        {
            if($GLOBALS['user']->Role->Bakery->WriteAccess)
            {
                $quotation = new Pastryquotation($GLOBALS['subscriber']);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "pool_item")
        {
            if($GLOBALS['user']->Role->Pool->WriteAccess)
            {
                $quotation = new Poolquotation($GLOBALS['subscriber']);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "room_item")
        {
            if($GLOBALS['user']->Role->Rooms->WriteAccess)
            {
                $quotation = new Roomquotation($GLOBALS['subscriber']);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "store_item")
        {
            if($GLOBALS['user']->Role->Store->WriteAccess)
            {
                $quotation = new Storequotation($GLOBALS['subscriber']);
            }
        }


        if($quotation !== null)
        {
            $quotation->Initialize($_REQUEST['quotid']);

            $ret->data = $quotation;
            $ret->status = "success";
            $ret->message = "Price enquiry retrieved successfully";
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