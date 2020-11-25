<?php

    $ret = new stdClass();
    $ret->data = Reservation::ByBookingNUmber($_REQUEST['booking']);
    $ret->status = "success";

    echo json_encode($ret);
