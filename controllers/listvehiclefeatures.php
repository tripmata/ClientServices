<?php

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "";
    $ret->data = Vehiclefeatures::Filter(1, 'status');

    echo json_encode($ret);