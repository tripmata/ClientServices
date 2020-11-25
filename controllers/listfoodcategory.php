<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = Foodcategory::All($GLOBALS['subscriber']);

	echo json_encode($ret);