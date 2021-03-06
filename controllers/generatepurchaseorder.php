<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    $pr = null;

    if(strtolower($_REQUEST['item_type']) == "bar_item")
    {
        if($GLOBALS['user']->Role->Bar->WriteAccess)
        {
            $pr = new Barpr($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "kitchen_item")
    {
        if($GLOBALS['user']->Role->Kitchen->WriteAccess)
        {
            $pr = new Kitchenpr($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "laundry_item")
    {
        if($GLOBALS['user']->Role->Laundry->WriteAccess)
        {
            $pr = new Laundrypr($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "pastry_item")
    {
        if($GLOBALS['user']->Role->Bakery->WriteAccess)
        {
            $pr = new Pastrypr($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "pool_item")
    {
        if($GLOBALS['user']->Role->Pool->WriteAccess)
        {
            $pr = new Poolpr($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "room_item")
    {
        if($GLOBALS['user']->Role->Rooms->WriteAccess)
        {
            $pr = new Roompr($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "store_item")
    {
        if($GLOBALS['user']->Role->Store->WriteAccess)
        {
            $pr = new Storepr($GLOBALS['subscriber']);
        }
    }


    if($pr !== null)
    {
        $pr->Initialize($_REQUEST['prid']);

        $items = [];
        $it = explode(",", $_REQUEST['items']);

        for($i = 0; $i < count($it); $i++)
        {
            if ($it[$i] != "")
            {
                $sp = explode(":", $it[$i]);

                if (count($sp) === 2)
                {
                    $std = new stdClass();
                    $std->item = $sp[0];
                    $std->supplier = $sp[1];
                    array_push($items, $std);
                }
            }
        }

        $ret->data = $pr->GenerateOrder($items, $_REQUEST['usersess']);

        $ret->status = "success";
        $ret->message = "Purchase request generated successfully";
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