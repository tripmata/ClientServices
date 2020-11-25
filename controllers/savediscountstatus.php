<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Discount->ReadAccess)
        {
            $p = new Property($_REQUEST['property']);

            $discount = new Discount(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
            $discount->Initialize($_REQUEST['Discountid']);
            $discount->Status = Convert::ToBool($_REQUEST['status']);
            $discount->Save();

            $ret->status = "success";
            $ret->data = "";
            $ret->message = "Discount deleted";
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