<?php

$ret = new stdClass();
$ret->status = "success";
$ret->data = new Site();

echo json_encode($ret);