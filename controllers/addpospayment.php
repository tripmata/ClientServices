<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    $transaction = null;
    $sale = null;

    if(strtolower($_REQUEST['item_type']) == "bar_item")
    {
        if($GLOBALS['user']->Role->Bar->ReadAccess)
        {
            $sale = new Barsale($GLOBALS['subscriber']);
            $transaction = new Bartransaction($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "kitchen_item")
    {
        if($GLOBALS['user']->Role->Kitchen->ReadAccess)
        {
            $sale = new Kitchensale($GLOBALS['subscriber']);
            $transaction = new Kitchentransaction($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "laundry_item")
    {
        if($GLOBALS['user']->Role->Laundry->ReadAccess)
        {
            $sale = new Laundrysale($GLOBALS['subscriber']);
            $transaction = new Laundrytransaction($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "pastry_item")
    {
        if($GLOBALS['user']->Role->Bakery->ReadAccess)
        {
            $sale = new Bakerysale($GLOBALS['subscriber']);
            $transaction = new Bakerytransaction($GLOBALS['subscriber']);
        }
    }
    if(strtolower($_REQUEST['item_type']) == "pool_item")
    {
        if($GLOBALS['user']->Role->Pool->ReadAccess)
        {
            $sale = new Poolsale($GLOBALS['subscriber']);
            $transaction = new Pooltransaction($GLOBALS['subscriber']);
        }
    }


    if($transaction !== null)
    {
        $sale->Initialize($_REQUEST['sale']);
        $sale->Paidamount += doubleval($_REQUEST['amount']);
        $sale->Save();

        $transaction->Sale = $sale;
        $transaction->Type = "credit";
        $transaction->Amount = doubleval($_REQUEST['amount']);
        $transaction->User = $_REQUEST['usersess'];
        $transaction->Text = "";
        $transaction->Method = $_REQUEST['method'];
        $transaction->Paytime = time();
        $transaction->Save();

        $ret->data = null;
        $ret->status = "success";
        $ret->message = "POS transaction added successfully";
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