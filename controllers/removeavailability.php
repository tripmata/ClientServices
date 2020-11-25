<?php

    $avail = new Availability($GLOBALS['subscriber']);
    $avail->Initialize($_REQUEST['avail']);
    $avail->Delete();

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "availability have been deleted";

    echo json_encode($ret);