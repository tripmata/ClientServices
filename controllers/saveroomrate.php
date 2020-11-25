<?php

    $rate = new Roomrate($GLOBALS['subscriber']);
    $rate->Room = $_REQUEST['category'];
    $rate->Startdate = strtotime($_REQUEST['start']);
    $rate->Stopdate = strtotime($_REQUEST['stop']);
    $rate->Rate = doubleval($_REQUEST['rate']);

    $rate->Save();

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "rate saved";
    $ret->data = $rate;

    echo json_encode($ret);