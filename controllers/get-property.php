<?php

$property = new Property($_REQUEST['property']);

$ret = new stdClass();
$ret->status = "success";
$ret->data = $property;
$ret->reviews = Reviews::ByProperty($property);
$ret->reservartions = count(Reservation::Pending($property));
$ret->messages = count(Message::ByProperty($property));

echo json_encode($ret);