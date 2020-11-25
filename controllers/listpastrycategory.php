<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = Pastrycategory::All($GLOBALS['subscriber']);

	echo json_encode($ret);