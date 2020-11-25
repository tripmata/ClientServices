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
            $customer->Name = $_REQUEST['name'];
            $customer->Surname = $_REQUEST['sname'];
            $customer->Phone = $_REQUEST['phone'];
            $customer->Country = $_REQUEST['country'];
            $customer->City = $_REQUEST['city'];
            $customer->State = $_REQUEST['state'];
            $customer->Sex = $_REQUEST['gender'];

            $customer->Save();

            $ret->status = "success";
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