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
            $site = new Site($GLOBALS['subscriber']);

            if((($customer->Bank === "") && ($customer->Accountnumber === "") && ($customer->Accountname === "")) || ($site->Customersaddress))
            {
                $customer->Bank = $_REQUEST['bank'];
                $customer->Accountname = $_REQUEST['accountName'];
                $customer->Accountnumber = $_REQUEST['accountNumber'];

                $customer->Save();

                $ret->status = "success";
                $ret->changeStatus = false;// $site->Customersaddress;
            }
            else
            {
                $ret->status = "failed";
                $ret->message = "Unable to save bank account details";
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