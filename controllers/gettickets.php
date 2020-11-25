<?php

    $ret = new stdClass();
    $ret->data = array();

    if(isset($_SESSION['user_token']))
    {
        $sess = Session::Get($_SESSION['user_token']);

        $customer = new Customer($GLOBALS['subscriber']);
        $customer->Initialize($sess->User);

        if ($customer->Id != "")
        {
            $filter = "all";

            if($_REQUEST['filter'] == "pending")
            {
                $filter = 1;
            }
            else if($_REQUEST['filter'] == "opened")
            {
                $filter = 2;
            }
            else if($_REQUEST['filter'] == "closed")
            {
                $filter = 3;
            }

            $tcks = Ticket::GetList($customer, $_REQUEST['term'], $filter);
            $i = 0;

            for($i = 0; $i < count($tcks); $i++)
            {
                $r = new stdClass();
                $r->Ticket = $tcks[$i];
                $r->Ticket->Subject = Article::Shorten($r->Ticket->Subject, 10)."...";
                $r->Replies = Ticketreply::GetReplies($tcks[$i]);
                $ret->data[$i] = $r;
            }
            $ret->Page = $_REQUEST['Page'];
            $ret->Total = count($tcks);
            $ret->Perpage = $_REQUEST['Perpage'];


            $ret->opened = Ticket::Count($customer, 2);
            $ret->pending = Ticket::Count($customer, 1);
            $ret->closed = Ticket::Count($customer, 3);
            $ret->total = Ticket::Count($customer, 0);

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