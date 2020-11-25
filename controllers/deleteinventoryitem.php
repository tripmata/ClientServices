<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    $item = null;

    if(strtolower($_REQUEST['item_type']) == "bar_item")
    {
        if($GLOBALS['user']->Role->Bar->WriteAccess)
        {
            $item = new Baritem($GLOBALS['subscriber']);
            $item->Initialize($_REQUEST['itemid']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "kitchen_item")
    {
        if($GLOBALS['user']->Role->Kitchen->WriteAccess)
        {
            $item = new Kitchenitem($GLOBALS['subscriber']);
            $item->Initialize($_REQUEST['itemid']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "laundry_item")
    {
        if($GLOBALS['user']->Role->Laundry->WriteAccess)
        {
            $item = new Laundryitem($GLOBALS['subscriber']);
            $item->Initialize($_REQUEST['itemid']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "pastry_item")
    {
        if($GLOBALS['user']->Role->Bakery->WriteAccess)
        {
            $item = new Pastryitem($GLOBALS['subscriber']);
            $item->Initialize($_REQUEST['itemid']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "pool_item")
    {
        if($GLOBALS['user']->Role->Pool->WriteAccess)
        {
            $item = new Poolitem($GLOBALS['subscriber']);
            $item->Initialize($_REQUEST['itemid']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "room_item")
    {
        if($GLOBALS['user']->Role->Rooms->WriteAccess)
        {
            $item = new Roomitem($GLOBALS['subscriber']);
            $item->Initialize($_REQUEST['itemid']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "store_item")
    {
        if($GLOBALS['user']->Role->Store->WriteAccess)
        {
            $item = new Storeitem($GLOBALS['subscriber']);
            $item->Initialize($_REQUEST['itemid']);
        }
    }


    if ($item !== null)
    {
        $item->Delete();

        $ret->status = "success";
        $ret->message = "Inventory item deleted successfully";
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