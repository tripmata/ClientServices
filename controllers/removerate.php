<?php

    $rate = new Roomrate($GLOBALS['subscriber']);
    $rate->Initialize($_REQUEST['rate']);
    $rate->Delete();

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "rate have been deleted";

    echo json_encode($ret);