<?php

	$ret = new stdClass();

    $ret->status = "success";
    $ret->data = Roomcategory::All($GLOBALS['subscriber'], $_REQUEST['property']);

	echo json_encode($ret);