<?php

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "cities list retrieved successfully";
    $ret->data = City::ByCountry(Country::ByCode("NG"));

    echo json_encode($ret);