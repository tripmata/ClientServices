<?php

    $rate = Roomrate::ByRoomtype($GLOBALS['subscriber'], $_REQUEST['category']);

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "Room rate data retrieved successfully";
    $ret->data = $rate;
    $ret->room = new Roomcategory($GLOBALS['subscriber']);
    $ret->room->Initialize($_REQUEST['category']);

    echo json_encode($ret);