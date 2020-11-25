<?php

	$ret = new stdClass();

    $ret->status = "success";
    $ret->data = messagetemplate::Email($GLOBALS['subscriber']);

	echo json_encode($ret);