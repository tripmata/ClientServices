<?php

$payment = new Paygateway($GLOBALS['subscriber']);

$ret = new stdClass();
$ret->status = "success";

$ret->bank = $payment->Bank;
$ret->accountname = $payment->Accountname;
$ret->accountnumber = $payment->Accountnumber;

echo json_encode($ret);
