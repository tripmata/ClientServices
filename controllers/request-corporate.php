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
            if($customer->Corporate == false)
            {
                if(Corporaterequest::FindRequest($customer) == null)
                {
                    $req = new Corporaterequest();
                    $req->Company = $_REQUEST['company'];
                    $req->Phone = $_REQUEST['phone'];
                    $req->Email = $_REQUEST['email'];
                    $req->State = $_REQUEST['state'];
                    $req->City = $_REQUEST['city'];
                    $req->Customer = $customer;
                    $req->Save();

                    $customer->Corporaterequest = true;
                    $customer->Save();

                    $ret = new stdClass();
                    $ret->status = "success";
                    $ret->message = "request places successfully";
                }
                else
                {
                    $ret->status = "exist";
                    $ret->message = "You have a pending request already in process";
                }
            }
            else
            {
                $ret->status = "exist";
                $ret->message = "You are a corporate member already";
            }
        }
        else
        {
            $ret->status = "access denied";
            $ret->message = "You do not have the required privilege to complete the operation";
        }
    }
    echo json_encode($ret);