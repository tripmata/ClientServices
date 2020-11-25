<?php

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "";
    $ret->data = Propertyfacilities::Filter(1, 'status');

    echo json_encode($ret);