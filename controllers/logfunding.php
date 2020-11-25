<?php

    $ret = new stdClass();

    if(isset($_SESSION['user_token']))
    {
        $sess = Session::Get($_SESSION['user_token']);

        $customer = new Customer($GLOBALS['subscriber']);
        $customer->Initialize($sess->User);

        if($customer->Id != "")
        {
            $method = $_REQUEST['method'];

            if($method === "card")
            {
                if($_REQUEST['gateway'] == "paystack")
                {
                    $gateWay = new Paygateway($GLOBALS['subscriber']);

                    $ret->status = "success";
                    $ret->data = new stdClass();
                    $ret->data->Currency = $GLOBALS['subscriber']->Currency->Code;
                    $ret->data->Amount = (($_REQUEST['amount']) * 100);
                    $ret->data->Email = $customer->Email;
                    $ret->data->Key = $gateWay->Paystackpublic;
                    $ret->Method = "PAYSTACK";
                    $ret->data->Ref = Random::GenerateId(10);
                }
                else
                {
                    $ret->status = "success";
                }
            }
            else if($method === "transfer")
            {
                $req = new Fundingrequest();
                $req->Customer = $customer;
                $req->Method = "transfer";
                $req->Amount = doubleval($_REQUEST['amount']);
                $req->Accountname = $_REQUEST['name'];

                $req->Save();
                $req->Created = new WixDate(time());

                $ret->status = "success";
                $ret->data = $req;
                $ret->message = "request saved successfully";
            }
            else
            {
                $req = new Fundingrequest();
                $req->Customer = $customer;
                $req->Method = "deposit";
                $req->Amount = doubleval($_REQUEST['amount']);
                $req->Accountname = $_REQUEST['name'];

                $req->Save();
                $req->Created = new WixDate(time());

                $ret->status = "success";
                $ret->data = $req;
                $ret->message = "request saved successfully";
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