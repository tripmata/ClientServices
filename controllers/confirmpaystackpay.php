<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    
    if ( ($GLOBALS['user']->Role->Barpos->ReadAccess)
        || ($GLOBALS['user']->Role->Kitchenpos->ReadAccess) || ($GLOBALS['user']->Role->Laundrypos->ReadAccess)
        || ($GLOBALS['user']->Role->Bakerypos->ReadAccess) || ($GLOBALS['user']->Role->Poolpos->ReadAccess) )
    {
        if(isset($_REQUEST['reference']))
        {
            if(Paygateway::confirmPaystackPayment($GLOBALS['subscriber'], $_REQUEST['reference']) === true)
            {
                $ret->data = null;
                $ret->status = "success";
                $ret->message = "Payment was successful";
            }
            else
            {
                $ret->data = null;
                $ret->status = "failed";
                $ret->message = "Payment failed";
            }
        }
        else
        {
            $ret->data = null;
            $ret->status = "failed";
            $ret->message = "Invalid payment";
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
    $ret->data = "login & try again";
}

echo json_encode($ret);

