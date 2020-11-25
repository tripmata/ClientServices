<?php

$ret = new stdClass();

$r = Random::GenerateId(6);
while(Food::BarcodeExist($GLOBALS['subscriber'], $r) || Drink::BarcodeExist($GLOBALS['subscriber'], $r) || Pastry::BarcodeExist($GLOBALS['subscriber'], $r))
{
    $r = Random::GenerateId(6);
}
$ret->data = $r;
$ret->status = "success";
$ret->message = "Barcode generated successfully";

echo json_encode($ret);