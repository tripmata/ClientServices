<?php

    //do delay
    for($i = 0; $i < 99999999; $i++) {}

    $ret = new stdClass();

    if (isset($_SESSION['user_token']))
    {
        $sess = Session::Get($_SESSION['user_token']);

        $customer = new Customer($GLOBALS['subscriber']);
        $customer->Initialize($sess->User);

        if ($customer->Id != "")
        {
            $ret->status = "success";
            $ret->data = Vehicle::ByCustomer($customer);
            $ret->message = "Property saved successfully";
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
