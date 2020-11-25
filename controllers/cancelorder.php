<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    

    $order = null;

    if(strtolower($_REQUEST['item_type']) == "bar_item")
    {
        if($GLOBALS['user']->Role->Barpos->ReadAccess)
        {
            $order = new Barorder($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "kitchen_item")
    {
        if($GLOBALS['user']->Role->Kitchenpos->ReadAccess)
        {
            $order = new Kitchenorder($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "laundry_item")
    {
        if($GLOBALS['user']->Role->Laundrypos->ReadAccess)
        {
            $order = new Laundryorder($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "pastry_item")
    {
        if($GLOBALS['user']->Role->Bakerypos->ReadAccess)
        {
            $order = new Bakeryorder($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "pool_item")
    {
        if($GLOBALS['user']->Role->Poolpos->ReadAccess)
        {
            $order = new Poolorder($GLOBALS['subscriber']);
        }
    }


    if($order !== null)
    {
        $ret->data = null;

        $order->Initialize($_REQUEST['order']);
        $order->Delete();

        $ret->status = "success";
        $ret->message = "online orders deleted successfully";
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