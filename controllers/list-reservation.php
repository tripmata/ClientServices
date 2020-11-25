<?php

    $ret = new stdClass();
    $ret->status = "login";
    $ret->message = "login and try again";

    if(isset($_SESSION['user_token']))
    {
        $sess = Session::Get($_SESSION['user_token']);

        $customer = new Customer($GLOBALS['subscriber']);
        $customer->Initialize($sess->User);

        if ($customer->Id != "")
        {
            $ret->data = Reservation::ByCustomer($customer);
            $ret->status = "success";
        }
        else
        {
            $ret->status = "access denied";
            $ret->message = "You do not have the required privilege to complete the operation";
        }
    }
    echo json_encode($ret);