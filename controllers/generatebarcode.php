<?php

$ret = new stdClass();

$r = Random::GenerateId(15);
while(Staff::BiodataExist($r, $GLOBALS['subscriber']))
{
    $r = Random::GenerateId(15);
}
$ret->data = $r;
$ret->status = "success";
$ret->message = "Barcode generated successfully";

echo json_encode($ret);