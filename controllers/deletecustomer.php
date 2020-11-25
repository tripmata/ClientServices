<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Customers->WriteAccess)
    {
        $p = new Property($_REQUEST['property']);

        $customer = new Guest(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
        $customer->Initialize($_REQUEST['Customerid']);
        $customer->Delete();

        $ret->status = "success";
        $ret->data = "success";
        $ret->message = "Customer have been deleted";
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