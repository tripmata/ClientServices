<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Discount->ReadAccess)
    {
        $p = new Property($_REQUEST['property']);

        $coupon = new Coupon(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
        $coupon->Initialize($_REQUEST['Couponid']);
        $coupon->Delete();

        $ret->status = "success";
        $ret->data = "";
        $ret->message = "Coupon deleted";
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