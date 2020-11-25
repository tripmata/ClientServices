<?php

    $ret = new stdClass();

    if(isset($_SESSION['user_token']))
    {
        $sess = Session::Get($_SESSION['user_token']);

        $customer = new Customer($GLOBALS['subscriber']);
        $customer->Initialize($sess->User);

        if($customer->Id != "")
        {
            $ret->status = "success";
            $ret->message = "";
            $ret->data = [];

            $ret->withdrawable = 0;
            $ret->balance = 0;
            $ret->withdrawn = 0;
            $ret->earnings = 0;
            $ret->revenue = 0;
            $ret->available = 0;


            $type = strtolower($_REQUEST['filter']);

            if($type === "all")
            {
                $tr1 = Propertytransaction::byUser($customer);
                $tr2 = Vehicletransaction::byUser($customer);
                $tr3 = Leasetransaction::byUser($customer);

                $trr1 = Transactions::Breakdown($tr1);
                $trr2 = Transactions::Breakdown($tr2);
                $trr3 = Transactions::Breakdown($tr3);


            }
            else if($type === "properties")
            {

            }
            else if($type === "vehicles")
            {

            }
            else
            {

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