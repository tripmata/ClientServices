<?php

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "states list retrieved successfully";
    $ret->data = States::FIlterCountry(Country::ByCode("NG"));

    echo json_encode($ret);