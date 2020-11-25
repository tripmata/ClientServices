<?php

    $ret = new stdClass();
    $ret->data = new stdClass();
    $ret->data->vehicle = Vehicle::ByMeta($_REQUEST['vehicle']);
    $ret->data->vehicle->Views++;
    $ret->data->vehicle->Save();
    $ret->status = "success";
    $ret->message = "";

    echo json_encode($ret);