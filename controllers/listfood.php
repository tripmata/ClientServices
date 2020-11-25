<?php

	$ret = new stdClass();

    $ret->status = "success";
    $ret->data = Food::All($GLOBALS['subscriber']);

	echo json_encode($ret);