<?php

    $ret = new stdClass();

    if(isset($_SESSION['user_token']))
    {
        $sess = Session::Get($_SESSION['user_token']);

        $customer = new Customer($GLOBALS['subscriber']);
        $customer->Initialize($sess->User);

        if ($customer->Id != "")
        {
            $reply = new Ticketreply();
            $reply->Tcket_num = $_REQUEST['ticket'];
            $reply->Body = $_REQUEST['reply'];
            $reply->Source = "customer";
            $reply->Save();

            $ret->status = "success";
            $ret->data = $reply;
            $ret->message = "reply saved successfully";
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