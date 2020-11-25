<?php

$ret = new stdClass();

$ret->data = Receipt::All();
$ret->status = "success";
$ret->message = "";
                
echo json_encode($ret);