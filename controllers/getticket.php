<?php

    $ret = new stdClass();
    $ret->data = new Ticket($_REQUEST['ticket']);
    $ret->replies = Ticketreply::GetReplies($ret->data);
    $ret->status = "success";

    echo json_encode($ret);