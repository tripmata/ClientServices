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
            if($customer->GetPassword() == md5($_REQUEST['old']))
            {
                $customer->SetPassword(md5($_REQUEST['newpassword']));
                $customer->Save();

                $ret->status = "success";
                $ret->message = "customers password set";
            }
            else
            {
                $ret->status = "failed";
                $ret->message = "incorrect old password";
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
        $ret->data = "login";
    }
    echo json_encode($ret);