<?php

$ret = new stdClass();

$ret->status = "success";
$ret->data = strtoupper(Random::GenerateId(10));

echo json_encode($ret);