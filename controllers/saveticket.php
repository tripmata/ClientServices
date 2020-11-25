<?php

    $ret = new stdClass();

    if(isset($_SESSION['user_token']))
    {
        $sess = Session::Get($_SESSION['user_token']);

        $customer = new Customer($GLOBALS['subscriber']);
        $customer->Initialize($sess->User);

        if ($customer->Id != "")
        {
            $ticket = new Ticket();
            $ticket->Subject = $_REQUEST['Subject'];
            $ticket->User = $customer->Id;
            $ticket->Ticket_number = Random::GenerateId(5);
            $ticket->Status = 1;
            $ticket->Deleted = false;
            $ticket->Body = $_REQUEST['Body'];
            $ticket->File = $_REQUEST['File'];

            $ticket->Save();

            $ret->status = "success";
            $ret->data = "";
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
