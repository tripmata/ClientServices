<?php

	$ret = new stdClass();

    $customer = new Customer($GLOBALS['subscriber']);

    if(Customer::isLoggedin($customerid))
    {
        $customer->Initialize($customerid);
    }

    if($customer->Id != "")
    {
        $customer->Profilepic = $_REQUEST['img'];
        $customer->Save();

        $ret->status = "success";
        $ret->message = "Profile picture updated successfully";
    }
    else
    {
        $ret->status = "failed";
        $ret->message = "Invalid customer account";
        Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "User Account", "Attempt to update user profile image");
    }

	echo json_encode($ret);