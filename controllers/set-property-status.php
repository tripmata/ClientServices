<?php

    $property = new Property($_REQUEST['property']);
    $property->Status = Convert::ToBool($_REQUEST['status']);
    $property->Save();

    $ret = new stdClass();
    $ret->status = "success";

    echo json_encode($ret);