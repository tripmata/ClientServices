<?php

$availability = Availability::ByRoomtype($GLOBALS['subscriber'], $_REQUEST['category']);

$ret = new stdClass();
$ret->status = "success";
$ret->message = "Availability data retrieved successfully";
$ret->data = $availability;
$ret->room = new Roomcategory($GLOBALS['subscriber']);
$ret->room->Initialize($_REQUEST['category']);

echo json_encode($ret);